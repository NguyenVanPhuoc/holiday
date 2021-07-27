<?php
use App\CountryTourDuration;
use App\Duration;
use App\Countries;
use App\CountryBlog;
use App\Overview;
use Illuminate\Http\Request;
/**
 * array data send country tour duration 
 * @param $slug_country, $slug 
 */
if(! function_exists('dataSendCountryTourDuration')){
	function dataSendCountryTourDuration($slug_country, $slug){ 
		$country = Countries::findBySlug($slug_country);
		$duration = Duration::findBySlug($slug);
		$country_tourDuration = CountryTourDuration::where('country_id', $country->id)->where('duration_id', $duration->id)->first();
		if($country_tourDuration):
		$desc_tourCountry = CountryBlog::where('type', 'country_tour')->where('country_id', $country->id)->select('country_blogs.*')->first();
		$request = new Request;
		$array_country_id = getArrayIdChildOfCountry($country->id);
		$array_country_id[] = $country->id;
		$request['array_country_id'] = $array_country_id; 
		$request['type_query_country'] = 'or'; 
		$request['duration_id'] = [$country_tourDuration->duration_id];
		$list_tour = filterTour($request);
		$list_region = getListRegionInCountry($country->id);
		$list_tourstyle = getListTourStyle();	
		$list_travelTip = getListPostGuideCountry('travel_tip', $country->id, 4);
		$list_reviewer = getListReviewer($country->id, NULL);
		$list_consultants = getConsultantsByCountry($country->id);
		$list_main_city = Overview::select('list_main_city')->where('country_id', $country->id)->first();
		$data = [
			'country' => $country,
			'duration' => $duration,
			'country_tourDuration' => $country_tourDuration,
			'list_tour' => $list_tour,
			'list_region' => $list_region,
			'list_tourstyle' => $list_tourstyle,
			'list_travelTip' => $list_travelTip,
			'list_reviewer' => $list_reviewer,
			'list_consultants' => $list_consultants,
			'desc_tourCountry' => $desc_tourCountry,
			'list_main_city' => $list_main_city,
		];
		return $data;
		else:
			return abort(404);;
		endif;
	}
}