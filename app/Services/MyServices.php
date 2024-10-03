<?php

namespace App\Services;

class MyServices
{
    public static function customPaginate($collection)
    {
        return [
            "total" => $collection->total(),
            "per_page" => $collection->perPage(),
            "current_page" => $collection->currentPage(),
            "last_page" => $collection->lastPage(),
            "top_page" => $collection->url(1),
            "bottom_page" => $collection->url($collection->lastPage()),
            "next_page_url" => $collection->nextPageUrl(),
            "prev_page_url" => $collection->previousPageUrl(),
            "has_pages" => $collection->lastPage()
        ];
    }
}
