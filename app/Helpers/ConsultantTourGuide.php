<?php 
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\ConsultantTourGuide;

/**
 * filter consultant tour guide
 * @param Request $request, int $per_page, int $page
 * @return list consultant_tour_guides
 */
if(! function_exists('filterConsultantTourGuide')){
	function filterConsultantTourGuide($request, $per_page, $page){
		$consultantTourGuides = ConsultantTourGuide::query();

		if(isset($request->type) && $request->type != '')
			$consultantTourGuides = $consultantTourGuides->where('type', $request->type);
		if(isset($request->s) && $request->s != '')
			$consultantTourGuides = $consultantTourGuides->where('title', 'LIKE', '%'. $request->s .'%');
		if(isset($request->country_id) && $request->country_id != '')
			$consultantTourGuides = $consultantTourGuides->where('country_id', $request->country_id);
		if(isset($request->tour_style_id) && $request->tour_style_id != '')
			$consultantTourGuides = $consultantTourGuides->where('tour_style_id', $request->tour_style_id);

		$consultantTourGuides = $consultantTourGuides->get();

		if($per_page != NULL && $page != NULL){
			$collection = $consultantTourGuides instanceof Collection ? $consultantTourGuides : Collection::make($consultantTourGuides);
            $list_consultantTourGuide = new LengthAwarePaginator($collection->forPage($page, $per_page), count($collection), $per_page, $page); 
            return $list_consultantTourGuide;
		}
		return $consultantTourGuides;
	}
}