<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'highlights';
    
    protected $fillable = [
        'text_map', 'gallery', 'video', 'desc_video', 'title_video', 'text_attraction_sec', 'text_hotel_sec', 'things_to_do', 'country_id', 'image_request_one', 'image_request_two'
    ];


    public static function getMessageRule()
    {
        return [
            'country_id.required' => 'Please chosen place to visit.',
        ];
    }

    public function country()
    {
        return $this->belongsTo('App\Countries');
    }
}
