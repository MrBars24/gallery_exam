<?php

namespace App\Http\Controllers;

use App\Helpers\ListingHelper;
use App\Http\Resources\ResponseResource;
use App\Models\Album;
use Exception;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        [
            'sort' => $sort,
            'sort_field' => $sortField,
            'page_limit' => $pageLimit,
            'search_keyword' => $searchKeyword,
            'show_all_records' => $showAllRecords,
            'filters' => $filters
        ] = ListingHelper::getPaginationRequests();

        $query = Album::withCount('photos');
        if (count($filters) > 0) {
            $query->where(function ($q) use ($filters) {
                foreach ($filters as $filter_field => $filter_value) {
                    $q->whereRaw('LOWER(' . $filter_field . ') LIKE "%' . strtolower($filter_value) . '%" ');
                }
            });
        }

        if (!empty($searchKeyword)) {
            $query->where('name', 'LIKE', '%' . $searchKeyword . '%');
            $query->orWhere('username', 'LIKE', '%' . $searchKeyword . '%');
            $query->orWhere('email', 'LIKE', '%' . $searchKeyword . '%');
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
    public function store(Request $request)
    {
        try {
            $album = Album::create([
                'title' => $request->title,
                'person_id' => $request->user_id
            ]);

            return response()->json([
                'data' => $album,
                'message' => 'Album has been created.',
                'success' => true,
            ]);
        } catch(Exception $e) {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $album = Album::findOrFail($id);

            $album->update([
                'person_id' => $request->user_id,
                'title' => $request->title,
            ]);

            return response()->json([
                'data' => $album,
                'message' => 'Album has been updated.',
                'success' => true,
            ]);
        } catch(Exception $e) {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Album::findOrFail($id)->delete();

            return response()->json([
                'message' => 'Album has been deleted.',
                'success' => true,
            ]);
        } catch(Exception $e) {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }
}
