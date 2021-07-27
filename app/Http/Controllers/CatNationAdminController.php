<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Guides;
use App\Media;
use App\CategoryGuide;
use Validator;

class CatNationAdminController extends Controller
{
	public function index(Request $request){  
        if($request->ajax()){
            $list_catGuide = CategoryGuide::where('post_type', 'market');
            if(isset($request->s) && $request->s != '')
                $list_catGuide = $list_catGuide->where('title', 'like', '%'.$request->s.'%');
            $list_catGuide = $list_catGuide->orderBy('position', 'asc')->get();
            $html = view('backend.catNations.table', ['list_catGuide' => $list_catGuide])->render();
            return response()->json(['html' => $html]);
        }  	
    	$list_catGuide = CategoryGuide::where('post_type', 'market')->orderBy('position', 'asc')->get();
        $data = [];
        $data['list_catGuide'] = $list_catGuide;
        return view('backend.catNations.list', $data);
    }

    public function create(){
        return view('backend.catNations.create');
    }

    public function store(Request $request){
        $list_rules = [];
        $list_rules['title'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, CategoryGuide::getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $request['slug'] = $request->title;
        CategoryGuide::create($request->all());
        return response()->json(['success' => 'Add to success.', 'url' => route('Nationality')]);
    }

    public function edit($slug){
        $cat_guide = CategoryGuide::findBySlug($slug); 
        $data = [];
        $data['cat_guide'] = $cat_guide;
        return view('backend.catNations.edit', $data);
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
        return response()->json(['success' => 'Update to success.', 'url' => route('editNationalityAdmin', $request['slug'])]);
    }

    public function delete($id){
        $cat_guide = CategoryGuide::find($id);
        $cat_guide->delete();
        return redirect()->route('Nationality')->with('success', 'Delete successfull.');
    }
   
}
