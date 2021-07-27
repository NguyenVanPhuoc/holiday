<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryArticle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'country_articles';
    protected $fillable = [
        'article_id', 'country_id'
    ];
}
