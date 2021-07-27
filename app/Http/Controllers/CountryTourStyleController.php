<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Countries;
use App\CountryTourStyle;
use App\CategoryTour;


class CountryTourStyleController extends Controller
{
	public function searchTourStyleOfCountry($slug_country, Request $request){
		if($request->ajax()){
            $country = Countries::findBySlug($slug_country);  
            $list_countryTourStyle = CountryTourStyle::join('category_tours', 'country_tour_styles.cat_id', '=', 'category_tours.id')
												->whereNotIn('country_tour_styles.id', [$request->current_id])
												->select('country_tour_styles.id', 'category_tours.title as tour_style_title')
												->distinct()->get();
            $html = '';
            if($list_countryTourStyle && count($list_countryTourStyle) > 0){
                foreach($list_countryTourStyle as $item){
                    $html .= '<li><a href="#">'. $item->tour_style_title .'</a></li>';
                }
            }
            else{
                $html .= '<li class="no-result">Please recheck your typing or <a href="#" class="">CONTACT US</a> for more detail</li>';
            }
            return response()->json(['msg' => 'success', 'html' => $html]);
        }
        return response()->json(['msg' => 'error']);
	}
}