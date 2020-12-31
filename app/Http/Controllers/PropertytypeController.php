<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Propertytype;
use App\Http\Resources\PropertytypeResource;

class PropertytypeController extends Controller
{
	public function index()
    {
	    $propertytypes = Propertytype::withCount(['listings' => function ($query) {
	                $query->withFilters();
	            }])
	            ->get();

	    return PropertytypeResource::collection($propertytypes);
	}
}
