<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Guides;
use App\Media;
use App\CategoryGuide;
use Validator;

class CatThingToDoAdminController extends Controller
{
	public function index(Request $request){  
        if($request->ajax()){
            $list_catGuide = CategoryGuide::where('post_type', 'thing_to_do');
            if(isset($request->s) && $request->s != '')
                $list_catGuide = $list_catGuide->where('title', 'like', '%'.$request->s.'%');
            $list_catGuide = $list_catGuide->orderBy('position', 'asc')->get();
            $html = view('backend.catGuides.table', ['list_catGuide' => $list_catGuide])->render();
            return response()->json(['html' => $html]);
        }  	
    	$list_catGuide = CategoryGuide::where('post_type', 'thing_to_do')->orderBy('position', 'asc')->get();
        $data = [];
        $data['list_catGuide'] = $list_catGuide;
        return view('backend.catThingToDos.list', $data);
    }

    public function store(){
        return view('backend.catThingToDos.create');
    }

    public function create(Request $request){
        $list_rules = [];
        $list_rules['title'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, CategoryGuide::getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $request['slug'] = $request->title;
        CategoryGuide::create($request->all());
        return response()->json(['success' => 'Add to success.', 'url' => route('storeCatThingToDoAdmin')]);
    }

    public function edit($slug){
        $cat_guide = CategoryGuide::findBySlug($slug); 
        $data = [];
        $data['cat_guide'] = $cat_guide;
        return view('backend.catThingToDos.edit', $data);
    }


    public function update($slug, Request $request){
        $cat_guide = CategoryGuide::findBySlug($slug); 
        $list_rules = [];
        $list_rules['title'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, CategoryGuide::getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all()]);

        unset($request['_token']);
        //$request['slug'] = str_slug($request->title, '-');
        $cat_guide->update($request->all());
        $cat_guide->touch();
        return response()->json(['success' => 'Update to success.', 'url' => route('editCatThingToDoAdmin', $request['slug'])]);
    }

    public function delete($id){
        $cat_guide = CategoryGuide::find($id);
        $cat_guide->delete();
        return redirect()->route('catThingsToDoAdmin')->with('success', 'Delete successfull.');
    }
   
}
