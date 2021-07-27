<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoryTour;
use Validator;

class CategoryTourAdminController extends Controller
{
    public function index(){    	
    	$cats = CategoryTour::orderBy('position', 'asc')->paginate(14);
    	return view('backend.categoryTour.list', ['cats'=>$cats]);
    }  

    public function store(){
        return view('backend.categoryTour.create');
    }

    public function create(Request $request){
        $list_rules = [];
        $list_rules['title'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all()]);
        $cat = CategoryTour::create($request->only('title', 'desc', 'image', 'white_icon', 'pink_icon', 'gray_icon', 'green_icon'));
        updateSlug('category_tours', $request->title, $cat->id);
        return response()->json(['success' => 'Add to success.', 'url' => route('storeCatTourAdmin')]);
    }

    public function edit($slug){
        $cat = CategoryTour::findBySlug($slug);
        return view('backend.categoryTour.edit', ['cat'=>$cat]);
    }

    public function update($slug, Request $request){
        $cat = CategoryTour::findBySlug($slug);
        $list_rules = [];
        $list_rules['title'] = 'required';
        $list_rules['slug'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, getMessageRule());

        $validator->after(function($validator) use ($request, $cat){
            $countSlug = CategoryTour::where('slug', $request->slug)->whereNotIn('id', [$cat->id])->count();
            if($countSlug > 0)
                //$validator->getMessageBag()->add('slug.same', 'The slug is already exist');
                $validator->errors()->add('slug', 'The slug is already exist');
        });
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all()]);

        

        /*insert to DB*/
        $cat->update($request->only('title', 'slug', 'desc', 'image', 'white_icon', 'pink_icon', 'gray_icon', 'green_icon'));
        $cat->touch();
        return response()->json(['success' => 'Update to success.', 'url' => route('editCatTourAdmin', $request->slug)]);
    }

    public function delete($id){
        $cat = CategoryTour::find($id);
        $cat->delete();
        return redirect('/admin/category-tour/')->with('success','Xóa thành công');
    }

    public function position(Request $request){
        $message = "error";
        if($request->ajax()):                       
            $routes = json_decode($request->routes);
            foreach ($routes as $item):
                $cat = CategoryTour::find($item->id);
                $cat->position = $item->position;                      
                $cat->save();
            endforeach;
            $message = "success";
        endif;
        return $message;
    }
    
}
