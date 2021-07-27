<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{

	protected $table = 'consultants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'tour_style_id'
    ];
}
