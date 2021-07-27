<?php
use App\Countries;
use App\Tours;
use App\CountryTours;
use App\Duration;
use App\PostGuide;
use App\Highlight;
use App\Attractions;
use App\Hotels;
use App\CategoryTour;
use App\CategoryGuide;
use App\Overview;
use App\CountryTourStyle;
use App\CountryTourDuration;
use App\ArticleCat;
use App\CountryBlog;
use Illuminate\Database\Eloquent\Collection;

if(! function_exists('getAllMainCountry')){
	function getAllMainCountry($array_pluck = false){
		if($array_pluck)
			return Countries::where('parent_id', 0)->orderBy('position', 'asc')->pluck('id')->toArray();
		else
			return Countries::where('parent_id', 0)->orderBy('position', 'asc')->distinct()->get();	
	}
}

//get country
if(! function_exists('getCountry')){
	function getCountry($id){
		return Countries::find($id);
	}
}
//get country
if(! function_exists('getCountryV1')){
	function getCountryV1($id){
		return Countries::select('title', 'id', 'slug')->find($id);
	}
}
//get slug
if(! function_exists('getSlugCountryById')){
	function getSlugCountryById($id){
		return Countries::select('id', 'slug' , 'parent_id')->where('id',$id)->first();
	}
}
// get another country
if(! function_exists('getAnotherCountry')){
	function getAnotherCountry($not_id){
		return Countries::where('id', '!=', $not_id)->where('parent_id', 0)->orderBy('position', 'asc')->get();
	}
}

/*
* get farthest parent of county
* @param country_id
* @return farthest country id
*/
if(!function_exists('getFarthestParentCountry')){
	function getFarthestParentCountry($id){
		$country = Countries::find($id);
		$parent = Countries::find($country->parent_id);
		/*$temp = $country->parent_id ;*/
		$result = $country->parent_id;
		if($parent && $parent->parent_id != 0) $result = $parent->parent_id;
		/*if($temp != 0){
			while ($temp != 0){ 
				$temp = getFarthestParentCountry($parent->parent_id); 
			}
		}*/
		return $result;
	}
}

//get list text country where in id
if(! function_exists('getListTextCountryWhereInID')){
	function getListTextCountryWhereInID($str_id){
		$array_ID = explode(",", $str_id);
		$array_text = Countries::whereIn('id', $array_ID)->pluck('title')->toArray();
		return implode(", ", $array_text);
	}
}

//get list countries order by title
if(!function_exists('getHtmlCountriesOrderByTitle')){
	function getHtmlCountriesOrderByTitle($parent_id = 0, $level = 0, $title = ''){
		$html = ''; 
		$countCountries = Countries::where('parent_id', $parent_id)->orderBy('title', 'asc')->count();
		
		if($countCountries > 0){ 
			$level ++;
			$countries = Countries::where('parent_id', $parent_id)->orderBy('title', 'asc')->get();
			if($level == 3)
				$countries = Countries::where('parent_id', $parent_id)->where('title', 'LIKE', '%'. $title .'%')->orderBy('title', 'asc')->get();
			$c = '';
			if($level > 1){
				for($i=0; $i<$level-1;$i++){
					$c .= '&nbsp;&nbsp;&nbsp;';
				}
			}
			$class = '';
			if($level != 3) $class = 'disabled';
 			foreach($countries as $item){ 
				$html .= '<li class="add item-'. $item->id .' ' .$class. '" data-id="'. $item->id .'" title="'. $item->title .'">';
					$html .= $c.$item->title;
				$html .= '</li>';
				$html .= getHtmlCountriesOrderByTitle($item->id, $level, $title); 
			}

		}
		return $html;
	}
}

//get level country 
if(!function_exists('getLevelCountry')){
	function getLevelCountry($id){
		$country = Countries::find($id);
		$level = 1;
		if($country->parent_id != 0){
			$parent = Countries::find($country->parent_id);
			$level = 2;
			if($parent->parent_id != 0){
				$grand = Countries::find($country->parent_id);
				$level = 3;
			}
		}
		return $level;
	}
}

// count tour in country
if (! function_exists('countTourInCountry')) {
	function countTourInCountry($id, $type = ''){        
		//return Tours::whereRaw("find_in_set($id,country_id)") ->count();
		$tours = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
						->where('country_tours.country_id', $id)->select('tours.*')->distinct()->get();
		if($type == 'multi')
			$tours = DB::select('SELECT  DISTINCT tours.id FROM tours JOIN  country_tours ON tours.id = country_tours.tour_id WHERE country_tours.country_id = ? AND tours.id IN ( SELECT  DISTINCT tours.id FROM tours JOIN  country_tours ON tours.id = country_tours.tour_id JOIN countries ON country_tours.country_id = countries.id WHERE country_tours.country_id IN ( SELECT countries.id FROM countries WHERE countries.parent_id = 0 ) GROUP BY country_tours.tour_id HAVING COUNT(country_tours.tour_id) > 1 )', [$id]);
		return count($tours);
	}
}

//count tour multi country in country
if(!function_exists('countTourMultiInCountry')){
	function countTourMultiInCountry($id){
		$tours = DB::select('SELECT  DISTINCT tours.* FROM tours JOIN  country_tours ON tours.id = country_tours.tour_id JOIN countries ON country_tours.country_id = countries.id WHERE country_tours.country_id IN ( SELECT countries.id FROM countries WHERE countries.parent_id = 0 ) GROUP BY country_tours.tour_id HAVING COUNT(country_tours.tour_id) > 1');
		return count($tours);
	}
}

//get string country active in tour
if(!function_exists('toStringCountryTour')){
	function toStringCountryTour($tour_id){
		$countryTour = CountryTours::where('tour_id', $tour_id)->pluck('country_id');;
		$items = $countryTour instanceof Collection ? $countryTour : Collection::make($countryTour);
		return  implode(",", $countryTour->toArray());
	}
}

//get post type the same url parent {country->slug}-travel
if(!function_exists('postTypeByCountryTravel')){
	function postTypeByCountryTravel($slug){ 
		if(strpos($slug, 'accommodation') == true){
			$slug = substr($slug,0,-14); //remove '-accommodation' in $slug
			$country = Countries::findBySlug($slug);
			$level_country = getLevelCountry($country->id);
			if($level_country == 2)
				return 'region_hotel';
			if($level_country == 3)
				return 'city_hotel';
        }
        else{ 
			$list_postTypes = config('data_config.post_same_level_country_travel'); //dd($list_postTypes);
			foreach ($list_postTypes as $item) {  
				if($item=="travel_tip" || $item=="thing_to_do" || $item=="market"){  
					$result = CategoryGuide::findBySlug($slug); 
					if($result != NULL){ 
						return $result->post_type; 
						break;
					}
				}
				if($item=="region" || $item=="highlight"){ 
					$result = Countries::findBySlug($slug);  
					if($result != NULL && getLevelCountry($result->id) == 2){
						return "region";
						break;
					}
					elseif($result != NULL && getLevelCountry($result->id) == 3){
						return "highlight";
						break;
					}
					
				}
				if($item=="hotel"){  
					$result = Hotels::findBySlug($slug);
					if($result){
						return $item;
						break;
					}
				}
				if($item == "country_tour_style"){
					$result = CategoryTour::findBySlug($slug);
					if($result){
						return $item;
						break;
					}
				}
				if($item == "country_tour_duration"){
					//$result = CountryTourDuration::findBySlug($slug);
					$result = Duration::findBySlug($slug);
					if($result){
						return $item;
						break;
					}
				}
				if($item == "country_category_blog"){ 
					$result = ArticleCat::findBySlug($slug);
					if($result){
						return $item;
						break;
					}
				}

				// if($item == "market"){ 
				// 	$result = PostGuide::findBySlug($slug);
				// 	if($result){
				// 		return $item;
				// 		break;
				// 	}
				// }

			}
		}
		return;
	}
}

//get list all country
if (! function_exists('getListOptionParentCountry')) { 
	function getListOptionParentCountry($country_id, $level, $hide_lastchild = false){ 
		$countries = Countries::where('parent_id', $country_id)->select('id', 'title', 'parent_id')->get(); 
		$idcountry_select = (isset($_GET['parent_id']) && $_GET['parent_id'] != '') ? $_GET['parent_id'] : '';  
		$html = ''; 
		if(!empty($countries)){
			$level ++;
			$c = '';
			if($level == 1){
				//$selected = ($idcountry_select == 0) ? 'selected' : '';
				$selected = '';
				if(isset($_GET['parent_id']) && $_GET['parent_id'] == 0) $selected = 'selected';
				$html .= '<option value="0" '. $selected .'>None</option>';
			}
			if($level > 1){
				for($i=0; $i<$level-1;$i++){
					$c .= '-';
				}
			}
 			foreach($countries as $item){ 
 				$selected = ($item->id == $idcountry_select) ? 'selected' : ''; 

 				$count_child = Countries::where('parent_id', $item->id)->count();
 				if($count_child > 0 && $hide_lastchild){ //check have list child
	 				$existName = Countries::where('title', $item->title)->count();
	 				if($existName > 1){ //check exist title country
	 					$parent = Countries::find($item->parent_id);
	 					$html .= '<option value="'. $item->id .'" '. $selected .'>'.$c.$item->title.' ('. $parent->title .')</option>';
	 				}
	 				else
						$html .= '<option value="'. $item->id .'" '. $selected .'>'.$c.$item->title.'</option>';
					$html .= getListOptionParentCountry($item->id, $level, $hide_lastchild);
				}
				else if(!$hide_lastchild){
					$existName = Countries::where('title', $item->title)->count();
	 				if($existName > 1){ //check exist title country
	 					$parent = Countries::find($item->parent_id);
	 					$parent_title = ($parent) ? $parent->title : '';
	 					$html .= '<option value="'. $item->id .'" '. $selected .'>'.$c.$item->title.' ('. $parent_title .')</option>';
	 				}
	 				else
						$html .= '<option value="'. $item->id .'" '. $selected .'>'.$c.$item->title.'</option>';
					$html .= getListOptionParentCountry($item->id, $level, $hide_lastchild);
				}
			}
		}
		return $html;
	}
}

//get list highlight (places to visit) in a country
if(! function_exists('getListHightlightInCountry')){
	function getListHightlightInCountry($country_id, $select = false){
		//get list region with parent_id is $country_id
		$country = Countries::find($country_id);
		if($country->parent_id == 0)
			$array_regionID = Countries::where('countries.parent_id', $country_id)->orderBy('countries.title', 'asc')->pluck('countries.id')->toArray(); 
		else
			$array_regionID = [$country_id];	 
		//get list province with parent_id whereIn $array_regionID
		if($select)
			$list_province = Countries::join('highlights', 'countries.id', '=', 'highlights.country_id')
		                                ->whereIn('countries.parent_id', $array_regionID)->orderBy('countries.title', 'asc')->select('countries.id', 'countries.title', 'countries.image')->get();
		else
			$list_province = Countries::join('highlights', 'countries.id', '=', 'highlights.country_id')
		                                ->whereIn('countries.parent_id', $array_regionID)->orderBy('countries.title', 'asc')->get();
		return $list_province;
	}
} 

//get array id child of country
if(! function_exists('getArrayIdChildOfCountry')){
	function getArrayIdChildOfCountry($country_id, $array = []){
		//$country = Countries::find($id);
		$list_child = Countries::where('parent_id', $country_id)->get();
		if($list_child){
			foreach ($list_child as $child) {
				$array[] = $child->id;
				$array = getArrayIdChildOfCountry($child->id, $array);
			}
		}
		return $array;
	}
}

//get all highlight
if(! function_exists('getAllCountryByLevel')){
	function getAllCountryByLevel($level, $select = false){
		if($select)
			$list_country = Countries::where('parent_id', 0)->orderBy('title', 'asc')->select('id', 'title')->get();
		else
			$list_country = Countries::where('parent_id', 0)->orderBy('title', 'asc')->get();
		if($level == 1)
			return $list_country;
		else if($level == 2){
			$array_CountryID = Countries::where('parent_id', 0)->pluck('id')->toArray();
			if($select)
				$list_region = Countries::whereIn('parent_id', $array_CountryID)->orderBy('title', 'asc')->select('id', 'title')->get();
			else
				$list_region = Countries::whereIn('parent_id', $array_CountryID)->orderBy('title', 'asc')->get();
			return $list_region;
		}
		else if ($level == 3) {
			$array_CountryID = Countries::where('parent_id', 0)->pluck('id')->toArray();
			$array_regionID = Countries::whereIn('parent_id', $array_CountryID)->pluck('id')->toArray();
			if($select)
				$list_highlight = Countries::whereIn('parent_id', $array_regionID)->orderBy('title', 'asc')->select('id', 'title')->get();
			else
				$list_highlight = Countries::whereIn('parent_id', $array_regionID)->orderBy('title', 'asc')->get();
			return $list_highlight;
		}
		return;
	}
}

//get data send view region
if(! function_exists('dataSendRegion')){
	function dataSendRegion($slug_country, $slug_region){
		$country = Countries::findBySlug($slug_country);
        $region = Countries::findBySlug($slug_region); 
        $list_highlight = getListHightlightInCountry($region->id);
        $top_highlight = Countries::join('highlights', 'countries.id', '=', 'highlights.country_id')
        						    ->where('countries.parent_id', $region->id)
                                    ->select('countries.id', 'countries.title', 'countries.image')->paginate(4);
        $related_tours = getListTourByCountry($region->id, 20);
        $related_articles = getListArticleByCountry($region->id, 20);
        $related_hotels = getListHotelByCountry($region->id, 20);
        
        $data = [];     
        $data['country'] = $country; 
        $data['region'] = $region; 
        $data['list_highlight'] = $list_highlight; 
        $data['top_highlight'] = $top_highlight; 
        $data['related_tours'] = $related_tours;     
        $data['related_articles'] = $related_articles;     
        $data['related_hotels'] = $related_hotels; 
        return $data;
	}
}

//get data send view detail place to visit
if(! function_exists('dataSendHighlight')){
	function dataSendHighlight($slug_country, $slug_highlight){
		$country = Countries::findBySlug($slug_country);
		$city = Countries::findBySlug($slug_highlight);
		$region = Countries::findOrFail($city->parent_id);
		$highlight = Highlight::where('country_id', $city->id)->first();
		$list_highlight = getListHightlightInCountry($country->id);
		$list_attraction = Attractions::where('country_id', $city->id)->paginate(5); 
		$gallery = json_decode($highlight->gallery);
		$list_hotel = Hotels::join('country_hotels', 'hotels.id', '=', 'country_hotels.hotel_id')
								->where('country_hotels.country_id', $city->id)
								->select('hotels.*')->distinct()->get();
		$list_tour_byCountry = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
							->where('country_tours.country_id', $city->id)
							->select('tours.*')->distinct()->get();
		$related_highlights =  Countries::join('highlights', 'countries.id', '=', 'highlights.country_id')
        						    ->where('countries.parent_id', $region->id)
        						    ->whereNotIn('countries.id', [$city->id])
                                    ->select('countries.id', 'countries.title', 'countries.image')->inRandomOrder()->limit(4)->get(); 
        if(count($related_highlights) < 4){ // get more if count $related_highlights < 4
        	$rest_number = 4 - count($related_highlights);
        	$array_rest_regionID = Countries::whereNotIn('id', [$region->id])->where('parent_id', $country->id)->inRandomOrder()->pluck('id')->toArray();
        	$rest_highlight = Countries::join('highlights', 'countries.id', '=', 'highlights.country_id')
        						    ->whereIn('countries.parent_id', $array_rest_regionID)
        						    ->whereNotIn('countries.id', [$city->id])
                                    ->select('countries.id', 'countries.title', 'countries.image')->inRandomOrder()->limit($rest_number)->get(); 
            $merged = $related_highlights->merge($rest_highlight);
			$related_highlights = $merged->all();
        } 
        $list_city = getListCitiesInCountry($country->id);
        $list_main_city = Overview::select('list_main_city')->where('country_id', $country->id)->first();
      
        $country_place = CountryBlog::where('type', 'country_places')->where('country_id', $country->id)->first();
		$data = [];     
        $data['country'] = $country; 
        $data['city'] = $city; 
        $data['highlight'] = $highlight; 
        $data['region'] = $region; 
        $data['list_highlight'] = $list_highlight; 
        $data['gallery'] = $gallery; 
        $data['list_attraction'] = $list_attraction;  
        $data['list_hotel'] = $list_hotel;  
        $data['list_tour_byCountry'] = $list_tour_byCountry;
        $data['related_highlights'] = $related_highlights;
        $data['list_city'] = $list_city;
        $data['list_main_city'] = $list_main_city;
        $data['country_place'] = $country_place;

        return $data;
	}
}

/**
 * get list highlight category thing to do in country
 * @param $country_id, $cat_guide_id
 * @return list ob place to visit (highlight)
 */
if(! function_exists('getListHighlightCatThingToDoInCountry')){
	function getListHighlightCatThingToDoInCountry($country_id, $cat_guide_id){
		$array_parent = getArrayIdChildOfCountry($country_id);
		$list_highlight = Countries::join('highlights', 'countries.id', '=', 'highlights.country_id')
									->whereIn('countries.parent_id', $array_parent)
									->whereRaw("find_in_set($cat_guide_id, things_to_do)")
									->select('countries.id', 'countries.title', 'countries.image', 'highlights.things_to_do')
									->distinct()
									->get();
		return $list_highlight;
	}
}

/**
 * get array city id of country (first : array main city, after merge with array other city id)
 * @param int $country_id
 * @return array array id city in country
 */
if(! function_exists('getArrayCityIdOfCountryHotel')){
	function getArrayCityIdOfCountryHotel($country_id){
		//get level of country
		$level = getLevelCountry($country_id);
		if($level == 1){
			$country = Countries::join('overviews', 'countries.id', '=', 'overviews.country_id')
								->where('countries.id', $country_id)
								->select('countries.id', 'countries.title', 'countries.slug', 'overviews.list_main_city')
								->distinct()->first();
			$array_regionID = Countries::where('parent_id', $country_id)->pluck('id')->toArray();
			$array_mainCityID = ($country->list_main_city != '') ? explode(",", $country->list_main_city) : [];
			$array_mainCityID2 = Countries::join('country_hotels', 'countries.id', '=', 'country_hotels.country_id')
										->whereIn('countries.id', $array_mainCityID)
										->distinct()->pluck('countries.id')->toArray();						
			$array_otherCityID = Countries::join('country_hotels', 'countries.id', '=', 'country_hotels.country_id')
										->whereNotIn('countries.id', $array_mainCityID2)
										->whereIn('countries.parent_id', $array_regionID)
										->distinct()->pluck('countries.id')->toArray();
			return array_merge($array_mainCityID2, $array_otherCityID);
		}
		else if($level == 2){
			$region = Countries::findOrFail($country_id);
			$country = Countries::join('overviews', 'countries.id', '=', 'overviews.country_id')
								->where('countries.id', $region->parent_id)
								->select('countries.id', 'countries.title', 'countries.slug', 'overviews.list_main_city')
								->distinct()->first();
			$array_mainCityID = $array_mainCityID = ($country->list_main_city != '') ? explode(",", $country->list_main_city) : [];
			$array_mainCityID2 = Countries::join('country_hotels', 'countries.id', '=', 'country_hotels.country_id')
										->whereIn('countries.id', $array_mainCityID)
										->where('countries.parent_id', $region->id)
										->distinct()->pluck('countries.id')->toArray();
			$array_otherCityID = Countries::join('country_hotels', 'countries.id', '=', 'country_hotels.country_id')
										->whereNotIn('countries.id', $array_mainCityID2)
										->where('countries.parent_id', $region->id)
										->distinct()->pluck('countries.id')->toArray();
			return array_merge($array_mainCityID2, $array_otherCityID);
		}
		return;
	}
}

/**
 * get array main city id of country
 * @param int $country_id
 * @return list city 
 */
if(! function_exists('getArrayIdMainCityOfCountry')){
	function getArrayIdMainCityOfCountry($country_id){
		$country = Countries::join('overviews', 'countries.id', '=', 'overviews.country_id')
							->where('countries.id', $country_id)
							->select('countries.id as id', 'countries.title as title', 'countries.slug as slug', 'overviews.list_main_city as list_main_city')
							->distinct()->first();
		$array_regionID = Countries::where('parent_id', $country_id)->pluck('id')->toArray();
		return ($country->list_main_city != '') ? explode(",", $country->list_main_city) : [];
	}
}

/**
 * get list main city of country
 * @param int $country_id, int $limit = null
 * @return list main city of country
 */
if(! function_exists('getListMainCityOfCountry')){
	function getListMainCityOfCountry($country_id, $limit = NULL){
		$array_mainCityID = getArrayIdMainCityOfCountry($country_id);
		$list_city = Countries::join('country_hotels', 'countries.id', '=', 'country_hotels.country_id')
									->whereIn('countries.id', $array_mainCityID)
									->select('countries.id', 'countries.title', 'countries.slug', 'countries.image')
									->distinct();
		if($limit != NULL)
			$list_city = $list_city->limit($limit);
		$list_city = $list_city->get();
		return $list_city;
	}
}

/**
 * get list main city of country
 * @param int $country_id, int $limit = null
 * @return list main city of country
 */
if(! function_exists('getListMainCityOfCountryv2')){
	function getListMainCityOfCountryv2($country_id, $limit = NULL){
		$array_mainCityID = getArrayIdMainCityOfCountry($country_id);
		$list_city = Countries::whereIn('id', $array_mainCityID)
									->select('id', 'title', 'slug', 'image');
		if($limit != NULL)
			$list_city = $list_city->limit($limit);
		$list_city = $list_city->get();
		return $list_city;
	}
}

/**
 * get list other city of country
 * @param int $country_id
 * @return list city 
 */
if(! function_exists('getListOtherCityOfCountry')){
	function getListOtherCityOfCountry($country_id){
		$array_regionID = Countries::where('parent_id', $country_id)->pluck('id')->toArray();
		$array_mainCityID = getArrayIdMainCityOfCountry($country_id);
		return Countries::join('country_hotels', 'countries.id', '=', 'country_hotels.country_id')
									->whereNotIn('countries.id', $array_mainCityID)
									->whereIn('countries.parent_id', $array_regionID)
									->select('countries.*')
									->distinct()->get();
	}
}

/**
 * get list region in country
 * @param int $country_id
 * @return list region in country
 */
if(! function_exists('getListRegionInCountry')){
	function getListRegionInCountry($country_id){
		return Countries::where('parent_id', $country_id)->orderBy('title', 'asc')
						->select('id', 'title', 'image')
						->get();
	}
}

/**
 * get list region in country Alphaber
 * @param int $country_id
 * @return list region in country
 */
if(! function_exists('getListRegionAlphabetInCountry')){
	function getListRegionAlphabetInCountry($country_id){
		return Countries::where('parent_id', $country_id)->orderBy('title')
						->select('id', 'title', 'image')
						->get();
	}
}

/**
 * get list city in country
 * @param int $country_id
 * @return list city in country
 */
if(! function_exists('getListCitiesInCountry')){
	function getListCitiesInCountry($country_id, $order_by=null){
		$regions = Countries::where('parent_id', $country_id)->select('id')->pluck('id')->toArray();
		if($order_by == null) return Countries::whereIn('parent_id', $regions)
									->where('countries.status', 'active')
									->select('id', 'title', 'image','slug')
									->orderBy('position', 'asc')
									->get();
			else return Countries::whereIn('parent_id', $regions)
					->where('countries.status', 'active')
					->select('id', 'title', 'image','slug')
					->orderBy('title', 'asc')
					->get();
	}
}

/**
 * get country overview
 * @param int $slug_country
 * @return country overview
 */
if(! function_exists('getCountryOverviewBySlug')){
	function getCountryOverviewBySlug($slug_country){
		return Countries::join('overviews', 'countries.id', '=', 'overviews.country_id')
                            ->where('countries.slug', $slug_country)
                            ->select('overviews.*', 'countries.*', 'overviews.id as overview_id')
                            ->first();
	}
}
/**
 * get list main city in country
 * @param int $country_id
 * @return country overview
 */
if(! function_exists('getListCityInCountry')){
	function getListCityInCountry($country_id){
		return Overview::select('list_main_city')->where('country_id', $country_id)->first();
	}
}
/**
 * get all city
 * @return all city
 */
if(! function_exists('getAllCity')){
	function getAllCity(){
		$array_CountryID = Countries::where('parent_id', 0)->pluck('id')->toArray();
		$array_regionID = Countries::whereIn('parent_id', $array_CountryID)->pluck('id')->toArray();
		return Countries::whereIn('parent_id', $array_regionID)->orderBy('title', 'asc')->select('id', 'title')->get();
	}
}

/**
 * get list country by string id
 * @param string $list_str_id
 * @return list ob countries
 */
if(! function_exists('getListCountryByStringId')){
	function getListCountryByStringId($list_str_id){
		$array_id = ($list_str_id != '') ? explode(",", $list_str_id) : [];
		return Countries::whereIn('id', $array_id)->select('id', 'title', 'slug', 'image', 'short_desc')
		                    ->orderByRaw(\DB::raw("FIELD(id, ".implode(",",$array_id).")"))->get();
	}
}

/**
 * get all place to visit (highlight)
 * @return list place to visit
 */
if(! function_exists('getAllPlaceToVisit')){
	function getAllPlaceToVisit(){
		return Highlight::join('countries', 'highlights.country_id', '=', 'countries.id')
						->orderBy('countries.title', 'asc')
						->select('highlights.id', 'highlights.country_id')
						->get();
	}
}

/**
 * get places to visit by array id
 * @param $array_id
 * @return list object countries
 */
if(! function_exists('getPlacesToVisitByArrayID')){
	function getPlacesToVisitByArrayID($array_id){
		return Highlight::join('countries', 'highlights.country_id', '=', 'countries.id')
							->whereIn('highlights.id', $array_id)
							->select('countries.*')
							->distinct()->get();
	}
}

if(! function_exists('getCountriesfooter')){
	function getCountriesfooter(){
		return Countries::join('overviews', 'countries.id', '=', 'overviews.country_id')
                            ->where('countries.parent_id', 0)
                            ->select('countries.title as title','countries.slug as slug', 'overviews.icon_flag_gray as icon_flag_gray', 'overviews.icon_flag as icon_flag')
                            ->orderBy('position', 'asc')
                            ->distinct()
                            ->get(); 
	}
}

if(! function_exists('getAllCountryver2')){
	function getAllCountryver2(){
		return Countries::where('parent_id', 0)->orderBy('position', 'asc')->select('id', 'title', 'slug', 'position')->get();
	}
}

if(! function_exists('getslugCountry')){
	function getslugCountry($id){
		return Countries::where('id', $id)->select('slug')->first();
	}
}

/*
* get farthest parent of county
* @param country_id
* @return farthest country id
*/
if(!function_exists('dsGetParent1stCountry')){
	function dsGetParent1stCountry($id){
		$country = Countries::find($id);
		if($country == null) return $id;
		$parent = Countries::find($country->parent_id);
		if($parent == null) return $id;
		if($parent->parent_id == 0) return $parent->id;
			else return dsGetParent1stCountry($parent->id);
	}
}