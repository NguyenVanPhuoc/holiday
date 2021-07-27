<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedules extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'brief', 'content', 'notes', 'meal', 'gallery', 'icon', 'tour_id','position'
    ];
}
