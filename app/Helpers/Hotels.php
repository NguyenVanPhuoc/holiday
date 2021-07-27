<?php 

use App\Hotels;
use App\StarRatings;
use App\LocationHotels;
use App\SpecialHotels;
use App\Countries;
use App\CountryHotel;
use App\AttractionHotels;
use App\Facilities;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

//get list star rating
if(!function_exists('getListStarRatings')){
	function getListStarRatings(){
		$stars = StarRatings::orderBy('position', 'asc')->get();
		return $stars;
	}
}

//get star rating by ID
if(!function_exists('getStarRatingByID')){
	function getStarRatingByID($id){
		$star = StarRatings::find($id);
		return $star;
	}
}

//get star of hotel html
if(! function_exists('getStarOfHotelHtml')){
	function getStarOfHotelHtml($hotel_id){
		$html = '';

		$hotel = Hotels::find($hotel_id);
		$star = StarRatings::find($hotel->star_rating_id);
		if($star){
			$number_star = $star->number_star;
			for($i=0; $i < $number_star; $i++){
				$html .= '<i class="fa fa-star" aria-hidden="true"></i>';
			}
		}
		return $html;
	}
}

//get list location hotel
if(!function_exists('getListLocationHotels')){
	function getListLocationHotels(){
		$location = LocationHotels::orderBy('position', 'asc')->get();
		return $location;
	}
}

//get location hotel by ID
if(!function_exists('getLocationHotelByID')){
	function getLocationHotelByID($id){
		$location = LocationHotels::find($id);
		return $location;
	}
}

//get list special hotel
if(!function_exists('getListSpecialHotels')){
	function getListSpecialHotels(){
		$special = SpecialHotels::orderBy('position', 'asc')->get();
		return $special;
	}
}

//get list country hotel
if(!function_exists('getCountryHotel')){
	function getCountryHotel($hotel_id){
		$countryHotel = CountryHotel::where('hotel_id', $hotel_id)->orderBy('country_id', 'desc')->get();
		$html = '';
		if($countryHotel){
			foreach($countryHotel as $key => $item){
				$country = getCountryById($item->country_id);
				if($key == 0) $html .= $country->title;
				else $html .= ', ' . $country->title;
			}
		}
		return $html;
	}
}

//get list id country hotel
if(!function_exists('getListIDCountryHotel')){
	function getListIDCountryHotel($hotel_id){
		$countryHotel = CountryHotel::where('hotel_id', $hotel_id)->orderBy('country_id', 'asc')->get();
		$html = '';
		if($countryHotel){
			foreach($countryHotel as $key => $item){
				if($key == 0) $html .= $item->country_id;
				else $html .= ',' . $item->country_id;
			}
		}
		return $html;
	}
}


//get list nearby hotel
if(!function_exists('getListNearByHotel')){
	function getListNearByHotel($hotel_id){
		$nearbys = AttractionHotels::where('hotel_id', $hotel_id)->orderBy('position', 'asc')->get();
		return $nearbys;
	}
}

//get list hotel order by title
if(!function_exists('getHotelsOrderByTitle')){
	function getHotelsOrderByTitle(){
		$hotels = Hotels::orderBy('title', 'asc')->get();
		return $hotels;
	}
}

//get hotel by ID
if(!function_exists('getHotelByID')){
	function getHotelByID($id){
		$hotel = Hotels::find($id);
		return $hotel;
	}
}

//get list hotel by country
if(! function_exists('getListHotelByCountry')){
	function getListHotelByCountry($country_id, $number_take = NULL, $paginate = false, $page = 1){
		$country = Countries::findOrFail($country_id);
		$level_country = getLevelCountry($country_id);
		if($level_country == 3)
			$arrayID[] = $country_id;
		else
			$arrayID = getArrayIdChildOfCountry($country_id);
		if($number_take != NULL && $paginate == true){
			$temp = Hotels::join('country_hotels', 'hotels.id', '=', 'country_hotels.hotel_id')
						->whereIn('country_hotels.country_id', $arrayID)
						->select('hotels.*')
						->distinct('country_hotels.hotel_id')
						->get();
			$items = $temp instanceof Collection ? $temp : Collection::make($temp);		
			$url_path = $country->slug . '-travel/accommodation'; 
			$hotels = new LengthAwarePaginator($items->forPage($page, $number_take), count($items), $number_take, $page, ['path'=>url($url_path)]); 	
		}
		else if($number_take != NULL && $paginate == false)
			$hotels = Hotels::join('country_hotels', 'hotels.id', '=', 'country_hotels.hotel_id')
						->whereIn('country_hotels.country_id', $arrayID)
						->select('hotels.*')
						->distinct()
						->take($number_take)->get();
		
		else
			$hotels = Hotels::join('country_hotels', 'hotels.id', '=', 'country_hotels.hotel_id')
						->whereIn('country_hotels.country_id', $arrayID)
						->select('hotels.*')
						->distinct()
						->get();
		return $hotels;
	}
}

/**
 * filter hotel admin
 */
if(! function_exists('filterHotelAdmin')){
	function filterHotelAdmin($request, $per_page, $page){
		$hotels = Hotels::join('country_hotels', 'hotels.id', '=', 'country_hotels.hotel_id');
		if($request->country_id && $request->country_id != '')
			$hotels = $hotels->where('country_hotels.country_id', $request->country_id);
		if($request->s && $request->s != '')
			$hotels = $hotels->where('hotels.title', 'LIKE', '%'. $request->s .'%');
		$hotels = $hotels->select('hotels.*')
						->distinct('country_hotels.hotel_id')
						->latest('hotels.created_at')
						->get();
		$items = $hotels instanceof Collection ? $hotels : Collection::make($hotels);
		 
		$list_hotels = new LengthAwarePaginator($items->forPage($page, $per_page), count($items), $per_page, $page);
		return $list_hotels;	
	}
}

/**
 * get array county id of hotel
 * @param $hotel_id
 * @return array country id
 */
if(! function_exists('getArrayCountryIdOfHotel')){
	function getArrayCountryIdOfHotel($hotel_id){
		return CountryHotel::where('hotel_id', $hotel_id)->pluck('country_id')->toArray();
	}
}


/**
 * get list similar hotel
 * @param int $country_id, int current_hotel_id
 * @return list object hotel
 */
if(! function_exists('getListSimilarHotel')){
	function getListSimilarHotel($country_id, $current_hotel_id = NULL, $limit = 20){
		$array_countryId = [];
		$level_country = getLevelCountry($country_id);
		if($level_country == 3){
			$array_countryId[] = $country_id;
		}else if($level_country ==1 || $level_country == 2){
			$array_countryId = getArrayIdChildOfCountry($country_id);
			$array_countryId[] = $country_id;
		}
		$list_hotel = Hotels::join('country_hotels', 'hotels.id', '=', 'country_hotels.hotel_id')
							->whereIn('country_hotels.country_id', $array_countryId);
		if($current_hotel_id != NULL)
			$list_hotel = $list_hotel->whereNotIn('hotels.id', [$current_hotel_id]);
		$list_hotel = $list_hotel->distinct()
								->select('hotels.id', 'hotels.title', 'hotels.image', 'hotels.star_rating_id')
								->limit($limit)
								->get();
		return $list_hotel;
	}
}


/**
 * count hotel in city
 * @param int country_id
 * @return int number count 
 */
if(! function_exists('countHotelInCity')){
	function countHotelInCity($country_id){
		return CountryHotel::where('country_id', $country_id)->count();
	}
}

/**
 * count hotel in star
 * @param int star_id
 * @return int number count
 */
if(! function_exists('countHotelInStar')){
	function countHotelInStar($star_id, $country_id = NULL){
		$count_hotel =  Hotels::join('country_hotels', 'hotels.id', '=', 'country_hotels.hotel_id')
									->where('hotels.star_rating_id', $star_id);
		if($country_id != NULL){
			$arr_countryID = getArrayIdChildOfCountry($country_id); //child of country_id
			$arr_countryID[] = $country_id;
			$count_hotel = $count_hotel->whereIn('country_hotels.country_id', $arr_countryID);
		}
		$count_hotel = $count_hotel->distinct('hotels.id')->count('hotels.id');
		return $count_hotel;
		//return Hotels::where('star_rating_id', $star_id)->count();
	}
}

/**
 * count hotel in location
 * @param int location_id
 * @return int number count
 */
if(! function_exists('countHotelInLocation')){
	function countHotelInLocation($location_id, $country_id = NULL){
		//return Hotels::where('location_id', $location_id)->count();
		$count_hotel =  Hotels::join('country_hotels', 'hotels.id', '=', 'country_hotels.hotel_id')
									->where('hotels.location_id', $location_id);
		if($country_id != NULL){
			$arr_countryID = getArrayIdChildOfCountry($country_id); //child of country_id
			$arr_countryID[] = $country_id;
			$count_hotel = $count_hotel->whereIn('country_hotels.country_id', $arr_countryID);
		}
		$count_hotel = $count_hotel->distinct('hotels.id')->count('hotels.id');
		return $count_hotel;
	}
}

/**
 * count hotel in location
 * @param int special_id
 * @return int number count
 */
if(! function_exists('countHotelInSpecial')){
	function countHotelInSpecial($special_id, $country_id = NULL){
		//return Hotels::whereRaw("find_in_set($special_id,special_id)")->count();
		$count_hotel =  Hotels::join('country_hotels', 'hotels.id', '=', 'country_hotels.hotel_id')
									->whereRaw("find_in_set($special_id,hotels.special_id)");
		if($country_id != NULL){
			$arr_countryID = getArrayIdChildOfCountry($country_id); //child of country_id
			$arr_countryID[] = $country_id;
			$count_hotel = $count_hotel->whereIn('country_hotels.country_id', $arr_countryID);
		}
		$count_hotel = $count_hotel->distinct('hotels.id')->count('hotels.id');
		return $count_hotel;
	}
}

/**
 * filter hotel
 * @param int $country_id, int $star_id, int location_id, array $arr_special_id, int $per_page, int $page
 * @return list hotel (accommodation)
 */
if(! function_exists('filterHotel')){
	function filterHotel($current_country_id, $country_id, $star_id, $location_id, $arr_special_id, $per_page, $page = 1){
		
		$hotels = Hotels::join('country_hotels', 'hotels.id', '=', 'country_hotels.hotel_id');
		//current country hotel
		if($current_country_id != NULL && $current_country_id != ''){
			$level_country = getLevelCountry($current_country_id);
			if($level_country == 3)
				$array_cityID = [$current_country_id];
			else
				$array_cityID = getArrayCityIdOfCountryHotel($current_country_id);
			$hotels = $hotels->whereIn('country_hotels.country_id', $array_cityID);
		}

		if($country_id != NULL && $country_id != ''){
			$hotels = $hotels->where('country_hotels.country_id', $country_id);

			$country = Countries::findOrFail($country_id);
			$url_path = $country->slug . '-travel/accommodation';
		}
		else
			$url_path = '/';

		if($star_id != NULL && $star_id != '')
			$hotels = $hotels->where('hotels.star_rating_id', $star_id);
		if($location_id != NULL && $location_id != '')
			$hotels = $hotels->where('hotels.location_id', $location_id);
		if($arr_special_id != NULL){
			foreach($arr_special_id as $special_id){
				$hotels = $hotels->whereRaw("find_in_set($special_id,special_id)");
			}
		}
		
		$hotels = $hotels->select('hotels.*')
						->distinct('country_hotels.hotel_id')
						->get();
		$items = $hotels instanceof Collection ? $hotels : Collection::make($hotels);

		/*if($country_id != NULL){
			$country = Countries::findOrFail($country_id);
			$url_path = $country->slug . '-travel/accommodation';
		}
		else
			$url_path = '/';*/
		 
		$list_hotels = new LengthAwarePaginator($items->forPage($page, $per_page), count($items), $per_page, $page, ['path'=>url($url_path)]);
		return $list_hotels;	
	}
}

/**
 * count hotel in each city
 * @param int $country_id, int $city_id (id in table country), int $star_id, int location_id, array $arr_special_id, int $type_array (value is 1 or 2 => 1 or 2-dimensional arrays)
 * @return array with key is id city (country), value is count hotel in city
 */
if(! function_exists('arrayCountHotelInCity')){
	function arrayCountHotelInCity($country_id, $city_id, $star_id, $location_id, $arr_special_id, $type_array = 2){
		$level_country = getLevelCountry($country_id);
		if($level_country == 3)
			$array_cityID = [$country_id];
		else
			$array_cityID = getArrayCityIdOfCountryHotel($country_id);
		$arrayCount = [];
		foreach($array_cityID as $key => $value){
			$count_hotel = Hotels::join('country_hotels', 'hotels.id', '=', 'country_hotels.hotel_id');

			if($city_id != NULL && $city_id != '')
				$count_hotel = $count_hotel->where('country_hotels.country_id', $city_id);
			if($star_id != NULL && $star_id != '')
				$count_hotel = $count_hotel->where('hotels.star_rating_id', $star_id);
			if($location_id != NULL && $location_id != '')
				$count_hotel = $count_hotel->where('hotels.location_id', $location_id);
			if($arr_special_id != NULL){
				foreach($arr_special_id as $special_id){
					$count_hotel = $count_hotel->whereRaw("find_in_set($special_id,special_id)");
				}
			}
			$count_hotel = $count_hotel = $count_hotel->where('country_hotels.country_id', $value)
							->select('hotels.*')
							->distinct('country_hotels.hotel_id')
							->count();

			if($type_array == 1) // 1-dimensional arrays
				$arrayCount[$value] = $count_hotel; 
			else{ //2-dimensional arrays
				$arrayCount[$key]['id'] = $value;
				$arrayCount[$key]['value'] = $count_hotel;
			}
		}
		return $arrayCount;
	}
}


/**
 * count hotel in each star
 * @param int $country_id, int $city_id (id in table country), int $star_id, int location_id, array $arr_special_id
 * @return array with key is id city (country), value is count hotel in city
 */
if(! function_exists('arrayCountHotelInStar')){
	function arrayCountHotelInStar($country_id, $city_id, $star_id, $location_id, $arr_special_id, $type_array = 2){
		$array_starID = StarRatings::orderBy('position', 'asc')->pluck('id')->toArray();
		$arrayCount = [];
		foreach($array_starID as $key => $value){
			$count_hotel = Hotels::join('country_hotels', 'hotels.id', '=', 'country_hotels.hotel_id');
			if($country_id != NULL && $country_id != ''){
				$level_country = getLevelCountry($country_id);
				if($level_country == 3)
					$array_cityID = [$country_id];
				else
					$array_cityID = getArrayCityIdOfCountryHotel($country_id);
				$count_hotel = $count_hotel->whereIn('country_hotels.country_id', $array_cityID);
			}
			if($city_id != NULL && $city_id != '')
				$count_hotel = $count_hotel->where('country_hotels.country_id', $city_id);
			if($star_id != NULL && $star_id != '')
				$count_hotel = $count_hotel->where('hotels.star_rating_id', $star_id);
			if($location_id != NULL && $location_id != '')
				$count_hotel = $count_hotel->where('hotels.location_id', $location_id);
			if($arr_special_id != NULL){
				foreach($arr_special_id as $special_id){
					$count_hotel = $count_hotel->whereRaw("find_in_set($special_id,special_id)");
				}
			}
			$count_hotel = $count_hotel = $count_hotel->where('hotels.star_rating_id', $value)
							->select('hotels.id')
							->distinct('hotels.id')
							->count('hotels.id');
			if($type_array == 1) // 1-dimensional arrays
				$arrayCount[$value] = $count_hotel; 
			else{ //2-dimensional arrays
				$arrayCount[$key]['id'] = $value;
				$arrayCount[$key]['value'] = $count_hotel;
			}
		}
		return $arrayCount;
	}
}

/**
 * count hotel in each location 
 * @param int $country_id, int $city_id (id in table country), int $star_id, int location_id, array $arr_special_id
 * @return array with key is id city (country), value is count hotel in city
 */
if(! function_exists('arrayCountHotelInLocation')){
	function arrayCountHotelInLocation($country_id, $city_id, $star_id, $location_id, $arr_special_id, $type_array = 2){
		$array_locationID = LocationHotels::orderBy('position', 'asc')->pluck('id')->toArray();
		$arrayCount = [];
		foreach($array_locationID as $key => $value){
			$count_hotel = Hotels::join('country_hotels', 'hotels.id', '=', 'country_hotels.hotel_id');
			if($country_id != NULL && $country_id != ''){
				$level_country = getLevelCountry($country_id);
				if($level_country == 3)
					$array_cityID = [$country_id];
				else
					$array_cityID = getArrayCityIdOfCountryHotel($country_id);
				$count_hotel = $count_hotel->whereIn('country_hotels.country_id', $array_cityID);
			}
			if($city_id != NULL && $city_id != '')
				$count_hotel = $count_hotel->where('country_hotels.country_id', $city_id);
			if($star_id != NULL && $star_id != '')
				$count_hotel = $count_hotel->where('hotels.star_rating_id', $star_id);
			if($location_id != NULL && $location_id != '')
				$count_hotel = $count_hotel->where('hotels.location_id', $location_id);
			if($arr_special_id != NULL){
				foreach($arr_special_id as $special_id){
					$count_hotel = $count_hotel->whereRaw("find_in_set($special_id,special_id)");
				}
			}
			$count_hotel = $count_hotel = $count_hotel->where('hotels.location_id', $value)
							->select('hotels.id')
							->distinct('hotels.id')
							->count('hotels.id');
			if($type_array == 1) // 1-dimensional arrays
				$arrayCount[$value] = $count_hotel; 
			else{ //2-dimensional arrays
				$arrayCount[$key]['id'] = $value;
				$arrayCount[$key]['value'] = $count_hotel;
			}
		}
		return $arrayCount;
	}
}

/**
 * count hotel in each special 
 * @param int $country_id, int $city_id (id in table country), int $star_id, int location_id, array $arr_special_id
 * @return array with key is id city (country), value is count hotel in city
 */
if(! function_exists('arrayCountHotelInSpecial')){
	function arrayCountHotelInSpecial($country_id, $city_id, $star_id, $location_id, $arr_special_id, $type_array = 2){
		$array_specialID = SpecialHotels::orderBy('position', 'asc')->pluck('id')->toArray();
		$arrayCount = [];
		foreach($array_specialID as $key => $value){
			$count_hotel = Hotels::join('country_hotels', 'hotels.id', '=', 'country_hotels.hotel_id');
			if($country_id != NULL && $country_id != ''){
				$level_country = getLevelCountry($country_id);
				if($level_country == 3)
					$array_cityID = [$country_id];
				else
					$array_cityID = getArrayCityIdOfCountryHotel($country_id);
				$count_hotel = $count_hotel->whereIn('country_hotels.country_id', $array_cityID);
			}
			if($city_id != NULL && $city_id != '')
				$count_hotel = $count_hotel->where('country_hotels.country_id', $city_id);
			if($star_id != NULL && $star_id != '')
				$count_hotel = $count_hotel->where('hotels.star_rating_id', $star_id);
			if($location_id != NULL && $location_id != '')
				$count_hotel = $count_hotel->where('hotels.location_id', $location_id);
			if($arr_special_id != NULL){
				foreach($arr_special_id as $special_id){
					$count_hotel = $count_hotel->whereRaw("find_in_set($special_id,special_id)");
				}
			}
			$count_hotel = $count_hotel = $count_hotel->whereRaw("find_in_set($value,special_id)")
							->select('hotels.id')
							->distinct('hotels.id')
							->count('hotels.id');
			if($type_array == 1) // 1-dimensional arrays
				$arrayCount[$value] = $count_hotel; 
			else{ //2-dimensional arrays
				$arrayCount[$key]['id'] = $value;
				$arrayCount[$key]['value'] = $count_hotel;
			}
		}
		return $arrayCount;
	}
}

/**
 * get link country hotel by multi param
 * @param $request
 * @return url route('hotelsByMultiParam', ...)
 */
if(! function_exists('getLinkCountryHotelsByMultiParam')){
	function getLinkCountryHotelsByMultiParam($request){
		$per_page = 8; $page = 1;
		if($request->per_page && $request->per_page != NULL && $request->per_page != '')
			$per_page = $request->per_page;
		if($request->page && $request->page != NULL && $request->page != '')
			$page = $request->page;

		$country = Countries::findOrFail($request->current_country);
		$slug_city = $slug_star = $slug_location = $slug_special = 'noindex';
		if($request->city != NULL && $request->city != ''){
			$city = Countries::findOrFail($request->city);
			$slug_city = $city->slug;
		}
		if($request->star != NULL && $request->star != ''){
			$star = StarRatings::findOrFail($request->star);
			$slug_star = $star->slug;
		}
		if($request->location != NULL && $request->location != ''){
			$location = LocationHotels::findOrFail($request->location);
			$slug_location = $location->slug;
		}
		if($request->special && $request->special != NULL && $request->special != ''){
			$array_slug = SpecialHotels::whereIn('id', $request->special)->pluck('slug')->toArray();
			$slug_special = implode("-and-", $array_slug);
		}


		$param_url = ['slug_country' => $country->slug, 'city' => $slug_city, 'star' => $slug_star, 'location' => $slug_location, 'special' => $slug_special, 'per_page' => $per_page, 'page' => $page];

		$level_country = getLevelCountry($request->current_country);
		if($level_country == 1)
			return route('countryHotelsByMultiParam', $param_url);
		else if($level_country == 2){
			$region = Countries::findOrFail($request->current_country);
			$country = Countries::findOrFail($region->parent_id);
			$param_url['slug_country'] = $country->slug;
			$param_url['slug'] = $region->slug . '-accommodation';
			return route('regionHotelsByMultiParam', $param_url);
		}
		else if ($level_country == 3) {
			$city = Countries::findOrFail($request->current_country);
			$fathesr_id = getFarthestParentCountry($city->id);
			$country = Countries::findOrFail($fathesr_id);
			$param_url['slug_country'] = $country->slug;
			$param_url['slug'] = $city->slug . '-accommodation';
			unset($param_url['city']);
			return route('cityHotelsByMultiParam', $param_url);
		}
		return;
	}
}

/**
 * data send region hotel
 * @param  string $slug_country, string $slug 
 */
if(! function_exists('dataSendRegionHotel')){
	function dataSendRegionHotel($slug_country, $slug){
		$country = Countries::join('overviews', 'countries.id', '=', 'overviews.country_id')
							->where('countries.slug', $slug_country)
							->select('countries.id', 'countries.title', 'countries.slug', 'overviews.list_main_city')
							->distinct()->first();
        $region = Countries::findBySlug($slug); 

        $array_regionID = Countries::where('parent_id', $country->id)->pluck('id')->toArray();
		$array_mainCityID = ($country->list_main_city != '') ? explode(",", $country->list_main_city) : [];
		$list_main_city = Countries::join('country_hotels', 'countries.id', '=', 'country_hotels.country_id')
									->whereIn('countries.id', $array_mainCityID)
									->where('countries.parent_id', $region->id)
									->select('countries.*')
									->distinct()->get(); 
		$other_city = Countries::join('country_hotels', 'countries.id', '=', 'country_hotels.country_id')
									->whereNotIn('countries.id', $array_mainCityID)
									->whereIn('countries.parent_id', $array_regionID)
									->where('countries.parent_id', $region->id)
									->select('countries.*')
									->distinct()->get();
		$list_star = StarRatings::orderBy('position', 'asc')->get();
		$list_location = LocationHotels::orderBy('position', 'asc')->get();
		$list_special = SpecialHotels::orderBy('position', 'asc')->get();
		$list_hotel = getListHotelByCountry($region->id, 8, true);  
		$list_consultant = getConsultantsByCountry($country->id);

		$data = [];
		$data['country'] = $country;
		$data['region'] = $region;
		$data['list_main_city'] = $list_main_city;
		$data['other_city'] = $other_city;
		$data['list_star'] = $list_star;
		$data['list_location'] = $list_location;
		$data['list_special'] = $list_special;
		$data['list_hotel'] = $list_hotel;
		$data['list_consultant'] = $list_consultant;
		return $data;
	}
}


/**
 * data send city hotel
 * @param  string $slug_country, string $slug 
 */
if(! function_exists('dataSendCityHotel')){
	function dataSendCityHotel($slug_country, $slug){
		$country = Countries::join('overviews', 'countries.id', '=', 'overviews.country_id')
							->where('countries.slug', $slug_country)
							->select('countries.id', 'countries.title', 'countries.slug', 'overviews.list_main_city')
							->distinct()->first();
		$city = Countries::findBySlug($slug); 
		$region = Countries::findOrFail($city->parent_id);

		$list_star = StarRatings::orderBy('position', 'asc')->get();
		$list_location = LocationHotels::orderBy('position', 'asc')->get();
		$list_special = SpecialHotels::orderBy('position', 'asc')->get();
		$list_hotel = getListHotelByCountry($city->id, 8, true);  
		$list_consultant = getConsultantsByCountry($country->id);

		$data = [];
		$data['country'] = $country;
		$data['region'] = $region;
		$data['city'] = $city;
		$data['list_star'] = $list_star;
		$data['list_location'] = $list_location;
		$data['list_special'] = $list_special;
		$data['list_hotel'] = $list_hotel;
		$data['list_consultant'] = $list_consultant;
		return $data;
	}
}

/**
 * data send detail hotel
 * @param  string $slug_country, string $slug 
 */
if(! function_exists('dataSendDetailHotel')){
	function dataSendDetailHotel($slug_country, $slug){
		$country = Countries::findBySlug($slug_country);
		$region = CountryHotel::join('countries', 'country_hotels.country_id', '=', 'countries.id')
								->join('hotels', 'country_hotels.hotel_id', '=', 'hotels.id')
								->where('countries.parent_id', $country->id)
								->where('hotels.slug', $slug)
								->distinct('country_hotels.hotel_id')
								->select('countries.*')
								->first(); 
		$city = CountryHotel::join('countries', 'country_hotels.country_id', '=', 'countries.id')
								->join('hotels', 'country_hotels.hotel_id', '=', 'hotels.id')
								->where('hotels.slug', $slug)
								->where('countries.parent_id', $region->id)
								->distinct('country_hotels.hotel_id')
								->select('countries.*')
								->first();  
		$hotel = Hotels::findBySlug($slug);
		$array_facilities = ($hotel->facilities != '') ? explode(",", $hotel->facilities) : [];
		$list_facility = Facilities::whereIn('id', $array_facilities)->get();
		$list_attraction = AttractionHotels::join('hotels', 'attraction_hotels.hotel_id', '=', 'hotels.id')
										->join('attractions', 'attraction_hotels.attraction_id', '=', 'attractions.id')
										->where('attraction_hotels.hotel_id', $hotel->id)
										->select('attraction_hotels.*', 'attractions.title', 'attractions.image', 'attractions.gallery')
										->distinct()
										->get();
		$list_similar_hotel = getListSimilarHotel($city->id);
		$list_main_city = getListMainCityOfCountry($country->id);
		$list_other_city = getListOtherCityOfCountry($country->id);
		$list_star = StarRatings::orderBy('position', 'asc')->get();
		$list_location = LocationHotels::orderBy('position', 'asc')->get();
		$list_special = SpecialHotels::orderBy('position', 'asc')->get();
		$list_consultant = getConsultantsByCountry($country->id);
		$seo = get_seo($hotel->id, 'hotel');
		$data = [];
		$data['country'] = $country;
		$data['region'] = $region;
		$data['city'] = $city;
		$data['hotel'] = $hotel;
		$data['list_facility'] = $list_facility;
		$data['list_attraction'] = $list_attraction;
		$data['list_similar_hotel'] = $list_similar_hotel;
		$data['list_main_city'] = $list_main_city;
		$data['list_other_city'] = $list_other_city;
		$data['list_star'] = $list_star;
		$data['list_location'] = $list_location;
		$data['list_special'] = $list_special;
		$data['list_consultant'] = $list_consultant;
		$data['seo'] = $seo;
		return $data;
	}
}

/**
 * get list hotel by array id
 * @param array $array_id
 * @return list object hotels
 */
if(! function_exists('getListHotelByArrayId')){
	function getListHotelByArrayId($array_id){
		return Hotels::whereIn('id', $array_id)->get();
	}
}