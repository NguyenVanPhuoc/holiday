<?php 
use App\Tours;
use App\CountryTours;
use App\Countries;
use App\Schedules;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
//get list tour order by title 
if(!function_exists('getToursOrderByTitle')){
	function getToursOrderByTitle(){
		$tours = Tours::orderBy('title', 'asc')->get();
		return $tours;
	}
}
//get tour by Id
if(!function_exists('getTourByID')){
	function getTourByID($id){
		$tour = Tours::find($id);
		return $tour;
	}
}
//get tour by Id
if(!function_exists('getAllTours')){
	function getAllTours($id){
		$tour = Tours::where('id', $id)->first();
		return $tour;
	}
}
if(!function_exists('getAllToursV1')){
	function getAllToursV1(){
		$tour = Tours::select('id', 'title')->orderBy('title', 'asc')->get();
		return $tour;
	}
}
/**
 * get duration of tour
 * @param int $tour_id
 * @return string duration 
 */
/*if(! function_exists('getDurationOfTour')){
	function getDurationOfTour($tour_id, $br = true){
		$num = Schedules::where('tour_id', $tour_id)->count();
		if($br) $text = $num . ' days <br>' . ($num - 1) .' nights';
			else  $text = $num . ' days ' . ($num - 1) .' nights';
		return $text;
	}
}*/
if(! function_exists('getDurationOfTour')){
	function getDurationOfTour($tour_id, $br = true){
		$num = Schedules::where('tour_id', $tour_id)->count();
		if($br) $text = $num . ' days <br>';
			else  $text = $num . ' days ';
		return $text;
	}
}
/**
 * get destinations of tour
 * @param int $tour_id
 * @return string list destinations
 */
if(! function_exists('getDestinationsOfTour')){
	function getDestinationsOfTour($tour_id){
		$list_destination = Countries::join('country_tours', 'countries.id', '=', 'country_tours.country_id')
									->where('country_tours.tour_id', $tour_id)
									->where('countries.parent_id', 0)
									->pluck('countries.title')
									->toArray();
		return implode(", ", $list_destination);
	}
}
/**
* get list tour by country
* @param int $country_id, int $number_take, string $type_field (NULL or 'some')
* @return list tour 
*/
if(! function_exists('getListTourByCountry')){
	function getListTourByCountry($country_id, $number_take = NULL, $type_field = NULL){ 
		$arrayID = getArrayIdChildOfCountry($country_id); 
		/*if($number_take != NULL)
			$tours = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
						->whereIn('country_tours.country_id', $arrayID)
						->select('tours.*')
						->distinct()
						->take($number_take)->get();
		else
			$tours = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
						->whereIn('country_tours.country_id', $arrayID)
						->select('tours.*')
						->distinct()
						->get();*/
		$tours = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
						->whereIn('country_tours.country_id', $arrayID);
		if($type_field != NULL)
			$tours = $tours->select('tours.*');
		else
			$tours = $tours->select('tours.id', 'tours.title', 'tours.image');
		if($number_take != NULL)
			$tours = $tours->limit($number_take);
		$tours = $tours->get();
		return $tours;
	}
}
/**
* get list string title country of tour
* @param int $id (product id)
* @return list string title country
*/
if(! function_exists('getListStrTitleCountryOfTour')){
	function getListStrTitleCountryOfTour($id){
		$array_title = CountryTours::join('countries', 'country_tours.country_id', '=', 'countries.id')
						->where('country_tours.tour_id', $id)
						->distinct()
						->pluck('countries.title')
						->toArray();
		return implode(", ", $array_title);
	}
}
/**
 * get array tour id by array country id
 * @param array $array_country_id
 * @return array tour id 
 */
if(! function_exists('getArrTourIdByArrCountryId')){
	function getArrTourIdByArrCountryId($array_country_id){
		$array_tour_id = CountryTours::query();
		foreach($array_country_id as $country_id){
			$array_tour_id = $array_tour_id->whereIn('tour_id', function ($query) use ($country_id) {
                $query->select('country_tours.tour_id')
                    ->from('country_tours')
                    ->where('country_tours.country_id', $country_id);
            });
		}
		$array_tour_id = $array_tour_id->distinct('tour_id')->pluck('tour_id')->toArray();
		return $array_tour_id;
	}
}
/**
 * filter tour
 * @param $request: array $array_country_id, int $duration_id, array $array_tourstyle_id
 */
if(! function_exists('filterTour')){
	function filterTour($request, $per_page = NULL, $page = NULL){
		$tours = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id');
						//->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id');	
		//current country
		if((isset($request->current_country_id) && $request->current_country_id != '') || (isset($request->child_cou) && $request->child_cou != '')){
			if(isset($request->child_cou) && $request->child_cou != '') $array_child_currentCountry = explode(',',$request->child_cou);
				else $array_child_currentCountry = getArrayIdChildOfCountry($request->current_country_id); 
			$array_child_currentCountry[] = $request->current_country_id;
			$tours = $tours->whereIn('country_tours.country_id', $array_child_currentCountry);
		}
		//current tour style (category_tours)
		if((isset($request->current_tourstyle_id) && $request->current_tourstyle_id != '') || (isset($request->cat_id) && $request->cat_id != '')){
			if(isset($request->cat_id) && $request->cat_id != '') $array_tourstyle_id = explode(',',$request->cat_id);
				else $array_tourstyle_id[] = $request->current_tourstyle_id;
			$tours = $tours->whereIn('tours.cat_id', $array_tourstyle_id);
			//dd($request->array_tourstyle_id);
		}
		//type filter
		if(isset($request->array_country_id) && count($request->array_country_id) > 0){
			$tours = $tours->whereIn('country_tours.country_id', $request->array_country_id);
		}
		if(isset($request->duration_id) && $request->duration_id != '')
			$tours = $tours->where('tours.duration_id', $request->duration_id);
		if(isset($request->array_tourstyle_id) && count($request->array_tourstyle_id) > 0)
			$tours = $tours->whereIn('tours.cat_id', $request->array_tourstyle_id);
		$tours = $tours->latest('tours.created_at')->select('tours.id', 'tours.title', 'tours.image', 'tours.content' ,'tours.price', 'tours.cat_id', 'tours.slug')
						->distinct()->get();
						//dd($tours);
		if((!isset($request->type_result) || $request->type_result != 'slide') && $per_page == NULL && $page == NULL){
			$per_page = 6; $page = 1;
		}
		if($per_page != NULL && $page != NULL){
			$items = $tours instanceof Collection ? $tours : Collection::make($tours);
			$list_tour = new LengthAwarePaginator($items->forPage($page, $per_page), count($items), $per_page, $page);
			return $list_tour;
		}
		return $tours;
	}
}
/**
 * filter tour
 * @param $request: array $array_country_id, int $duration_id, array $array_tourstyle_id
 */
if(! function_exists('CountfilterTour')){
	function CountfilterTour($request){
		$tours = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id');
		//current country
		if((isset($request->current_country_id) && $request->current_country_id != '') || (isset($request->child_cou) && $request->child_cou != '')){
			if(isset($request->child_cou) && $request->child_cou != '') $array_child_currentCountry = explode(',',$request->child_cou);
				else $array_child_currentCountry = getArrayIdChildOfCountry($request->current_country_id); 
			$array_child_currentCountry[] = $request->current_country_id;
			$tours = $tours->whereIn('country_tours.country_id', $array_child_currentCountry);
		}
		//current tour style (category_tours)
		if((isset($request->current_tourstyle_id) && $request->current_tourstyle_id != '') || (isset($request->cat_id) && $request->cat_id != '')){
			if(isset($request->cat_id) && $request->cat_id != '') $array_tourstyle_id = explode(',',$request->cat_id);
				else $array_tourstyle_id[] = $request->current_tourstyle_id;
			$tours = $tours->whereIn('tours.cat_id', $array_tourstyle_id);
		}
		//type filter
		if(isset($request->array_country_id) && count($request->array_country_id) > 0){
				$tours = $tours->whereIn('country_tours.country_id', $request->array_country_id);
		}
		if(isset($request->duration_id) && $request->duration_id != '')
			$tours = $tours->where('tours.duration_id', $request->duration_id);
		if(isset($request->array_tourstyle_id) && count($request->array_tourstyle_id) > 0)
			$tours = $tours->whereIn('tours.cat_id', $request->array_tourstyle_id);
		$tours = $tours->latest('tours.created_at')->select('tours.id')
						->distinct()->get();
		return $tours;
	}
}
/**
 * get list tour by array id
 * @param array $array_id
 * @return list object
 */
if(! function_exists('getListTourByArrayId')){
	function getListTourByArrayId($array_id){
		return Tours::whereIn('id', $array_id)->get();
	}
}
/**
 * count destinations of tour
 * @param int $tour_id
 * @return count
 */
if(! function_exists('countDestinationsOfTour')){
	function countDestinationsOfTour($tour_id){
		$count = Countries::join('country_tours', 'countries.id', '=', 'country_tours.country_id')
									->where('country_tours.tour_id', $tour_id)
									->where('countries.parent_id', 0)
									->select('id')->count();
		return $count;
	}
}
if(! function_exists('countTourByCountryId')){
	function countTourByCountryId($country_id){
		/*$array_country_id = getArrayIdChildOfCountry($country_id);
        $array_country_id[] = $country_id;*/
		return Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                //->whereIn('country_tours.country_id', $array_country_id)
                                ->where('country_tours.country_id', $country_id)
                                ->distinct()->select('tours.id')
                                ->count();
	}
}
if(! function_exists('countTourByCatId')){
	function countTourByCatId($cat_id, $country_id){
		return Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                    ->where('country_tours.country_id', $country_id)
                    ->where('cat_id', $cat_id)
                    ->distinct()->select('tours.id')
                    ->count();
	}
}
if(! function_exists('countTourByDurationId')){
	function countTourByDurationId($duration_id, $country_id){
		return Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                    ->where('country_tours.country_id', $country_id)
                    ->where('duration_id', $duration_id)
                    ->distinct()->select('tours.id')
                    ->count();
	}
}
if(! function_exists('countTourByCatIdAsia')){
	function countTourByCatIdAsia($cat_id){
		return Tours::where('cat_id', $cat_id)
                    ->distinct()->select('tours.id')
                    ->count();
	}
}
if(! function_exists('countTourByDurationIdAsia')){
	function countTourByDurationIdAsia($duration_id){
		return Tours::where('duration_id', $duration_id)
                    ->distinct()->select('tours.id')
                    ->count();
	}
}