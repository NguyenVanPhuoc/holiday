<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Icon extends Model
{
	protected $table = 'icons';
    protected $fillable = [
        'title', 'type', 'pink_icon'
    ];

    public static function getMessageRule()
    {
        return [
            'title.required' => 'Please input title.',
        ];
    }
}
