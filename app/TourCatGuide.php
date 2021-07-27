<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourCatGuide extends Model
{
	protected $table = 'tour_cat_guides';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tour_id', 'cat_guide_id'
    ];
}
