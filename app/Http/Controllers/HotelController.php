<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotels;
use App\Countries;
use App\Overview;
use App\StarRatings;
use App\LocationHotels;
use App\SpecialHotels;


class HotelController extends Controller
{
	public function searchByName($city_id, Request $request){
		if($request->ajax()){
			$list_hotel = Hotels::join('country_hotels', 'hotels.id', '=', 'country_hotels.hotel_id')
									->where('country_hotels.country_id', $city_id)
									->where('hotels.title', 'like', '%'.$request->keyword.'%')
									->select('hotels.*')->distinct()->get();
			$html = '';
			if($list_hotel && count($list_hotel) > 0){
		        foreach($list_hotel as $item){
		            $html .= '<li><a href="#">'. $item->title .'</a></li>';
		        }
		    }
		    else{
		    	$html .= '<li class="no-result">Please recheck your typing or <a href="#" class="">CONTACT US</a> for more detail</li>';
		    }
	        return response()->json(['msg' => 'success', 'html' => $html]);
	    }
	    return response()->json(['msg' => 'error']);
	}

	//country hotel (accommodation)
	public function countryHotel($slug_country){
		/*$country = Countries::findBySlug($slug_country);
		$overview = Overview::join('countries', 'overviews.country_id', '=', 'countries.id')
							->first(); */
		$country = Countries::join('overviews', 'countries.id', '=', 'overviews.country_id')
							->where('countries.slug', $slug_country)
							->select('countries.id', 'countries.title', 'countries.slug', 'overviews.list_main_city')
							->distinct()->first();
		$array_regionID = Countries::where('parent_id', $country->id)->pluck('id')->toArray();
		$array_mainCityID = ($country->list_main_city != '') ? explode(",", $country->list_main_city) : [];
		$list_main_city = Countries::join('country_hotels', 'countries.id', '=', 'country_hotels.country_id')
									->whereIn('countries.id', $array_mainCityID)
									->select('countries.*')
									->distinct()->get();
		$other_city = Countries::join('country_hotels', 'countries.id', '=', 'country_hotels.country_id')
									->whereNotIn('countries.id', $array_mainCityID)
									->whereIn('countries.parent_id', $array_regionID)
									->select('countries.*')
									->distinct()->get();
		$list_star = StarRatings::orderBy('position', 'asc')->get();
		$list_location = LocationHotels::orderBy('position', 'asc')->get();
		$list_special = SpecialHotels::orderBy('position', 'asc')->get();
		$list_hotel = getListHotelByCountry($country->id, 8, true);  
		$list_consultant = getConsultantsByCountry($country->id);

		$data = [];
		$data['country'] = $country;
		$data['list_main_city'] = $list_main_city;
		$data['other_city'] = $other_city;
		$data['list_star'] = $list_star;
		$data['list_location'] = $list_location;
		$data['list_special'] = $list_special;
		$data['list_hotel'] = $list_hotel;
		$data['list_consultant'] = $list_consultant;
		/*TEST*/
		
		/*END TEST*/
		return view('hotels.countryHotel', $data);
	}

	/**
	 * filter hotel
	 */
	public function filterHotel(Request $request){
		$per_page = 8; $page = 1;
		if($request->per_page && $request->per_page != NULL && $request->per_page != '')
			$per_page = $request->per_page;
		if($request->page && $request->page != NULL && $request->page != '')
			$page = $request->page;
		$list_hotel = filterHotel($request->current_country, $request->city, $request->star, $request->location, $request->special, $per_page, $page);
		$country = Countries::findOrFail($request->current_country);
		$data_view = [
			'list_hotel' => $list_hotel,
			'country' => $country
		];
		
		$html = view('hotels.content-list-hotel', $data_view)->render();
		$array_countCity = arrayCountHotelInCity($request->current_country, $request->city, $request->star, $request->location, $request->special);
		$array_countStar = arrayCountHotelInStar($request->current_country, $request->city, $request->star, $request->location, $request->special);
		$array_countLotion = arrayCountHotelInLocation($request->current_country, $request->city, $request->star, $request->location, $request->special);
		$array_countSpecial = arrayCountHotelInSpecial($request->current_country, $request->city, $request->star, $request->location, $request->special);
		

		$data_response = [
			'msg' => 'success', 
			'html' => $html, 
			'count_city' => $array_countCity,
			'count_star' => $array_countStar,
			'count_location' => $array_countLotion,
			'count_special' => $array_countSpecial,
			'url' => getLinkCountryHotelsByMultiParam($request),
			'total' => $list_hotel->total()
		];
		return response()->json($data_response);
	}


	/**
	 * list hotel by multi param
	 */
	public function countryHotelsByMultiParam($slug_country, $city, $star, $location, $special, $per_page, $page){
		$city = Countries::findBySlug($city);
		$star = StarRatings::findBySlug($star);
		$location = LocationHotels::findBySlug($location);
		$array_slugSpecial = explode("-and-", $special);
		$array_IdSplecial = SpecialHotels::whereIn('slug', $array_slugSpecial)->pluck('id')->toArray();
		$city_id = ($city) ? $city->id : NULL;
		$star_id = ($star) ? $star->id : NULL;
		$location_id = ($location) ? $location->id : NULL;

		$country = Countries::join('overviews', 'countries.id', '=', 'overviews.country_id')
							->where('countries.slug', $slug_country)
							->select('countries.id', 'countries.title', 'countries.slug', 'overviews.list_main_city')
							->distinct()->first();
		$array_regionID = Countries::where('parent_id', $country->id)->pluck('id')->toArray();
		$array_mainCityID = ($country->list_main_city != '') ? explode(",", $country->list_main_city) : [];
		$list_main_city = Countries::join('country_hotels', 'countries.id', '=', 'country_hotels.country_id')
									->whereIn('countries.id', $array_mainCityID)
									->select('countries.*')
									->distinct()->get();
		$other_city = Countries::join('country_hotels', 'countries.id', '=', 'country_hotels.country_id')
									->whereNotIn('countries.id', $array_mainCityID)
									->whereIn('countries.parent_id', $array_regionID)
									->select('countries.*')
									->distinct()->get();
		$list_star = StarRatings::orderBy('position', 'asc')->get();
		$list_location = LocationHotels::orderBy('position', 'asc')->get();
		$list_special = SpecialHotels::orderBy('position', 'asc')->get();
		$list_consultant = getConsultantsByCountry($country->id);
		//$list_hotel = getListHotelByCountry($country->id, 8, true);  
		$list_hotel = filterHotel($country->id, $city_id, $star_id, $location_id, $array_IdSplecial, $per_page, $page);  
		$array_countCity = arrayCountHotelInCity($country->id, $city_id, $star_id, $location_id, $array_IdSplecial, 1); 
		$array_countStar = arrayCountHotelInStar($country->id, $city_id, $star_id, $location_id, $array_IdSplecial, 1);
		$array_countLotion = arrayCountHotelInLocation($country->id, $city_id, $star_id, $location_id, $array_IdSplecial, 1);
		$array_countSpecial = arrayCountHotelInSpecial($country->id, $city_id, $star_id, $location_id, $array_IdSplecial, 1);


		$data = [];
		$data['country'] = $country;
		$data['list_main_city'] = $list_main_city;
		$data['other_city'] = $other_city;
		$data['list_star'] = $list_star;
		$data['list_location'] = $list_location;
		$data['list_special'] = $list_special;
		$data['list_hotel'] = $list_hotel;
		$data['list_consultant'] = $list_consultant;
		$data['city_id'] = $city_id;
		$data['star_id'] = $star_id;
		$data['location_id'] = $location_id;
		$data['array_IdSplecial'] = $array_IdSplecial;
		$data['array_countCity'] = $array_countCity;
		$data['array_countStar'] = $array_countStar;
		$data['array_countLotion'] = $array_countLotion;
		$data['array_countSpecial'] = $array_countSpecial;
		return view('hotels.countryHotel', $data);
	}

	public function regionHotelsByMultiParam($slug_country, $slug, $city, $star, $location, $special, $per_page, $page){
		$slug = substr($slug,0,-14); //remove '-accommodation' in $slug
		$region = Countries::findBySlug($slug);
		$city = Countries::findBySlug($city);
		$star = StarRatings::findBySlug($star);
		$location = LocationHotels::findBySlug($location);
		$array_slugSpecial = explode("-and-", $special);
		$array_IdSplecial = SpecialHotels::whereIn('slug', $array_slugSpecial)->pluck('id')->toArray();
		$city_id = ($city) ? $city->id : NULL;
		$star_id = ($star) ? $star->id : NULL;
		$location_id = ($location) ? $location->id : NULL;

		$country = Countries::join('overviews', 'countries.id', '=', 'overviews.country_id')
							->where('countries.slug', $slug_country)
							->select('countries.id', 'countries.title', 'countries.slug', 'overviews.list_main_city')
							->distinct()->first();
		$array_regionID = Countries::where('parent_id', $country->id)->pluck('id')->toArray();
		$array_mainCityID = ($country->list_main_city != '') ? explode(",", $country->list_main_city) : [];
		$list_main_city = Countries::join('country_hotels', 'countries.id', '=', 'country_hotels.country_id')
									->where('countries.parent_id', $region->id)
									->whereIn('countries.id', $array_mainCityID)
									->select('countries.*')
									->distinct()->get();
		$other_city = Countries::join('country_hotels', 'countries.id', '=', 'country_hotels.country_id')
									->where('countries.parent_id', $region->id)
									->whereNotIn('countries.id', $array_mainCityID)
									->whereIn('countries.parent_id', $array_regionID)
									->select('countries.*')
									->distinct()->get();
		$list_star = StarRatings::orderBy('position', 'asc')->get();
		$list_location = LocationHotels::orderBy('position', 'asc')->get();
		$list_special = SpecialHotels::orderBy('position', 'asc')->get();
		$list_consultant = getConsultantsByCountry($country->id);
		//$list_hotel = getListHotelByCountry($country->id, 8, true);  
		$list_hotel = filterHotel($region->id, $city_id, $star_id, $location_id, $array_IdSplecial, $per_page, $page);  
		$array_countCity = arrayCountHotelInCity($region->id, $city_id, $star_id, $location_id, $array_IdSplecial, 1); //dd($array_countCity);
		$array_countStar = arrayCountHotelInStar($region->id, $city_id, $star_id, $location_id, $array_IdSplecial, 1);
		$array_countLotion = arrayCountHotelInLocation($region->id, $city_id, $star_id, $location_id, $array_IdSplecial, 1);
		$array_countSpecial = arrayCountHotelInSpecial($region->id, $city_id, $star_id, $location_id, $array_IdSplecial, 1);


		$data = [];
		$data['region'] = $region;
		$data['country'] = $country;
		$data['list_main_city'] = $list_main_city;
		$data['other_city'] = $other_city;
		$data['list_star'] = $list_star;
		$data['list_location'] = $list_location;
		$data['list_special'] = $list_special;
		$data['list_hotel'] = $list_hotel;
		$data['list_consultant'] = $list_consultant;
		$data['city_id'] = $city_id;
		$data['star_id'] = $star_id;
		$data['location_id'] = $location_id;
		$data['array_IdSplecial'] = $array_IdSplecial;
		$data['array_countCity'] = $array_countCity;
		$data['array_countStar'] = $array_countStar;
		$data['array_countLotion'] = $array_countLotion;
		$data['array_countSpecial'] = $array_countSpecial;
		return view('hotels.regionHotel', $data);
	}


	public function cityHotelsByMultiParam($slug_country, $slug, $star, $location, $special, $per_page, $page){
		$slug = substr($slug,0,-14); //remove '-accommodation' in $slug
		$city = Countries::findBySlug($slug); 
		$region = Countries::findOrFail($city->parent_id);
		$star = StarRatings::findBySlug($star);
		$location = LocationHotels::findBySlug($location);
		$array_slugSpecial = explode("-and-", $special);
		$array_IdSplecial = SpecialHotels::whereIn('slug', $array_slugSpecial)->pluck('id')->toArray();
		$city_id = ($city) ? $city->id : NULL;
		$star_id = ($star) ? $star->id : NULL;
		$location_id = ($location) ? $location->id : NULL;

		$country = Countries::join('overviews', 'countries.id', '=', 'overviews.country_id')
							->where('countries.slug', $slug_country)
							->select('countries.id', 'countries.title', 'countries.slug', 'overviews.list_main_city')
							->distinct()->first();

		$list_star = StarRatings::orderBy('position', 'asc')->get();
		$list_location = LocationHotels::orderBy('position', 'asc')->get();
		$list_special = SpecialHotels::orderBy('position', 'asc')->get();
		$list_consultant = getConsultantsByCountry($country->id);
		//$list_hotel = getListHotelByCountry($country->id, 8, true);  
		$list_hotel = filterHotel($city->id, NULL, $star_id, $location_id, $array_IdSplecial, $per_page, $page);  
		$array_countStar = arrayCountHotelInStar($city->id, NULL, $star_id, $location_id, $array_IdSplecial, 1);
		$array_countLotion = arrayCountHotelInLocation($city->id, NULL, $star_id, $location_id, $array_IdSplecial, 1);
		$array_countSpecial = arrayCountHotelInSpecial($city->id, NULL, $star_id, $location_id, $array_IdSplecial, 1);


		$data = [];
		$data['region'] = $region;
		$data['country'] = $country;
		$data['city'] = $city;
		$data['list_star'] = $list_star;
		$data['list_location'] = $list_location;
		$data['list_special'] = $list_special;
		$data['list_hotel'] = $list_hotel;
		$data['list_consultant'] = $list_consultant;
		$data['star_id'] = $star_id;
		$data['location_id'] = $location_id;
		$data['array_IdSplecial'] = $array_IdSplecial;
		$data['array_countStar'] = $array_countStar;
		$data['array_countLotion'] = $array_countLotion;
		$data['array_countSpecial'] = $array_countSpecial;
		return view('hotels.cityHotel', $data);
	}

	/**
	 * quick search
	 */
	public function quickSearch($slug_country, Request $request){
		if($request->ajax()){
			$country = Countries::findBySlug($slug_country);
			$request['current_country'] = $country->id;
			$url = getLinkCountryHotelsByMultiParam($request);
			return response()->json(['msg' => 'success', 'url' => $url]);
		}
		return response()->json(['msg' => 'error']);
	}
}