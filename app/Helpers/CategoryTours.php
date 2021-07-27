<?php 
use App\Tours;
use App\Countries;
use App\CategoryTour;

// count tour in category by single country
if (! function_exists('countTourInCatByCountry')) {
	function countTourInCatByCountry($id, $country_id, $type = ''){   // type of country     
		/*return Tours::whereRaw("find_in_set($id,cat_id)")
				->whereRaw("find_in_set($country_id,country_id)")->count();*/
		$tours = Tours::join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
						->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
						->where('cat_tour_metas.cat_id', $id)
						->where('country_tours.country_id', $country_id)
						->select('tours.*')->distinct()->get(); 
		if($type == 'multi')
			$tours = DB::select('SELECT  DISTINCT tours.id FROM tours JOIN  cat_tour_metas ON tours.id = cat_tour_metas.tour_id WHERE cat_tour_metas.cat_id = ? AND tours.id IN ( SELECT  DISTINCT tours.id FROM tours JOIN  country_tours ON tours.id = country_tours.tour_id JOIN countries ON country_tours.country_id = countries.id WHERE country_tours.country_id IN ( SELECT countries.id FROM countries WHERE countries.parent_id = 0 ) GROUP BY country_tours.tour_id HAVING COUNT(country_tours.tour_id) > 1 )', [$id]);
		return count($tours);
	}
}
// count tour in category by multi country
if (! function_exists('countTourInCatByMultiCountry')) {
	function countTourInCatByMultiCountry($id){        
		/*return Tours::whereRaw("find_in_set($id,cat_id)")
				->whereRaw("find_in_set($country_id,country_id)")->count();*/
		/*$tours = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
						->join('countries', 'country_tours.country_id', '=', 'countries.id')
						->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
						->select('tours.*')
						->where('cat_tour_metas.cat_id', $id)
						->whereIn('country_tours.country_id',function($query){
			               	$query->select('countries.id')->from('countries')
			               	->where('countries.parent_id', 0);
			            })
			            ->where(DB::raw(`( GROUP BY country_tours.tour_id HAVING COUNT(country_tours.tour_id) > 1 )` ))
			            ->distinct()->get(); */
		$tours = DB::select('SELECT  DISTINCT tours.* FROM tours JOIN  country_tours ON tours.id = country_tours.tour_id JOIN countries ON country_tours.country_id = countries.id WHERE country_tours.country_id IN ( SELECT countries.id FROM countries WHERE countries.parent_id = 0 ) GROUP BY country_tours.tour_id HAVING COUNT(country_tours.tour_id) > 1');
		return $tours;
	}
}

if(!function_exists('testQuery')){
	function testQuery(){
		$tours = Tours::join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
						->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
						->select('tours.*')->distinct()->get(); 
		$test = collect(DB::select('SELECT  DISTINCT tours.* FROM tours JOIN  country_tours ON tours.id = country_tours.tour_id JOIN countries ON country_tours.country_id = countries.id WHERE country_tours.country_id IN ( SELECT countries.id FROM countries WHERE countries.parent_id = 0 ) GROUP BY country_tours.tour_id HAVING COUNT(country_tours.tour_id) > 1'));
		return $tours;
	}
}

/**
* get list text tour style where in id
* @param string id, example : "1,2,3"
* @return list string title tour style (a, b, c)
*/
if(! function_exists('getListTextTourStyleWhereInID')){
	function getListTextTourStyleWhereInID($str_id){
		$array_ID = explode(",", $str_id);
		$array_text = CategoryTour::whereIn('id', $array_ID)->pluck('title')->toArray();
		return implode(", ", $array_text);
	}
}

/**
 * get list tour style
 * @param $array_pluck : is true or fasle
 * @return list ob or array id
 */
if(! function_exists('getListTourStyle')){
	function getListTourStyle($array_pluck = false){
		$list_tour_style = CategoryTour::orderBy('position', 'asc');
		if($array_pluck)
			$list_tour_style = $list_tour_style->pluck('id')->toArray();
		else
			$list_tour_style = $list_tour_style->distinct()->get();
		return $list_tour_style;
	}
}

if(! function_exists('getTourStyleId')){
	function getTourStyleId($id){
		return CategoryTour::select('title', 'id', 'slug')->find($id);
	}
}
