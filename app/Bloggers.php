<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Bloggers extends Model
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

    protected $table = 'bloggers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'title_tag', 'slug', 'short_desc', 'desc', 'icon_facebook', 'icon_twitter', 'facebook', 'twitter', 'favourite_article', 'favourite_books', 'favourite_highlight', 'image', 'banner'
    ];

    public function articles(){
        return $this->hasMany('App\Article');
    }

    public static function getMessageRule(){
        return [
            'title.required' => 'Please input the title',
        ];
    }
}
