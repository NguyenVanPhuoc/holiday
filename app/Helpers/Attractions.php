<?php
use App\Attractions;
use App\Icon;

//get list attraction
if(!function_exists('getListAttraction')){
	function getListAttraction(){
		$attractions = Attractions::orderBy('title', 'asc')->get();
		return $attractions;
	}
}

//get attraction by ID
if(!function_exists('getAttactionByID')){
	function getAttactionByID($id){
		$att = Attractions::find($id);
		return $att;
	}
}

//get list icon attraction
if(! function_exists('getListIconAttractionByID')){
	function getListIconAttractionByID($attraction_id){
		$attraction = Attractions::findOrFail($attraction_id);
		$array_iconID = explode(",", $attraction->list_icon);
		$list_icon = Icon::whereIn('id', $array_iconID)->get();
		return $list_icon;
	}
}