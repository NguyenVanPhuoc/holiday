<?php
use App\Seo;

/**
* create seo
* @param int $post_id, string $type, string $meta_key, string $meta_value
*/
if(! function_exists('createSeo')){
	function createSeo($post_id, $type, $meta_key, $meta_value){
		Seo::create(['post_id' => $post_id, 'type' => $type, 'key' => $meta_key, 'value' => $meta_value]);
	}
}

/**
* update seo
* @param int $post_id, string $type, string $meta_key, string $meta_value
*/

if(! function_exists('updateSeo')){
	function updateSeo($post_id, $type, $meta_key, $meta_value){
		$seo = Seo::where('post_id', $post_id)->where('type', $type)->first();
		if(!$seo)
			Seo::create(['post_id' => $post_id, 'type' => $type, 'key' => $meta_key, 'value' => $meta_value]);
		else
			$seo->update(['key' => $meta_key, 'value' => $meta_value]);
	}
}

/**
 * delete seo
 * @param int $post_id, string $type
 */
if(! function_exists('deleteSeo')){
	function deleteSeo($post_id, $type){
		Seo::where('post_id', $post_id)->where('type', $type)->delete();
	}
}

/**
 * get seo
 * @param int $posy_id, $type
 * @return object seos
 */
if (! function_exists('get_seo')) {
	function get_seo($post_id, $type){        
		return Seo::where('post_id',$post_id)->where('type',$type)->first();
	}
}