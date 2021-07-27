<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\LocationHotels;
use App\Media;
use App\Seo;

class LocationHotelAdminController extends Controller
{
	public function index(){    	
    	$locations = LocationHotels::orderBy('position', 'asc')->get();
    	return view('backend.locationHotels.list',['locations'=>$locations]);
    }

    public function store(){
        return view('backend.locationHotels.create');
    }

    public function create(Request $request){
        $msg = 'success';
        if($request->ajax()){
            $sum = LocationHotels::count();
            $location = new LocationHotels;
            $location->title = $request->title;
            $location->slug = $request->title;
            $location->position = $sum + 1;
            $location->save();
            $msg = 'success';
        }
        return $msg;
    }

    public function edit($slug){
        $location = LocationHotels::findBySlug($slug);
        return view('backend.locationHotels.edit', ['location'=>$location]);
    }

     public function update($slug, Request $request){
        if($request->ajax()){
            $location = LocationHotels::findBySlug($slug);
            $location->title = $request->title;
            $location->slug = $request->title;
            $location->save();
            return response()->json(['msg'=>'success', 'redirect' => route('editLocationHotelAdmin', ['slug'=>$location->slug])]);
        }
        return response()->json(['msg'=>'error']);
    }

    public function delete($id){
        $location = LocationHotels::find($id);
        $location->delete();
        return redirect()->route('locationHotelsAdmin')->with('success', 'Delete Success.');
    }

    public function position(Request $request){
        $message = "error";
        if($request->ajax()):                       
            $routes = json_decode($request->routes);
            foreach ($routes as $item):
                $location = LocationHotels::find($item->id);
                $location->position = $item->position;                      
                $location->save();
            endforeach;
            $message = "success";
        endif;
        return $message;
    }
    
}
