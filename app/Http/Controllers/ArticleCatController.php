<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Media;
use App\ArticleCat;
use App\Seo;
use App\Tag;
use Validator;

class ArticleCatController extends Controller
{
	public function index(){    	
    	$categories = ArticleCat::orderBy('position', 'asc')->paginate(15);    	
    	return view('backend.articles.list_cat',['categories'=>$categories]);
    }
    
    public function store(){    	
    	return view('backend.articles.create_cat');
    }

    public function create(Request $request){
        $list_rules = [];
        $list_rules['title'] = 'required';
        $validator = Validator::make($request->all(), $list_rules, getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $position = ArticleCat::count() + 1;
        $request['position'] = $position;
        $cat = ArticleCat::create($request->only('title', 'title_tag', 'content', 'image', 'image_looking', 'image_request', 'position'));
        updateSlug('article_cats', $request->title, $cat->id);
        createSeo($cat->id, 'category', $request->meta_key, $request->meta_value);
        return response()->json(['success' => 'Add to success.', 'url' => route('storeCategoryAdmin')]);
    }
    
    public function edit($id){
        $category = ArticleCat::find($id);
        $seo = Seo::where('type','category')->where('post_id',$category->id)->first();
    	return view('backend.articles.edit_cat',['category'=>$category, 'seo'=>$seo]);
    }

    public function update(Request $request, $id){    	
    	$list_rules['title'] = 'required';
        $validator = Validator::make($request->all(), $list_rules, getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        ArticleCat::where('id', $id)->update($request->only('title', 'title_tag', 'content', 'image', 'image_looking', 'image_request'));
        updateSlug('article_cats', $request->title, $id);
        updateSeo($id, 'category', $request->meta_key, $request->meta_value);
        return response()->json(['success' => 'Update to success.', 'url' => route('updateCategoryAdmin', $id)]);
    }
	public function position(Request $request){
		$message = "error";
		if($request->ajax()):						
			$routes = json_decode($request->routes);
			foreach ($routes as $item):
				$category = ArticleCat::find($item->id);
				$category->position = $item->position;						
				$category->save();
			endforeach;
			$message = "success";
		endif;
		return $message;
	}
	public function delete($id){
		$seo = Seo::where('post_id',$id)->where('type','category')->delete();
        $category = ArticleCat::find($id);
        $category->delete();
        //update position
        return redirect()->route('categoriesAdmin')->with('success','Deleted successfull');
    }
}
