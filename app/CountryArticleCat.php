<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryArticleCat extends Model
{
    protected $table = 'country_article_cats';
    protected $fillable = [
        'title_tag', 'desc', 'image', 'image_looking', 'image_request' , 'country_id', 'cat_id'
    ];
}
