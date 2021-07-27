<?php

namespace App;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CountryTourDuration extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug'
            ]
        ];
    }

    protected $table = 'country_tour_durations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'title_tag', 'desc', 'text_list_content', 'list_content', 'image', 'image_looking', 'image_request', 'country_id', 'duration_id'
    ];

    /**
     * Get the country that owns the country tour duration.
     */
    public function country()
    {
        return $this->belongsTo('App\Countries');
    }

    /**
     * Get the duration that owns the country tour duration.
     */
    public function duration()
    {
        return $this->belongsTo('App\Duration');
    }

    /*
    * custom message validation
    */
    public static function getMessageRule(){
        return [
            'title.required' => 'Please input the title',
            'duration_id.required' => 'Please chose a duration',
            'country_id.required' => 'Please chose a country',
        ];
    }
}
