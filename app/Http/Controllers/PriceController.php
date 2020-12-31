<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;

class PriceController extends Controller
{
	
    public function index () 
    {
    	$prices = [];

        foreach(Listing::PRICES as $index => $name) {
            $prices[] = [
                'name' => $name,
                'listings_count' => $this->getListingCount($index)
            ];
        }

        return $prices;
    }

    private function getListingCount($index)
    {
        return Listing::withFilters()
            ->when($index == 0, function ($query) {
                $query->where('price', '<', '600000');
            })
            ->when($index == 1, function ($query) {
                $query->whereBetween('price', ['600000', '700000']);
            })
            ->when($index == 2, function ($query) {
                $query->whereBetween('price', ['700000', '800000']);
            })
            ->when($index == 3, function ($query) {
                $query->whereBetween('price', ['800000', '900000']);
            })
            ->when($index == 4, function ($query) {
                $query->where('price', '>', '900000');
            })
            
            ->count();
    }
}
