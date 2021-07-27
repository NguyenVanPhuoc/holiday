<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\ArticleCat;
use App\Article;
use App\SlideDetail;
use App\Countries;
use App\CountryArticleCat;
use App\CountryArticle;
use App\Pages;
use App\CountryBlog;
use App\Overview;
class ArticleFrontController extends Controller
{
    public function index(){
        $page = Pages::find(24);
        if($page) $seo = get_seo($page->id,'page');
            else $seo = false;
        $list_blog = Article::orderBy('created_at', 'desc')->where('articles.status', 1 )->offset(0)->limit(10)->get();
        $total = Article::orderBy('created_at', 'desc')->count();
        $countries = Countries::all();
        $blogSlide = Article::orderBy('created_at', 'desc')->limit(5)->get();
        $data = [];        
        $data['page'] = $page;
        $data['seo'] = $seo;
        $data['list_blog'] = $list_blog;
        $data['countries'] = $countries;
        $data['blogSlide'] = $blogSlide;
        $data['total'] = intval(ceil($total/6));
        return view('articles.list', $data);
    }  
    public function blogCall($slug, Request $request){
        $cat = ArticleCat::findBySlug($slug);
        $blog = Article::findBySlug($slug);
        $country = Countries::findBySlug($slug);
            //dd($country);
        if (!empty($country)) {
            return $this->blogCountries($country);
        } 
        if (!empty($cat)) {
            return $this->blogCat($cat);
        } 
        else if(!empty($blog)){
            return $this->blogDetail($blog);
        }
        else{
            abort('404');
        }
    }
    public function blogDetail($blog){
        $countCountry = getAllCountriesId($blog->id);
        if($countCountry==1){
            $country_id = CountryArticle::where('article_id', $blog->id)
                                    ->select('country_id as id')                                    
                                    ->first();
            $country = getCountry(dsGetParent1stCountry($country_id->id));
            $topBlog= Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
                                ->where('country_articles.country_id', $country->id)
                                ->where('country_articles.article_id','!=', $blog->id)
                                ->where('articles.cat_id', $blog->cat_id)
                                ->where('articles.status', 1 )
                                ->select('articles.*')->orderBy('view', 'desc')->limit(6)->get();
            $list_blog =  Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id') 
                                ->join('article_cats', 'articles.cat_id', '=', 'article_cats.id') 
                                ->where('country_articles.country_id', $country->id)
                                ->where('country_articles.article_id','!=', $blog->id)
                                ->where('articles.cat_id', $blog->cat_id)
                                ->where('articles.status', 1 )
                                ->select('articles.*')->orderBy('created_at', 'desc')->limit(6)->get();
            $count = count($list_blog);
            $article_id = array();
            foreach ($list_blog as $value) {
                $article_id[] = $value->id;
            }
            if($count <= 6){
                 $list_blog_v1 =  Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id') 
                                ->join('article_cats', 'articles.cat_id', '=', 'article_cats.id') 
                                ->where('country_articles.article_id','!=', $blog->id)
                                ->whereNotIn('country_articles.article_id', $article_id)
                                ->where('articles.cat_id', $blog->cat_id)
                                ->where('articles.status', 1 )
                                ->select('articles.*')->orderBy('created_at', 'desc')->limit(6 - $count)->get();
            }
            $list_country = CountryBlog::where('type','country_blog')->where('country_id',$country->id)->first();
            $list_main_city = Overview::select('list_main_city')->where('country_id', $country->id)->first();
            $relatedBlog = Article::select('list_blog')->where('id', $blog->id)->first();
            //dd($list_blog);
        }else{
            $array_country = CountryArticle::where('article_id', $blog->id)
                                    ->select('country_id as id')                                    
                                    ->get();
            $zzz = array();
            foreach ($array_country as $value) {
                    $zzz[] = $value->id;
            }
            $country = getCountry($zzz[0]);
            $topBlog= Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
                                ->whereIn('country_articles.country_id', $zzz)
                                ->where('country_articles.article_id','!=', $blog->id)
                                ->where('articles.cat_id', $blog->cat_id)
                                ->where('articles.status', 1 )
                                ->select('articles.*')->orderBy('view', 'desc')->distinct()->limit(6)->get();
            $list_blog =  Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id') 
                                ->join('article_cats', 'articles.cat_id', '=', 'article_cats.id') 
                                ->whereIn('country_articles.country_id', $zzz)
                                ->where('country_articles.article_id','!=', $blog->id)
                                ->where('articles.cat_id', $blog->cat_id)
                                ->where('articles.status', 1 )
                                ->select('articles.*')->orderBy('created_at', 'desc')->distinct()->limit(6)->get();
            $list_blog_v1 = false;
            $list_country = false;
            $list_main_city = false;
            $relatedBlog = Article::select('list_blog')->where('id', $blog->id)->first();
        }                           
        $seo = get_seo($blog->id,'article');
        $otherArticles = Article::where('id','<>',$blog->id)
                ->where('cat_id',$blog->cat_id)
                ->orderBy('created_at','desc')->paginate(5);
        $cate_ids = ($blog->cat_id != '') ? ($blog->cat_id) : FALSE;
        $cates = ArticleCat::select('title')->where('id', $cate_ids)->first();             
        $data = [
            'country' => $country,
            'blog'=>$blog, 
            'seo'=>$seo, 
            'otherArticles'=>$otherArticles,
            'list_blog'=>$list_blog,
            'list_blog_v1'=>$list_blog_v1,
            'list_country'=>$list_country,
            'list_main_city'=>$list_main_city,
            'countCountry'=>$countCountry,
            'topBlog'=>$topBlog,
            'relatedBlog'=>$relatedBlog,
            'cates'=>$cates
        ];
        return view('articles.detail', $data);
    }
    public function blogCountryCate($country_slug, $cate_slug, Request $request){
        $cat = ArticleCat::findBySlugOrFail($cate_slug);
        $country = Countries::findBySlugOrFail($country_slug);
        if($cat && $country) $country_cat = CountryArticleCat::where([['country_id', $country->id],['cat_id', $cat->id]])->first();
        $list_blog = Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
                                ->where('country_articles.country_id', $country->id)
                                ->where('articles.cat_id', $cat->id)
                                ->where('articles.status', 1 )
                                ->select('articles.*')->orderBy('articles.created_at', 'desc')
                                ->distinct()->limit(6)->get();
        $articleMostView = Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
                                ->where('country_articles.country_id', $country->id)
                                ->where('articles.cat_id', $cat->id)
                                ->where('articles.status', 1 )
                                ->select('articles.*')->orderBy('articles.view', 'desc')
                                ->distinct()->limit(6)->get();
        $total = Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
                                ->where('country_articles.country_id', $country->id)
                                ->where('articles.cat_id', $cat->id)->where('articles.status', 1 )->count();
        $list_country = CountryBlog::where('type','country_blog')->where('country_id',$country->id)->first();
        $seo = get_seo($country_cat->id,'country_article_cat');
        $data = [
            'cat'=>$cat, 
            'country'=>$country, 
            'country_cat'=>$country_cat, 
            'list_blog'=>$list_blog, 
            'list_country'=>$list_country, 
            'articleMostView'=>$articleMostView, 
            'total'=>intval(ceil($total/6)), 
            'seo'=>$seo
        ];
        return view('articles.list_by_cat_country', $data);
    }
    public function blogCat($item){
        $cat = $item;
        $list_blog = Article::where('cat_id',$cat->id)
                        ->where('status', 1 )
                        ->select('articles.*')->orderBy('articles.created_at', 'desc')
                        ->distinct()->limit(6)->get();
        $total = Article::where('cat_id', $cat->id)->where('status', 1 )->count();
        $articleMostView = Article::where('cat_id', $cat->id)
                                ->where('status', 1 )
                                ->select('articles.*')->orderBy('view', 'desc')
                                ->distinct()->limit(6)->get();
        $seo = get_seo($cat->id,'category');
        $data = [
            'list_blog'=>$list_blog, 
            'cat'=>$cat, 
            'total'=>intval(ceil($total/6)),
            'articleMostView'=>$articleMostView,
            'seo'=>$seo
        ];
        return view('articles.list_by_cat', $data);
    }
    public function blogCountries($item){
        $country = $item;
        $list_country = CountryBlog::where('type','country_blog')->where('country_id',$country->id)->first();
        if ($list_country) {
            $seo = get_seo($list_country->id,'country_blog');
        }else{
            $seo = "";
        }
        $total = Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
                                ->where('country_articles.country_id', $country->id)->count();
        $countries = Countries::all();
        $list_blog = Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
                                ->where('country_articles.country_id', $country->id)
                                ->where('articles.status', 1 )
                                ->select('articles.id as id', 'articles.title as title', 'articles.slug as slug', 'articles.image as image' , 'articles.created_at as created_at' , 'articles.content as content' , 'articles.cat_id as cat_id', 'country_articles.country_id as country_id')
                                ->distinct()->latest()->paginate(6);
        $categories = ArticleCat::all();
        $data = [
            'country' => $country,
            'list_country'=> $list_country,
            'seo'=>$seo,
            'countries' => $countries,
            'list_blog' => $list_blog,
            'categories' => $categories,
            'total'     => intval(ceil($total/6)),
        ];
        return view('articles.list_by_country', $data);
    }
    public function blogCountry($slug_country){
        $country = Countries::findBySlug($slug_country);
        $total = Article::orderBy('created_at', 'desc')->count();
        $countries = Countries::all();
        $list_blog = Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
                                ->where('country_articles.country_id', $country->id)
                                ->where('articles.status', 1 )
                                ->select('articles.id as id', 'articles.title as title', 'articles.slug as slug', 'articles.image as image' , 'articles.created_at as created_at' , 'articles.content as content' , 'articles.cat_id as cat_id', 'country_articles.country_id as country_id')
                                ->distinct()->orderBy('created_at', 'desc')->paginate(6);
        $categories = ArticleCat::all();
        $data = [
            'country' => $country,
            'countries' => $countries,
            'list_blog' => $list_blog,
            'categories' => $categories,
            'total'     => intval(ceil($total/6)),
        ];
        return view('articles.list_by_country', $data);
    }
    public function search(Request $request){    
        $list_blog = Article::where('title','like','%'.$request->s.'%')->paginate(2);    
        $countResult = Article::where('title','like','%'.$request->s.'%')->count(); 
        $data = [
            'list_blog'=>$list_blog, 
            'countResult'=>$countResult, 
            's'=>$request->s,
        ];
        return view('articles.search', $data);
    }
    public function loadMoreBlog(Request $request) {
        $number = 6;
        $current = $request->current;
        $total = $request->total;
        //dd($total);
        $list_blog = Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
                                ->orderBy('created_at', 'desc')->where('status', 1 )
                                ->select('articles.id as id', 'articles.title as title', 'articles.slug as slug', 'articles.image as image' , 'articles.created_at as created_at' , 'articles.content as content' , 'articles.cat_id as cat_id', 'country_articles.country_id as country_id')
                                ->distinct()->offset(($current-1)*$number + 4)->limit($number)->get();
        $html = '';
        $check = 0;
        if($list_blog) {
            foreach ($list_blog as $item) {
                $html .= view('articles.item_v2', ['item' => $item])->render();
            }
            $check = 1;
        }
        $data = [
            'html' => $html,
            'check' => $check,
        ];
        return response()->json($data);
    }
    public function loadMoreBlogCountry(Request $request, $slug) {
        $number = 6;
        $country = Countries::findBySlug($slug);
        $current = $request->current;
        $total = $request->total;
        $list_blog = Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
                                ->where('country_articles.country_id', $country->id)->where('articles.status', 1 )
                                ->select('articles.id as id', 'articles.title as title', 'articles.slug as slug', 'articles.image as image' , 'articles.created_at as created_at' , 'articles.content as content' , 'articles.cat_id as cat_id', 'country_articles.country_id as country_id')
                                ->distinct()->offset(($current-1)*$number)->limit($number)->orderBy('articles.created_at', 'desc')->get();
        $html = '';
        $check = 0;
        if($list_blog) {
            foreach ($list_blog as $item) {
                $html .= view('articles.item_v2', ['item' => $item])->render();
            }
            $check = 1;
        }
        $data = [
            'html' => $html,
            'check' => $check,
        ];
        return response()->json($data);
    }
    public function loadMoreBlogCountryCat(Request $request, $country_slug ,$cate_slug ) {
        $number = 6;
        $cat = ArticleCat::findBySlugOrFail($cate_slug);
        $country = Countries::findBySlugOrFail($country_slug);
        $current = $request->current;
        $list_blog = Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
                                ->where('country_articles.country_id', $country->id)
                                ->where('articles.cat_id', $cat->id)
                                ->where('articles.status', 1 )
                                ->select('articles.*')
                                ->orderBy('articles.created_at', 'desc')
                                ->distinct()->offset(($current-1)*$number)->limit($number)->get();
        $html = '';
        $check = 0;
        if($list_blog) {
            foreach ($list_blog as $item) {
                $html .= view('articles.item_v1', ['item' => $item])->render();
            }
            $check = 1;
        }
        $data = [
            'html' => $html,
            'check' => $check,
        ];
        return response()->json($data);
    }
    public function loadMoreCat(Request $request, $slug_cat ) {
        $number = 6;
        $cat = ArticleCat::findBySlugOrFail($slug_cat);
        $current = $request->current;
        $list_blog = Article::where('cat_id', $cat->id)
                            ->where('status', 1 )
                            ->select('articles.id as id', 'articles.title as title', 'articles.slug as slug', 'articles.image as image' , 'articles.created_at as created_at' , 'articles.content as content' , 'articles.cat_id as cat_id')
                            ->orderBy('created_at', 'desc')
                            ->distinct()->offset(($current-1)*$number)->limit($number)->get();
        $html = '';
        $check = 0;
        //dd(count($list_blog));
        if($list_blog) {
            foreach ($list_blog as $item) {
                $html .= view('articles.item_v1', ['item' => $item])->render();
            }
            $check = 1;
        }
        $data = [
            'html' => $html,
            'check' => $check,
        ];
        return response()->json($data);
    }
    public function blogSearch(Request $request){
        if($request->ajax()){
            $array_s=explode(' ', $request->keyword);
            $list_blog = Article::where(function ($query) use ($array_s) {
                                foreach ($array_s as $key => $value){
                                    $query->where('title', "like", "%" . $value . "%");
                                }
                            })
                            ->where('status', 1 )->select('articles.*')
                            ->orderBy('created_at', 'desc')->get();
            $html = '';
            if($list_blog && count($list_blog) > 0){
                foreach($list_blog as $item){
                    $html .= '<li><a href="'.route('blogCall', ['slug' => $item->slug]).'" class="link_city">'. $item->title .'</a></li>';
                }
            }
            else{
                $html .= '<li class="no-result">Please find another keyword!</li>';
            }
            return response()->json(['msg' => 'success', 'html' => $html]);
        }
        return response()->json(['msg' => 'error']);   
    }
}