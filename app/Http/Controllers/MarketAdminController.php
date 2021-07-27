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
use App\Tours;
use Validator;

class MarketAdminController extends Controller
{
	public function index(Request $request){    	
    	if($request->ajax()){
            $list_guide = PostGuide::join('countries', 'post_guides.country_id', '=', 'countries.id')
                                    ->join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                                    ->where('post_guides.post_type', 'market');
            if(isset($request->country_id) && $request->country_id != '')
                $list_guide = $list_guide->where('post_guides.country_id', $request->country_id);
            if(isset($request->cat_id) && $request->cat_id != '')
                $list_guide = $list_guide->where('post_guides.cat_id', $request->cat_id);
            if(isset($request->s) && $request->s != '')
                $list_guide = $list_guide->where('post_guides.title', 'like', '%'. $request->s .'%');
            $list_guide = $list_guide->orderBy('post_guides.created_at', 'desc')
                                    ->distinct()
                                    ->select('post_guides.*', 'countries.title as country_title', 'category_guides.title as category_title')
                                    ->paginate(14);

            $html = view('backend.marketGuides.table', ['list_guide' => $list_guide])->render();
            return response()->json(['html' => $html]);
        }
        $list_guide = PostGuide::join('countries', 'post_guides.country_id', '=', 'countries.id')
                                ->join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                                ->orderBy('post_guides.created_at', 'desc')->where('post_guides.post_type', 'market')
                                ->distinct()->select('post_guides.*', 'countries.title as country_title', 'category_guides.title as category_title')
                                ->paginate(14);
        return view('backend.marketGuides.list',['list_guide'=>$list_guide]);
    }

    public function store(){
        $list_cat = CategoryGuide::where('post_type', 'market')->orderBy('title')->get();
        $list_tour = Tours::orderBy('created_at', 'desc')->get(); 
        $data = [];
        $data['list_cat'] = $list_cat;
        $data['list_tour'] = $list_tour;
        return view('backend.marketGuides.create', $data);
    }

    //create
    public function create(Request $request){
        $list_rules = [];
        $list_rules['title'] = 'required';
        $list_rules['cat_id'] = 'required';
        $list_rules['country_id'] = 'required';
        $request['list_tour'] = ($request->list_tour != '') ? implode(",", $request->list_tour) : '';
        $validator = Validator::make($request->all(), $list_rules, PostGuide::getMessageRule());

        $validator->after(function($validator) use ($request) {
            //check exist
            $post_exist = PostGuide::where('post_type', 'market')->where('cat_id', $request->cat_id)->where('country_id', $request->country_id)->first();
            if($post_exist)
                $validator->errors()->add('exist', 'Country and Category is already exist.');
        });
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $request['slug'] = $request->title;
        $request['post_type'] = 'market';
        $guide = PostGuide::create($request->only('title', 'title_tag', 'slug', 'desc', 'list_tour', 'post_type', 'image', 'image_looking', 'image_request', 'cat_id', 'country_id'));
        createSeo($guide->id, 'market', $request->meta_key, $request->meta_value);
        createTableContent($request->table_content, 'market', $guide->id);

        return response()->json(['success' => 'Add to success.', 'url' => route('storeMarketAdmin')]);
    }
    
    //edit
    public function edit($id){
        $guide = PostGuide::findOrFail($id);
        $cat = CategoryGuide::findOrFail($guide->cat_id);
        $list_cat = CategoryGuide::where('post_type', 'market')->orderBy('title')->get();
        $list_tour = Tours::orderBy('created_at', 'desc')->get();
        //dd($list_tour);
        $data = [];
        $data['guide'] = $guide;
        $data['cat'] = $cat;
        $data['list_cat'] = $list_cat;
        $data['list_tour'] = $list_tour;
        $data['country'] = Countries::findOrFail($guide->country_id); 
        return view('backend.marketGuides.edit', $data);
    }

    //update
    public function update($id, Request $request){
        $guide = PostGuide::findOrFail($id);
        $list_rules = [];
        $list_rules['title'] = 'required';
        $list_rules['cat_id'] = 'required';
        $list_rules['country_id'] = 'required';
        $request['list_tour'] = ($request->list_tour != '') ? implode(",", $request->list_tour) : '';
        $validator = Validator::make($request->all(), $list_rules, PostGuide::getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $guide->update($request->only('title', 'title_tag', 'slug', 'desc', 'list_tour', 'image', 'image_looking', 'image_request', 'cat_id', 'country_id'));
        $guide->touch();
        updateSeo($guide->id, 'market', $request->meta_key, $request->meta_value);
        updateTableContent($request->table_content, 'market', $guide->id);
        return response()->json(['success' => 'Update to success.', 'url' => route('editMarketAdmin', $id)]);
    }

    public function delete($id){
        $seo = Seo::where('post_id',$id)->where('type','market')->delete();
        $tableContent = TableContents::where('post_id',$id)->where('post_type','market')->delete();
        $guide = PostGuide::find($id);
        $guide->delete();
        return redirect()->route('marketAdmin')->with('success', 'Deleted successfull.');
    }

    //deleteAll
    public function deleteAll(Request $resquest){
        if($resquest->ajax()){
            $items = json_decode($resquest->items);
            if(count($items)>0){
                foreach($items as $id){
                    $seo = Seo::where('post_id',$id)->where('type','market')->delete();
                    $tableContent = TableContents::where('post_id',$id)->where('post_type','market')->delete();
                }
                PostGuide::destroy($items);
            }
            $list_guide = PostGuide::join('countries', 'post_guides.country_id', '=', 'countries.id')
                                ->join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                                ->orderBy('post_guides.created_at', 'desc')->where('post_guides.post_type', 'market')
                                ->distinct()->select('post_guides.*', 'countries.title as country_title', 'category_guides.title as category_title')
                                ->paginate(14);
            $html = view('backend.guides.table', ['list_guide' => $list_guide])->render();
            return response()->json(['html' => $html]);
        }
        return  'error';
    }

}
