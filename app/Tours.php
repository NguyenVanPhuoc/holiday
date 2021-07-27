<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tours extends Model
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
        'title', 'title_tag', 'slug', 'code', 'gallery', 'map', 'content', 'must_see_1', 'must_see_2', 'must_see_3', 'must_see_4', 'itinerary', 'price', 'cat_id', 'image', 'pdf','image_pdf','image_request','image_personalize', 'country_id', 'duration_id'
    ];
}
