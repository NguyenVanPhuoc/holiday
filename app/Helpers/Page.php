<?php 
use App\Pages;
use App\ConsultantTourGuide;
use App\Bloggers;

/**
 * get post type have slug level 1
 * @param $slug
 * @return string post_type
 */
if(! function_exists('getPostTypeLevelOne')){
	function getPostTypeLevelOne($slug){
		$list_postTypes = config('data_config.post_level_1');
		$post_type = NULL;
		foreach($list_postTypes as $item){
			if($item == 'consultant'){
				$result = ConsultantTourGuide::findBySlug($slug);
				if($result){
					$post_type = $item;
					break;
				}
			}
			if($item == 'blogger'){
				$result = Bloggers::findBySlug($slug);
				if($result){
					$post_type = $item;
					break;
				}
			}
		}
		if($post_type != NULL)
			return $post_type;
		else
			return abort(404);
	}
}

/**
* display pages options
* @param $array
*/
if(!function_exists('display_pages_option')){
	function display_pages_option($array=array()){
		$pages = Pages::select('id','title')->latest()->get();
		$html = '';
		if($pages):
			foreach ($pages as $page) {
				$html .= '<option value="'.$page->id.'"'.(in_array($page->id,$array) ? ' selected' : '').'>'.$page->title.'</option>';
			}
		endif;
		return $html;
	}
}