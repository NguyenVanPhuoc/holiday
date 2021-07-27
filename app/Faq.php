<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faqs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'position', 'cat_id', 'most_asked'
    ];

    public function category(){
    	return $this->belongsTo('App\CategoryFaq', 'cat_id');
    }
}
