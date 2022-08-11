<?php

namespace App\Http\Controllers;

use App\Helpers\ListingHelper;
use App\Http\Resources\ResponseResource;
use App\Models\Album;
use App\Models\Person;
use App\Models\Photo;
use Exception;
use Illuminate\Http\Request;

class UserPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        [
            'sort' => $sort,
            'sort_field' => $sortField,
            'page_limit' => $pageLimit,
            'search_keyword' => $searchKeyword,
            'show_all_records' => $showAllRecords,
            'filters' => $filters
        ] = ListingHelper::getPaginationRequests();

        $query = Photo::whereHas('album', function($query) use ($userId) {
            return $query->where('person_id', $userId);
        });

        if (count($filters) > 0) {
            $query->where(function ($q) use ($filters) {
                foreach ($filters as $filter_field => $filter_value) {
                    $q->whereRaw('LOWER(' . $filter_field . ') LIKE "%' . strtolower($filter_value) . '%" ');
                }
            });
        }

        if (!empty($searchKeyword)) {
            $query->where('title', 'LIKE', '%' . $searchKeyword . '%');
        }

        if ($showAllRecords) {
            if (isset($pageLimit)) {
                $query->limit($pageLimit);
            }
            $data = $query->orderBy($sortField, $sort)->get();
        } else {
            $data = $query->orderBy($sortField, $sort)->paginate($pageLimit);
        }

        return ResponseResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $userId)
    {
        try {
            $album = Album::where([
                'person_id' => $userId,
                'id' => $request->album_id,
            ])->firstOrFail();

            $photo = $album->photos()->create([
                'title' => $request->title,
                'url' => $request->url,
                'thumbnail_url' => $request->thumbnail_url,
            ]);

            return response()->json([
                'data' => $photo,
                'success' => true,
            ]);
        } catch(Exception $e) {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userId, $id)
    {
        try {
            $photo = Photo::whereHas('album', function($query) use ($userId) {
                        return $query->where('person_id', $userId);
                    })
                    ->where('id', $id)
                    ->firstOrFail();

            $photo->update([
                'title' => $request->title,
            ]);

            return response()->json([
                'data' => $photo,
                'message' => 'User photo has been updated.',
                'success' => true,
            ]);
        } catch(Exception $e) {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, $id)
    {
        try {
            $photo = Photo::whereHas('album', function($query) use ($userId) {
                        return $query->where('person_id', $userId);
                    })
                    ->where('id', $id)
                    ->firstOrFail();

            $photo->delete();

            return response()->json([
                'message' => 'User photo has been deleted.',
                'success' => true,
            ]);
        } catch(Exception $e) {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }
}
