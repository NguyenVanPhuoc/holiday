<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Facilities;
use App\Media;
use App\Seo;

class FacilitiesAdminController extends Controller
{
	public function index(){    	
    	$facilities = Facilities::orderBy('created_at', 'desc')->paginate(14);
    	return view('backend.facilities.list',['facilities'=>$facilities]);
    }

    public function store(){
        return view('backend.facilities.create');
    }

    public function create(Request $request){
        $msg = 'error';
        if($request->ajax()){
            $facility = new Facilities;
            $facility->title = $request->title;
            $facility->slug = $request->title;
            $facility->white_icon = $request->white_icon;
            $facility->gray_icon = $request->gray_icon;
            $facility->save();
            $msg = 'success';
        }
        return $msg;
    }

    public function edit($slug){
        $facility = Facilities::findBySlug($slug);
        return view('backend.facilities.edit', ['facility'=>$facility]);
    }

    public function update(Request $request, $slug){
        if($request->ajax()){
            $facility = Facilities::findBySlug($slug);
            $facility->title = $request->title;
            $facility->slug = $request->title;
            $facility->white_icon = $request->white_icon;
            $facility->gray_icon = $request->gray_icon;
            $facility->save();
            return response()->json(['msg'=>'success', 'redirect'=>route('editFacilityAdmin', ['slug'=>$facility->slug]) ]);
        }
        return response()->json(['msg'=>'error']);
    }

    public function delete($id){
        $facility = Facilities::find($id);
        $facility->delete();
        return redirect()->route('facilitiesAdmin')->with('success', 'Delete Success.');
    }

    //deleteAll
    public function deleteAll(Request $resquest){
        $message = "error";
        if($resquest->ajax()){
            $items = json_decode($resquest->items);
            if(count($items)>0){
                Facilities::destroy($items);
            }
            $message = "success";
        }
        return $message;
    }

}
