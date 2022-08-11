<?php

namespace App\Http\Controllers;

use App\Helpers\ListingHelper;
use App\Http\Resources\ResponseResource;
use App\Models\Album;
use App\Models\Photo;
use Exception;
use Illuminate\Http\Request;

class AlbumPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $albumId)
    {
        [
            'sort' => $sort,
            'sort_field' => $sortField,
            'page_limit' => $pageLimit,
            'search_keyword' => $searchKeyword,
            'show_all_records' => $showAllRecords,
            'filters' => $filters
        ] = ListingHelper::getPaginationRequests();

        $query = Photo::where('album_id', $albumId);

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
    public function store(Request $request, $albumId)
    {
        try {
            $album = Album::findOrFail($albumId);

            $photo = $album->photos()->create([
                'title' => $request->title,
                'url' => $request->url,
                'thumbnail_url' => $request->thumbnail_url,
            ]);

            return response()->json([
                'data' => $photo,
                'message' => 'Album photo has been created.',
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
    public function update(Request $request, $albumId, $id)
    {
        try {
            $photo = Photo::where('album_id', $albumId)
                        ->where('id', $id)
                        ->firstOrFail();

            $photo->update([
                'title' => $request->title,
            ]);

            return response()->json([
                'data' => $photo,
                'message' => 'Album photo has been updated.',
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
    public function destroy($albumId, $id)
    {
        try {
            $photo = Photo::where('album_id', $albumId)
                        ->where('id', $id)
                        ->firstOrFail();

            $photo->delete();

            return response()->json([
                'message' => 'Album photo has been deleted.',
                'success' => true,
            ]);
        } catch(Exception $e) {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }
}
