<?php 

use App\Article;
use App\ArticleCat;
use App\CountryArticle;
use App\CountryArticleCat;
use App\Countries;

if (! function_exists('get_blog')) {
	function get_blog($id){        
		return '';
	}
}
if(! function_exists('getArticle')){
	function getArticle($id){
		return Article::find($id);
	}
}

if(!function_exists('getAticlesOrderByTitle')){
	function getAticlesOrderByTitle(){
		$articles = Article::orderBy('title', 'asc')->get();
		return $articles;
	}
}

//get article by ID
if(!function_exists('getArticleByID')){
	function getArticleByID($id){
		$blog = Article::find($id);
		return $blog;
	}
}

//get list aticle by country
if(! function_exists('getListArticleByCountry')){
	function getListArticleByCountry($country_id, $number_take = NULL){
		$arrayID = getArrayIdChildOfCountry($country_id);
		$arrayID[] = $country_id;
		if($number_take != NULL)
			$articles = Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
						->whereIn('country_articles.country_id', $arrayID)
						->select('articles.*')
						->distinct()
						->take($number_take)
						->get();
		else
			$articles = Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
						->whereIn('country_articles.country_id', $arrayID)
						->select('articles.*')
						->distinct()
						->get();
		return $articles;
	}
}

//get country of article item
if(! function_exists('getCountryOfArticle')){
	function getCountryOfArticle($article_id){
		$country = CountryArticle::join('countries', 'country_articles.country_id', '=', 'countries.id')
									->where('country_articles.article_id', $article_id)
									->where('countries.parent_id', 0)
									->first();
		if($country)
			return $country;
		return;	
	}
}

/**
* get list article by country
* @param $country_id
* @return list article of country
*/
if(! function_exists('allArticleByCountry')){
	function allArticleByCountry($country_id){
		return Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
								->where('country_articles.country_id', $country_id)
								->select('articles.*')
								->limit(6)->latest()->get();
	}
}

if(! function_exists('allArticleByCountryV1')){
	function allArticleByCountryV1($country_id){
		return Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
								->where('country_articles.country_id', $country_id)
								->where('articles.status', 1)
								->select('articles.*')
								->limit(6)->latest()->get();
	}
}

/**
 * get most view article
 */
if(! function_exists('getMostViewArticle')){
	function getMostViewArticle($limit){
		return Article::orderBy('view', 'desc')->limit($limit)->get();
	}
}
/**
 * get most date article
 */
if(! function_exists('getMostDateArticle')){
	function getMostDateArticle($limit){
		return Article::where('status',1)->orderBy('created_at', 'desc')->limit($limit)->get();
	}
}
/**
 * get most view of country article
 */
if(! function_exists('getMostViewArticleOfCountry')){
	function getMostViewArticleOfCountry($limit, $country){
		return Article::join('country_articles', 'articles.id','=','country_articles.article_id')->where('country_articles.country_id', $country)->orderBy('view', 'desc')->limit($limit)->get();
	}
}
/**
 * data send country category blog
 * @param string $slug_country
 * @param string $slug
 * @return mixed
 */
if(! function_exists('dataSendCountryCatBlog')){
	function dataSendCountryCatBlog($slug_country, $slug){
		$country = Countries::findBySlug($slug_country);
		$cat =  ArticleCat::findBySlug($slug);
		$countryCat = CountryArticleCat::where('country_id', $country->id)->where('cat_id', $cat->id)->first();
		$seo = get_seo($countryCat->id, 'country_article_cat');
		$array_CountryID = getArrayIdChildOfCountry($country->id, [$country->id]);

		$list_blog = Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
							->whereIn('country_articles.country_id', $array_CountryID)
							->where('articles.cat_id', $cat->id)
							->distinct()
							->paginate(6);

		$data = [
			'country' => $country,
			'cat' => $cat,
			'countryCat' => $countryCat,
			'seo' => $seo,
			'list_blog' => $list_blog,
		]; 
		return $data;
	}
}

/**
 * get list article by array id
 * @param array $array_id
 * @return list object
 */
if(! function_exists('getArticlesByArrayId')){
	function getArticlesByArrayId($array_id){
		return Article::whereIn('id', $array_id)->get();
	}
}
/**
 * get all id countries
 * @param  id
 * 
 */
if(! function_exists('getAllCountriesId')){
	function getAllCountriesId($blog){
		$country_ids = CountryArticle::where('article_id', $blog)
                            ->select('country_id as id')
                            ->pluck('id')->toArray();
        $parent = array();
        if($country_ids) {
        	foreach ($country_ids as $value) {
        		$parent[] = dsGetParent1stCountry($value);
        	}
        }       
        return count(array_unique($parent));

	}
}
//get country of article item
if(! function_exists('getCountryOfArticle')){
	function getCountryOfArticle($article_id){
		$country = CountryArticle::join('countries', 'country_articles.country_id', '=', 'countries.id')
									->where('country_articles.article_id', $article_id)
									->where('countries.parent_id', 0)
									->first();
		if($country)
			return $country;
		return;	
	}
}
//get country of article item
if(! function_exists('getCountryOfArticleV1')){
	function getCountryOfArticleV1($article_id){
		$country = CountryArticle::join('articles', 'articles.id', '=', 'country_articles.article_id') 
									->join('countries', 'country_articles.country_id', '=', 'countries.id')
									->where('country_articles.article_id', $article_id)
									->select('countries.title as title' , 'countries.id as id')
									->get();
		if($country)
			return $country;
		return;	
	}
}
//get another article cat
if(! function_exists('getAnotherAticleCat')){
	function getAnotherAticleCat($cat_id){
		$category = ArticleCat::where('id','!=', $cat_id)
									->select('article_cats.*')
									->orderBy('position','asc')
									->get();
		return $category;
	}
}