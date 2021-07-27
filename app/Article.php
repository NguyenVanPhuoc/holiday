<?php
namespace App;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Article extends Model
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
        'title', 'title_tag', 'slug', 'desc', 'content', 'sort_list' ,'image', 'image_request1', 'image_looking', 'image_request2', 'cat_id', 'view', 'user_id', 'blogger_id', 'status'
    ];

    public function countries()
    {
        return $this->belongsToMany('App\Countries', 'country_article', 'article_id', 'country_id');
    }

    public function category(){
        return $this->belongsTo('App\ArticleCat', 'cat_id');
    }

    public function blogger(){
        return $this->belongsTo('App\Bloggers');
    }

    public function fathestCountries(){
        return Countries::join('country_articles', 'countries.id', '=', 'country_articles.country_id')
                            ->where('countries.parent_id', 0)->where('country_articles.article_id', $this->id)
                            ->select('countries.id', 'countries.image', 'countries.title', 'countries.flag')
                            ->distinct()->get();
    }

    public function getPermalink(){
        // $countryArticles = CountryArticle::join('countries', 'country_articles.country_id', '=', 'countries.id')
        //                                 ->where('countries.parent_id', 0)
        //                                 ->where('country_articles.article_id', $this->id)
        //                                 ->select('countries.id', 'countries.title', 'countries.slug')
        //                                 ->get();
        // if(count($countryArticles) == 1){
        //     return route('postTypeCountryTravel', ['slug_country' => $countryArticles[0]->slug, 'slug' => $this->slug]);
        // }else{
            return route('blogCall', $this->slug);
        //}
    }
}
