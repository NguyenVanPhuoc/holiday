<?php 
use App\PostGuide;
use App\Guide;
use App\CategoryGuide;

/**
 * get list cate guide
 * @param $array_pluck : is true or fasle
 * @return list ob or array id
 */
if(! function_exists('getListCatGuide')){
	function getListCatGuide($array_pluck = false){
		$cat_guide = CategoryGuide::where('post_type', 'travel_tip')->orderBy('position', 'asc');
		if($array_pluck)
			$cat_guide = $cat_guide->pluck('id')->toArray();
		else
			$cat_guide = $cat_guide->get();
		return $cat_guide;
	}
}
/**
 * get list cate nation
 * @param $array_pluck : is true or fasle
 * @return list ob or array id
 */
if(! function_exists('getListCatNation')){
	function getListCatNation($array_pluck = false){
		$cat_guide = CategoryGuide::where('post_type', 'market')->orderBy('position', 'asc');
		if($array_pluck)
			$cat_guide = $cat_guide->pluck('id')->toArray();
		else
			$cat_guide = $cat_guide->get();
		return $cat_guide;
	}
}
/**
 * get list Nationality
 * @param $array_pluck : is true or fasle
 * @return list ob or array id
 */
if(! function_exists('getListNation')){
	function getListNation($limit = 6, $offset = 0){
		$result = CategoryGuide::select('title', 'slug', 'feature_image' , 'id')->where('post_type', 'market')->orderBy('position', 'asc')->offset($offset)->limit($limit)->get();
		return $result;
	}
}

if(! function_exists('getTotalNation')){
	function getTotalNation(){
		return CategoryGuide::select('id')->where('post_type', 'market')->count();
	}
}


/**
* get list travel tips by country
* @param $type, $country_id
* @return list travel tips of country
*/
if(! function_exists('getListTravelTipsByCountry')){
	function getListTravelTipsByCountry($type , $country_id){
		return PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
								->where('post_guides.country_id', $country_id)
								->where('post_guides.post_type', $type)
								->select('category_guides.title as title', 'category_guides.slug as slug', 'category_guides.gray_icon as gray_icon', 'category_guides.white_icon as white_icon', 'category_guides.feature_image as feature_image', 'post_guides.image as image')
								->distinct()->get();

	}
}