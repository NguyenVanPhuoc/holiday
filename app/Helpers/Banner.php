<?php 
use Illuminate\Support\Facades\DB;

//get image banner post by country
if(! function_exists('getBannerPostByCountry')){
	function getBannerPostByCountry($post_type, $country_id){
		$image_id = '';
		$banner = DB::table('country_post_images')->where('post_type', $post_type)->where('country_id', $country_id)->first();
		if($banner)
			$image_id = $banner->image;
		return $image_id;
	}
}