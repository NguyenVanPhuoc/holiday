<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\StarRatings;
use App\Media;
use App\Seo;

class StarRatingAdminController extends Controller
{
	public function index(){    	
    	$stars = StarRatings::orderBy('position', 'asc')->get();
    	return view('backend.starRating.list',['stars'=>$stars]);
    }

    public function store(){
        return view('backend.starRating.create');
    }

    public function create(Request $request){
        $msg = 'success';
        if($request->ajax()){
            $sum = StarRatings::count();
            $star = new StarRatings;
            $star->title = $request->title;
            $star->slug = $request->title;
            $star->number_star = $request->number_star;
            $star->position = $sum + 1;
            $star->save();
            $msg = 'success';
        }
        return $msg;
    }

    public function edit($slug){
        $star = StarRatings::findBySlug($slug);
        return view('backend.starRating.edit', ['star'=>$star]);
    }

    public function update($slug, Request $request){
        if($request->ajax()){
            $star = StarRatings::findBySlug($slug);
            $star->title = $request->title;
            $star->slug = $request->title;
            $star->number_star = $request->number_star;
            $star->save();
            return response()->json(['msg'=>'success', 'redirect' => route('editStarRatingAdmin', ['slug'=>$star->slug])]);
        }
        return response()->json(['msg'=>'error']);
    }

    public function delete($id){
        $star = StarRatings::find($id);
        $star->delete();
        return redirect()->route('starRatingsAdmin')->with('success', 'Delete Success.');
    }

    public function position(Request $request){
        $message = "error";
        if($request->ajax()):                       
            $routes = json_decode($request->routes);
            foreach ($routes as $item):
                $star = StarRatings::find($item->id);
                $star->position = $item->position;                      
                $star->save();
            endforeach;
            $message = "success";
        endif;
        return $message;
    }
    
}
