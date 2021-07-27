<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\SpecialHotels;
use App\Media;
use App\Seo;

class SpecialHotelAdminController extends Controller
{
	public function index(){    	
    	$specials = SpecialHotels::orderBy('position', 'asc')->get();
    	return view('backend.specialHotels.list',['specials'=>$specials]);
    }

    public function store(){
        return view('backend.specialHotels.create');
    }

    public function create(Request $request){
        $msg = 'success';
        if($request->ajax()){
            $sum = SpecialHotels::count();
            $special = new SpecialHotels;
            $special->title = $request->title;
            $special->slug = $request->title;
            $special->position = $sum + 1;
            $special->save();
            $msg = 'success';
        }
        return $msg;
    }

    public function edit($slug){
        $special = SpecialHotels::findBySlug($slug);
        return view('backend.specialHotels.edit', ['special'=>$special]);
    }

     public function update($slug, Request $request){
        if($request->ajax()){
            $special = SpecialHotels::findBySlug($slug);
            $special->title = $request->title;
            $special->slug = $request->title;
            $special->save();
            return response()->json(['msg'=>'success', 'redirect' => route('editSpecialHotelAdmin', ['slug'=>$special->slug])]);
        }
        return response()->json(['msg'=>'error']);
    }

    public function delete($id){
        $special = SpecialHotels::find($id);
        $special->delete();
        return redirect()->route('specialHotelsAdmin')->with('success', 'Delete Success.');
    }

    public function position(Request $request){
        $message = "error";
        if($request->ajax()):                       
            $routes = json_decode($request->routes);
            foreach ($routes as $item):
                $special = SpecialHotels::find($item->id);
                $special->position = $item->position;                      
                $special->save();
            endforeach;
            $message = "success";
        endif;
        return $message;
    }
    
}
