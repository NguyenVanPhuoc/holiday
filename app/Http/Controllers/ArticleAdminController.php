<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Media;
use App\ArticleCat;
use App\Article;
use App\CountryArticleCat;
use App\Seo;
use App\TableContentDetails;
use App\TableContents;
use App\CountryArticle;
use App\Countries;
use App\Bloggers;
use Validator;


class ArticleAdminController extends Controller
{
	public function index(){    	
    	$articles = Article::orderBy('created_at', 'desc')->paginate(14);
    	return view('backend.articles.list',['articles'=>$articles]);
    }    
    public function store(){  
        $list_blogger = Bloggers::orderBy('title', 'desc')->get(); 
        $list_blog = Article::orderBy('created_at', 'desc')->where('articles.status', 1 )->get();  
        $data = [
            'list_blogger' => $list_blogger,
            'list_blog' => $list_blog,
        ];  
        return view('backend.articles.create', $data);
    }
    public function edit($id){
        $article = Article::find($id);
        $list_countryid = Article::join('country_articles', 'articles.id', '=', 'country_articles.article_id')
                                ->where('country_articles.article_id', $id)
                                ->distinct()->pluck('country_articles.country_id')
                                ->toArray();
        $seo = get_seo($article->id,'article');
        $list_blogger = Bloggers::orderBy('title', 'desc')->get();
        $list_blog = Article::orderBy('created_at', 'desc')->where('articles.status', 1 )->get();
        $data = [
            'article'=>$article, 
            'seo'=>$seo, 
            'list_countryid' => $list_countryid,
            'list_blogger' => $list_blogger,
            'list_blog' => $list_blog
        ];
    	return view('backend.articles.edit', $data);
    }
    public function create(Request $request){
        $message = "error";
        if($request->ajax()):
            $array_idcountries = $request->countries;
            $categories = json_decode($request->categories);
            $tableContent = json_decode($request->tableContent);
            $article = new Article;
            $article->title = $request->title;
            $article->slug = $request->title;
            $article->title_tag = $request->title_tag;
            $article->content = $request->content;
            $article->desc = $request->shortContent;
            $article->image = $request->image;
            $article->image_request1 = $request->image_request1;
            $article->image_looking = $request->image_looking;
            $article->image_request2 = $request->image_request2;
            $article->status = $request->status;
            $article->cat_id = $request->catId;
            $article->blogger_id = $request->blogger_id;
            if($request->list_blog && (count($request->list_blog) > 0))
                $article->list_blog = implode(",", $request->list_blog);
            /*if(isset($request->countries) && $request->countries != '')
                $article->country_id = implode(",",$request->countries);*/
            if(Auth::check()) $article->user_id = Auth::id();
            if($article->save()){
                //country_articles
                if($array_idcountries != '' && $array_idcountries != NULL){
                    foreach($array_idcountries as $value){
                        $country_article = new CountryArticle;
                        $country_article->article_id = $article->id;
                        $country_article->country_id = $value;
                        $country_article->save();
                    }
                }

                //seo
                $seo = new Seo;
                $seo->key = $request->metaKey;
                $seo->value = $request->metaValue;
                $seo->type = "article";
                $seo->post_id = $article->id;
                if($seo->save()){                   
                    $message = "success";
                }
                //table content
                if($tableContent){
                    //create a new table
                    $tablePost = new TableContents;
                    $tablePost->post_type = "article";
                    $tablePost->post_id = $article->id;
                    if($tablePost->save()){ //create list new detail
                        foreach($tableContent as $level1){ //level 1
                            $contentLevel1 = new TableContentDetails;
                            $contentLevel1->title = $level1->title;
                            $contentLevel1->content = $level1->content;
                            $contentLevel1->parent_id = 0;
                            $contentLevel1->level = 1;
                            $contentLevel1->table_id = $tablePost->id;
                            $contentLevel1->sequence = $level1->position;
                            if($contentLevel1->save() && isset($level1->child)){ //level 2
                                $childLevel2 = $level1->child;
                                foreach($childLevel2 as $level2){
                                    $contentLevel2 = new TableContentDetails;
                                    $contentLevel2->title = $level2->title;
                                    $contentLevel2->content = $level2->content;
                                    $contentLevel2->parent_id = $contentLevel1->id;
                                    $contentLevel2->level = 2;
                                    $contentLevel2->table_id = $tablePost->id;
                                    $contentLevel2->sequence = $level2->position;
                                    if($contentLevel2->save() && isset($level2->child)){ //level 3
                                        $childLevel3 = $level2->child;
                                        foreach($childLevel3 as $level3){
                                            $contentLevel3 = new TableContentDetails;
                                            $contentLevel3->title = $level3->title;
                                            $contentLevel3->content = $level3->content;
                                            $contentLevel3->parent_id = $contentLevel2->id;
                                            $contentLevel3->level = 3;
                                            $contentLevel3->table_id = $tablePost->id;
                                            $contentLevel3->sequence = $level3->position;
                                            $contentLevel3->save();
                                        }
                                    }
                                }
                            }
                        } 
                        $message = "success"; 
                    } 
                }
            }            
        endif;
        return $message;
    }

    public function update(Request $request, $id){    	
    	$message = "error";
        if($request->ajax()):
            $categories = json_decode($request->categories);
            $tableContent = json_decode($request->tableContent);
            $array_idcountries = $request->countries;
            $article = Article::find($id);
            $article->title = $request->title;
            $article->slug = $request->slug;
            $article->title_tag = $request->title_tag;
            $article->content = $request->content;
            $article->desc = $request->shortContent;
            $article->image = $request->image;
            $article->image_request1 = $request->image_request1;
            $article->image_looking = $request->image_looking;
            $article->image_request2 = $request->image_request2;
            $article->status = $request->status;
            $article->cat_id = $request->catId;
            $article->blogger_id = $request->blogger_id;
            if($request->list_blog && (count($request->list_blog) > 0))
                $article->list_blog = implode(",", $request->list_blog);
            /*if(isset($request->countries) && $request->countries != '')
                $article->country_id = implode(",",$request->countries);*/
            if($article->save()){
                $article->touch(); //update updated_at
                if($array_idcountries != '' && $array_idcountries != NULL){
                    foreach($array_idcountries as $value){
                        $country_article = CountryArticle::where('article_id', $article->id)->where('country_id', $value)->first();
                        //if no exist add new row
                        if(! $country_article){
                            $country_article = new CountryArticle;
                            $country_article->article_id = $article->id;
                            $country_article->country_id = $value;
                            $country_article->save();
                        }
                    }
                    //remove if no exist in list country chose
                    $country_articles = CountryArticle::where('article_id', $article->id)->get();
                    foreach ($country_articles as $item) {
                        if(! in_array($item->country_id, $array_idcountries))
                            $item->delete();
                    }
                }

                $seo = Seo::where('post_id',$id)->where('type','article')->first();
                if(!$seo){
                    $seo = new Seo;
                }
                $seo->key = $request->metaKey;
                $seo->value = $request->metaValue;                
                $seo->type = 'article';
                $seo->post_id = $article->id;
                if($seo->save()){                   
                    $message = "success";
                }

                //table content
                if($tableContent){
                    //create a new table
                    $tablePost = getTableContent($article->id, 'article');
                    if(!$tablePost) {
                        $tablePost = new TableContents;
                        $tablePost->post_type = "article";
                        $tablePost->post_id = $article->id;
                    }
                    if($tablePost->save()){ //create list new detail
                        foreach($tableContent as $level1){ //level 1
                            $contentLevel1 = new TableContentDetails;
                            if($level1->action == 'edit')
                                $contentLevel1 = TableContentDetails::find($level1->id);
                            $contentLevel1->title = $level1->title;
                            $contentLevel1->content = $level1->content;
                            $contentLevel1->parent_id = 0;
                            $contentLevel1->level = 1;
                            $contentLevel1->table_id = $tablePost->id;
                            $contentLevel1->sequence = $level1->position;
                            if($contentLevel1->save() && isset($level1->child)){ //level 2
                                $childLevel2 = $level1->child;
                                foreach($childLevel2 as $level2){
                                    $contentLevel2 = new TableContentDetails;
                                    if($level2->action == 'edit')
                                        $contentLevel2 = TableContentDetails::find($level2->id);
                                    $contentLevel2->title = $level2->title;
                                    $contentLevel2->content = $level2->content;
                                    $contentLevel2->parent_id = $contentLevel1->id;
                                    $contentLevel2->level = 2;
                                    $contentLevel2->table_id = $tablePost->id;
                                    $contentLevel2->sequence = $level2->position;
                                    if($contentLevel2->save() && isset($level2->child)){ //level 3
                                        $childLevel3 = $level2->child;
                                        foreach($childLevel3 as $level3){
                                            $contentLevel3 = new TableContentDetails;
                                            if($level3->action == 'edit')
                                                $contentLevel3 = TableContentDetails::find($level3->id);
                                            $contentLevel3->title = $level3->title;
                                            $contentLevel3->content = $level3->content;
                                            $contentLevel3->parent_id = $contentLevel2->id;
                                            $contentLevel3->level = 3;
                                            $contentLevel3->table_id = $tablePost->id;
                                            $contentLevel3->sequence = $level3->position;
                                            $contentLevel3->save();
                                        }
                                    }
                                }
                            }
                        } 
                        $message = "success"; 
                    } 
                }
            }            
        endif;
        return $message;     
    }
	
	/*public function search(Request $request){
        $category = $request->category;
        $s = $request->s;
        if($category!="" && $s!=""):
            $articles = Article::where('title','like','%'.$s.'%')->whereRaw("find_in_set($category,cat_id)")->latest()->paginate(14);
        elseif($category=="" && $s!=""):
            $articles = Article::where('title','like','%'.$s.'%')->latest()->paginate(14);
        else:
            $articles = Article::whereRaw("find_in_set($category,cat_id)")->latest()->paginate(14);    
        endif;
        return view('backend.articles.list',['articles'=>$articles, 's'=>$s, 'category'=>$category]);
    }*/
    public function search(Request $request){
        $s = $request->s;
        $category = $request->category;
        $country = $request->country;
        $articles = Article::query();
        if($s != ''){
            $articles = $articles->where('title','like','%'.$s.'%');
        }
        if($category != ''){
            $articles = $articles->where('cat_id', $category);
        }
        if($country != ''){
            $articles = $articles->join('country_articles', 'articles.id', '=', 'country_articles.article_id')->where('country_articles.country_id', $country);
        }
        $articles = $articles->select('articles.*')->orderBy('created_at', 'desc')->paginate(14);
        return view('backend.articles.list',['articles'=>$articles, 's'=>$s, 'category'=>$category, 'country'=>$country]);
    }

    public function delete($id){
        $seo = Seo::where('post_id',$id)->where('type','article');
        $tableContent = TableContents::where('post_id',$id)->where('post_type','article');
        if($seo) $seo->delete();
        if($tableContent) $tableContent->delete();
    	$article = article::find($id);
    	$article->delete();
    	return redirect('/admin/blog/')->with('success','Xóa thành công');
    }
    //deleteAll
    public function deleteAll(Request $resquest){
        $message = "error";
        if($resquest->ajax()){
            $items = json_decode($resquest->items);
            if(count($items)>0){
                foreach($items as $id){
                    $seo = Seo::where('post_id',$id)->where('type','article');
                    $tableContent = TableContents::where('post_id',$id)->where('post_type','article');
                    if($seo) $seo->delete();
                    if($tableContent) $tableContent->delete();
                }
                Article::destroy($items);
            }
            $message = "success";
        }
        return $message;
    }

    //delete row content
    public function deleteRowContent(Request $request){
        $msg = 'error';
        if($request->ajax()){
            $rowItem = TableContentDetails::find($request->id);
            if($rowItem){
                deleteListChildContent($request->id);
                $rowItem->delete();
                $msg = "success";
            }
            
        }
        return $msg;
    }


    //search from list
    public function searchFromList(Request $request){
        if($request->ajax()){
            $html = '';
            $tours = Article::where('title', 'LIKE', '%'.$request->keyword.'%')->where('type', 'article')->orderBy('title', 'asc')->get();
            if($tours){
                foreach($tours as $item){
                    $html .= '<li class="item-'. $item->id .'" data-id="'. $item->id .'" title="'. $item->title .'">';
                        $html .= $item->title;
                    $html .= '</li>';
                }
            }
            return response()->json(['msg'=>'success', 'html'=>$html]);
        }
        return response()->json(['msg'=>'error']);
    }

    public function countryCat(Request $request){
        $list_country = getAllMainCountry();
        $list_cat = ArticleCat::orderBy('position', 'asc')->get();
        $data = [
            'list_country' => $list_country,
            'list_cat' => $list_cat,
        ];

        if(!empty($request->country_id) && !empty($request->cat_id)){ 
            $country = Countries::where('id', $request->country_id)->where('parent_id', 0)->first();
            $cat = ArticleCat::find($request->cat_id);

            //validate
            $list_rules = [];
            $validator = Validator::make($request->all(), $list_rules);

            if(!$country)
                $validator->errors()->add('country', 'The country invalid');
            if(!$cat)
                $validator->errors()->add('category', 'The category invalid');

            $errors = $validator->errors()->all();    

            $countryCat = CountryArticleCat::where('country_id', $request->country_id)   
                                            ->where('cat_id', $request->cat_id)->first();
            if($countryCat){
                $seo = Seo::where('type', 'country_article_cat')->where('post_id', $countryCat->id)->first();
                $data['countryCat'] = $countryCat;
                $data['seo'] = $seo;
            }

            $data['errors'] = $errors;
            $data['country'] = $country;
            $data['cat'] = $cat;
        }
        //dd($data);
        return view('backend.articles.country_cat', $data);
    }

    public function saveCountryCat(Request $request){
        $countryCat = CountryArticleCat::where('country_id', $request->country_id)
                                        ->where('cat_id', $request->cat_id)->first();

        //if exist -> update   
        if($countryCat){
            $countryCat->update($request->only('title_tag', 'desc', 'image', 'image_looking', 'image_request'));
            updateSeo($countryCat->id, 'country_article_cat', $request->meta_key, $request->meta_value);
        }
        else{ // add new
            $countryCat = CountryArticleCat::create($request->only('title_tag', 'desc', 'image', 'image_looking', 'image_request', 'country_id', 'cat_id'));
            createSeo($countryCat->id, 'country_article_cat', $request->meta_key, $request->meta_value);
        }

        return redirect()->route('countryCatBlogAdmin', ['country_id' => $request->country_id, 'cat_id' => $request->cat_id])->with('success', 'Updated successfull');
    }

    
}