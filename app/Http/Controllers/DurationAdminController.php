<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Duration;

class DurationAdminController extends Controller
{
    public function index(){    	
    	$durations = Duration::orderBy('created_at', 'desc')->paginate(14);
    	return view('backend.duration.list', ['durations'=>$durations]);
    }  

    public function store(){
        return view('backend.duration.create');
    }

    public function create(Request $request){
        $msg = 'error';
        if($request->ajax()){
            $duration = new Duration;
            $duration->title = $request->title;
            $duration->slug = $request->title;
            $duration->min = $request->min;
            $duration->max = $request->max;
            $duration->white_icon = $request->white_icon;
            $duration->yellow_icon = $request->yellow_icon;
            $duration->save();
            $msg = 'success';
        }
        return $msg;
    }

    public function edit($slug){
        $duration = Duration::findBySlug($slug);
        return view('backend.duration.edit', ['duration'=>$duration]);
    }

    public function update($slug, Request $request){
        $msg = array();
        $status = 'error';
        if($request->ajax()){
            $duration = Duration::findBySlug($slug);
            $duration->title = $request->title;
            $duration->slug = $request->title;
            $duration->min = $request->min;
            $duration->max = $request->max;
            $duration->white_icon = $request->white_icon;
            $duration->yellow_icon = $request->yellow_icon;
            $duration->save();
            $duration->touch();
            $status = 'success';
            $msg['url'] = route('editDurationAdmin', ['slug'=>$duration->slug]);
        }
        $msg['status'] = $status;
        return $msg;
    }

    public function delete($id){
        $duration = Duration::find($id);
        $duration->delete();
        return redirect('/admin/duration/')->with('success','Xóa thành công');
    }

    public function position(Request $request){
        $message = "error";
        if($request->ajax()):                       
            $routes = json_decode($request->routes);
            foreach ($routes as $item):
                $duration = Duration::find($item->id);
                $duration->position = $item->position;                      
                $duration->save();
            endforeach;
            $message = "success";
        endif;
        return $message;
    }
    
}
