<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryTours extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tour_id', 'country_id'
    ];
}
