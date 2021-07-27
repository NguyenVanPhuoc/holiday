<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class IconsDetailSchedules extends Model
{
    protected $fillable = [
        'title','icon','yellow_icon'
    ];
}
