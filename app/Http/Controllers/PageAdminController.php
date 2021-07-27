<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Pages;
use App\GroupMetas;
use App\Metas;
use App\User;
use App\Seo;
use App\Options;
use App\PageMeta;

class PageAdminController extends Controller
{
    public function index(){    	
    	$pages = Pages::orderBy('updated_at', 'desc')->paginate(14);
        return view('backend.page.list',['pages'=>$pages]);        
    }
    
    public function store(){    	
    	return view('backend.page.create');
    }

    public function create(Request $request){    	
    	$message = "error";
        if($request->ajax()){
        	$user = Auth::User();
        	$page = new Pages;
            $page->title = $request->title;
        	$page->slug = $request->title;
        	$page->content = $request->content;
        	$page->user_id = $user->id;
        	if($page->save()){
                $seo = new Seo;
                $seo->key = $request->metaKey;
                $seo->value = $request->metaValue;                
                $seo->type = 'page';
                $seo->post_id = $page->id;
                $seo->save();
            }
            $message = "success";
        }
        return $message;
    }
    
    public function edit($id){
        $page = Pages::find($id);
        $seo = get_seo($id,'page');
        $option = Options::select('page_id','show_gallery')->first();
        $zzz= json_decode($option->page_id);
        $show_gallery= json_decode($option->show_gallery);
        $pageMeta = PageMeta::where('page_id',$id)->where('meta_key','sustainability')->first();
        $pageMutual = PageMeta::where('page_id',$id)->where('meta_key','mutual')->first();
        $pageSupport = PageMeta::where('page_id',$id)->where('meta_key','support')->first();
        $data = [
            'page' => $page,
            'seo'=>$seo, 
            'zzz'=>$zzz,
            'show_gallery'=>$show_gallery,
            'pageMeta'=>$pageMeta,
            'pageMutual'=>$pageMutual,
            'pageSupport'=>$pageSupport,
        ];
    	return view('backend.page.edit',$data);
    }

    public function update(Request $request, $id){
        $message = "error";
        if($request->ajax()){
            $page = Pages::find($id);
            $page->title = $request->title;
            $page->slug = $request->title;
            $page->content = $request->content;
            $page->image = $request->image;
            $page->gallery = $request->array_gallery;
            if($page->save()){
                $metaFields = json_decode($request->metaFields); 
                if(count($metaFields)>0):
                    foreach ($metaFields as $item) {   
                        $meta = Metas::find($item->id);
                        $meta->content = $item->content;
                        $meta->save();
                    }
                endif;
                $seo = Seo::where('post_id',$id)->where('type','page')->first();
                if(!$seo){
                    $seo = new Seo;
                }
                $seo->key = $request->metaKey;
                $seo->value = $request->metaValue;                
                $seo->type = 'page';
                $seo->post_id = $id;
                $seo->save();
                /* Update page meta*/
                $attr_items = $request->attr_items; 
                if(isset($attr_items) && count($attr_items) > 0) {
                    $pageMeta = PageMeta::firstOrcreate(['meta_key'=>'sustainability', 'page_id'=>$id ]);
                    PageMeta::where('id',$pageMeta->id)->update(['meta_value'=> json_encode($attr_items)]);
                }
                $attr_mutual = $request->attr_mutual;
                if(isset($attr_mutual) && count($attr_mutual) > 0) {
                    $pageMeta = PageMeta::firstOrcreate(['meta_key'=>'mutual', 'page_id'=>$id ]);
                    PageMeta::where('id',$pageMeta->id)->update(['meta_value'=> json_encode($attr_mutual)]);
                }
                $attr_support = $request->attr_support;
                if(isset($attr_support) && count($attr_support) > 0) {
                    $pageMeta = PageMeta::firstOrcreate(['meta_key'=>'support', 'page_id'=>$id ]);
                    PageMeta::where('id',$pageMeta->id)->update(['meta_value'=> json_encode($attr_support)]);
                }

            }
            $message = "success";
        }
        return $message;
    }
	public function delete($id){
        $seo = Seo::where('post_id',$id)->where('type','page');
        if($seo) $seo->delete();
    	$page = Pages::find($id);
    	$page->delete();
    	return redirect('/admin/pages/')->with('success','Xóa thành công');
    }
}