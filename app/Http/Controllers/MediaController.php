<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Media;
use App\User;
use App\UserMetas;

class MediaController extends Controller
{
    public function index(Request $request){
    	$user = Auth::User();
        $media = Media::where('user_id',$user->id)->latest()->paginate(14);
        return view('media.list',['user'=>$user,'media'=>$media]);
    }

    //load media
    public function load(Request $request){
       return json_encode(media());
    }    
    //create media
    public function store(){
        $user = Auth::User();
        return view('media.create',['user'=>$user]);
    }
    public function create(Request $request){       
        $file = $request->file('file');
        if($file){
            $file_name = $file->getClientOriginalName();
            $imageName = explode(".", $file_name);
            $file_url = str_slug(str_random(4)."_".$imageName[0]).".".$imageName[1];
            $file->move("public/uploads/",$file_url);
            $user = Auth::User();
            $media = new Media();
            $media->title = $imageName[0];
            $media->image_path = $file_url;
            $media->type = $imageName[1];
            $media->user_id = $user->id;
            $media->save();
        }
        return 'success';
    }
    //edit media
    public function edit($id){
        $user = Auth::User();
        $media = Media::find($id);
        return view('media.edit',['user'=>$user,'media'=>$media]);
    }
    public function update(Request $request, $id){
        $user = Auth::User();
        $media = Media::find($id);        
        $media->title = $request->title;
        $media->save();
        $request->session()->flash('success', 'Sửa thành công');
        return redirect('/profile/media/edit/'.$id);
    }
    public function delete($id){
        $user = Auth::User();
        $media = Media::where('id',$id)->where('user_id',$user->id)->first();
        $path = public_path() . '/uploads/' . $media->image_path; 
        if(file_exists($path)) {
            unlink($path);
            $media->delete();
            return redirect('/profile/media/')->with('success','Xóa thành công');
        }
        return 'error';
    }
    //delete media files are choosed
    public function deleteAll(Request $resquest){
        $message = "error";
        if($resquest->ajax()){
            $user = Auth::User();
            $items = json_decode($resquest->items);
            if(count($items)>0){
              foreach ($items as $item) {
                  $media = Media::where('id',$item)->where('user_id',$user->id)->first();
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

    //delete one file with ajax
    public function deleteMediaSingle(Request $resquest){
        if($resquest->ajax()){
           $media = Media::find($resquest->id);
            $path = public_path() . '/uploads/' . $media->image_path; 
            if(file_exists($path)) {
                unlink($path);
                $media->delete();           
                return 'success';
            }
        }
        return 'error';
    }
   //load media
    public function library(Request $resquest){
        if($resquest->ajax()){
            $user = Auth::User();
            $media = Media::where('user_id',$user->id)->latest()->simplePaginate(27);
            return view('media.load', compact('media'));    
        }
        return 'error';
    }
    //change banner
    public function changeBanner(Request $resquest){
        $message = "error";
        if($resquest->ajax()){
            if($resquest->id!=""):
                $user = Auth::User();
                $userMeta = UserMetas::where('user_id',$user->id)->first();
                if($userMeta){
                    $userMeta->banner = $resquest->id;
                }else{
                    $userMeta = UserMetas();
                    $userMeta->user_id = $user->id;
                    $userMeta->banner = $resquest->id;
                }
                $userMeta->save();
                $message = "success";
            endif;
        }
        return $message;
    }
    //change avatar
    public function changeAvatar(Request $resquest){
        $message = "error";
        if($resquest->ajax()){
            if($resquest->id!=""):
                $user = Auth::User();                
                $user->image = $resquest->id;
                $user->save();
                $message = "success";
            endif;
        }
        return $message;
    }    
}
