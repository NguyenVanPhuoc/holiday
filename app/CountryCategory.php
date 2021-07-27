<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'cat_id'
    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'country_cats';
}
