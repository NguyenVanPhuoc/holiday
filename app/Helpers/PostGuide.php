<?php
use App\PostGuide;
use App\Countries;

/**
 * get list post guide by country
 * @param $type, $country_id
 */ 
if(! function_exists('getListPostGuideCountry')){
	function getListPostGuideCountry($type, $country_id, $limit = NULL){
		$list_postGuide = PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                            ->where('post_guides.post_type', $type)
                            ->where('post_guides.country_id', $country_id)
                            ->orderBy('category_guides.position', 'asc')
                            ->select('post_guides.*', 'category_guides.slug', 'category_guides.title as short_title', 'category_guides.white_icon', 'category_guides.gray_icon', 'category_guides.green_icon', 'category_guides.yellow_icon')
                            ->distinct();
        if($limit != NULL)
        	$list_postGuide = $list_postGuide->limit($limit);
        $list_postGuide = $list_postGuide->get();
        return $list_postGuide;
	}
}
if(! function_exists('getListPostGuideCountryV1')){
	function getListPostGuideCountryV1($type, $country_id, $guide ,$limit = NULL){
		$list_postGuide = PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                            ->where('post_guides.post_type', $type)
                            ->where('post_guides.country_id', $country_id)
                            ->where('category_guides.id','!=', $guide)
                            ->orderBy('category_guides.position', 'asc')
                            ->select('post_guides.*', 'category_guides.slug', 'category_guides.title as short_title', 'category_guides.white_icon', 'category_guides.gray_icon', 'category_guides.green_icon', 'category_guides.yellow_icon')
                            ->distinct();
        if($limit != NULL)
        	$list_postGuide = $list_postGuide->limit($limit);
        $list_postGuide = $list_postGuide->get();
        return $list_postGuide;
	}
}
/**
* get item post guide
* @param string $slug, string $slug_country
*/
if(! function_exists('getItemPostGuideBySlug')){
	function getItemPostGuideBySlug($slug, $slug_country = NULL){	
		$post_guide = PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
								->where('category_guides.slug', $slug);	

		if($slug_country && $slug_country != ''){	
			$country = Countries::findBySlug($slug_country);			
			$post_guide = $post_guide->where('post_guides.country_id', $country->id);  
		}
		$post_guide = $post_guide->select('post_guides.*', 'category_guides.title as short_title', 'category_guides.white_icon', 'category_guides.gray_icon', 'category_guides.green_icon', 'category_guides.yellow_icon')->first();
		return $post_guide; 
	}
}

/**
* get list post guide by list string cat id
* @param string $type
* @param  string $str_cat_id (example '1,2,3')
* @param int $country_id
* @return list post guide
*/
if(! function_exists('getListPostGuideByStrCatID')){
	function getListPostGuideByStrCatID($type, $str_cat_id, $country_id){
		$array_catID = explode(",", $str_cat_id);
		$list_postGuide = PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
									->where('post_guides.post_type', $type)
									->whereIn('category_guides.id', $array_catID)
									->where('post_guides.country_id', $country_id)
									->distinct()
									->select('post_guides.*', 'category_guides.title as short_title', 'category_guides.white_icon', 'category_guides.gray_icon', 'category_guides.green_icon', 'category_guides.yellow_icon')
									->get();
		return $list_postGuide;
	}
}

/**
 * get 4 main item post guide in country
 * @param string $type 
 * @retun list 4 object post guide
 */
if(! function_exists('getFourItemPostGuideInCountry')){
	function getFourItemPostGuideInCountry($type, $country_id){
		return PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                                ->where('post_guides.post_type', $type)
                                ->where('post_guides.country_id', $country_id)
                                ->distinct()
                                ->select('post_guides.*', 'category_guides.title as short_title', 'category_guides.white_icon', 'category_guides.gray_icon', 'category_guides.green_icon', 'category_guides.yellow_icon')
                                ->orderBy('category_guides.position', 'asc')->limit(4)->get();
	}
}