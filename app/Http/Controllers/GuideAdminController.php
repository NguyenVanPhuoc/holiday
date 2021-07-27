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

class GuideAdminController extends Controller
{
	public function index(Request $request){    	
        if($request->ajax()){
            $list_guide = PostGuide::join('countries', 'post_guides.country_id', '=', 'countries.id')
                                    ->join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                                    ->where('post_guides.post_type', 'travel_tip');
            if(isset($request->country_id) && $request->country_id != '')
                $list_guide = $list_guide->where('post_guides.country_id', $request->country_id);
            if(isset($request->s) && $request->s != '')
                $list_guide = $list_guide->where('post_guides.title', 'like', '%'. $request->s .'%');
            $list_guide = $list_guide->orderBy('post_guides.created_at', 'desc')
                                    ->distinct()
                                    ->select('post_guides.*', 'countries.title as country_title', 'category_guides.title as category_title')
                                    ->paginate(14);

            $html = view('backend.guides.table', ['list_guide' => $list_guide])->render();
            return response()->json(['html' => $html]);
        }
    	$list_guide = PostGuide::join('countries', 'post_guides.country_id', '=', 'countries.id')
                                ->join('category_guides', 'post_guides.cat_id', '=', 'category_guides.id')
                                ->orderBy('post_guides.created_at', 'desc')->where('post_guides.post_type', 'travel_tip')
                                ->distinct()->select('post_guides.*', 'countries.title as country_title', 'category_guides.title as category_title')
                                ->paginate(14);
    	return view('backend.guides.list',['list_guide'=>$list_guide]);
    }

    public function store(){
        $list_cat = CategoryGuide::where('post_type', 'travel_tip')->orderBy('title')->get();
        $data = [];
        $data['list_cat'] = $list_cat;
        return view('backend.guides.create', $data);
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
            $post_exist = PostGuide::where('post_type', 'travel_tip')->where('cat_id', $request->cat_id)->where('country_id', $request->country_id)->first();
            if($post_exist)
                $validator->errors()->add('exist', 'Country and Category is already exist.');
        });
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $request['slug'] = $request->title;
        $request['post_type'] = 'travel_tip';
        $guide = PostGuide::create($request->only('title', 'title_tag', 'desc', 'post_type', 'image', 'image_looking', 'image_request', 'cat_id', 'country_id'));
        updateSlug('post_guides', $request->title, $guide->id);
        createSeo($guide->id, 'guide', $request->meta_key, $request->meta_value);
        createTableContent($request->table_content, 'guide', $guide->id);

        return response()->json(['success' => 'Add to success.', 'url' => route('storeGuideAdmin')]);
    }
    
    //edit
    public function edit($id){
        $guide = PostGuide::findOrFail($id);
        $cat = CategoryGuide::findOrFail($guide->cat_id);
        $list_cat = CategoryGuide::where('post_type', 'travel_tip')->orderBy('title')->get();
        $data = [];
        $data['guide'] = $guide;
        $data['list_cat'] = $list_cat;
        $data['country'] = Countries::findOrFail($guide->country_id); 
        $data['cat'] = $cat;
        return view('backend.guides.edit', $data);
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
        $guide->update($request->only('title', 'title_tag', 'desc', 'image', 'image_looking', 'image_request', 'cat_id', 'country_id'));
        $guide->touch();
        updateSlug('post_guides', $request->title, $guide->id);
        updateSeo($guide->id, 'guide', $request->meta_key, $request->meta_value);
        updateTableContent($request->table_content, 'guide', $guide->id);
        return response()->json(['success' => 'Update to success.', 'url' => route('editGuideAdmin', $id)]);
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
                                ->orderBy('post_guides.created_at', 'desc')->where('post_guides.post_type', 'travel_tip')
                                ->distinct()->select('post_guides.*', 'countries.title as country_title', 'category_guides.title as category_title')
                                ->paginate(14);
            $html = view('backend.guides.table', ['list_guide' => $list_guide])->render();
            return response()->json(['html' => $html]);
        }
        return  'error';
    }

    public function search(Request $request){
        $s = $request->s;
        $country_id = $request->country_id;
        $guides = PostGuide::query();
        if($s != ''){
            $guides = $guides->where('long_title','like','%'.$s.'%');
        }
        if($country_id != ''){
            $guides = $guides->where('country_id', $country_id);
        }
        $guides = $guides->where('post_type', 'travel_tip')->orderBy('created_at', 'desc')->paginate(14);
        return view('backend.guides.list',['guides'=>$guides, 's'=>$s, 'country_id'=>$country_id]);
    }
}
