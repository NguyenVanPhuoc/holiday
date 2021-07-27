<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatTourMetas extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tour_id', 'cat_id'
    ];
}
