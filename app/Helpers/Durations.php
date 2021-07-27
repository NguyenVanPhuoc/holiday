<?php
use App\Duration;
use App\Tours;

// count tour in duration
if (! function_exists('countTourInDuration')) {
	function countTourInDuration($id){        
		return Tours::where('duration_id',$id)->count();
	}
}
// count tour in durationby country
if (! function_exists('countTourInDurationByCountry')) {
	function countTourInDurationByCountry($id, $country_id, $type = ''){        
		/*return Tours::where('duration_id',$id)
		       ->whereRaw("find_in_set($country_id,country_id)")->count();*/
		$tours = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
						->where('tours.duration_id', $id)
						->where('country_tours.country_id', $country_id)
						->select('tours.*')->distinct()->get();
		if($type == 'multi'){ //multi country
			$tours = DB::select('SELECT  DISTINCT tours.id FROM tours JOIN  country_tours ON tours.id = country_tours.tour_id WHERE tours.duration_id = ? AND tours.id IN ( SELECT  DISTINCT tours.id FROM tours JOIN  country_tours ON tours.id = country_tours.tour_id JOIN countries ON country_tours.country_id = countries.id WHERE country_tours.country_id IN ( SELECT countries.id FROM countries WHERE countries.parent_id = 0 ) GROUP BY country_tours.tour_id HAVING COUNT(country_tours.tour_id) > 1 )', [$id]);
		}
		return count($tours);
	}
}

/**
 * get list duration
 */
if(! function_exists('getListDuration')){
	function getListDuration(){
		return Duration::all();
	}
}
/**
* get list tour duration 
*/
if(! function_exists('getListTourDurationByCountryV1')){
	function getListTourDurationByCountryV1($duration){
		return Duration::where('id', '!=' ,$duration)->get();

	}
}
/**
* get slug tour duration 
*/
if(! function_exists('getSlugDurationById')){
	function getSlugDurationById($duration_id){
		return Duration::where('id',$duration_id)->select('id','slug')->first();

	}
}