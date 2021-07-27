<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class ConsultantTourGuide extends Model
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'short_desc', 'desc', 'text_tour', 'text_highlight', 'text_hotel', 'favourite_tour', 'favourite_highlight', 'favourite_hotel', 'type', 'country_id', 'tour_style_id', 'image', 'banner'
    ];

    /**
     * Get the country that owns the consultant_tour_guides.
     */
    public function country()
    {
        return $this->belongsTo('App\Countries');
    }

    /**
     * Get the country that owns the consultant_tour_guides.
     */
    public function tourStyle()
    {
        return $this->belongsTo('App\CategoryTour');
    }


    /*
    * custom message validation
    */
    public static function getMessageRule(){
        return [
            'title.required' => 'Please input the title',
        ];
    }
}
