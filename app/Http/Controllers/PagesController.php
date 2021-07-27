<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Pages;
use Mail;
use App\Metas;
use App\SlideDetail;
use App\ArticleCat;
use App\Article;
use App\Countries;
use App\CategoryTour;
use App\CategoryGuide;
use App\Tours;
use App\Faq;
use App\Overview;
use App\Options;
use App\PageMeta;
use App\CountryTours;
use DB;

class PagesController extends Controller
{
    public function index(){
        $page = Pages::find(1);   
        $objectMetas = new \stdClass();
        $objectMetas->title_country = Metas::find(63)->content;
        $objectMetas->desc_country = Metas::find(64)->content;
        $objectMetas->background_request = Metas::find(259)->content;
        $objectMetas->img_request = Metas::find(260)->content;
        $objectMetas->title_traveling= Metas::find(261)->content;
        $objectMetas->desc_traveling = Metas::find(262)->content;
        $objectMetas->iframe_video = Metas::find(263)->content;
        $objectMetas->title_journey = Metas::find(264)->content;
        $objectMetas->desc_journey = Metas::find(265)->content;
        $objectMetas->title_hand_craft = Metas::find(266)->content;
        $objectMetas->desc_hand_craft = Metas::find(267)->content;
        $objectMetas->background_request2 = Metas::find(268)->content;
        $objectMetas->title_explore = Metas::find(274)->content;
        $objectMetas->desc_explore = Metas::find(275)->content;
        $objectMetas->title_responsible = Metas::find(281)->content;
        $objectMetas->desc_responsible = Metas::find(282)->content;
        $objectMetas->title_preparing = Metas::find(289)->content;
        $objectMetas->desc_preparing = Metas::find(290)->content;
        $objectMetas->title_blog = Metas::find(293)->content;
        $objectMetas->desc_blog = Metas::find(294)->content;
        $tour_hand_craft = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                    ->join('countries', 'country_tours.country_id', '=', 'countries.id')
                                    ->where('countries.parent_id', 0)
                                    ->distinct()->select('tours.*')
                                    ->limit(6)->get();
        $articlesVip = Article::latest()->limit(8)->get();
        $articlesNew = Article::latest()->paginate(15);        
        $homeSlide = Countries::join('overviews', 'countries.id', '=', 'overviews.country_id')
                            ->where('countries.parent_id', 0)
                            ->select('countries.image', 'countries.title', 'countries.desc', 'countries.slug', 'overviews.icon_flag_gray', 'overviews.icon_flag')
                            ->orderBy('position', 'asc')
                            ->distinct()
                            ->get(); 

        $seo = get_seo($page->id,'page');  
        $destination = Countries::where('parent_id', 0)->orderBy('position', 'asc')
                                ->select('title', 'image', 'flag' , 'slug' , 'id')
                                ->limit(5)->get();
        $tours = Tours::orderBy('created_at', 'asc')->paginate(15);
        $list_blog = Article::where('status',1)->orderBy('created_at', 'desc')->paginate(6);
        $list_sustai = PageMeta::where('meta_key','sustainability')->first();
        $data = [
            'page' => $page,
            'seo'=>$seo, 
            'homeSlide'=>$homeSlide,
            'destination'=>$destination,
            'tours'=>$tours,
            'articlesNew'=>$articlesNew,
            'objectMetas'=>$objectMetas,
            'tour_hand_craft'=>$tour_hand_craft,
            'list_blog'=>$list_blog,
            'list_sustai'=>$list_sustai,
        ];
        return view('index',$data);
    }
    public function biigClub(){
        $page = Pages::findBySlugOrFail('sonasia-club');
        $seo = get_seo($page->id,'page');
        $gallery = Pages::where('id', 20)->first();
        $options = Options::first();
        return view("biigclub",['page'=>$page, 'seo'=>$seo, 'gallery'=>$gallery , 'options'=>$options]);
    }
    public function responsibleTravel(){
        $page = Pages::find(21);
        $seo = get_seo($page->id,'page');
        $list_sustai = PageMeta::where('meta_key','sustainability')->first();
        $list_mutual = PageMeta::where('meta_key','mutual')->first();
        $list_support = PageMeta::where('meta_key','support')->first();
        $data = [
            'page' => $page,
            'seo'=>$seo, 
            'list_sustai'=>$list_sustai,
            'list_mutual'=>$list_mutual,
            'list_support'=>$list_support,
        ];
        return view("responsible",$data);
    }
    public function bookingSteps(){
        $page = Pages::find(22);
        $seo = get_seo($page->id,'page');
        return view("booking_steps",['page'=>$page, 'seo'=>$seo]);
    }
    public function landingPage(){
        $page = Pages::find(23);
        $seo = get_seo($page->id,'page');
        return view("landing_page",['page'=>$page, 'seo'=>$seo]);
    }
    public function aboutPage(){
        $page = Pages::find(16);
        $seo = get_seo($page->id,'page');
        $list_sustai = PageMeta::where('meta_key','sustainability')->first();
        return view("about",['page'=>$page, 'seo'=>$seo, 'list_sustai'=>$list_sustai]);
    }
    public function bookingConditions(){
        $page = Pages::find(19);
        $seo = get_seo($page->id,'page');
        return view("booking_conditions",['page'=>$page, 'seo'=>$seo]);
    }
    public function termOfUse(){
        $page = Pages::find(17);
        $seo = get_seo($page->id,'page');
        $list_blog = Article::orderBy('created_at', 'asc')->paginate(3);
        return view("term_of_use",['page'=>$page, 'seo'=>$seo, 'list_blog'=> $list_blog]);
    }
    public function privacyPolicy(){
        $page = Pages::find(18);
        $seo = get_seo($page->id,'page');
        $list_blog = Article::orderBy('created_at', 'asc')->paginate(3);
        return view("privacy_policy",['page'=>$page, 'seo'=>$seo, 'list_blog'=> $list_blog]);
    }
    public function page($slug){
        $page = Pages::findBySlugOrFail($slug);
        $seo = get_seo($page->id,'page');
        if($page->id == 15) {
            return view("contact",['page'=>$page, 'seo'=>$seo]);
        }
        return view("contact",['page'=>$page, 'seo'=>$seo]);
    }

    public function createFaq(){
        return view('faq.index');
    }

    public function postType($slug){
        $post_type = getPostTypeLevelOne($slug);
        switch ($post_type) {
            case 'page':
                $page = Pages::findBySlug($slug);
                $seo = get_seo($page->id,'page');
                if($page->id!=15)
                   return view("page",['page'=>$page, 'seo'=>$seo]);
                else
                   
                    return view("contact",['page'=>$page, 'seo'=>$seo]);
                break;
            case 'consultant':
                $data = dataSendDetailConsultant($slug);
                return view('consultants.detail', $data);
                break;
            case 'blogger':
                $data = dataSendBlogger($slug);
                return view('bloggers.detail', $data);
            default:
                abort(404);
                break;
        }
    }
    public function searchNation(Request $request){
        $s = $request->keyword;
        $html = '';
        if($s == '')
        {
            $html = view('form.list_nation')->render();
            return response()->json(['html' => $html, 'count' => 1]);
        }
        else{
            $nations = CategoryGuide::select('title', 'slug', 'feature_image' , 'id')
                        ->where('post_type', 'market')
                        ->where('title','like','%'.$s.'%')
                        ->orderBy('position','asc')->get();
            if($nations->count() > 0) {
                $html = view('form.search_nation', ['nations' => $nations])->render();
            } 
            return response()->json(['html' => $html, 'count' => $nations->count()]);
        }
    }
    public function searchCodeTour(Request $request){
        $s = $request->keyword;
        $tour = Tours::where('code','like','%'.$s.'%')->first();
        //dd($tour);
        if($tour){
            $country = Countries::join('country_tours','country_tours.country_id','=','countries.id')
                                ->where('country_tours.tour_id',$tour->id)
                                ->where('countries.parent_id',0)
                                ->select('countries.slug')->get();
            $title = '';                    
            $link = '';                    
            if(count($country) == 1)
            {
                $title .= $country[0]->slug;
            }else{
                $title .= 'asia';
            }
            $link = '/'.$title.'-tour-packages/'.$tour->slug;
            return response()->json(['msg' => 'success', 'link' => $link]);
        }else{
            $html = '';
            $html .='<div class="text-center">';
                $html .='<h3 class="oops"> Oops! </h3>';
                $html .='<div class="desc">'; 
                    $html .='<p>It seems that the package code you entered is incorrect.</p>';
                    $html .='<p>Please try again or contact us at <a href="mailto:info@sonasia-holiday.com" class="pink"> info@sonasia-holiday.com</a></p>';
                $html .='</div>';
            $html .='</div>';
            return response()->json(['msg' => 'error', 'html' => $html]);
        }
        
    }


}
