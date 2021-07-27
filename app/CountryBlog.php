<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryBlog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'country_id', 'type', 'title' , 'title_tag', 'desc', 'banner', 'banner_country', 'content_ready_yet', 'banner_plants', 'img_plant', 'content_tips'
    ];

    /*
    * custom message validation
    */
    public static function getMessageRule(){
        return [
            'title.required' => 'Please input the title',
            'country_id.required' => 'Please choose country',
        ];
    }
}
