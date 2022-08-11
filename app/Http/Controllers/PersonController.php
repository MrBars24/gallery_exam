<?php

namespace App\Http\Controllers;

use App\Helpers\ListingHelper;
use App\Http\Resources\ResponseResource;
use Illuminate\Http\Request;
use App\Models\Person;
use Exception;
use Faker\Generator;
use Illuminate\Container\Container;

class PersonController extends Controller
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

        $query = Person::query();
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
        $faker = Container::getInstance()->make(Generator::class);

        $person = Person::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'street' => $faker->streetAddress,
            'suite' => $faker->title,
            'city' => $faker->city,
            'zipcode' => $faker->randomNumber(5, true),
            'geo_lat' => $faker->latitude,
            'geo_lng' => $faker->longitude,
            'phone' => $faker->phoneNumber,
            'website' => $faker->url,
            'company_name' => $faker->company,
            'company_catch_phrase' => $faker->sentence,
            'company_bs' => $faker->title,
        ]);

        return response()->json([
            'data' => $person,
            'message' => 'User has been created.',
            'success' => true,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $person = Person::findOrFail($id);

            $person->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
            ]);

            return response()->json([
                'data' => $person,
                'message' => 'User has been updated.',
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
    public function destroy($id)
    {
        try {
            Person::findOrFail($id)->delete();

            return response()->json([
                'message' => 'User has been deleted.',
                'success' => true,
            ]);
        } catch(Exception $e) {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
    }
}
