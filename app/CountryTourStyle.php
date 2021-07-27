<?php

namespace App;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CountryTourStyle extends Model
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

    protected $table = 'country_tour_styles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'title_tag', 'desc', 'text_tour', 'list_content', 'text_city', 'list_city', 'text_review', 'image_content', 'image', 'image_looking', 'image_request', 'cat_id', 'country_id'
    ];

    public function tourStyle()
    {
        return $this->belongsTo('App\CategoryTour', 'cat_id');
    }

    public function country(){
        return $this->belongsTo('App\Countries', 'country_id');
    }

    public function relatedTourStyles(){
        return \App\CategoryTour::join('country_tour_styles', 'category_tours.id', '=', 'country_tour_styles.cat_id')
                            ->whereNotIn('category_tours.id', [$this->cat_id])
                            ->where('country_id', $this->country_id)
                            ->select('category_tours.title', 'category_tours.gray_icon', 'category_tours.white_icon', 'country_tour_styles.image')
                                ->distinct()->get();
    }


    /*
    * custom message validation
    */
    public static function getMessageRule(){
        return [
            'title.required' => 'Please input the title',
            'cat_id.required' => 'Please chose a category',
            'country_id.required' => 'Please chose a country',
        ];
    }
}
