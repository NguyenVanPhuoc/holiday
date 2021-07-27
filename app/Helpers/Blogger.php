<?php 
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Bloggers;

/**
 * filter blogger
 * @param Request $request, int $per_page, int $page
 * @return list consultant_tour_guides
 */
if(! function_exists('filterBlogger')){
	function filterBlogger($request, $per_page, $page){
		$bloggers = Bloggers::query();

		if(isset($request->s) && $request->s != '')
			$bloggers = $bloggers->where('title', 'LIKE', '%'. $request->s .'%');

		$bloggers = $bloggers->get();

		if($per_page != NULL && $page != NULL){
			$collection = $bloggers instanceof Collection ? $bloggers : Collection::make($bloggers);
            $list_blogger = new LengthAwarePaginator($collection->forPage($page, $per_page), count($collection), $per_page, $page); 
            return $list_blogger;
		}
		return $bloggers;
	}
}

/**
 * data send blogger page
 * @param string $slug
 * @return array
 */
if(!function_exists('dataSendBlogger')){
	function dataSendBlogger($slug){
		$blogger = Bloggers::findBySlug($slug);
		$seo = get_seo($blogger, 'blogger');
		$list_blogger = Bloggers::where('id', '<>', $blogger->id)->limit(10)->get();
		
		$data = [
			'blogger' => $blogger,
			'seo' => $seo,
			'list_blogger' => $list_blogger,
		];
		return $data;
	}
}