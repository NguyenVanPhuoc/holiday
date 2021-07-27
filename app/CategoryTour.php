<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CategoryTour extends Model
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

    protected $table = 'category_tours';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'desc', 'image', 'white_icon', 'pink_icon', 'gray_icon', 'green_icon'
    ];


    /**
     * Get the consultant_tour_guides of country.
     */
    public function consultantTourGuides()
    {
        return $this->hasMany('App\ConsultantTourGuide', 'tour_style_id');
    }


    public function countryTourStyles()
    {
        return $this->hasMany('App\CountryTourStyle', 'cat_id');
    }
}
