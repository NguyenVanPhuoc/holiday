<?php 
use App\Consultant;
use App\ConsultantTourGuide;
use App\Countries;


//get consultant_tour_guide by consultant_id
if(!function_exists('getConsultantTourGuide')){
	function getConsultantTourGuide($consultant_id){
		$consultant_tour_guide = ConsultantTourGuide::where('consultant_id', $consultant_id)->first();
		return $consultant_tour_guide;
	}
}



//get list consultants by country
if(!function_exists('getConsultantsByCountry')){
	function getConsultantsByCountry($country_id = NULL, $take_number = NULL){
		if($country_id == NULL) $consultants = Consultant::query();
			else $consultants = Countries::find($country_id)->consultantTourGuides();
		if($take_number != NULL){
			$consultants = $consultants->limit($take_number);
		}
		$consultants = $consultants->get();
		return $consultants;
	}
}


/**
 * data send detail consultant
 * @param $slug
 * @return array data send view detail consultant
 */
if(! function_exists('dataSendDetailConsultant')){
	function dataSendDetailConsultant($slug){
		$consultant = ConsultantTourGuide::findBySlug($slug);
		$seo = get_seo($consultant->id, 'consultant_tour_guide');
		$array_tourID = ($consultant->favourite_tour != '') ? explode(",", $consultant->favourite_tour) : [];
		$array_highlightID = ($consultant->favourite_highlight != '') ? explode(",", $consultant->favourite_highlight) : [];
		$array_hotelID = ($consultant->favourite_hotel != '') ? explode(",", $consultant->favourite_hotel) : [];

		$list_tour = getListTourByArrayId($array_tourID);
		$list_highlight = getPlacesToVisitByArrayID($array_highlightID);
		$list_hotel = getListHotelByArrayId($array_hotelID);

		$data = [
			'consultant' => $consultant,
			'seo' => $seo,
			'list_tour' => $list_tour,
			'list_highlight' => $list_highlight,
			'list_hotel' => $list_hotel,
		];
		return $data;
	}
}