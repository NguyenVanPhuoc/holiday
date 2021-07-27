<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Guides;
use App\Media;
use App\CategoryGuide;
use Validator;

class CatGuideAdminController extends Controller
{
	public function index(Request $request){  
        if($request->ajax()){
            $list_catGuide = CategoryGuide::where('post_type', 'travel_tip');
            if(isset($request->s) && $request->s != '')
                $list_catGuide = $list_catGuide->where('title', 'like', '%'.$request->s.'%');
            $list_catGuide = $list_catGuide->orderBy('position', 'asc')->get();
            $html = view('backend.catGuides.table', ['list_catGuide' => $list_catGuide])->render();
            return response()->json(['html' => $html]);
        }  	
    	$list_catGuide = CategoryGuide::where('post_type', 'travel_tip')->orderBy('position', 'asc')->get();
        $data = [];
        $data['list_catGuide'] = $list_catGuide;
        return view('backend.catGuides.list', $data);
    }

    public function store(){
        return view('backend.catGuides.create');
    }

    public function create(Request $request){
        $list_rules = [];
        $list_rules['title'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, CategoryGuide::getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        //$request['slug'] = $request->title;
        $cat_guide = CategoryGuide::create($request->all());
        updateSlug('category_guides', $request->title, $cat_guide->id);

        return response()->json(['success' => 'Add to success.', 'url' => route('storeCatGuideAdmin')]);
    }

    public function edit($slug){
        $cat_guide = CategoryGuide::findBySlug($slug); 
        $data = [];
        $data['cat_guide'] = $cat_guide;
        return view('backend.catGuides.edit', $data);
    }


    public function update($slug, Request $request){
        $cat_guide = CategoryGuide::findBySlug($slug); 
        $list_rules = [];
        $list_rules['title'] = 'required';
        $list_rules['slug'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all()]);

        unset($request['_token']);
        $cat_guide->update($request->all());
        $cat_guide->touch();
        
        return response()->json(['success' => 'Update to success.', 'url' => route('editCatGuideAdmin', $request['slug'])]);
    }

    public function delete($id){
        $cat_guide = CategoryGuide::find($id);
        $cat_guide->delete();
        return redirect()->route('catGuidesAdmin')->with('success', 'Delete successfull.');
    }

    //deleteAll
    public function deleteAll(Request $resquest){
        $message = "error";
        if($resquest->ajax()){
            $items = json_decode($resquest->items);
            if(count($items)>0){
                CategoryGuide::destroy($items);
            }
            $message = "success";
        }
        return $message;
    }


    //position
    public function position(Request $request){
        $msg = 'error';
        if($request->ajax()){
            $routes = json_decode($request->routes);
            foreach ($routes as $item){
                CategoryGuide::where('id', $item->id)->update(['position' => $item->position]);
            }
            $msg = 'success';
        }
        return $msg;
    }
   
}
