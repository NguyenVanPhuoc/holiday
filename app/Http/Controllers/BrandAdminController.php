<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Brand;
use App\User;
use App\Media;

class BrandAdminController extends Controller
{
	public function index(){    	
    	$brands = Brand::orderBy('created_at', 'desc')->paginate(14);
    	return view('backend.brands.list',['brands'=>$brands]);
    }
    
    public function store(){    	
    	return view('backend.brands.create');
    }

    public function create(Request $request){
        $message = "error";
        if($request->ajax()):        	
        	$brand = new Brand;
            $brand->title = $request->title;
        	$brand->slug = $request->title;
            $brand->link = $request->link;
        	$brand->image = $request->image;
        	$brand->save();
            $message = "success";
    	endif;
        return $message;
    }
    
    public function edit($id){
        $brand = Brand::find($id); 
    	return view('backend.brands.edit',['brand'=>$brand]);
    }

    public function update(Request $request, $id){    	
    	$message = "error";
        if($request->ajax()):           
            $brand = Brand::find($id);
            $brand->title = $request->title;
            $brand->slug = $request->title;
            $brand->link = $request->link;
            $brand->image = $request->image;
            $brand->save();
            $message = "success";
        endif;
        return $message;     
    }
	public function delete($id){
    	$brand = Brand::find($id);
    	$brand->delete();
    	return redirect('/admin/brands/')->with('success','Xóa thành công');
    }
}
