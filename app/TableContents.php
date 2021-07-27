<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TableContents extends Model
{
    protected $fillable = [
        'post_type','post_id'
    ];
}
