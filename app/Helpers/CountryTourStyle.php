<?php
use App\CountryTourStyle;
use App\CategoryTour;
use App\Countries;
use App\CountryTours;
use App\CatTourMetas;
use App\Attractions;
use App\CountryBlog;

use Illuminate\Http\Request;

/**
* get list tour style by country
* @param $country_id
* @return list tour style of country
*/
if(! function_exists('getListTourStyleByCountry')){
	function getListTourStyleByCountry($country_id){
		return CountryTourStyle::join('category_tours', 'country_tour_styles.cat_id', '=', 'category_tours.id')
								->where('country_tour_styles.country_id', $country_id)
								->select('category_tours.title as title','category_tours.slug as slug' , 'category_tours.gray_icon as gray_icon', 'category_tours.white_icon as white_icon', 'country_tour_styles.image as image','category_tours.desc as desc',  'country_tour_styles.text_city as text_city')
								->distinct()->get();

	}
}
/**
* get list tour style by country
* @param $country_id
* @return list tour style of country
*/
if(! function_exists('getListTourStyleByCountryV1')){
	function getListTourStyleByCountryV1($style){
		return CategoryTour::where('category_tours.id', '!=' ,$style)->get();

	}
}
/**
* get list tour style by country alphabet
* @param $country_id
* @return list tour style of country
*/
if(! function_exists('getListTourStyleAlphabetByCountry')){
	function getListTourStyleAlphabetByCountry($country_id){
		return CountryTourStyle::join('category_tours', 'country_tour_styles.cat_id', '=', 'category_tours.id')
								->where('country_tour_styles.country_id', $country_id)->orderBy('title')
								->select('category_tours.id as id', 'category_tours.title as title', 'category_tours.slug as slug' , 'category_tours.gray_icon as gray_icon', 'category_tours.white_icon as white_icon', 'country_tour_styles.image as image','category_tours.desc as desc',  'country_tour_styles.text_city as text_city')
								->distinct()->get();

	}
}

/**
 * data send country tour style
 * @param $slug_country, $slug
 * @return data send view country tour style
 */
if(! function_exists('dataSendCountryTourStyle')){
	function dataSendCountryTourStyle($slug_country, $slug){
		$country = Countries::findBySlug($slug_country);
		$tour_style = CategoryTour::findBySlug($slug);
		$country_tourStyle = getCountryTourStyle($country->id, $tour_style->id);
		$list_countryTourStyle = CountryTourStyle::join('category_tours', 'country_tour_styles.cat_id', '=', 'category_tours.id')
												->whereNotIn('country_tour_styles.id', [$country_tourStyle->id])
												->select('country_tour_styles.id', 'category_tours.title as tour_style_title')
												->distinct()->get();
		$list_tour_style=CategoryTour::join('country_tour_styles', 'country_tour_styles.cat_id', '=', 'category_tours.id')
							->where('country_tour_styles.country_id',$country->id)
							->where('category_tours.id', '!=', $tour_style->id)
							->select('country_tour_styles.image as image', 'category_tours.title as title', 'category_tours.desc as desc', 'category_tours.slug as slug')
							->distinct()
							->get();
		$request = new Request;
		$array_country_id = getArrayIdChildOfCountry($country->id);
		$array_country_id[] = $country->id;
		$request['array_country_id'] = $array_country_id; 
		$request['type_query_country'] = 'or'; 
		$request['array_tourstyle_id'] = [$tour_style->id];
		$list_tour = filterTour($request);
		$list_attraction = Attractions::whereRaw("find_in_set($tour_style->id,cat_id)")->where('country_id',$country->id)->select('attractions.*')->get();
		$list_region = getListRegionInCountry($country->id);
		$list_duration = getListDuration();	
		$list_topCity = getListCountryByStringId($country_tourStyle->list_city);
		$list_reviewer = getListReviewer($country->id, $tour_style->id); 
		$desc_tourCountry = CountryBlog::where('type', 'country_tour')->where('country_id', $country->id)->select('country_blogs.*')->first();
		//$list_tour_style = $country_tourStyle->relatedTourStyles();
		$list_consultants = getConsultantsByCountry($country->id);
							
		$data = [
			'country' => $country,
			'country_tourStyle' => $country_tourStyle,
			'tour_style' => $tour_style,
			'list_countryTourStyle' => $list_countryTourStyle,
			'list_tour' => $list_tour,
			'list_region' => $list_region,
			'list_duration' => $list_duration,
			'list_topCity' => $list_topCity,
			'list_reviewer' => $list_reviewer,
			'list_tour_style' => $list_tour_style,
			'list_consultants' => $list_consultants,
			'list_attraction' => $list_attraction,
			'desc_tourCountry' => $desc_tourCountry,
		];

		return $data;
	}
}

/**
 * get country tour style
 * @param Countries $country_id
 * @param CategoryTour $tour_style_id
 * @return object
 */
if(! function_exists('getCountryTourStyle')){
	function getCountryTourStyle($country_id, $tour_style_id){
		return CountryTourStyle::where('country_id', $country_id)->where('cat_id', $tour_style_id)->first();
	}
}

/**
 * get all country tour style
 * @return object
 */
if(! function_exists('getAllCountryTourStyle')){
	function getAllCountryTourStyle(){
		return CategoryTour::all();
	}
}

/**
 * get list tour style in country
 * @param int $country_id
 * @return list region in country
 */
// if(! function_exists('getListRegionInCountry')){
// 	function getListRegionInCountry($country_id){
// 		return Countries::where('parent_id', $country_id)->orderBy('position', 'asc')
// 						->select('id', 'title', 'image')
// 						->get();
// 	}
// }


/**
* get list countries by tour style
* @param $style_id
* @return list countries of tour style
*/
if(! function_exists('getCountriesByTourStyle')){
	function getCountriesByTourStyle($style_id){
		return CountryTourStyle::join('countries', 'country_tour_styles.country_id', '=', 'countries.id')
								->where('country_tour_styles.cat_id', $style_id)
								->select('countries.title as title', 'countries.flag as flag', 'countries.slug as slug')
								->distinct()->get();

	}
}

/**
* get slug tour style 
*/
if(! function_exists('getSlugTourStyleById')){
	function getSlugTourStyleById($cat_id){
		return CategoryTour::where('id',$cat_id)->select('id','slug')->first();

	}
}