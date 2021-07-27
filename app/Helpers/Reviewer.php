<?php
use App\Reviewers;
use App\GroupType;
use App\Countries;
/**
 * get list reviewer
 * @param int $country_id, int $tour_style_id, int $limit = NULL
 * @return list review
 */
if(! function_exists('getListReviewer')){
	function getListReviewer($country_id, $tour_style_id, $limit = NULL){
		$list_reviewer = Reviewers::query();
		if($country_id != NULL)
			$list_reviewer = $list_reviewer->whereRaw("find_in_set($country_id,list_destination)");
		if($tour_style_id != NULL)
			$list_reviewer = $list_reviewer->whereRaw("find_in_set($tour_style_id,list_tour_style)");
		if($limit != NULL)
			$list_reviewer = $list_reviewer->orderBy('created_at', 'DESC')->limit($limit);
		$list_reviewer = $list_reviewer->get();
		return $list_reviewer;
	}
}
/**
 * get list destination of reviewer
 * @param int $reviewer_id, string $type_return (is 'id', 'title' or 'object')
 * @return array, text or object country
 */
if(! function_exists('getListDestinationOfReview')){
	function getListDestinationOfReview($reviewer_id, $type_return = 'object'){
		$reviewer = Reviewers::findOrFail($reviewer_id);
		$array_country_id = ($reviewer->list_destination != '') ? explode(",", $reviewer->list_destination) : [];
		$list_country = Countries::whereIn('id', $array_country_id);
		if($type_return == 'id')
			$list_country = $list_country->pluck('id')->toArray();
		else if($type_return == 'title')
			$list_country = $list_country->pluck('title')->toArray();
		else
			$list_country = $list_country->get();
		return $list_country;
	}
}
/**
 * filter review front
 * @param array $array_param
 * @return array
 */
if(! function_exists('filterReviewFront')){
	function filterReviewFront($array_param = []){
		$array_country_id = (!empty($array_param['array_country_id'])) ? $array_param['array_country_id'] : NULL;
		$array_tourstyle_id = (!empty($array_param['array_tourstyle_id'])) ? $array_param['array_tourstyle_id'] : NULL;
		$group_type_id = (!empty($array_param['group_type_id'])) ? $array_param['group_type_id'] : NULL;
		$limit = (!empty($array_param['limit'])) ? $array_param['limit'] : 6;
		$skip = (!empty($array_param['skip'])) ? $array_param['skip'] : 0;
		$current_id = (!empty($array_param['current_id'])) ? $array_param['current_id'] : '';
		$reviews = Reviewers::query();
		if($array_country_id){
			foreach ($array_country_id as $country_id) {
				$reviews = $reviews->orwhereRaw("FIND_IN_SET($country_id, list_destination)");
			}
		}
		if($array_tourstyle_id){
			foreach ($array_tourstyle_id as $tourstyle_id) {
				$reviews = $reviews->whereRaw("FIND_IN_SET($tourstyle_id, list_tour_style)");
			}
		}
		if($group_type_id != NULL)
			$reviews = $reviews->where('group_type_id', $group_type_id);
		if($current_id != '')
			$reviews = $reviews->where('id', '<>', $current_id);
		$count = $reviews->count();
		$list_review = $reviews->skip($skip)->limit($limit)->get();
		return [
			'list_review' => $list_review,
			'total' => $count,
		];
	}
}
/**
 * Get title of group type by id
 */
if(! function_exists('getTitleOfGroupType')){
	function getTitleOfGroupType($id){
		$title = groupType::select('title')->find($id);
		if($title) return $title->title;
			else return '';
	}
}
if(! function_exists('countReviewByCountryId')){
	function countReviewByCountryId($country_id){
		return Reviewers::whereRaw("FIND_IN_SET($country_id, list_destination)")
                                ->distinct()->select('reviewers.id')
                                ->count();
	}
}
if(! function_exists('countReviewByStyleId')){
	function countReviewByStyleId($style_id){
		return Reviewers::whereRaw("FIND_IN_SET($style_id, list_tour_style)")
                                ->distinct()->select('reviewers.id')
                                ->count();
	}
}
if(! function_exists('countReviewByGroupTypeId')){
	function countReviewByGroupTypeId($group_id){
		return Reviewers::where('group_type_id', $group_id)
                                ->distinct()->select('reviewers.id')
                                ->count();
	}
}
