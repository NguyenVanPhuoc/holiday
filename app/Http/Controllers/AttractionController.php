<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attractions;


class AttractionController extends Controller
{
	public function loadMore(Request $request){
		if($request->ajax()){
			$country_id = $request->country_id;
			$num_itemShowing = $request->num_itemShowing;
			$icon_id = $request->icon_id;
			$html = '';

			$num_all = Attractions::where('country_id', $country_id)->count();
			$num_load = (($num_all - $num_itemShowing) < 5) ? ($num_all - $num_itemShowing) : 5;
			$num_take_all = $num_itemShowing + $num_load;

			if($icon_id != ''){
				$num_byIcon = Attractions::where('country_id', $country_id)->whereRaw("find_in_set($icon_id, list_icon)")->count();
				$num_take_byIcon = ($num_take_all < $num_byIcon) ? $num_take_all : $num_byIcon;
				$num_take_extant = (($num_take_all - $num_take_byIcon) < 5) ? ($num_take_all - $num_take_byIcon) : 5;

				$list_byIcon = Attractions::where('country_id', $country_id)->whereRaw("find_in_set($icon_id, list_icon)")->take($num_take_byIcon)->get();
				foreach($list_byIcon as $attraction){
					$html .= view('attractions.item', ['attraction' => $attraction])->render();
				}
				$arrayID_byIcon = Attractions::where('country_id', $country_id)->whereRaw("find_in_set($icon_id, list_icon)")
											->take($num_take_byIcon)->pluck('id')->toArray();
				$list_extant = Attractions::where('country_id', $country_id)->whereNotIn('id', $arrayID_byIcon)->take($num_take_extant)->get();

				foreach($list_extant as $attraction){
					$html .= view('attractions.item', ['attraction' => $attraction])->render();
				}

				$num_loadNext = ($num_all - $num_take_all);
			}
			else{
				$list_attraction = Attractions::where('country_id', $country_id)->skip($num_itemShowing)->take($num_load)->get();

				foreach ($list_attraction as $attraction) {
					$html .= view('attractions.item', ['attraction' => $attraction])->render();
				}

				$num_loadNext = ($num_all - (count($list_attraction) + $num_itemShowing));
			}

			

			return response()->json(['msg' => 'success','html'=>$html, 'num_loadNext' => $num_loadNext]);
		}
	}

	public function filterByIcon(Request $request){
		if($request->ajax()){
			$country_id = $request->country_id;
			$num_itemShowing = $request->num_itemShowing;
			$icon_id = $request->icon_id;
			$html = '';

			$num_all = Attractions::where('country_id', $country_id)->count();
			$num_byIcon = Attractions::where('country_id', $country_id)->whereRaw("find_in_set($icon_id, list_icon)")->count();
			$num_take_byIcon = ($num_itemShowing < $num_byIcon) ? $num_itemShowing : $num_byIcon;
			$num_take_extant = $num_itemShowing - $num_take_byIcon;

			$list_byIcon = Attractions::where('country_id', $country_id)->whereRaw("find_in_set($icon_id, list_icon)")->take($num_take_byIcon)->get();
			foreach($list_byIcon as $attraction){
				$html .= view('attractions.item', ['attraction' => $attraction])->render();
			}
			$arrayID_byIcon = Attractions::where('country_id', $country_id)->whereRaw("find_in_set($icon_id, list_icon)")
										->take($num_take_byIcon)->pluck('id')->toArray();
			$list_extant = Attractions::where('country_id', $country_id)->whereNotIn('id', $arrayID_byIcon)->take($num_take_extant)->get();
			foreach($list_extant as $attraction){
				$html .= view('attractions.item', ['attraction' => $attraction])->render();
			}

			return response()->json(['msg' => 'success','html'=>$html]);
		}	
	}
}