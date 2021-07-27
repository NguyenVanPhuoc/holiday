<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\MediaCat;
use App\Media;

class MediaCatAdminController extends Controller
{
	public function index(){
		$mediaCats = MediaCat::orderBy('position', 'asc')->get();
		return view('backend.media.list_cat',['mediaCats'=>$mediaCats]);
	}

	public function store(){    	
		return view('backend.media.create_cat');
	}

	public function create(Request $request){    	
		$message = "error";
		if($request->ajax()){			
			$media = new MediaCat();
			$media->title = $request->title;
			$media->slug = $request->title;
			$media->save();
			$message = "success";
		}
		return $message;
	}

	public function edit($id){ 
		$mediaCat = MediaCat::find($id);   	
		return view('backend.media.edit_cat',['mediaCat'=>$mediaCat]);
	}
	public function update(Request $request, $id){
		$message = "error";
		if($request->ajax()){			
			$media = MediaCat::find($id);
			$media->title = $request->title;
			$media->slug = $request->title;
			$media->save();
			$message = "success";
		}
		return $message;
	}	
	public function delete($id){
		$media = Media::where('cat_id',$id)->first();
		if($media) $media->cat_id = NULL;
        $mediaCat = MediaCat::find($id);
        $mediaCat->delete();
        return redirect('/admin/media-cat')->with('success','Xóa danh mục thành công');
    }

	//deleteAll
	public function deleteAll(Request $resquest){
		$message = "error";
		if($resquest->ajax()){
			$items = json_decode($resquest->items);
			if(count($items)>0){
				foreach ($items as $item) {
					$media = Media::find($item);
					$path = public_path() . '/uploads/' . $media->image_path; 
					if(file_exists($path)) {
						unlink($path);
						$media->delete();
					}
				}            
			}
			$message = "success";
		}
		return $message;
	}
	public function position(Request $request){
		$message = "error";
		if($request->ajax()):						
			$routes = json_decode($request->routes);
			foreach ($routes as $item):
				$mediaCat = MediaCat::find($item->id);
				$mediaCat->position = $item->position;						
				$mediaCat->save();
			endforeach;
			$message = "success";
		endif;
		return $message;
	}  
}