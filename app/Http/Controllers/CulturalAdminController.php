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
use App\CategoryGuide;
use App\Countries;
use Validator;

class CulturalAdminController extends Controller
{
	public function index(Request $request){    	
    	if($request->ajax()){
            $list_guide = PostGuide::join('countries', 'post_guides.country_id', '=', 'countries.id')
                                    ->join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                                    ->where('post_guides.post_type', 'cultural');
            if(isset($request->country_id) && $request->country_id != '')
                $list_guide = $list_guide->where('post_guides.country_id', $request->country_id);
            if(isset($request->s) && $request->s != '')
                $list_guide = $list_guide->where('post_guides.title', 'like', '%'. $request->s .'%');
            $list_guide = $list_guide->orderBy('post_guides.created_at', 'desc')
                                    ->distinct()
                                    ->select('post_guides.*', 'countries.title as country_title', 'category_guides.title as category_title')
                                    ->paginate(14);

            $html = view('backend.culturalGuides.table', ['list_guide' => $list_guide])->render();
            return response()->json(['html' => $html]);
        }
        $list_guide = PostGuide::join('countries', 'post_guides.country_id', '=', 'countries.id')
                                ->join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                                ->orderBy('post_guides.created_at', 'desc')->where('post_guides.post_type', 'cultural')
                                ->distinct()->select('post_guides.*', 'countries.title as country_title', 'category_guides.title as category_title')
                                ->paginate(14);
        return view('backend.culturalGuides.list',['list_guide'=>$list_guide]);
    }

    public function store(){
        $list_cat = CategoryGuide::where('post_type', 'cultural')->orderBy('title')->get();
        $data = [];
        $data['list_cat'] = $list_cat;
        return view('backend.culturalGuides.create', $data);
    }

    //create
    public function create(Request $request){
        $list_rules = [];
        $list_rules['title'] = 'required';
        $list_rules['cat_id'] = 'required';
        $list_rules['country_id'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, PostGuide::getMessageRule());

        $validator->after(function($validator) use ($request) {
            //check exist
            $post_exist = PostGuide::where('post_type', 'cultural')->where('cat_id', $request->cat_id)->where('country_id', $request->country_id)->first();
            if($post_exist)
                $validator->errors()->add('exist', 'Country and Category is already exist.');
        });
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $request['slug'] = $request->title;
        $request['post_type'] = 'cultural';
        $guide = PostGuide::create($request->only('title', 'title_tag', 'slug', 'desc', 'post_type', 'image', 'cat_id', 'country_id'));
        createSeo($guide->id, 'guide', $request->meta_key, $request->meta_value);
        createTableContent($request->table_content, 'guide', $guide->id);

        return response()->json(['success' => 'Add to success.', 'url' => route('storeCulturalAdmin')]);
    }
    
    //edit
    public function edit($id){
        $guide = PostGuide::findOrFail($id);
        $cat = CategoryGuide::findOrFail($guide->cat_id);
        $list_cat = CategoryGuide::where('post_type', 'cultural')->orderBy('title')->get();
        $data = [];
        $data['guide'] = $guide;
        $data['cat'] = $cat;
        $data['list_cat'] = $list_cat;
        $data['country'] = Countries::findOrFail($guide->country_id); 
        return view('backend.culturalGuides.edit', $data);
    }

    //update
    public function update($id, Request $request){
       $guide = PostGuide::findOrFail($id);
        $list_rules = [];
        $list_rules['title'] = 'required';
        $list_rules['cat_id'] = 'required';
        $list_rules['country_id'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, PostGuide::getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $guide->update($request->only('title', 'title_tag', 'slug', 'desc', 'image', 'cat_id', 'country_id'));
        $guide->touch();
        updateSeo($guide->id, 'guide', $request->meta_key, $request->meta_value);
        updateTableContent($request->table_content, 'guide', $guide->id);
        return response()->json(['success' => 'Update to success.', 'url' => route('editCulturalAdmin', $id)]);
    }

    public function delete($id){
        $seo = Seo::where('post_id',$id)->where('type','guide')->delete();
        $tableContent = TableContents::where('post_id',$id)->where('post_type','guide')->delete();
        $guide = PostGuide::find($id);
        $guide->delete();
        return redirect()->route('guidesAdmin')->with('success', 'Deleted successfull.');
    }

    //deleteAll
    public function deleteAll(Request $resquest){
        if($resquest->ajax()){
            $items = json_decode($resquest->items);
            if(count($items)>0){
                foreach($items as $id){
                    $seo = Seo::where('post_id',$id)->where('type','guide')->delete();
                    $tableContent = TableContents::where('post_id',$id)->where('post_type','guide')->delete();
                }
                PostGuide::destroy($items);
            }
            $list_guide = PostGuide::join('countries', 'post_guides.country_id', '=', 'countries.id')
                                ->join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                                ->orderBy('post_guides.created_at', 'desc')->where('post_guides.post_type', 'cultural')
                                ->distinct()->select('post_guides.*', 'countries.title as country_title', 'category_guides.title as category_title')
                                ->paginate(14);
            $html = view('backend.guides.table', ['list_guide' => $list_guide])->render();
            return response()->json(['html' => $html]);
        }
        return  'error';
    }

}
