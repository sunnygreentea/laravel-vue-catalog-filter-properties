<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Http\Resources\CityResource;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::withCount(['listings' => function ($query) {
                $query->withFilters();
            }])
            ->get();

        return CityResource::collection($cities);
    }
}
