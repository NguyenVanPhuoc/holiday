<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/*
* use for Tip & Guide, Cultural insight, Things to do
* @post_type : 
*   + travel_tip: Tip & Guide
*   + cultural : Cultural insight
*   + thing_to_do: Things to do
*/
class PostGuide extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug'
            ]
        ];
    }

    protected $table = 'post_guides';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'title_tag', 'slug', 'desc', 'post_type', 'list_tour', 'image', 'image_looking', 'image_request', 'cat_id', 'country_id'
    ];


    public function country(){
        return $this->belongsTo('App\Countries', 'country_id');
    }

    public function category(){
        return $this->belongsTo('App\CategoryGuide', 'cat_id');
    }

    /*
    * custom message validation
    */
    public static function getMessageRule(){
        return [
            'title.required' => 'Please input the title',
            'cat_id.required' => 'Please chose a category',
            'country_id.required' => 'Please input a country',
        ];
    }

    public function getPermalink(){
        return route('postTypeCountryTravel', ['slug_country' => $this->country->slug, 'slug' => $this->category->slug]);
    }
}
