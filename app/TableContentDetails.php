<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TableContentDetails extends Model
{
     protected $fillable = [
        'title','content', 'parent_id', 'level', 'table_id', 'sequence'
    ];
}
