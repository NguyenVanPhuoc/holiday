<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Media;
use App\Bloggers;
use App\Article;
use App\Highlight;
use Validator;

class BloggerAdminController extends Controller
{
	public function index(Request $request){
		$per_page = 14;
        $page = (isset($request->page) && $request->page != '') ? $request->page : 1;
        $list_blogger = filterBlogger($request, $per_page, $page);

        if($request->ajax()){
            $html = view('backend.bloggers.table', ['list_blogger' => $list_blogger])->render();
            return response()->json(['html' => 'success', 'html' => $html]);
        }

		return view('backend.bloggers.list', ['list_blogger'=>$list_blogger]);
	}

	public function store(){
        $list_highlight = Highlight::get();
        $list_article = Article::orderBy('title', 'asc')->get();
        $data = [
            'list_highlight' => $list_highlight,
            'list_article' => $list_article,
        ];
		return view('backend.bloggers.create', $data);
	}

	public function create(Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, Bloggers::getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        $request['favourite_article'] = ($request->article != '') ? implode(",", $request->article) : NULL;
        $request['favourite_highlight'] = ($request->highlight != '') ? implode(",", $request->highlight) : NULL;
        /*insert to DB*/
        $blogger = Bloggers::create($request->only('title', 'title_tag', 'short_desc', 'desc', 'social_icon' , 'icon_facebook', 'icon_twitter', 'facebook', 'twitter', 'favourite_article', 'favourite_books', 'favourite_highlight', 'image', 'banner'));
        updateSlug('bloggers', $request->title, $blogger->id);
        //seos
        createSeo($blogger->id, 'blogger', $request->meta_key, $request->meta_value);

        return response()->json(['success' => 'Add to success.', 'url' => route('storeBloggerAdmin')]);

	}

	public function edit($id){
		$blogger = Bloggers::findOrFail($id);
        $seo = get_seo($blogger->id, 'blogger');
        $list_highlight = Highlight::get();
        $list_article = Article::orderBy('title', 'asc')->get();
        $data = [
            'blogger' => $blogger,
            'seo' => $seo,
            'list_highlight' => $list_highlight,
            'list_article' => $list_article,
        ];
		return view('backend.bloggers.edit', $data);
	}

	public function update($id, Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, Bloggers::getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        $request['favourite_article'] = ($request->article != '') ? implode(",", $request->article) : NULL;
        $request['favourite_highlight'] = ($request->highlight != '') ? implode(",", $request->highlight) : NULL;
        /*insert to DB*/
        Bloggers::where('id', $id)->update($request->only('title', 'title_tag', 'short_desc', 'desc', 'social_icon' , 'icon_facebook', 'icon_twitter', 'facebook', 'twitter', 'favourite_article', 'favourite_books', 'favourite_highlight', 'image', 'banner'));
        updateSlug('bloggers', $request->slug, $id);
        //seos
        updateSeo($id, 'blogger', $request->meta_key, $request->meta_value);

        return response()->json(['success' => 'Update to success.', 'url' => route('updateBloggerAdmin', $id)]);
	}

    public function delete($id){
        deleteSeo($id, 'blogger');
        Bloggers::where('id', $id)->delete();
        return redirect()->route('bloggersAdmin')->with('success', 'Delete successfull.');
    }

     public function deleteAll(Request $request){
        $msg = "error";
        if($request->ajax()){
            $items = json_decode($request->items);
            if(count($items)>0){
                Seo::where('type', 'blogger')->whereIn('id', $items)->delete();
                Bloggers::destroy($items);
            }
            $msg = "success";
        }
        return $msg;
    }
}