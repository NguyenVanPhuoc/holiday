<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BannerAdminController extends Controller
{
	public function index(){
		$list_country = getAllMainCountry();

		$data = [];
		$data['list_country'] = $list_country;
		$data['list_postType'] = config('data_config.post_banner');
		return view('backend.banner.list', $data);
	}

	public function save(Request $request){
		$msg = 'error';
		if($request->ajax()){
			$post_type = $request->post_type;
			$list_country = getAllMainCountry(true); 
			if($post_type != ''){
				foreach ($list_country as $country_id) {
					$banner = DB::table('country_post_images')->where('post_type', $post_type)->where('country_id', $country_id)->first();
					$image_id = $request->image[$country_id];
					if(!$banner){
						$data = [
							'post_type' => $post_type,
							'country_id' => $country_id,
							'image' => $image_id,
							'created_at' => Carbon::now()
						];
						DB::table('country_post_images')->insert($data);
					}
					else{
						$data = ['image' => $image_id, 'updated_at' => Carbon::now()];
						DB::table('country_post_images')->where('post_type', $post_type)->where('country_id', $country_id)->update($data);
					}
				}
			}
			$msg = 'success';
		}
		return $msg;
	}

	//event change post 
	public function changePost(Request $request){
		if($request->ajax()){
			$list_country = getAllMainCountry();

			$html = '';
			$data = [];
			$data['list_country'] = $list_country;
			$data['post_type'] = $request->post_type;
			return response()->json(['msg'=>'success', 'html' => view('backend.banner.group_country_layout', $data)->render()]);
		}
		return response()->json(['msg'=>'error']);
	}
}