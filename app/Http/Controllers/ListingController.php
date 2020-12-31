<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use App\Http\Resources\ListingResource;

class ListingController extends Controller
{
    public function index()
    {
        $listings = Listing::withFilters()->get();

        return ListingResource::collection($listings);
    }
}
