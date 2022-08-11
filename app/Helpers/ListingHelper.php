<?php

namespace App\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ListingHelper {

    /**
     * Get Pagination Requests
     *
     * @return Array
     */
    public static function getPaginationRequests()
    {
        // get current user ID
        $currentUserId = Auth::user() ? Auth::user()->id : null;

        // get request parameters
        $requestParams = request()->all();

        // get limit
        $limit = Arr::get($requestParams, 'rows_per_page', Config::get('constants.ITEM_PER_PAGE', 5));
        if ((int) $limit === 0) { // for cases of all, rowsPerPage is 0 value
            $limit = Arr::get($requestParams, 'rows_number', Config::get('constants.ITEM_PER_PAGE', 5));
        }

        // get keyword for general search
        $keyword = Arr::get($requestParams, 'keyword', '');

        // get sort field
        $field = Arr::get($requestParams, 'sort_by', 'created_at');

        // get sorting direction
        $descending = Arr::get($requestParams, 'descending', 'false');
        $sort = $descending === 'true' ? 'desc' : 'asc';

        // get display value
        $showAllRecords = Arr::get($requestParams, 'display_all', 0);

        // get filter
        $filters = array_filter(json_decode(Arr::get($requestParams, 'filters', '{}'), true));

        return [
            "current_user_id" => $currentUserId,
            "search_keyword" => $keyword,
            "page_limit" => $limit,
            "sort_field" => $field,
            "sort" => $sort,
            "filters" => $filters,
            "show_all_records" => $showAllRecords
        ];
    }

}
