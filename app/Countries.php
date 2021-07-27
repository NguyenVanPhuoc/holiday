<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Countries extends Model
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
        'title', 'title_tag', 'slug', 'parent_id', 'color', 'desc', 'short_desc', 'best_time_to_visit', 'image', 'flag', 'icon', 'map', 'position', 'status'
    ];

    /**
     * Get the country tour duration record associated with the country.
     */
    public function countryTourDuration()
    {
        return $this->hasMany('App\CountryTourDuration', 'country_id');
    }

    public function highlight()
    {
        return $this->hasOne('App\Highlight', 'country_id');
    }

    /**
     * Get the consultant_tour_guides of country.
     */
    public function consultantTourGuides()
    {
        return $this->hasMany('App\ConsultantTourGuide', 'country_id');
    }

    public function countryTourStyles()
    {
        return $this->hasMany('App\CountryTourStyle', 'country_id');
    }

    public function postGuides()
    {
        return $this->hasMany('App\PostGuide', 'country_id');
    }

    public function articles(){
        return $this->belongsToMany('App\Article', 'country_article', 'article_id', 'country_id');
    }

    public function getParentFathest(){
        if($this->parent_id == 0)
            return;
    }

    /*
    * custom message validation
    */
    public static function getMessageRule(){
        return [
            'title.required' => 'Please input the title',
            'parent_id.required' => 'Please chose the parent',
        ];
    }

    public function listPostGuide($post_type, $limit = NULL){
        $list_postGuide = PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                                ->where('post_guides.post_type', $post_type)
                                ->where('post_guides.country_id', $this->id)
                                ->orderBy('category_guides.position', 'asc');
        if($limit != NULL)
            $list_postGuide = $list_postGuide->limit($limit);
        $list_postGuide = $list_postGuide->distinct()->get();
        return $list_postGuide;
    }

    public function catGuideSelect($post_type){
        $country_id = getFarthestParentCountry($this->id);
        $array_select = ($this->highlight->things_to_do != '') ? explode(",", $this->highlight->things_to_do) : []; //dd($array_select);
        return PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                                ->where('post_guides.post_type', $post_type)
                                ->where('post_guides.country_id', $country_id)
                                ->whereIn('category_guides.id', $array_select)
                                ->orderBy('category_guides.position', 'asc')
                                ->distinct()->get();
    }

}
