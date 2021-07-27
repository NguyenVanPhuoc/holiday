<?php
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Faq;

/**
 * filter faq
 * @param Request $request
 * @param int $per_page
 * @param int $page
 * @return array
 */
if(! function_exists('filterFaq')){
	function filterFaq($request, $per_page = 14, $page = 1){
		$faqs = Faq::query();

		if(isset($request->s) && $request->s != '')
			$faqs = $faqs->where('title', 'LIKE', '%'. $request->s .'%');

		if(isset($request->cat_id) && $request->cat_id != '')
			$faqs = $faqs->where('cat_id', $request->cat_id);

		$faqs = $faqs->get();

		if($per_page != NULL && $page != NULL){
			$collection = $faqs instanceof Collection ? $faqs : Collection::make($faqs);
            $list = new LengthAwarePaginator($collection->forPage($page, $per_page), count($collection), $per_page, $page); 
            return $list;
		}
		return $faqs;
	}
}