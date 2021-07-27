<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\MediaCat;
use App\Media;
use App\User;

class MediaAdminController extends Controller
{
  public function index(){
    if(isset($_GET['cat_media']) && $_GET['cat_media'] != '') ;
    $media = Media::orderBy('updated_at', 'desc')->paginate(14);
    return view('backend.media.list',['media'=>$media]);
  }

  public function store(){    	
    return view('backend.media.create');
  }
  public function create(Request $request){    	
    $file = $request->file('file');    
    if($file){
      $file_name = $file->getClientOriginalName();
      $file_extension = $file->getClientOriginalExtension();
      $file_size = $file->getSize();
      $file_mime = $file->getMimeType();
      $file_attributes = getimagesize($file->getRealPath());
      $file_url = str_slug(str_random(4)."_".$file_name).'.'.$file_extension;
      $file->move("public/uploads/",$file_url);
      $media = new Media();
      $media->title = $file_name;
      $media->alt = $file_name;
      $media->image_path = $file_url;
      $media->type = $file_extension;
      $media->size = $file_size;
      if($request->category !="") $media->cat_ids = $request->category;
      $media->user_id = Auth::User()->id;
      if($file_attributes){
        $media->width = $file_attributes[0];
        $media->height = $file_attributes[1];
      }
      $media->save();
    }
    return $request->category;
  }
  public function edit($id){
    $media = Media::find($id);    
    $mediaCat = MediaCat::orderBy('position', 'desc')->get();
    return view('backend.media.edit',['media'=>$media, 'mediaCat'=>$mediaCat]);
  }
  public function update(Request $request, $id){
    $message = "error";
    if($request->ajax()):
      $categories = json_decode($request->categories);
      $media = Media::find($id);
      $media->cat_ids = implode(",",$categories);
      if($request->title!="") $media->title = $request->title;
      if($request->alt!="") $media->alt = $request->alt;
      if($request->caption!="") $media->caption = $request->caption;
      if($request->desc!="") $media->description = $request->desc;
      $media->save();
      $message = "success";
    endif;
    return $message;
  }
  public function delete($id){
    $media = Media::find($id);
    $path = public_path() . '/uploads/' . $media->image_path; 
    if(file_exists($path)) {
      unlink($path);
      $media->delete();
      return redirect('/admin/media/')->with('success','Xóa thành công');
    }
    return 'error';
  }
  //get detail file in popup  
  public function getDetail(Request $request){
    if($request->ajax()):
      $image = explode("-",$request->id);
      $media = Media::find($image[1]);
      if($media):
        $mediaCat = MediaCat::select('title','id')->orderBy('position', 'desc')->get();
        $catIds = explode(',',$media->cat_ids);
        $html = '<div class="attachment-info att-item">';
        $html .= '<h2>ATTACHMENT DETAILS</h2>';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-6 thumb">'.image($media->id,120,80,$media->alt).'</div>';
        $html .= '<div class="col-md-6 desc">';
        $html .= '<ul>';
        $html .= '<li>'.$media->title.'</li>';
        $html .= '<li>'.dateConvert($media->created_at).'</li>';
        if(checkImage($media->type)==1){              
          $html .= '<li>'.formatSizeUnits($media->size).'</li>';  
          $html .= '<li>'.$media->width.' x '.$media->height.'</li>';
        }            
        $html .= '<li><a href="'.url('/admin/media/edit').'/'.$media->id.'" class="edit">Edit File</a> <span>|</span> <a href="#" class="delete">Delete</a></li>';        
        $html .= '</ul>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="attachment-config att-item">';
        $html .= '<div class="frm-url">';
        $html .= '<label for="url">Url</label>';
        $html .= '<input type="text" name="url" class="form-control frm-input"value="'.url('/public/uploads').'/'.$media->image_path.'" readonly/>';
        $html .= '</div>';
        $html .= '<div class="frm-title">';
        $html .= '<label for="title">Title</label>';
        $html .= '<input type="text" name="title" class="frm-input" data-value="title" value="'.$media->title.'"/>';
        $html .= '</div>';
        $html .= '<div class="frm-caption">';
        $html .= '<label for="title">Caption</label>';
        $html .= '<textarea name="caption" class="frm-input" data-value="caption" placeholder="Caption" rows="2">'.$media->caption.'</textarea>';
        $html .= '</div>';
        $html .= '<div class="frm-alt">';
        $html .= '<label for="alt">Alt</label>';
        $html .= '<input type="text" name="alt" class="frm-input" data-value="alt" value="'.$media->alt.'"/>';
        $html .= '</div>';
        $html .= '<div class="frm-desc">';
        $html .= '<label for="desc">Description</label>';
        $html .= '<textarea name="desc" class="frm-input" data-value="description" placeholder="Description" rows="2">'.$media->description.'</textarea>';
        $html .= '</div>';
        $html .="</div>";
        if($mediaCat):
          $html .='<div class="attachment-cat att-item">';
          $html .= '<h2>MEDIA CATEGORIES</h2>';
          $html .='<ul class="list">';
          foreach ($mediaCat as $item):              
            $html .= '<li class="checkbox checkbox-success">';
            if(in_array($item->id,$catIds))
              $html .= '<input type="checkbox" name="media'.$item->id.'" id="mediacat-'.$item->id.'" value="'.$item->id.'" checked>';  
            else
              $html .= '<input type="checkbox" name="media'.$item->id.'" id="mediacat-'.$item->id.'" value="'.$item->id.'">';
            $html .= '<label for="mediacat-'.$item->id.'">'.$item->title.'</label>';
            $html .='</li>';              
          endforeach;
          $html .='</ul>';
          $html .="</div>";
        endif;
      endif;
      return response()->json(['message'=>'success','html'=>$html,'file_id'=>$media->id]);      
    endif;
    return response()->json(['message'=>'error']);
  }
  //change fileds value
  public function changeAttribute(Request $request){
    if($request->ajax()){
      $media = Media::find($request->id);
      if($media):        
        switch ($request->type) {
          case 'title':
          $media->title = $request->value;            
          break;
          case 'caption':
          $media->caption = $request->value;            
          break;
          case 'description':
          $media->description = $request->value;            
          break;
          case 'alt':
          $media->alt = $request->value;            
          break;
          default:
            # code...
          break;
        }
        $media->save();
        return response()->json(['message'=>'success']);
      endif;
      return response()->json(['message'=>'error']);
    }
    return response()->json(['message'=>'error']);
  }  
  //change category file
  public function changeCategory(Request $request){
    if($request->ajax()):
      $media = Media::find($request->id);
      if($media):
        $categories = json_decode($request->categories);
        if(count($categories)>0)
          $media->cat_ids = implode(",",$categories);
        else
          $media->cat_ids = NULL;
        $media->save();
        return 'success';
      endif;      
    endif;
    return 'error';
  }
  //delete one file with ajax
  public function deleteMediaSingle(Request $resquest){
    if($resquest->ajax()){
      $media = Media::find($resquest->id);
      if($media){
        $path = public_path() . '/uploads/' . $media->image_path; 
        if(file_exists($path)){
          unlink($path);
          $media->delete();           
          return 'success';
        }  
      }
    }
    return 'error';
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
  //load media
  public function loadMedia(Request $resquest){
    $total = Media::count();
    $limit = 27;    
    $media = Media::limit($limit)->latest()->get();
    $message = 'error';
    if($media):
      $message = "success";
      $html = '';
      foreach ($media as $item):  
        if($item->type == 'pdf'){
          $path = asset('/public/admin/images/pdf_icon.png');
          $html .='<li id="image-'.$item->id.'"><div class="wrap"><img src="'.$path.'" alt="'.$item->image_path.'"/></div></li>';
        }
        else{
          $path = url('/').'/image/'.$item->image_path.'/150/100';
          $html .='<li id="image-'.$item->id.'"><div class="wrap"><img src="'.$path.'" alt="'.$item->image_path.'"/></div></li>';
        }
      endforeach;      
    endif;
    return response()->json(['message'=>'success','html'=>$html,'total'=>$total,'limit'=>$limit,'current'=>count($media)]);
  }  
  //load by cat
  public function loadMediaByCat(Request $resquest){
    $message = "error";
    if($resquest->ajax()){
      $limit = 27;      
      if($resquest->catId!="" && $resquest->s!=""):
        $total = Media::whereRaw("find_in_set($resquest->catId,cat_ids)")->where('title','like','%'.$resquest->s.'%')->count();      
        $media = Media::whereRaw("find_in_set($resquest->catId,cat_ids)")->where('title','like','%'.$resquest->s.'%')->offset(0)->limit($limit)->latest()->get();
      elseif($resquest->catId!=""):
        $total = Media::whereRaw("find_in_set($resquest->catId,cat_ids)")->count();      
        $media = Media::whereRaw("find_in_set($resquest->catId,cat_ids)")->offset(0)->limit($limit)->latest()->get();
      else:
        $total = Media::count();      
        $media = Media::limit($limit)->latest()->get();
      endif;
      if($media):
        $message = "success";
        $html = '';
        foreach ($media as $item):
          $path = url('/').'/image/'.$item->image_path.'/150/100';
          $html .='<li id="image-'.$item->id.'"><div class="wrap"><img src="'.$path.'" alt="'.$item->image_path.'"/></div></li>';
        endforeach;        
      endif;
      return response()->json(['message'=>'success','html'=>$html,'total'=>$total,'limit'=>$limit,'current'=>count($media)]);
    }
    return $message;
  }
  //search media cat
  public function searchCatMedia(Request $resquest){
    $message = "error";
    if($resquest->ajax()){
      if($resquest->s!=""):
        $mediaCat = MediaCat::where('title','like','%'.$resquest->s.'%')->get();
      else:
        $mediaCat = MediaCat::get();
      endif;
      if($mediaCat):
        $message = "success";
        $html = '';
        foreach ($mediaCat as $item):
          $html .='<a hef="#'.$item->slug.'" data-value="'.$item->id.'">'.$item->title.'</a>';
        endforeach;        
      endif;
      return response()->json(['message'=>'success','html'=>$html]);
    }
    return $message;
  }
  public function search(Request $request){
        $category = $request->category;
        $s = $request->s;
        $author = $request->author;
        $media = Media::query();
        if($s!="")
        {
          $media = $media->where('title','like','%'.$s.'%');
        }
        if($author!=""){
          $media = $media->join('users', 'users.id' ,'=', 'media.user_id')->where('media.user_id', $author);
        }
        if($category!=""){
          $media = $media->whereRaw("find_in_set($category, cat_ids)");  
        }
        $media = $media->select('media.*')->orderBy('created_at', 'desc')->paginate(14);
        return view('backend.media.list',['media'=>$media, 's'=>$s, 'category'=>$category , 'author'=>$author]);
    }
  //search key
  public function searchMedia(Request $resquest){
    $message = "error";
    if($resquest->ajax()){
      $limit = 27;
      if($resquest->catId!="" && $resquest->s!=""):
        $total = Media::whereRaw("find_in_set($resquest->catId,cat_ids)")->where('title','like','%'.$resquest->s.'%')->count();      
        $media = Media::whereRaw("find_in_set($resquest->catId,cat_ids)")->where('title','like','%'.$resquest->s.'%')->offset(0)->limit($limit)->latest()->get();
      elseif($resquest->catId!=""):
        $total = Media::whereRaw("find_in_set($resquest->catId,cat_ids)")->count();      
        $media = Media::whereRaw("find_in_set($resquest->catId,cat_ids)")->offset(0)->limit($limit)->latest()->get();
      elseif($resquest->s!=""):
        $total = Media::where('title','like','%'.$resquest->s.'%')->count();          
        $media = Media::where('title','like','%'.$resquest->s.'%')->offset(0)->limit($limit)->latest()->get();
      else:
        $total = Media::count();      
        $media = Media::limit($limit)->latest()->get();
      endif;
      if($media):
        $message = "success";
        $html = '';
        foreach ($media as $item):
          if($item->type == 'pdf'){
            $path = asset('/public/admin/images/pdf_icon.png');
            $html .='<li id="image-'.$item->id.'"><div class="wrap"><img src="'.$path.'" alt="'.$item->image_path.'"/></div></li>';
          }
          else{
            $path = url('/').'/image/'.$item->image_path.'/150/100';
            $html .='<li id="image-'.$item->id.'"><div class="wrap"><img src="'.$path.'" alt="'.$item->image_path.'"/></div></li>';
          }
        endforeach;        
      endif;
      return response()->json(['message'=>'success','html'=>$html,'total'=>$total,'limit'=>$limit,'current'=>count($media)]);
    }
    return $message;
  }
  //load more media
  public function loadMorePage(Request $resquest){
    $s = $resquest->s;
    $catId = $resquest->catId;
    $current = $resquest->current;
    $limit = 27;
    $html='';
    $message = "error";      
    if($catId!="" && $s!=""){
      $total = $media = Media::whereRaw("find_in_set($resquest->catId,cat_ids)")->where('title','like','%'.$s.'%')->count();
      if($total > $current){                
        $media = Media::whereRaw("find_in_set($resquest->catId,cat_ids)")->where('title','like','%'.$s.'%')->offset($current)->limit($limit)->latest()->get();
        $current = $current + count($media);
        $html = '';
        foreach ($media as $item):
          $path = url('/').'/image/'.$item->image_path.'/150/100';
          $html .='<li id="image-'.$item->id.'"><div class="wrap"><img src="'.$path.'" alt="'.$item->image_path.'" data-date="'.$item->updated_at.'" data-image="'.url('public/uploads').'/'.$item->image_path.'" /></div></li>';
        endforeach;
        $message = "success";
      }
    }else if($catId!=""){
      $total = Media::whereRaw("find_in_set($resquest->catId,cat_ids)")->count();          
      if($total > $current){                
        $media = Media::whereRaw("find_in_set($resquest->catId,cat_ids)")->offset($current)->limit($limit)->latest()->get();
        $current = $current + count($media);
        $html = '';
        foreach ($media as $item):
          $path = url('/').'/image/'.$item->image_path.'/150/100';
          $html .='<li id="image-'.$item->id.'"><div class="wrap"><img src="'.$path.'" alt="'.$item->image_path.'" data-date="'.$item->updated_at.'" data-image="'.url('public/uploads').'/'.$item->image_path.'" /></div></li>';
        endforeach;
        $message = "success";
      }
    }else if($s!=""){
      $total = $media = Media::where('title','like','%'.$s.'%')->count();
      if($total > $current){        
        $media = Media::where('title','like','%'.$s.'%')->offset($current)->limit($limit)->latest()->get();
        $current = $current + count($media);
        $html = '';
        foreach ($media as $item):
          $path = url('/').'/image/'.$item->image_path.'/150/100';
          $html .='<li id="image-'.$item->id.'"><div class="wrap"><img src="'.$path.'" alt="'.$item->image_path.'" data-date="'.$item->updated_at.'" data-image="'.url('public/uploads').'/'.$item->image_path.'" /></div></li>';
        endforeach;
        $message = "success";
      }
    }else{
      $total = $media = Media::count();
      if($total > $current){        
        $media = Media::offset($current)->limit($limit)->latest()->get();  
        $current = $current + count($media);
        $html = '';
        foreach ($media as $item):
          $path = url('/').'/image/'.$item->image_path.'/150/100';
          $html .='<li id="image-'.$item->id.'"><div class="wrap"><img src="'.$path.'" alt="'.$item->image_path.'" data-date="'.$item->updated_at.'" data-image="'.url('public/uploads').'/'.$item->image_path.'" /></div></li>';
        endforeach;
        $message = "success";
      }  
    }
    return response()->json(['message'=>$message,'html'=>$html,'total'=>$total,'limit'=>$limit,'current'=>$current]);
  }
}