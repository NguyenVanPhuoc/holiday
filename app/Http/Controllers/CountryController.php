<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Countries;
use App\CountryCategory;
use App\Highlight;
use App\Overview;
use App\PostGuide;
use App\CountryBlog;
use App\CategoryGuide;
use App\Attractions;
use App\Tours;
use DB;


class CountryController extends Controller
{
    public function overview($slug_country){    
        $country = Countries::join('overviews', 'countries.id', '=', 'overviews.country_id')
                            ->where('countries.slug', $slug_country)
                            ->select('overviews.*', 'countries.*', 'overviews.id as overview_id')
                            ->first();
        $highlight_ct = Countries::join('highlights', 'countries.id', '=', 'highlights.country_id')
                            ->where('countries.slug', $slug_country)
                            ->select('highlights.video as video')
                            ->first();                
        $list_highlight = getListHightlightInCountry($country->id);
        if($country->list_main_city != ''){
            $array_mainCityID = explode(",", $country->list_main_city);
            $top_highlight = Countries::whereIn('id', $array_mainCityID)->limit(4)->get();
        }else{
            $array_regionID = Countries::where('parent_id', $country->id)->pluck('id')->toArray();
            $top_highlight = Countries::whereIn('parent_id', $array_regionID)->limit(4)->get();
        }
        $list_tourStyle = getListTourStyleByCountry($country->id);
        $related_articles = getListArticleByCountry($country->id, 20);
        $list_ortherCountry = Countries::whereNotIn('id', [$country->id])->where('parent_id', 0)->get();
        $list_city = getListCitiesInCountry($country->id);
        $list_main_city = Overview::select('list_main_city')->where('country_id', $country->id)->first();
        $highlight = Highlight::where('country_id', $country->id)->first();
        $activities= Attractions::where('country_id',$country->id)->get();
        $list_tour_byCountry = Tours::join('country_tours', 'tours.id','=','country_tours.tour_id')
                        ->where('country_tours.country_id',$country->id)
                        ->inRandomOrder()
                        ->select('tours.*')
                        ->limit(6)->get();
        $data = [];
        $data['country'] = $country;
        $data['list_highlight'] = $list_highlight;
        $data['top_highlight'] = $top_highlight;
        $data['list_tourStyle'] = $list_tourStyle; 
        $data['related_articles'] = $related_articles;
        $data['list_ortherCountry'] = $list_ortherCountry;
        $data['list_city'] = $list_city;
        $data['list_main_city'] = $list_main_city;
        $data['highlight'] = $highlight;
        $data['highlight_ct'] = $highlight_ct;
        $data['activities'] = $activities;
        $data['list_tour_byCountry'] = $list_tour_byCountry;
        return view('countries.overview', $data);
    } 

    //country places to visit
    public function countryPlaceToVisit($slug_country){  
        $country = Countries::findBySlug($slug_country);
        $country_place = CountryBlog::where('type', 'country_places')->where('country_id', $country->id)->first();
            if ($country_place) {$seo = get_seo($country_place->id,'country_blog');}
            else{$seo = "";}
        $array_regionID = Countries::where('parent_id', $country->id)->pluck('id')->toArray();
        $list_highlight = getListHightlightInCountry($country->id);
        $list_region = Countries::where('parent_id', $country->id)->get();
        $top_highlight = Countries::whereIn('parent_id', $array_regionID)->select('id', 'title', 'image')->latest()->take(4)->get(); 
        $related_tours = getListTourByCountry($country->id, 20);
        $related_articles = getListArticleByCountry($country->id, 20);
        $related_hotels = getListHotelByCountry($country->id, 20);
        $list_city = getListCitiesInCountry($country->id);
        $list_city_alphabet  = getListCitiesInCountry($country->id, 'title');
        //$list_main_city = getListMainCityOfCountryv2($country->id);
        $list_main_city = Overview::select('list_main_city')->where('country_id', $country->id)->first();


        $data = [];     
        $data['country'] = $country;
        $data['country_place'] = $country_place;
        $data['seo'] = $seo;     
        $data['list_highlight'] = $list_highlight;     
        $data['list_region'] = $list_region;     
        $data['top_highlight'] = $top_highlight;     
        $data['related_tours'] = $related_tours;     
        $data['related_articles'] = $related_articles;     
        $data['related_hotels'] = $related_hotels; 
        $data['list_city'] = $list_city;     
        $data['list_city_alphabet'] = $list_city_alphabet;
        $data['list_main_city'] = $list_main_city;
        return view('countries.countryPlaceToVisit', $data);
    }  

    //region places to visit
    public function regionPlaceToVisit($slug_country, $slug_region){
        $country = Countries::findBySlug($slug_country);
        $region = Countries::findBySlug($slug_region); 
        $list_highlight = getListHightlightInCountry($region->id, true);
        $top_highlight = Countries::where('parent_id', $region->id)->select('id', 'title', 'image')->latest()->take(4)->get();
        $related_tours = getListTourByCountry($region->id, 20);
        $related_articles = getListArticleByCountry($region->id, 20);
        $related_hotels = getListHotelByCountry($region->id, 20);
        
        $data = [];     
        $data['country'] = $country; 
        $data['region'] = $region; 
        $data['list_highlight'] = $list_highlight; 
        $data['top_highlight'] = $top_highlight; 
        $data['related_tours'] = $related_tours;     
        $data['related_articles'] = $related_articles;     
        $data['related_hotels'] = $related_hotels; 

        return view('countries.regionPlaceToVisit', $data);
    }

    public function postTypeCountryTravel($slug_country, $slug){         
        $country = Countries::findBySlug($slug_country); 
    	$post_type = postTypeByCountryTravel($slug); 
        
    	switch ($post_type) { 
    		case 'travel_tip': 
    			$data = dataSendDetailTravelTip($slug_country, $slug ); 
    			return view('guides.guide', $data);
    			break;
            case 'cultural': 
                $data = dataSendDetailCultural($slug_country, $slug); 
                return view('guides.cultural', $data);
                break;
            case 'market': 
                $data = dataSendDetailMarket($slug_country, $slug); 
                return view('guides.market', $data);
                break;
            case 'thing_to_do': 
                $data = dataSendDetailThingToDo($slug_country, $slug); 
                return view('guides.thingToDo', $data);
                break;
            case 'region':
                $region = Countries::findBySlug($slug); 
                $best_parentID = getFarthestParentCountry($region->id);
                if($best_parentID != $country->id)
                    abort(404);
                $data = dataSendRegion($slug_country, $slug);
                return view('countries.regionPlaceToVisit', $data);
                break;
            case 'highlight':
                $city = Countries::findBySlug($slug); 
                $best_parentID = getFarthestParentCountry($city->id);
                if($best_parentID != $country->id)
                    abort(404);
                $data = dataSendHighlight($slug_country, $slug);
                return view('countries.placeToVisit', $data);
                break;
            case 'region_hotel':
                $slug = substr($slug,0,-14);
                $data = dataSendRegionHotel($slug_country, $slug);
                return view('hotels.regionHotel', $data);
            case 'city_hotel':
                $slug = substr($slug,0,-14);
                $data = dataSendCityHotel($slug_country, $slug);
                return view('hotels.cityHotel', $data);
            case 'hotel': 
                $data = dataSendDetailHotel($slug_country, $slug);
                return view('hotels.hotel', $data);
           /* case 'country_tour_style': 
                $data = dataSendCountryTourStyle($slug_country, $slug);  //slug of category_tours
                return view('countryTourStyles.detail', $data);
            case 'country_tour_duration':  
                $data = dataSendCountryTourDuration($slug_country, $slug);
                return view('countryTourDuration.detail', $data);*/
            case 'country_category_blog':  
                $data = dataSendCountryCatBlog($slug_country, $slug);
                return view('articles.country_cat', $data);
    		default:  
    			abort(404);
    			break;
    	}
    }



    //search highlight
    public function seachHighlight($slug_country, Request $request){
        if($request->ajax()){
            $country = Countries::findBySlug($slug_country);
            $array_regionID = Countries::where('parent_id', $country->id)->pluck('id')->toArray();  
            $list_province = Countries::join('highlights', 'countries.id', '=', 'highlights.country_id')
                                        ->whereIn('countries.parent_id', $array_regionID)
                                        ->where('countries.title', 'like', '%'. $request->keyword .'%')
                                        ->select('countries.id', 'countries.title')->get();
            $html = '';
            if($list_province && count($list_province) > 0){
                foreach($list_province as $item){
                    $html .= '<li><a href="#">'. $item->title .'</a></li>';
                }
            }
            else{
                $html .= '<li class="no-result">Please recheck your typing or <a href="#" class="">CONTACT US</a> for more detail</li>';
            }
            return response()->json(['msg' => 'success', 'html' => $html]);
        }
        return response()->json(['msg' => 'error']);
    } 

    //search highlight hotel
    public function seachHighlightHotel($slug_country, Request $request){
        if($request->ajax()){
            $country = Countries::findBySlug($slug_country);
            $array_regionID = Countries::where('parent_id', $country->id)->pluck('id')->toArray();  
            $list_province = Countries::join('highlights', 'countries.id', '=', 'highlights.country_id')
                                        ->whereIn('countries.parent_id', $array_regionID)
                                        ->where('countries.title', 'like', '%'. $request->keyword .'%')
                                        ->select('countries.id', 'countries.title')->get();
            $html = '';
            foreach($list_province as $item){
                $html .= '<li><a href="#">'. $item->title .'</a></li>';
            }
            return response()->json(['msg' => 'success', 'html' => $html]);
        }
        return response()->json(['msg' => 'error']);
    }

    //search city country
    public function seachCitiesCountry($slug_country, Request $request){
        if($request->ajax()){
                $country = Countries::findBySlug($slug_country);
                $regions = Countries::where('parent_id', $country->id)->select('id')->pluck('id')->toArray();  
                $list_city = Countries::whereIn('parent_id', $regions)
                                    ->where('title', 'like', '%'. $request->keyword .'%')
                                    ->select('id', 'title', 'image','slug')
                                    ->orderBy('position', 'asc')->get();
                                     
                $html = '';
                if($list_city && count($list_city) > 0){
                    foreach($list_city as $item){
                        $html .= '<li><a href="'.route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item->slug]).'" class="link_city">'. $item->title .'</a></li>';
                    }
                }
                else{
                    $html .= '<li class="no-result">Please find another keyword!</li>';
                }
                return response()->json(['msg' => 'success', 'html' => $html]);
        }
        return response()->json(['msg' => 'error']);   
    }
     //search nationality
    public function searchNationality(Request $request){
        $country=$request->country;
        if($request->ajax()){
                $nations = CategoryGuide::select('title', 'slug', 'feature_image' , 'id')
                        ->where('post_type', 'market')
                        ->where('title', 'like', '%'. $request->keyword .'%')
                        ->orderBy('position','asc')->get();                     
                $html = '';
                if($nations && count($nations) > 0){
                    foreach($nations as $nation){
                        $html .= '<li><a href="'.route('postTypeCountryTravel', ['slug_country' => $country,'slug' => $nation->slug]) .'" class="link_city">'.$nation->title.'</a></li>';
                    }
                    //$html = view('form.search_nation_v2', ['nations' => $nations])->render();
                }
                else{
                    $html .= '<li class="no-result">Please find another keyword!</li>';
                }
                return response()->json(['msg' => 'success', 'html' => $html, 'nations' => $nations]);
        }
        return response()->json(['msg' => 'error']);
    } 

}
