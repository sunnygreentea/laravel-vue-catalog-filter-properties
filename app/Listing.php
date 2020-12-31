<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\City;
use App\Transaction;
use App\Propertytype;

class Listing extends Model
{
    use SoftDeletes;
    
    public $table = 'listings';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'user_id',
        'transaction_id',
        'ptype_id',
        'city_id',
        'price',
        'per',
        'beds',
        'baths',
        'garage',
        'area',
        'amenties',
        'description',
        'lat',
        'lng'
    ];

    const PRICES = [
        'Less than 60k',
        'From 60k to 70k',
        'From 70k to 80k',
        'From 80k to 90k',
        'More than 90k',
    ];


    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }

   
    public function ptype()
    {
        return $this->belongsTo('App\Propertytype', 'ptype_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function scopeWithFilters ($query) 
    {
        return $query

            ->when(count(request()->input('cities', [])), function ($query) {
                $query->whereIn('city_id', request()->input('cities'));
            })

            ->when(count(request()->input('propertytypes', [])), function ($query) {
                $query->whereIn('ptype_id', request()->input('propertytypes'));
            })
            
            ->when(count(request()->input('prices', [])), function ($query) {
                $query->where(function ($query) {
                    $query->when(in_array(0, request()->input('prices')), function ($query) {
                            $query->orWhere('price', '<', '600000');
                        })
                        ->when(in_array(1, request()->input('prices')), function ($query) {
                            $query->orWhereBetween('price', ['600000', '700000']);
                        })
                        ->when(in_array(2, request()->input('prices')), function ($query) {
                            $query->orWhereBetween('price', ['700000', '800000']);
                        })
                        ->when(in_array(3, request()->input('prices')), function ($query) {
                            $query->orWhereBetween('price', ['800000', '900000']);
                        })
                        ->when(in_array(4, request()->input('prices')), function ($query) {
                            $query->orWhere('price', '>', '900000');
                        });
                });
            });
    }

    /*
    public function scopeWithFilters($query)
    {
        return $query->when(count(request()->input('manufacturers', [])), function ($query) {
                $query->whereIn('manufacturer_id', request()->input('manufacturers'));
            })
            ->when(count(request()->input('categories', [])), function ($query) {
                $query->whereIn('category_id', request()->input('categories'));
            })
            ->when(count(request()->input('prices', [])), function ($query) {
                $query->where(function ($query) {
                    $query->when(in_array(0, request()->input('prices')), function ($query) {
                            $query->orWhere('price', '<', '5000');
                        })
                        ->when(in_array(1, request()->input('prices')), function ($query) {
                            $query->orWhereBetween('price', ['5000', '10000']);
                        })
                        ->when(in_array(2, request()->input('prices')), function ($query) {
                            $query->orWhereBetween('price', ['10000', '50000']);
                        })
                        ->when(in_array(3, request()->input('prices')), function ($query) {
                            $query->orWhere('price', '>', '50000');
                        });
                });
            });
    }
    */
}
