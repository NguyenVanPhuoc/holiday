<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Media;
use App\Slide;
use App\SlideDetail;

class SlideAdminController extends Controller
{
	public function index(){        
		$slides = Slide::latest()->get();
		return view('backend.slides.list',['slides'=>$slides]);
	}
	
	public function store(){       
        return view('backend.slides.create');
    }	
	public function edit($id){
		$slide = Slide::find($id);
		return view('backend.slides.edit',['slide'=>$slide]);
	}
	
	public function create(Request $request){
        $message = "error";
        if($request->ajax()):
	        $slide = new Slide;
	        $slide->title = $request->title;
	        $slide->slug = $request->title;                
	        if($slide->save()):
	            $metas = json_decode($request->metas);
	            foreach ($metas as $item):	                
	                $slide_meta = new SlideDetail;
	                $slide_meta->content = $item->text;
	                $slide_meta->image = $item->image;
	                $slide_meta->position = $item->position;
	                $slide_meta->slide_id = $slide->id;
	                $slide_meta->save();
	            endforeach;
	            $message = "success";                   
	        endif;
       	endif;
        return $message;
    }
    public function update(Request $request, $id){
        $message = "error";
        if($request->ajax()):
        	$slide = Slide::find($id);
            $slide->title = $request->title;
            $slide->slug = $request->title;
            if($slide->save()):                
                $old_metas = json_decode($request->old_metas);
                $new_metas = json_decode($request->new_metas);
            	$del_items = json_decode($request->delItems);                
                //delete recores
                if(count($request->delItems)>0){
                    SlideDetail::destroy($del_items);
                }                
                //update recores
                if(count($old_metas)>0){
                    foreach ($old_metas as $item):
                        $slide_meta = SlideDetail::find($item->meta_id);
                        $slide_meta->content = $item->text;
                        $slide_meta->image = $item->image;
                        $slide_meta->position = $item->position;                        
                        $slide_meta->save();
                    endforeach;                
                }
                //new recores
        		if(count($new_metas)>0){
                    foreach ($new_metas as $item):
                        $slide_meta = new SlideDetail;
                        $slide_meta->content = $item->text;
                        $slide_meta->image = $item->image;
                        $slide_meta->position = $item->position;
                        $slide_meta->slide_id = $id;
                        $slide_meta->save();
            		endforeach;                
                }            
        		$message = "success";                	
            endif;
        endif;
		return $message;
	}
    public function delete($id){
        $slide = Slide::find($id);
        $slide->delete();
        return redirect('/admin/slides/')->with('success','Xóa thành công');
    }
}
