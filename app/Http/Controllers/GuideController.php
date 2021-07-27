<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\PostGuide;
use App\Media;
use App\Seo;
use App\TableContentDetails;
use App\TableContents;
use App\Countries;
use App\Tours;
use App\CountryBlog;
use App\CategoryGuide;

class GuideController extends Controller
{
	/*public function countryGuide($slug_country){
        $country = Countries::findBySlug($slug_country);
        if($slug_country == 'multi-country'){
            $country = Countries::findBySlug('laos');
            $guides = PostGuide::paginate(8); 
        }
        else if($slug_country == 'admin'){
            $user = Auth::user();
            $guides = PostGuide::orderBy('created_at', 'desc')->where('post_type', 'travel_tip')->paginate(14);
            if($user && $user->level=="admin")
                return view('backend.guides.list',['guides'=>$guides]);
            else
                return redirect('login');
        }
        else{
            $guides = PostGuide::where('country_id', $country->id)->where('post_type', 'travel_tip')->orderBy('created_at', 'asc')->get();
            $related_tours = Tours::whereRaw("find_in_set($country->id,country_id)")->get();
        }
        
        return view('guides.country_guide', ['country'=>$country, 'guides'=>$guides, 'related_tours'=>$related_tours]);
    }*/

    public function countryGuide($slug_country){
        $country = Countries::findBySlug($slug_country);
        $count_guides = count(getListPostGuideCountry('travel_tip', $country->id ));
        $guides = PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                            ->where('post_guides.post_type', 'travel_tip')
                            ->where('post_guides.country_id', $country->id)
                            ->orderBy('category_guides.position', 'asc')
                            ->select('post_guides.*', 'category_guides.slug as slug', 'category_guides.title as title')
                            ->distinct()->limit(3)->get();
        $array_id = array();
        foreach ($guides as $value) {
                    $array_id[] = $value->id;
        }
        if($count_guides > 3){
            $guides_v1= PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                            ->where('post_guides.post_type', 'travel_tip')
                            ->whereNotIn('post_guides.id', $array_id)
                            ->where('post_guides.country_id', $country->id)
                            ->orderBy('category_guides.position', 'asc')
                            ->select('post_guides.*', 'category_guides.slug as slug', 'category_guides.title as title')
                            ->distinct()->get();
        }   
        $desc_guideCountry = CountryBlog::where('type', 'country_guide')->where('country_id', $country->id)->select('country_blogs.*')->first();
        $count_nation = count(getListPostGuideCountry('market', $country->id));
        $list_nation =  PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                            ->where('post_guides.post_type', 'market')
                            ->where('post_guides.country_id', $country->id)
                            ->orderBy('category_guides.position', 'asc')
                            ->select('post_guides.*', 'category_guides.slug as slug', 'category_guides.title as title' , 'category_guides.feature_image as feature_image')
                            ->distinct()->limit(6)->get();
        $array_id_nation = array();
        foreach ($list_nation as $value){
                    $array_id_nation[] = $value->id;
        }
        if($count_nation > 6){
        $list_nation_v1= PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                            ->where('post_guides.post_type', 'market')
                            ->whereNotIn('post_guides.id', $array_id_nation)
                            ->where('post_guides.country_id', $country->id)
                            ->orderBy('category_guides.position', 'asc')
                            ->select('post_guides.*', 'category_guides.slug as slug', 'category_guides.title as title' )
                            ->distinct()->get();
        }
        $seo = get_seo($desc_guideCountry->id,'country_blog');
        $data = [];
        $data['country'] = $country;
        $data['guides'] = $guides;
        $data['guides_v1'] = $guides_v1;
        $data['desc_guideCountry'] = $desc_guideCountry;
        $data['list_nation'] = $list_nation;
        $data['list_nation_v1'] = $list_nation_v1;
        $data['seo'] = $seo;
        return view('guides.country_guide', $data);
    }

    //guide
    public function guide($slug_country, $slug){

        //if $slug is create in admin
       /* $user = Auth::user();
        if($slug === 'create' && $user && $user->level == 'admin'){
            return view('backend.guides.create');
        }*/
        
        $guide = PostGuide::findBySlug($slug);
        $country = Countries::findBySlug($slug_country);
        $related_guides = PostGuide::where('country_id', $country->id)
                                ->where('post_type', 'travel_tip')
                                ->orderBy('created_at', 'asc')->get();
        $related_tours = Tours::whereRaw("find_in_set($country->id,country_id)")->get();
        $list_consultants = getConsultantsByCountry($country->id);
        $data = [];
        $data['guide'] = $guide;
        $data['related_guides'] = $related_guides;
        $data['related_tours'] = $related_tours;
        $data['list_consultants'] = $list_consultants;  
        return view('guides.guide', $data);
    }

    public function countryCultural($slug_country){
        $country = Countries::findBySlug($slug_country);
        $guides = getListPostGuideCountry('cultural', $country->id);
        $related_tours = getListTourByCountry($country->id); 
        $related_articles = getListArticleByCountry($country->id, 20);
        $data = [
            'country'=>$country, 
            'guides'=>$guides, 
            'related_tours'=>$related_tours,
            'related_articles'=>$related_articles
        ];
        
        return view('guides.country_cultural', $data);
    }
    public function countryMarket($slug_country){
        $country = Countries::findBySlug($slug_country);
        $guides = getListPostGuideCountry('nation', $country->id);
        $related_tours = getListTourByCountry($country->id); 
        $related_articles = getListArticleByCountry($country->id, 20);
        $data = [
            'country'=>$country, 
            'guides'=>$guides, 
            'related_tours'=>$related_tours,
            'related_articles'=>$related_articles
        ];
        
        return view('guides.country_market', $data);
    }

    public function countryThingsToDo($slug_country){
        $country = Countries::findBySlug($slug_country);
        $guides = getListPostGuideCountry('thing_to_do', $country->id);
        $related_tours = getListTourByCountry($country->id); 
        $list_travelTip = getFourItemPostGuideInCountry('travel_tip', $country->id);
        $list_consultants = getConsultantsByCountry($country->id);

        $data = [
            'country' => $country, 
            'guides' => $guides, 
            'related_tours' => $related_tours,
            'list_travelTip' => $list_travelTip,
            'list_consultants' => $list_consultants
        ];
        
        return view('guides.country_thingToDo', $data);
    }

    //search things to do
    public function seachThingToDo($slug_country, Request $request){
        if($request->ajax()){
            $country = Countries::findBySlug($slug_country);
            $list_thingToDo = PostGuide::join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                            ->where('post_guides.post_type', 'thing_to_do')
                            ->where('post_guides.country_id', $country->id)
                            ->where('category_guides.title', 'LIKE', '%'. $request->keyword .'%');
            if($request->current_id != '')
                $list_thingToDo = $list_thingToDo->where('post_guides.id', '<>', $request->current_id);
            $list_thingToDo = $list_thingToDo->orderBy('post_guides.created_at', 'asc')
                            ->select('post_guides.*', 'category_guides.title as short_title', 'category_guides.white_icon', 'category_guides.gray_icon', 'category_guides.green_icon', 'category_guides.yellow_icon')
                            ->distinct()->get();
            $html = '';
            if($list_thingToDo && count($list_thingToDo) > 0){
                foreach($list_thingToDo as $item){
                    $html .= '<li><a href="#">'. $item->short_title .'</a></li>';
                }
            }
            else{
                $html .= '<li class="no-result">Please recheck your typing or <a href="#" class="">CONTACT US</a> for more detail</li>';
            }
            return response()->json(['msg' => 'success', 'html' => $html]);
        }
        return response()->json(['msg' => 'error']);
    }

    public function searchCatMarketGuide(Request $request){
        $slug_country=$request->country;
        $cat_guide=$request->cat_guide;
        $country = Countries::findBySlug($slug_country);
        if($request->ajax()){
                $nations = CategoryGuide::join('post_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                        ->where('post_guides.country_id', $country->id)
                        ->where('post_guides.cat_id','!=',$cat_guide)
                        ->where('category_guides.post_type', 'market')
                        ->where('category_guides.title', 'like', '%'. $request->keyword .'%')
                        ->select('category_guides.*')
                        ->orderBy('position','asc')->get();                     
                $html = '';
                if($nations && count($nations) > 0){
                    foreach($nations as $nation){
                        $html .= '<li><a href="'.route('postTypeCountryTravel', ['slug_country' => $slug_country,'slug' => $nation->slug]) .'" class="link_city">'.$nation->title.'</a></li>';
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
    