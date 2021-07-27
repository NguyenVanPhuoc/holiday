<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overview extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'overviews';
    protected $fillable = [
        'list_main_city', 'list_quick_info', 'list_trip_planning', 'text_where_to_go', 'text_what_to_do', 'text_more_inspiration', 'text_exclusive', 'text_hand_crafted', 'text_preparing', 'best_things_to_do', 'icon_flag_gray', 'icon_flag', 'country_id'
    ];

    public static function getMessageRule()
    {
        return [
            'country_id.required' => 'Please chosen overview.',
        ];
    }
}
