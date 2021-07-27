<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryFaq extends Model
{
    protected $table = 'category_faqs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'position', 'white_icon', 'yellow_icon'
    ];

    public function faqs(){
    	return $this->hasMany('App\Faq', 'cat_id');
    }
}
