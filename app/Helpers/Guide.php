<?php
use App\PostGuide;
use App\Countries;
use App\Tours;
use App\CategoryGuide;
use App\TourCatGuide;
use App\CountryBlog;
use App\Overview;


if(! function_exists('dataSendDetailTravelTip')){
	function dataSendDetailTravelTip($slug_country, $slug){ 
		$guide = getItemPostGuideBySlug($slug, $slug_country);
        //dd($guide);
        $cat = CategoryGuide::findOrFail($guide->cat_id);
        $country = Countries::findBySlug($slug_country);
        $related_guides = getListPostGuideCountry('travel_tip', $country->id);
        $related_tours = getListTourByCountry($country->id, null, 'some');
        $list_consultants = getConsultantsByCountry($country->id);
        $desc_guideCountry = CountryBlog::where('type', 'country_guide')->where('country_id', $country->id)->select('country_blogs.*')->first();
        $list_main_city = Overview::select('list_main_city')->where('country_id', $country->id)->first();
        $seo = get_seo($guide->id, 'guide');

        $data = [];
        $data['guide'] = $guide;
        $data['cat'] = $cat;
        $data['related_guides'] = $related_guides;
        $data['related_tours'] = $related_tours;
        $data['list_consultants'] = $list_consultants;
        $data['desc_guideCountry'] = $desc_guideCountry;
        $data['list_main_city'] = $list_main_city;
        $data['seo'] = $seo;
        return $data;
	}
}

if(! function_exists('dataSendDetailCultural')){
    function dataSendDetailCultural($slug_country, $slug){
        $guide = getItemPostGuideBySlug($slug, $slug_country);
        $cat = CategoryGuide::findOrFail($guide->cat_id);
        $country = Countries::findBySlug($slug_country);
        $related_guides = $country->listPostGuide('cultural');
        $related_tours = getListTourByCountry($country->id, null, 'some');
        $list_consultants = getConsultantsByCountry($country->id);
        $seo = get_seo($guide->id, 'guide');

        $data = [];
        $data['guide'] = $guide;
        $data['cat'] = $cat;
        $data['related_guides'] = $related_guides;
        $data['related_tours'] = $related_tours;
        $data['list_consultants'] = $list_consultants;
        $data['seo'] = $seo;

        return $data;
    }
}
if(! function_exists('dataSendDetailMarket')){
    function dataSendDetailMarket($slug_country, $slug){
        $guide = getItemPostGuideBySlug($slug, $slug_country);
        if($guide){
            $cat = CategoryGuide::findOrFail($guide->cat_id);
        }else abort(404);
        $country = Countries::findBySlug($slug_country);
        $related_guides = getListPostGuideCountryV1('market', $country->id, $guide->cat_id);
        $related_tours = PostGuide::select('list_tour')->where('id', $guide->id)->first();
        $list_main_city = Overview::select('list_main_city')->where('country_id', $country->id)->first();
        $list_consultants = getConsultantsByCountry($country->id);
        $seo = get_seo($guide->id, 'market');
        $another_country=getCountriesfooter();
        $desc_guideCountry = CountryBlog::where('type', 'country_guide')->where('country_id', $country->id)->select('country_blogs.*')->first();
        $data = [];
        $data['guide'] = $guide;
        $data['cat'] = $cat;
        $data['related_guides'] = $related_guides;
        $data['related_tours'] = $related_tours;
        $data['list_main_city'] = $list_main_city;
        $data['list_consultants'] = $list_consultants;
        $data['seo'] = $seo;
        $data['another_country'] = $another_country;
        $data['desc_guideCountry'] = $desc_guideCountry;
        $data['slug'] = $slug;
        return $data;
    }
}

if(! function_exists('dataSendDetailThingToDo')){
    function dataSendDetailThingToDo($slug_country, $slug){
        $guide = getItemPostGuideBySlug($slug, $slug_country);
        $cat = CategoryGuide::findOrFail($guide->cat_id);
        $country = Countries::findBySlug($slug_country);
        $list_loadThingToDo = PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                            ->where('post_guides.post_type', 'thing_to_do')
                            ->where('post_guides.country_id', $country->id)
                            ->where('post_guides.id', '<>', $guide->id)
                            ->orderBy('post_guides.created_at', 'asc')
                            ->select('post_guides.*', 'category_guides.title as short_title', 'category_guides.white_icon', 'category_guides.gray_icon', 'category_guides.green_icon', 'category_guides.yellow_icon')
                            ->distinct()->get();
        $related_tours = getToursInCountryCatThingToDo($country->id, $guide->cat_id);
        $list_consultants = getConsultantsByCountry($country->id);
        $seo = get_seo($guide->id, 'guide');
        $list_highlight = getListHighlightCatThingToDoInCountry($country->id, $guide->cat_id); 
        //$list_travelTip = getListTravelTipByCountry($country->id, 4);
        $list_travelTip = $country->listPostGuide('travel_tip', 4); 
        $list_ortherThingsToDo = PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                            ->where('post_guides.post_type', 'thing_to_do')
                            ->where('post_guides.country_id', $country->id)
                            ->whereNotIn('post_guides.id', [$guide->id])
                            ->orderBy('post_guides.created_at', 'asc')
                            ->select('post_guides.*', 'category_guides.title as short_title', 'category_guides.gray_icon', 'category_guides.yellow_icon')
                            ->distinct()->get();
        $list_consultants = getConsultantsByCountry($country->id);

        $data = [];
        $data['guide'] = $guide;
        $data['cat'] = $cat;
        $data['list_loadThingToDo'] = $list_loadThingToDo;
        $data['related_tours'] = $related_tours;
        $data['list_consultants'] = $list_consultants;
        $data['seo'] = $seo;
        $data['list_highlight'] = $list_highlight;
        $data['list_travelTip'] = $list_travelTip;
        $data['list_ortherThingsToDo'] = $list_ortherThingsToDo;
        $data['list_consultants'] = $list_consultants;

        return $data;
    }
}

//get list thing to do by array id
if(! function_exists('getThingsToDoByArrayID')){
    function getThingsToDoByArrayID($array_id){
        return PostGuide::whereIn('id', $array_id)->get();
    }
}

/**
 * get category guide by id
 * @param int $id
 * @return ob category guide
 */
if(! function_exists('getCatGuide')){
    function getCatGuide($id){
        return CategoryGuide::findOrFail($id);
    }
}

/**
 * get tour in country category thing to do
 * @param int $country_id, int $cat_guide_id
 */
if(! function_exists('getToursInCountryCatThingToDo')){
    function getToursInCountryCatThingToDo($country_id, $cat_guide_id){ 
        $list_tour = Tours::join('tour_cat_guides', 'tours.id', '=', 'tour_cat_guides.tour_id')
                            ->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->where('country_tours.country_id', $country_id)
                            ->where('tour_cat_guides.cat_guide_id', $cat_guide_id)
                            ->select('tours.id', 'tours.title', 'tours.image')
                            ->distinct()
                            ->get();
        return $list_tour;
    }
}

/**
 * get list category guide by list id
 * @param string list id (ex: '1,2,3')
 * @return list category guide
 */
if(! function_exists('getListCatGuideByListId')){
    function getListCatGuideByListId($str_id){
        $array_id = explode(",", $str_id);
        return CategoryGuide::whereIn('id', $array_id)->get();  
    }
}

/**
 * get list travel tip by country
 * @param int $country_id, int limit
 * @return list travel tip
 */
if(! function_exists('getListTravelTipByCountry')){
    function getListTravelTipByCountry($country_id, $limit = ''){
        if($limit != '')
            $list_travelTip = PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                                ->where('post_guides.post_type', 'travel_tip')
                                ->where('post_guides.country_id', $country_id)
                                ->distinct()
                                ->select('post_guides.*', 'category_guides.title as short_title', 'category_guides.white_icon', 'category_guides.gray_icon', 'category_guides.green_icon', 'category_guides.yellow_icon')
                                ->inRandomOrder()->limit($limit)->get();
        else
            $list_travelTip = PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                                ->where('post_guides.post_type', 'travel_tip')
                                ->where('post_guides.country_id', $country_id)
                                ->distinct()
                                ->select('post_guides.*', 'category_guides.title as short_title', 'category_guides.white_icon', 'category_guides.gray_icon', 'category_guides.green_icon', 'category_guides.yellow_icon')
                                ->get();
        return $list_travelTip;
    }
}
/**
 * get slug guide
 * @param int $cat_id
 */
if(! function_exists('get_slug_guideMarket')){
    function get_slug_guideMarket($cat_id){ 
        $slug = CategoryGuide::where('category_guides.id', $cat_id)
                            ->select('category_guides.id', 'category_guides.title', 'category_guides.slug')
                            ->first();
        return $slug;
    }
}