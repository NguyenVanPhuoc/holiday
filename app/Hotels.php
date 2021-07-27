<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Hotels extends Model
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

    protected $table = 'hotels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'title_tag', 'slug', 'desc', 'map', 'gallery', 'facilities', 'tripadvisor_code', 'tripadvisor_link', 'website_link', 'image', 'star_rating_id', 'location_id', 'special_id'
    ];


    //custom validator message
    public static function getMessageRule()
    {
        return [
            'title.required' => 'Please input title.',
            'country.required' => 'Please chosen city.',
        ];
    }

    public function getPermalink(){
        $country = CountryHotel::join('countries', 'country_hotels.country_id', '=', 'countries.id')
                                ->where('countries.parent_id', 0)
                                ->where('country_hotels.hotel_id', $this->id)
                                ->select('countries.*')
                                ->distinct()
                                ->first();
        if($country) return route('postTypeCountryTravel',['slug_country' => $country->slug, 'slug' => $this->slug]);
            else return '';
    }
}
