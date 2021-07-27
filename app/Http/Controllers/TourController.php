<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Media;
use App\Tours;
use App\Schedules;
use App\Seo;
use App\Countries;
use App\CountryCategory;
use App\CategoryTour;
use App\Duration;
use App\Highlight;
use App\Overview;
use App\CountryBlog;
use App\Article;
use App\CountryTours;
use App\Pages;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use DB;
class TourController extends Controller
{   
    public function asiaTour(Request $request){
        $page = Pages::find(27);
        $seo = get_seo(27,'page');
        $array_destinationID = (isset($request->destination_id) && $request->destination_id != '') ? explode(",", $request->destination_id) : []; 
        $duration_id = $request->duration_id;
        $array_catID = (isset($request->cat_id) && $request->cat_id != '') ? explode(",", $request->cat_id) : [];
        $request['array_country_id'] = $array_destinationID;
        $request['array_tourstyle_id'] = $array_catID;
        $list_destination = getAllMainCountry();
        $array_ids = array();
        foreach ($list_destination as $value) {
                $array_ids[] = $value->id;
        }
        $list_tour_style = getListTourStyle();
        $list_duration = getListDuration();
        $list_tour = filterTour($request , 6, 1);
        $list_consultants = getConsultantsByCountry(NULL, NULL);
        $total = count(CountfilterTour($request));
        $list_blog = Article::orderBy('created_at', 'desc')->paginate(6);
        $data = [
            'list_destination' => $list_destination,
            'list_tour_style' => $list_tour_style,
            'list_duration' => $list_duration,
            'list_tour' => $list_tour,
            'list_consultants' => $list_consultants,
            'array_destinationID' => $array_destinationID,
            'duration_id' => $duration_id,
            'array_catID' => $array_catID,
            'total' => $total,
            'array_ids' => $array_ids,
            'list_blog' => $list_blog,
            'page' => $page,
            'seo' => $seo,
        ];
        return view('tours.asia_tour', $data);
    }
    public function filterTourAsia(Request $request){
        if($request->ajax()){
            $request['type_query_country'] = 'and'; 
            $value = isset($request->value) ? $request->value : 6;
            $page = isset($request->page) ? $request->page : 1;
            if($value != null && $page != null ){
                $list_tour = filterTour($request, $value, $page);
            }
            $total_data = count(CountfilterTour($request));
            $html = '';
            $filter='';
            $number= count($list_tour);
                $array_id = $request->array_id;
                $country_id = $request->array_country_id;
                $duration_id = $request->duration_id;
                $tourstyle_id = $request->array_tourstyle_id;
                $list_destination = Countries::query()->join('country_tours', 'countries.id', '=', 'country_tours.country_id')
                                        ->join('tours', 'country_tours.tour_id' , '=', 'tours.id')
                                        ->where('countries.parent_id',0);
                $list_duration = Duration::query()->join('tours', 'durations.id', '=', 'tours.duration_id')
                                        ->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                        ->join('countries', 'countries.id', '=', 'country_tours.country_id');
                $list_tour_style = CategoryTour::query()->join('tours', 'category_tours.id', '=', 'tours.cat_id')
                                                ->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                                ->join('countries', 'countries.id', '=', 'country_tours.country_id');
                if($country_id) {
                    $list_duration = $list_duration->whereIn('country_tours.country_id', $country_id);
                    $list_tour_style = $list_tour_style->whereIn('country_tours.country_id', $country_id);
                }else{
                        $list_duration = $list_duration->where('countries.parent_id',0);
                        $list_tour_style = $list_tour_style->where('countries.parent_id',0);
                    }
                if($duration_id) {
                    $abc= Tours::where('duration_id', $duration_id)->get();
                    $zzz=array();
                    foreach ($abc as $value){
                        $zzz[]=$value->id;
                    }
                    $list_destination = $list_destination->whereIn('country_tours.tour_id', $zzz);
                    $list_tour_style = $list_tour_style->where('tours.duration_id', $duration_id);
                }
                if($tourstyle_id){
                    $list_duration = $list_duration->whereIn('tours.cat_id', $tourstyle_id);
                    $bcd= Tours::whereIn('cat_id', $tourstyle_id)->get();
                    $xxx=array();
                    foreach ($bcd as $value){
                        $xxx[]=$value->id;
                    }
                    $list_destination = $list_destination->whereIn('country_tours.tour_id', $xxx);
                }
                $list_destination = $list_destination->groupBy('countries.id')
                                            ->select(DB::raw('COUNT(tours.id) as count, countries.slug as slug, countries.id as id, countries.title as title'))
                                            ->having(DB::raw("COUNT(tours.id)"), '>', 0)
                                            ->orderBy('countries.position', 'asc')->distinct('countries.id')->get();
                $list_duration = $list_duration->groupBy('durations.id')
                                            ->select(DB::raw('COUNT(DISTINCT tours.id) as count, durations.slug as slug, durations.id as id, durations.title as title'))
                                            ->having(DB::raw("COUNT(tours.id)"), '>', 0)
                                            ->distinct('durations.id')->get();
                $list_tour_style = $list_tour_style->groupBy('category_tours.id')
                                            ->select(DB::raw('COUNT(DISTINCT tours.id) as count, category_tours.slug as slug, category_tours.id as id, category_tours.position as position, category_tours.title as title'))
                                            ->having(DB::raw("COUNT(tours.id)"), '>', 0)
                                            ->orderBy('position', 'asc')
                                            ->distinct('category_tours.id')->get();
            //dd($list_duration,count($list_tour));
            $html .= view('tours.list-result-asia', ['list_tour' => $list_tour,'total' => $total_data,'number' => $number])->render();
            $filter .= view('tours.filter_asia', ['list_destination'=>$list_destination,'array_destinationID' => $country_id, 'list_duration' => $list_duration,'duration_checked' => $duration_id,'list_tour_style' => $list_tour_style,'tourstyle_checked' => $tourstyle_id])->render();
            }
        return response()->json(['msg' => 'success', 'html' => $html,'filter' => $filter,'total' => $total_data, 'number' => $number]);
    }
    public function loadMoreTourAsia(Request $request) {
        $current = isset($request->current) ? $request->current : 1;
        $total = $request->total;
        $value = isset($request->value) ? $request->value : 6;
        $array_country_id = ($request->array_country_id != "") ? explode(',',$request->array_country_id) : array();
        $array_tourstyle_id = ($request->array_tourstyle_id != "") ? explode(',',$request->array_tourstyle_id) : array();
        $array_duration_id = str_replace(',','',$request->array_duration_id);
        $tours = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id');
        if(isset($array_country_id) && count($array_country_id) > 0){
                $tours = $tours->whereIn('country_tours.country_id', $array_country_id);
        }
        if(isset($array_tourstyle_id) && count($array_tourstyle_id) > 0)
            $tours = $tours->whereIn('tours.cat_id', $array_tourstyle_id);
        if(isset($array_duration_id) && $array_duration_id != '')
            $tours = $tours->where('tours.duration_id', $array_duration_id);
        if($current > 1){
            $tours = $tours->offset(($current-1)*$value)->limit($value)
                        ->latest('tours.created_at')
                        ->select('tours.id', 'tours.title', 'tours.image', 'tours.content' ,'tours.price', 'tours.cat_id', 'tours.slug')
                        ->distinct()->get();
        }else{
            $tours = $tours->limit($value)
                        ->latest('tours.created_at')
                        ->select('tours.id', 'tours.title', 'tours.image', 'tours.content' ,'tours.price', 'tours.cat_id', 'tours.slug')
                        ->distinct()->get();
        }

        $html = '';
        $check = 0;
        $all = ($value*$current > $total) ? $total : $value*$current;
        if($tours) {
            foreach ($tours as $tour) {
                $countCountry = getAllCountriesId($tour->id);
                $html .= view('tours.related_item_asia', ['tour' => $tour, 'countCountry' => $countCountry ])->render();
            }
            $check = 1;
        }
        $data = [
            'html' => $html,
            'check' => $check,
            'all' => $all,
        ];
        return response()->json($data);
    }
    public function countryTour($slug_country, Request $request){
        $country = getCountryOverviewBySlug($slug_country);
        $array_country_id = getArrayIdChildOfCountry($country->id);
        $array_country_id[] = $country->id;
        $request['array_country_id'] = $array_country_id;
        $list_region = getListRegionInCountry($country->id);
        $list_tour_style = getListTourStyle();
        $list_duration = getListDuration();
        $list_tour = filterTour($request, 6, 1); 
        $list_tourStyle = getListTourStyleByCountry($country->id);
        $list_tourDuration = $country->countryTourDuration()->get();
        $total = count(CountfilterTour($request));
        $desc_tourCountry = CountryBlog::where('type', 'country_tour')->where('country_id', $country->id)->select('country_blogs.*')->first();
        $list_main_city = Overview::select('list_main_city')->where('country_id', $country->id)->first();
        $data =[
            'country' => $country,
            'array_country_id' => $array_country_id,
            'list_region' => $list_region,
            'list_tour_style' => $list_tour_style,
            'list_duration' => $list_duration,
            'list_tour' => $list_tour,
            'list_tourStyle' => $list_tourStyle,
            'list_tourDuration' => $list_tourDuration,
            'total' => $total,
            'desc_tourCountry' => $desc_tourCountry,
            'list_main_city' => $list_main_city,
        ];
        return view('tours.country_tour', $data);
    }
    public function loadMoreTourCountry(Request $request, $slug) {
        $country = Countries::findBySlug($slug);
        $current = isset($request->current) ? $request->current : 1;
        $total = $request->total;
        $value = isset($request->value) ? $request->value : 6;
        $array_country_id = ($request->array_country_id != "") ? explode(',',$request->array_country_id) : array();
        $array_tourstyle_id = ($request->array_tourstyle_id != "") ? explode(',',$request->array_tourstyle_id) : array();
        $array_duration_id = str_replace(',','',$request->array_duration_id);
        $tours = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id');
        //->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id');
        if(isset($array_country_id) && count($array_country_id) > 0){
                $tours = $tours->whereIn('country_tours.country_id', $array_country_id);
        }else{
            $tours = $tours->where('country_tours.country_id', $country->id);
        }
        if(isset($array_tourstyle_id) && count($array_tourstyle_id) > 0)
            $tours = $tours->whereIn('tours.cat_id', $array_tourstyle_id);
        if(isset($array_duration_id) && $array_duration_id != '')
            $tours = $tours->where('tours.duration_id', $array_duration_id);
        if($current > 1){
            $tours = $tours->offset(($current-1)*$value)->limit($value)
                        ->latest('tours.created_at')
                        ->select('tours.id', 'tours.title', 'tours.image', 'tours.content' ,'tours.price', 'tours.cat_id', 'tours.slug')
                        ->distinct()->get();
        }else{
            $tours = $tours->limit($value)
                        ->latest('tours.created_at')
                        ->select('tours.id', 'tours.title', 'tours.image', 'tours.content' ,'tours.price', 'tours.cat_id', 'tours.slug')
                        ->distinct()->get();
        }

        $html = '';
        $check = 0;
        $all = ($value*$current > $total) ? $total : $value*$current;
        if($tours) {
            foreach ($tours as $tour) {
                $countCountry = getAllCountriesId($tour->id);
                $html .= view('tours.related_item_v1', ['tour' => $tour, 'countCountry' => $countCountry , 'country' => $country ])->render();
            }
            $check = 1;
        }
        $data = [
            'html' => $html,
            'check' => $check,
            'all' => $all,
        ];
        return response()->json($data);
    }
   
    /**
     * filter tour v.2
     */
    public function filterTour2(Request $request){
        if($request->ajax()){
            $parent_id= $request->current_country_id;
            $country = Countries::where('id', $parent_id)->first();
            $request['type_query_country'] = 'and'; 
            $value = isset($request->value) ? $request->value : 6;
            $page = isset($request->page) ? $request->page : 1;
            if($value != null && $page != null )
                $list_tour = filterTour($request, $value, $page);
            else
                $list_tour = filterTour($request);
            $total_data = count(CountfilterTour($request));
            $html = '';
            $filter='';
            $number= count($list_tour);
            if(isset($request->type_result) && $request->type_result == 'slide'){
                foreach($list_tour as $tour){
                    $html .= view('tours.related_item', ['tour' => $tour])->render();
                }
            }else{
                    $country_id = $request->array_country_id;
                    $duration_id = $request->duration_id;
                    $tourstyle_id = $request->array_tourstyle_id;
                    $list_duration = Duration::query()->join('tours', 'durations.id', '=', 'tours.duration_id')
                                                        ->join('country_tours', 'tours.id', '=', 'country_tours.tour_id');
                    $list_region = Countries::query()->join('country_tours', 'countries.id', '=', 'country_tours.country_id')
                                            ->join('tours', 'country_tours.tour_id' , '=', 'tours.id')
                                            ->where('countries.parent_id', $parent_id);
                    $list_tour_style = CategoryTour::query()->join('tours', 'category_tours.id', '=', 'tours.cat_id')
                                                            ->join('country_tours', 'tours.id', '=', 'country_tours.tour_id');
                    if($country_id) {
                        $list_duration = $list_duration->whereIn('country_tours.country_id', $country_id);
                        $list_tour_style = $list_tour_style->whereIn('country_tours.country_id', $country_id);
                    }else{
                        $list_duration = $list_duration->where('country_tours.country_id', $parent_id);
                        $list_tour_style = $list_tour_style->where('country_tours.country_id', $parent_id);
                    }
                    if($duration_id) {
                        $abc= Tours::where('duration_id', $duration_id)->get();
                        $zzz=array();
                        foreach ($abc as $value){
                            $zzz[]=$value->id;
                        }
                        $list_region = $list_region->whereIn('country_tours.tour_id', $zzz);
                        $list_tour_style = $list_tour_style->where('tours.duration_id', $duration_id);
                    }
                    if($tourstyle_id){
                        $list_duration = $list_duration->whereIn('tours.cat_id', $tourstyle_id);
                        $bcd= Tours::whereIn('cat_id', $tourstyle_id)->get();
                        $xxx=array();
                        foreach ($bcd as $value){
                            $xxx[]=$value->id;
                        }
                        $list_region = $list_region->whereIn('country_tours.tour_id', $xxx);
                    }
                    $list_region = $list_region->groupBy('countries.id')
                                                ->select(DB::raw('COUNT(tours.id) as count, countries.slug as slug, countries.id as id, countries.title as title'))
                                                ->having(DB::raw("COUNT(tours.id)"), '>', 0)
                                                ->orderBy('countries.title','ASC')->distinct('countries.id')->get();
                    $list_duration = $list_duration->groupBy('durations.id')
                                                ->select(DB::raw('COUNT(tours.id) as count, durations.slug as slug, durations.id as id, durations.title as title'))
                                                ->having(DB::raw("COUNT(tours.id)"), '>', 0)
                                                ->distinct('durations.id')->get();
                    $list_tour_style = $list_tour_style->groupBy('category_tours.id')
                                                ->select(DB::raw('COUNT(tours.id) as count, category_tours.slug as slug, category_tours.id as id, category_tours.title as title'))
                                                ->having(DB::raw("COUNT(tours.id)"), '>', 0)
                                                ->orderBy('position', 'asc')
                                                ->distinct('category_tours.id')->get();
                $html .= view('tours.list-result', ['list_tour' => $list_tour,'total' => $total_data,'country' => $country,'number' => $number])->render();
                // dd($list_duration);
                $filter .= view('tours.filter', ['list_region'=>$list_region,'region_checked' => $country_id, 'list_duration' => $list_duration,'duration_checked' => $duration_id,'list_tour_style' => $list_tour_style,'tourstyle_checked' => $tourstyle_id, 'country' => $country])->render();
            }
            return response()->json(['msg' => 'success', 'html' => $html,'filter' => $filter,'total' => $total_data, 'number' => $number, 'request' => $request->duration_id]);
        }
        return 'error';
    }
    //multi country tour
    
    public function tour($slug_country, $slug){
        $post_type = postTypeByCountryTravel($slug); 
        if($post_type== 'country_tour_style') {
            $data = dataSendCountryTourStyle($slug_country, $slug);  //slug of category_tours
            return view('countryTourStyles.detail', $data);
        }
        else if($post_type== 'country_tour_duration'){
            $data = dataSendCountryTourDuration($slug_country, $slug);
            return view('countryTourDuration.detail', $data);
        }
        else{
            $tour = Tours::findBySlugOrFail($slug);
            $array_country = get_country_of_tour($tour->id);
            $country = $array_country[0];
            if($slug_country != $country->slug || count($array_country) > 1) abort(404);
            $array_highlightID = ($tour->itinerary != '') ? explode(",", $tour->itinerary) : [];    
            $cate_ids = ($tour->cat_id != '') ? ($tour->cat_id) : FALSE;
            $cates = CategoryTour::select('title', 'image')->where('id', $cate_ids)->first();
            if($country) 
                $regions = Countries::where('parent_id', $country->id)->get();
            else
                $regions = Countries::where('parent_id', 0)->get();
            $list_schedule = Schedules::where('tour_id', $tour->id)->orderBy('position', 'asc')->get();
            $related_tours = Tours::whereRaw("find_in_set($country->id,country_id)")->paginate(20);
            $seo = get_seo($tour->id, 'tour');
            $list_travelTip = getListPostGuideCountry('travel_tip', $country->id, 4);
            $list_highlight = Highlight::whereIn('id', $array_highlightID)->get();
            $list_tour_byCountry= Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                                ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                                ->where('country_tours.tour_id', '!=', $tour->id)
                                                ->where('country_tours.country_id', $country->id)
                                                ->where('tours.duration_id', $tour->duration_id)
                                                ->where('tours.cat_id', $tour->cat_id)
                                                ->distinct()->select('tours.*')
                                                ->get();
            $count_ml=count($list_tour_byCountry);
            $array_tour_id = array();
            foreach ($list_tour_byCountry as $value) {
                    $array_tour_id[] = $value->id;
            }
            if($count_ml < 6){
                $list_tour_byCountry_v1= Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                    ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                    ->whereNotIn('country_tours.tour_id', $array_tour_id)
                                    ->where('country_tours.tour_id', '!=', $tour->id)
                                    ->where('country_tours.country_id', $country->id)
                                    ->where('tours.duration_id', $tour->duration_id)
                                    ->distinct()->select('tours.*')->limit(6 - $count_ml)
                                    ->get();
            }                                     
            $list_main_city = Overview::select('list_main_city')->where('country_id', $country->id)->first();
            $desc_tourCountry = CountryBlog::where('type', 'country_tour')->where('country_id', $country->id)->select('country_blogs.*')->first();
            $data = [
                'tour' => $tour, 
                'list_schedule' => $list_schedule, 
                'country' => $country, 
                'related_tours' => $related_tours, 
                'regions' => $regions,
                'seo' => $seo,
                'list_travelTip' => $list_travelTip,
                'list_highlight' => $list_highlight,
                'cates' => $cates,
                'list_tour_byCountry' => $list_tour_byCountry,
                'list_tour_byCountry_v1' => $list_tour_byCountry_v1,
                'list_main_city' => $list_main_city,
                'desc_tourCountry' => $desc_tourCountry,
            ];
            return view('tours.tour', $data);
        }
    }
    public function tourMultiDes($slug){
        $tour = Tours::findBySlugOrFail($slug);
        $array_country = get_country_of_tour($tour->id);
        $array_ids = array();
        foreach ($array_country as $value) {
                $array_ids[] = $value->id;
        }
        $country = $array_country[0];
        $array_highlightID = ($tour->itinerary != '') ? explode(",", $tour->itinerary) : [];    
        $cate_ids = ($tour->cat_id != '') ? ($tour->cat_id) : FALSE;
        $cates = CategoryTour::select('title', 'image')->where('id', $cate_ids)->first();
        if($country) 
            $regions = Countries::where('parent_id', $country->id)->get();
        else
            $regions = Countries::where('parent_id', 0)->get();
        $list_schedule = Schedules::where('tour_id', $tour->id)->orderBy('position', 'asc')->get();
        $related_tours = Tours::whereRaw("find_in_set($country->id,country_id)")->paginate(20);
        $seo = get_seo($tour->id, 'tour');
        $list_travelTip = getListPostGuideCountry('travel_tip', $country->id, 4);
        $list_highlight = Highlight::whereIn('id', $array_highlightID)->get();
        $list_tour_multi= Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                            ->where('country_tours.tour_id', '!=', $tour->id)
                                            ->whereIn('country_tours.country_id', $array_ids)
                                            ->where('tours.duration_id', $tour->duration_id)
                                            ->where('tours.cat_id', $tour->cat_id)
                                            ->distinct()->select('tours.*')->limit(6)
                                            ->get();
        $count_ml=count($list_tour_multi);
        $array_tour_id = array();
        foreach ($list_tour_multi as $value) {
                $array_tour_id[] = $value->id;
        }
        if($count_ml <= 6){
            $list_tour_multi_v1= Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                ->whereNotIn('country_tours.tour_id', $array_tour_id)
                                ->where('country_tours.tour_id', '!=', $tour->id)
                                ->whereIn('country_tours.country_id', $array_ids)
                                ->where('tours.duration_id', $tour->duration_id)
                                ->distinct()->select('tours.*')->limit(6 - $count_ml)
                                ->get();
        } 
        $list_main_city = Overview::select('list_main_city')->where('country_id', $country->id)->first();
        $desc_tourCountry = CountryBlog::where('type', 'country_tour')->where('country_id', $country->id)->select('country_blogs.*')->first();
        $list_blog = Article::orderBy('created_at', 'asc')->paginate(6);
        $data = [
            'tour' => $tour, 
            'list_schedule' => $list_schedule, 
            'country' => $country, 
            'related_tours' => $related_tours, 
            'regions' => $regions,
            'seo' => $seo,
            'list_travelTip' => $list_travelTip,
            'list_highlight' => $list_highlight,
            'cates' => $cates,
            'list_tour_multi' => $list_tour_multi,
            'list_tour_multi_v1' => $list_tour_multi_v1,
            'list_main_city' => $list_main_city,
            'desc_tourCountry' => $desc_tourCountry,
            'list_blog' => $list_blog,
        ];
        return view('tours.tour', $data);
    }
    //filter by country
    public function toursMultiParamByCountry($slug_country, $region, $duration, $cat, $per_page, $page){
        $country = Countries::findBySlug($slug_country); 
        $region_select = $cat_select = array();
        //sb region
        $array_all_region =  Countries::where('parent_id', $country->id)->select('id')->get();
        $count_region = array();
        $query_region = array();
        //sb duration
        $array_all_duration = Duration::select('id')->get();
        $count_duration = array();
        $query_duration = array();
        //sb cat
        $array_all_cat = CategoryTour::select('id')->get(); 
        $count_cat = array();
        $query_cat = array();
        if($region != 'noindex') $region_select = explode('-and-', $region); //split string to array 
        if($cat != 'noindex') $cat_select = explode('-and-', $cat); //split string to array 
        if($per_page == 'noindex' || $per_page == '') $per_page = 8;
        if($page == 'noindex' || $page == '') $page = 1;
        if($slug_country == 'multi'){ //multi country
            $regions = Countries::where('parent_id', $country->id)->get();
            $tours = Tours::whereRaw("find_in_set($country->id,country_id)")->paginate($per_page);
        }
        else{ //single country
            $regions = Countries::where('parent_id', $country->id)->get(); 
            //$tours = Tours::whereRaw("find_in_set($country->id,country_id)")->paginate($per_page);
            $tours = Tours::query();
            foreach($array_all_region as $key => $value){ //query of list region
                $query_region[$key] = Tours::query(); 
            }
            foreach($array_all_duration as $key => $value){ //query of list duration
                $query_duration[$key] = Tours::query(); 
            }
            foreach($array_all_cat as $key => $value){ //query of list cat
                $query_cat[$key] = Tours::query(); 
            }
            $tours = $tours->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id');
            foreach($array_all_region as $key => $value){ //query of list region
                $query_region[$key] = $query_region[$key]->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id');
            }
            foreach($array_all_duration as $key => $value){ //query of list duration
                $query_duration[$key] = $query_duration[$key]->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id'); 
            }
            foreach($array_all_cat as $key => $value){ //query of list cat
                $query_cat[$key] = $query_cat[$key]->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id');
            }
            //filter by duration slug
            if($duration != 'noindex'){
                $tours = $tours->where('durations.slug', $duration);
                foreach($array_all_region as $key => $value){ //query of list region
                    $query_region[$key] = $query_region[$key]->where('durations.slug', $duration);
                }
                foreach($array_all_duration as $key => $value){ //query of list duration
                    $query_duration[$key] = $query_duration[$key]->where('durations.slug', $duration);
                }
                foreach($array_all_cat as $key => $value){ //query of list cat
                    $query_cat[$key] = $query_cat[$key]->where('durations.slug', $duration);
                }
            }
            $tours = $tours->orderBy('tours.created_at', 'desc')->select('tours.*')->distinct()->get(); 
            //current country
            if($country){
                /*$tours = $tours->intersect(
                            Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->where('country_tours.country_id', $country->id)
                            ->distinct()->select('tours.*')
                            ->get()
                        ); */
                $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->where('country_tours.country_id', $country->id)
                            ->distinct()->select('tours.*')
                            ->get();
                $tours = $tours->intersect($queryTemp);
                //dd($tours);
                /*$test = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')->where('country_tours.country_id', $country->id)->distinct()->select('tours.*')->get();
                dd($test);*/
            }
            if($region_select){ 
                $query_region_select = Tours::query();
                $query_region_select = $query_region_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->distinct()->select('tours.*')->get();
                foreach($region_select as $region_slug){
                    $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                        ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                        ->join('durations', 'tours.duration_id', '=', 'durations.id')
                        ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                        ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')
                        ->where('countries.slug', $region_slug)->distinct()->select('tours.*')->get();
                    $query_region_select = $query_region_select->intersect($queryTemp);
                }
                $tours = $tours->intersect($query_region_select); 
            } 
            if($cat_select){
                $query_cat_select = Tours::query();
                $query_cat_select = $query_cat_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->distinct()->select('tours.*')->get();
                foreach($cat_select as $keyCat => $cat_slug){
                    $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                        ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                        ->join('durations', 'tours.duration_id', '=', 'durations.id')
                        ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                        ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')
                        ->where('category_tours.slug', $cat_slug)->distinct()->select('tours.*')->get();
                    $query_cat_select = $query_cat_select->intersect($queryTemp);
                }
                $tours = $tours->intersect($query_cat_select); 
            }
        } 
        /*$test = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')->where('country_tours.country_id', 4)->distinct()->select('tours.*')->get();
        dd($test);*/
        $items = $tours instanceof Collection ? $tours : Collection::make($tours);
        $countryCat = CountryCategory::where('country_id', $country->id)->select('cat_id')->get();
        //set pagination
        $lap = new LengthAwarePaginator($items->forPage($page, $per_page), count($items), $per_page, $page); 
       /* $last_page_url = $lap->resolveCurrentPath() . '?page=' . $lap->lastPage();
        $first_page_url = $lap->resolveCurrentPath() . '?page=1';*/
        /*$paging = [
                'current_page' => $lap->currentPage(),
                'first_page_url' => $first_page_url,
                'from' => $lap->firstItem(),
                'last_page' => $lap->lastPage(),
                'last_page_url' => $last_page_url,
                'next_page_url' => $lap->nextPageUrl(),
                'per_page' => $lap->perPage(),
                'prev_page_url' => $lap->previousPageUrl(),
                'path' => $lap->resolveCurrentPath(),
                'to' => $lap->lastItem(),
                'total' => $lap->total(),
            ];*/ 
        $item = $items->toArray(); 
        //sidebar count region
        if($array_all_region){
            foreach($array_all_region as $key => $value){
                $query_region_select = Tours::query();
                $query_region_select = $query_region_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->distinct()->select('tours.*')->get();
                if($region_select){
                    foreach($region_select as $region_slug){
                        $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')
                            ->where('countries.slug', $region_slug)->distinct()->select('tours.*')->get();
                        $query_region_select = $query_region_select->intersect($queryTemp);
                    }
                }  
                $query_region[$key] = $query_region[$key]->where('country_tours.country_id', $value->id)
                                                    ->select('tours.*')->distinct()->get()->intersect($query_region_select);
                //current country
                $query_region[$key] = $query_region[$key]->intersect(
                                            Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                            ->where('country_tours.country_id', $country->id)
                                            ->distinct()->select('tours.*')
                                            ->get()
                                        );
                if($cat_select){
                    $query_cat_select = Tours::query();
                    $query_cat_select = $query_cat_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->distinct()->select('tours.*')->get();
                    foreach($cat_select as $keyCat => $cat_slug){
                        $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')
                            ->where('category_tours.slug', $cat_slug)->distinct()->select('tours.*')->get();
                        $query_cat_select = $query_cat_select->intersect($queryTemp);
                    }
                    $query_region[$key] = $query_region[$key]->intersect($query_cat_select);
                }
                $count_region[$value->id] = count($query_region[$key]);
            }
        }
        //count tour for each duration
        if($array_all_duration){
            foreach($array_all_duration as $key => $value){
                $query_duration[$key] = $query_duration[$key]->where('tours.duration_id', $value->id)
                                                        ->select('tours.*')->distinct()->get();
                //current country
                $query_duration[$key] = $query_duration[$key]->intersect(
                                            Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                            ->where('country_tours.country_id', $country->id)
                                            ->distinct()->select('tours.*')
                                            ->get()
                                        );
                //region                                          
                if($region_select){ 
                    $query_region_select = Tours::query();
                    $query_region_select = $query_region_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                ->join('durations', 'tours.duration_id', '=', 'durations.id')
                                ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                                ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->distinct()->select('tours.*')->get();
                    foreach($region_select as $region_slug){
                        $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')
                            ->where('countries.slug', $region_slug)->distinct()->select('tours.*')->get();
                        $query_region_select = $query_region_select->intersect($queryTemp);
                    }
                    $query_duration[$key] = $query_duration[$key]->intersect($query_region_select); 
                }
                //cat
                if($cat_select){
                    $query_cat_select = Tours::query();
                    $query_cat_select = $query_cat_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->distinct()->select('tours.*')->get();
                    foreach($cat_select as $keyCat => $cat_slug){
                        $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')
                            ->where('category_tours.slug', $cat_slug)->distinct()->select('tours.*')->get();
                        $query_cat_select = $query_cat_select->intersect($queryTemp);
                    }
                    $query_duration[$key] = $query_duration[$key]->intersect($query_cat_select);
                }
                $count_duration[$value->id] = count($query_duration[$key]);
            }
        }   
        //count tour for each cat
        if($array_all_cat){
            foreach($array_all_cat as $key => $value){ 
                /*$query_cat[$key] = $query_cat[$key]->where('category_tours.id', $value->id)
                                                 ->select('tours.*')->distinct()->get();*/
                $query_cat_select = Tours::query();
                $query_cat_select = $query_cat_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->distinct()->select('tours.*')->get();
                if($cat_select){
                    foreach($cat_select as $keyCat => $cat_slug){
                        $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')
                            ->where('category_tours.slug', $cat_slug)->distinct()->select('tours.*')->get();
                        $query_cat_select = $query_cat_select->intersect($queryTemp);
                    }
                }
                $query_cat[$key] = $query_cat[$key]->where('category_tours.id', $value->id)
                                                    ->select('tours.*')->distinct()->get()->intersect($query_cat_select);
                //current country
                $query_cat[$key] = $query_cat[$key]->intersect(
                                            Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                            ->where('country_tours.country_id', $country->id)
                                            ->distinct()->select('tours.*')
                                            ->get()
                                        );
                if($region_select){ 
                    $query_region_select = Tours::query();
                    $query_region_select = $query_region_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                ->join('durations', 'tours.duration_id', '=', 'durations.id')
                                ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                                ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->distinct()->select('tours.*')->get();
                    foreach($region_select as $region_slug){
                        $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')
                            ->where('countries.slug', $region_slug)->distinct()->select('tours.*')->get();
                        $query_region_select = $query_region_select->intersect($queryTemp);
                    }
                    $query_cat[$key] = $query_cat[$key]->intersect($query_region_select); 
                }
                $count_cat[$value->id] = count($query_cat[$key]);
            }
        }
        //dd($lap);
        return view('tours.country_tour', ['country'=>$country, 'regions'=>$regions, 'tours'=> $lap->values(), 'countryCat'=>$countryCat, 'region_select'=>$region_select, 'duration_select'=>$duration, 'cat_select'=>$cat_select, 'paging' => $lap, 'all_tours'=>$tours, 'count_region'=>$count_region, 'count_duration'=>$count_duration, 'count_cat'=>$count_cat]);
    }
    //filter by country
    public function toursMultiParamByMulti($region, $duration, $cat, $per_page, $page){
        $region_select = $cat_select = array();
        //sb region
        $array_all_region =  Countries::where('parent_id', 0)->select('id')->get();
        $count_region = array();
        $query_region = array();
        //sb duration
        $array_all_duration = Duration::select('id')->get();
        $count_duration = array();
        $query_duration = array();
        //sb cat
        $array_all_cat = CategoryTour::select('id')->get(); 
        $count_cat = array();
        $query_cat = array();
        if($region != 'noindex') $region_select = explode('-and-', $region); //split string to array 
        if($cat != 'noindex') $cat_select = explode('-and-', $cat); //split string to array 
        if($per_page == 'noindex' || $per_page == '') $per_page = 8;
        if($page == 'noindex' || $page == '') $page = 1;
            $regions = Countries::where('parent_id', 0)->get(); 
            //$tours = Tours::whereRaw("find_in_set($country->id,country_id)")->paginate($per_page);
            $tours = Tours::query();
            foreach($array_all_region as $key => $value){ //query of list region
                $query_region[$key] = Tours::query(); 
            }
            foreach($array_all_duration as $key => $value){ //query of list duration
                $query_duration[$key] = Tours::query(); 
            }
            foreach($array_all_cat as $key => $value){ //query of list cat
                $query_cat[$key] = Tours::query(); 
            }
            $tours = $tours->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id');
            foreach($array_all_region as $key => $value){ //query of list region
                $query_region[$key] = $query_region[$key]->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id');
            }
            foreach($array_all_duration as $key => $value){ //query of list duration
                $query_duration[$key] = $query_duration[$key]->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id'); 
            }
            foreach($array_all_cat as $key => $value){ //query of list cat
                $query_cat[$key] = $query_cat[$key]->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id');
            }
            $arr_multiID = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                ->whereIn('country_tours.country_id', function ($query) {
                                    $query->select('countries.id')
                                        ->from('countries')
                                        ->where('countries.parent_id', 0);
                                })
                                ->groupBy('country_tours.tour_id')
                                ->having(DB::raw("count(country_tours.tour_id)"), '>', 1)
                                ->distinct()->pluck('tours.id');
            $tours = $tours->whereIn('tours.id', $arr_multiID);
            foreach($array_all_region as $key => $value){ //query of list region
                $query_region[$key] = $query_region[$key]->whereIn('tours.id', $arr_multiID);
            }
            foreach($array_all_duration as $key => $value){ //query of list duration
                $query_duration[$key] = $query_duration[$key]->whereIn('tours.id', $arr_multiID);
            }
            foreach($array_all_cat as $key => $value){ //query of list cat
                $query_cat[$key] = $query_cat[$key]->whereIn('tours.id', $arr_multiID); 
            }
            //filter by duration slug
            if($duration != 'noindex'){
                $tours = $tours->where('durations.slug', $duration);
                foreach($array_all_region as $key => $value){ //query of list region
                    $query_region[$key] = $query_region[$key]->where('durations.slug', $duration);
                }
                foreach($array_all_duration as $key => $value){ //query of list duration
                    $query_duration[$key] = $query_duration[$key]->where('durations.slug', $duration);
                }
                foreach($array_all_cat as $key => $value){ //query of list cat
                    $query_cat[$key] = $query_cat[$key]->where('durations.slug', $duration);
                }
            }
            $tours = $tours->orderBy('tours.created_at', 'desc')->select('tours.*')->distinct()->get(); 
            //current country
            if($region_select){ 
                $query_region_select = Tours::query();
                $query_region_select = $query_region_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->distinct()->select('tours.*')->get();
                foreach($region_select as $region_slug){
                    $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                        ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                        ->join('durations', 'tours.duration_id', '=', 'durations.id')
                        ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                        ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')
                        ->where('countries.slug', $region_slug)->distinct()->select('tours.*')->get();
                    $query_region_select = $query_region_select->intersect($queryTemp);
                }
                $tours = $tours->intersect($query_region_select); 
            } 
            if($cat_select){
                $query_cat_select = Tours::query();
                $query_cat_select = $query_cat_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->distinct()->select('tours.*')->get();
                foreach($cat_select as $keyCat => $cat_slug){
                    $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                        ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                        ->join('durations', 'tours.duration_id', '=', 'durations.id')
                        ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                        ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')
                        ->where('category_tours.slug', $cat_slug)->distinct()->select('tours.*')->get();
                    $query_cat_select = $query_cat_select->intersect($queryTemp);
                }
                $tours = $tours->intersect($query_cat_select); 
            }
        /*$test = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')->where('country_tours.country_id', 4)->distinct()->select('tours.*')->get();
        dd($test);*/
        $items = $tours instanceof Collection ? $tours : Collection::make($tours);
        $countryCat = CountryCategory::select('cat_id')->get();
        //set pagination
        $lap = new LengthAwarePaginator($items->forPage($page, $per_page), count($items), $per_page, $page); 
       /* $last_page_url = $lap->resolveCurrentPath() . '?page=' . $lap->lastPage();
        $first_page_url = $lap->resolveCurrentPath() . '?page=1';*/
        /*$paging = [
                'current_page' => $lap->currentPage(),
                'first_page_url' => $first_page_url,
                'from' => $lap->firstItem(),
                'last_page' => $lap->lastPage(),
                'last_page_url' => $last_page_url,
                'next_page_url' => $lap->nextPageUrl(),
                'per_page' => $lap->perPage(),
                'prev_page_url' => $lap->previousPageUrl(),
                'path' => $lap->resolveCurrentPath(),
                'to' => $lap->lastItem(),
                'total' => $lap->total(),
            ];*/ 
        $item = $items->toArray(); 
        //sidebar count region
        if($array_all_region){
            foreach($array_all_region as $key => $value){
                $query_region_select = Tours::query();
                $query_region_select = $query_region_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->distinct()->select('tours.*')->get();
                if($region_select){
                    foreach($region_select as $region_slug){
                        $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')
                            ->where('countries.slug', $region_slug)->distinct()->select('tours.*')->get();
                        $query_region_select = $query_region_select->intersect($queryTemp);
                    }
                }  
                $query_region[$key] = $query_region[$key]->where('country_tours.country_id', $value->id)
                                                    ->select('tours.*')->distinct()->get()->intersect($query_region_select);
                //current country
                $query_region[$key] = $query_region[$key]->intersect(
                                            Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                            ->distinct()->select('tours.*')
                                            ->get()
                                        );
                if($cat_select){
                    $query_cat_select = Tours::query();
                    $query_cat_select = $query_cat_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->distinct()->select('tours.*')->get();
                    foreach($cat_select as $keyCat => $cat_slug){
                        $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')
                            ->where('category_tours.slug', $cat_slug)->distinct()->select('tours.*')->get();
                        $query_cat_select = $query_cat_select->intersect($queryTemp);
                    }
                    $query_region[$key] = $query_region[$key]->intersect($query_cat_select);
                }
                $count_region[$value->id] = count($query_region[$key]);
            }
        }
        //count tour for each duration
        if($array_all_duration){
            foreach($array_all_duration as $key => $value){
                $query_duration[$key] = $query_duration[$key]->where('tours.duration_id', $value->id)
                                                        ->select('tours.*')->distinct()->get();
                //current country
                $query_duration[$key] = $query_duration[$key]->intersect(
                                            Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                            ->distinct()->select('tours.*')
                                            ->get()
                                        );
                //region                                          
                if($region_select){ 
                    $query_region_select = Tours::query();
                    $query_region_select = $query_region_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                ->join('durations', 'tours.duration_id', '=', 'durations.id')
                                ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                                ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->distinct()->select('tours.*')->get();
                    foreach($region_select as $region_slug){
                        $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')
                            ->where('countries.slug', $region_slug)->distinct()->select('tours.*')->get();
                        $query_region_select = $query_region_select->intersect($queryTemp);
                    }
                    $query_duration[$key] = $query_duration[$key]->intersect($query_region_select); 
                }
                //cat
                if($cat_select){
                    $query_cat_select = Tours::query();
                    $query_cat_select = $query_cat_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->distinct()->select('tours.*')->get();
                    foreach($cat_select as $keyCat => $cat_slug){
                        $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')
                            ->where('category_tours.slug', $cat_slug)->distinct()->select('tours.*')->get();
                        $query_cat_select = $query_cat_select->intersect($queryTemp);
                    }
                    $query_duration[$key] = $query_duration[$key]->intersect($query_cat_select);
                }
                $count_duration[$value->id] = count($query_duration[$key]);
            }
        }   
        //count tour for each cat
        if($array_all_cat){
            foreach($array_all_cat as $key => $value){ 
                /*$query_cat[$key] = $query_cat[$key]->where('category_tours.id', $value->id)
                                                 ->select('tours.*')->distinct()->get();*/
                $query_cat_select = Tours::query();
                $query_cat_select = $query_cat_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->distinct()->select('tours.*')->get();
                if($cat_select){
                    foreach($cat_select as $keyCat => $cat_slug){
                        $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')
                            ->where('category_tours.slug', $cat_slug)->distinct()->select('tours.*')->get();
                        $query_cat_select = $query_cat_select->intersect($queryTemp);
                    }
                }
                $query_cat[$key] = $query_cat[$key]->where('category_tours.id', $value->id)
                                                    ->select('tours.*')->distinct()->get()->intersect($query_cat_select);
                //current country
                $query_cat[$key] = $query_cat[$key]->intersect(
                                            Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                            ->distinct()->select('tours.*')
                                            ->get()
                                        );
                if($region_select){ 
                    $query_region_select = Tours::query();
                    $query_region_select = $query_region_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                ->join('durations', 'tours.duration_id', '=', 'durations.id')
                                ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                                ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->distinct()->select('tours.*')->get();
                    foreach($region_select as $region_slug){
                        $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('durations', 'tours.duration_id', '=', 'durations.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')
                            ->where('countries.slug', $region_slug)->distinct()->select('tours.*')->get();
                        $query_region_select = $query_region_select->intersect($queryTemp);
                    }
                    $query_cat[$key] = $query_cat[$key]->intersect($query_region_select); 
                }
                $count_cat[$value->id] = count($query_cat[$key]);
            }
        }
        return view('tours.multi_country_tour', ['regions'=>$regions, 'tours'=> $lap->values(), 'countryCat'=>$countryCat, 'region_select'=>$region_select, 'duration_select'=>$duration, 'cat_select'=>$cat_select, 'paging' => $lap, 'all_tours'=>$tours, 'count_region'=>$count_region, 'count_duration'=>$count_duration, 'count_cat'=>$count_cat]);
    }
    //filter tour
    public function filterTour(Request $request){
        if($request->ajax()){
            $html = '';
            $slug_country = '';
            $result = array();
            $array_region = json_decode($request->region);
            $duration = $request->duration;
            $array_cat = json_decode($request->cat);
            $page = 1;
            if($request->page) $page = $request->page;
            //sb region
            $array_all_region = json_decode($request->all_region);
            $count_region = array();
            $query_region = array();
            //sb duration
            $array_all_duration = json_decode($request->all_duration);
            $count_duration = array();
            $query_duration = array();
            //sb cat
            $array_all_cat = json_decode($request->all_cat);
            $count_cat = array();
            $query_cat = array();
            $per_page = 8;
            if($request->per_page && $request->per_page !='' && $request->per_page != NULL){
                $per_page = $request->per_page;
            }
            /*$skip = 0;
            if($request->skip && $request->skip !='' && $request->skip != NULL){
                $skip = intval(($request->page - 1))* $per_page;
            }*/
            $tours = Tours::query();
            foreach($array_all_region as $key => $value){ //query of list region
                $query_region[$key] = Tours::query(); 
            }
            foreach($array_all_duration as $key => $value){ //query of list duration
                $query_duration[$key] = Tours::query(); 
            }
            foreach($array_all_cat as $key => $value){ //query of list cat
                $query_cat[$key] = Tours::query(); 
            }
            $tours = $tours->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id')->select('tours.*');
            foreach($array_all_region as $key => $value){ //query of list region
                $query_region[$key] = $query_region[$key]->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id');
            }
            foreach($array_all_duration as $key => $value){ //query of list duration
                $query_duration[$key] = $query_duration[$key]->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id');
            }
            foreach($array_all_cat as $key => $value){ //query of list cat
                $query_cat[$key] = $query_cat[$key]->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                            ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                            ->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                            ->join('category_tours', 'cat_tour_metas.cat_id', '=', 'category_tours.id'); 
            }
            //current country tour (page)
            //filter region
            //filter duration
            if($duration && $duration!=''){ 
                $tours = $tours->where("duration_id", $duration);
                //country
                foreach($array_all_region as $key => $region_id){
                    $query_region[$key] = $query_region[$key]->where("tours.duration_id", $duration);
                }
                //duration
                foreach($array_all_duration as $key => $duration_id){
                    $query_duration[$key] =  $query_duration[$key]->where("tours.duration_id", $duration);
                }
                //cat
                foreach($array_all_cat as $key => $cat_id){
                    $query_cat[$key] = $query_cat[$key]->where("tours.duration_id", $duration);
                }
            }
            /*-- if multi country --*/
            if(isset($request->type_country) && $request->type_country == 'multi'){
              
                $arr_multiID = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                    ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                    ->whereIn('country_tours.country_id', function ($query) {
                                        $query->select('countries.id')
                                            ->from('countries')
                                            ->where('countries.parent_id', 0);
                                    })
                                    ->groupBy('country_tours.tour_id')
                                    ->having(DB::raw("count(country_tours.tour_id)"), '>', 1)
                                    ->distinct()->pluck('tours.id');
                $tours = $tours->whereIn('tours.id', $arr_multiID);
                foreach($array_all_region as $key => $value){ //query of list region
                    $query_region[$key] = $query_region[$key]->whereIn('tours.id', $arr_multiID);
                }
                foreach($array_all_duration as $key => $value){ //query of list duration
                    $query_duration[$key] = $query_duration[$key]->whereIn('tours.id', $arr_multiID);
                }
                foreach($array_all_cat as $key => $value){ //query of list cat
                    $query_cat[$key] = $query_cat[$key]->whereIn('tours.id', $arr_multiID); 
                }
                $slug_country = 'multi';
            }
            //$tours = $tours->orderBy('tours.created_at', 'desc')->distinct()->select('tours.*')->paginate($per_page);
            $tours = $tours->orderBy('tours.created_at', 'desc')->distinct()->get();
            foreach($array_all_region as $key => $region_id){
                $query_region[$key] = $query_region[$key]->distinct()->select('tours.*')->get();
                //current value
                $queryTemp = Tours::query();
                $queryTemp = $queryTemp->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                        ->where('country_tours.country_id', $region_id)
                                        ->distinct()->select('tours.*')->get();
                $query_region[$key] = $query_region[$key]->intersect($queryTemp);
            }
            //duration
            foreach($array_all_duration as $key => $duration_id){
                $query_duration[$key] =  $query_duration[$key]->where('tours.duration_id', $duration_id)->distinct()->select('tours.*')->get();
            }
            //cat
            foreach($array_all_cat as $key => $cat_id){
                $query_cat[$key] = $query_cat[$key]->distinct()->select('tours.*')->get();
                //current value
                $queryTemp = Tours::query();
                $queryTemp = $queryTemp->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                                        ->where('cat_tour_metas.cat_id', $cat_id)
                                        ->distinct()->select('tours.*')->get();
                $query_cat[$key] = $query_cat[$key]->intersect($queryTemp);
            }
            /*-- filter params of countries (current country of page and region select to filter) --*/
            if($request->current_country != ''){ //current country
                $queryTemp = Tours::query();
                $queryTemp = $queryTemp->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                        ->where('country_tours.country_id', $request->current_country)
                                        ->distinct()->select('tours.*')->get();
                $tours = $tours->intersect($queryTemp); //for tours
                if($array_all_region){ //for all region
                    foreach($array_all_region as $key => $region_id){
                        $query_region[$key] = $query_region[$key]->intersect($queryTemp);
                    }
                }
                if($array_all_duration){ //for all duration
                    foreach($array_all_duration as $key => $duration_id){
                        $query_duration[$key] = $query_duration[$key]->intersect($queryTemp);
                    }
                }
                if($array_all_cat){ //for all categories
                    foreach($array_all_cat as $key => $cat_id){
                        $query_cat[$key] = $query_cat[$key]->intersect($queryTemp);
                    }
                }
                //get item current country
                $country = getCountry($request->current_country);
                $slug_country = $country->slug;
            }
            if($array_region){ //array select countries
                $query_region_select = Tours::query();
                $query_region_select = $query_region_select->join('country_tours', 'tours.id', '=', 'country_tours.tour_id')->distinct()->select('tours.*')->get();
                foreach($array_region as $value){
                    $queryTemp = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                        ->where('country_tours.country_id', $value)->distinct()->select('tours.*')->get();
                    $query_region_select = $query_region_select->intersect($queryTemp);
                }
                $tours = $tours->intersect($query_region_select); //for tours
                if($array_all_region){ //for all region
                    foreach($array_all_region as $key => $region_id){
                        $query_region[$key] = $query_region[$key]->intersect($query_region_select);
                    }
                }
                if($array_all_duration){ //for all duration
                    foreach($array_all_duration as $key => $duration_id){
                        $query_duration[$key] = $query_duration[$key]->intersect($query_region_select);
                    }
                }
                if($array_all_cat){ //for all categories
                    foreach($array_all_cat as $key => $cat_id){
                        $query_cat[$key] = $query_cat[$key]->intersect($query_region_select);
                    }
                }
            }
            /* end filter params of countries (current country of page and region select to filter) */
            /*-- filter params of categories (categories select to filter) --*/
            if($array_cat){ 
                $query_cat_select = Tours::query();
                $query_cat_select = $query_cat_select->join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')->distinct()->select('tours.*')->get();
                foreach($array_cat as $value){
                    $queryTemp = Tours::join('cat_tour_metas', 'tours.id', '=', 'cat_tour_metas.tour_id')
                        ->where('cat_tour_metas.cat_id', $value)->distinct()->select('tours.*')->get();
                    $query_cat_select = $query_cat_select->intersect($queryTemp);
                }
                $tours = $tours->intersect($query_cat_select); //for tours
                if($array_all_region){ //for all region
                    foreach($array_all_region as $key => $region_id){
                        $query_region[$key] = $query_region[$key]->intersect($query_cat_select);
                    }
                }
                if($array_all_duration){ //for all duration
                    foreach($array_all_duration as $key => $duration_id){
                        $query_duration[$key] = $query_duration[$key]->intersect($query_cat_select);
                    }
                }
                if($array_all_cat){ //for all categories
                    foreach($array_all_cat as $key => $cat_id){
                        $query_cat[$key] = $query_cat[$key]->intersect($query_cat_select);
                    }
                }
            }
            /*end filter params of categories*/
            if($array_all_region){ //count tour in list region
                foreach($array_all_region as $key => $value){
                    $count_region[$key]['id'] = $value;
                    $count_region[$key]['count'] = count($query_region[$key]);
                }
            }
            if($array_all_duration){
                foreach($array_all_duration as $key => $value){
                    $count_duration[$key]['id'] = $value;
                    $count_duration[$key]['count'] = count($query_duration[$key]);
                }
            }
            if($array_all_cat){
                foreach($array_all_cat as $key => $value){
                    $count_cat[$key]['id'] = $value;
                    $count_cat[$key]['count'] = count($query_cat[$key]);
                }
            }
            $items = $tours instanceof Collection ? $tours : Collection::make($tours);
            //set pagination
            $lap = new LengthAwarePaginator($items->forPage($page, $per_page), count($items), $per_page, $page); 
            //$paginate  = '';
            $paginate = getPaginate($lap); //get paginate of tours
            $html = getContentListTour($lap->values());
            if(count($tours) < $per_page) $paginate = 'empty';
            /*
            * slug in redirect URL
            */
            $slug_region = $slug_duration = $slug_cat = 'noindex';
            //region
            if($array_region){
                foreach($array_region as $key => $value){
                    $countryTemp = getCountryById($value);
                    if($key == 0) $slug_region = $countryTemp->slug;
                    else $slug_region .= '-and-' . $countryTemp->slug; 
                }
            }
            //duration
            if($duration){
                $slug_duration = getDurationById($duration)->slug;
            }
            //category tour
            if($array_cat){
                foreach($array_cat as $key => $value){
                    $catTemp = get_category_tour($value);
                    if($key == 0) $slug_cat = $catTemp->slug;
                    else $slug_cat .= '-and-' . $catTemp->slug; 
                }
            }
            $slug_page = $slug_per_page = 'noindex';
            if($request->per_page && $request->per_page != ''){
                $slug_per_page = $per_page;
            }
            if($request->page && $request->page != ''){
                $slug_page = $page;
                //$slug_per_page = $per_page;
            }
            $result['url'] = route('toursMultiParamByCountry', ['slug_country'=>$slug_country, 'region' => $slug_region, 'duration' => $slug_duration, 'cat' => $slug_cat, 'per_page' => $slug_per_page, 'page' => $slug_page]);
            if(isset($request->type_country) && $request->type_country == 'multi'){
                $result['url'] = route('toursMultiParamByMulti', ['region' => $slug_region, 'duration' => $slug_duration, 'cat' => $slug_cat, 'per_page' => $slug_per_page, 'page' => $slug_page]);
            }
            $result['content'] = $html;
            $result['paginate'] = $paginate;
            $result['total_result'] = count($tours);
            $result['count_region'] = json_encode($count_region);
            $result['count_duration'] = json_encode($count_duration);
            $result['count_cat'] = json_encode($count_cat);
            return json_encode($result);
        }
        return 'error';
    }
    
    /**
     * filter tour v.2
     */
    public function filterTourAbout(Request $request){
        if($request->ajax()){
            $request['type_query_country'] = 'and'; 
            if(isset($request->per_page) && isset($request->page))
                $list_tour = filterTour($request, $request->per_page, $request->page);
            else
                $list_tour = filterTour($request);
            $html = '';
            if(isset($request->type_result) && $request->type_result == 'slide'){
                foreach($list_tour as $tour){
                    $html .= view('tours.related_item', ['tour' => $tour])->render();
                }
            }else{
                $html .= view('tours.list-result', ['list_tour' => $list_tour])->render();
            }
            return response()->json(['msg' => 'success', 'html' => $html, 'total' => count($list_tour), 'request' => $request->duration_id]);
        }
        return 'error';
    }
}