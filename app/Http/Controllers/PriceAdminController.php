<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Prices;
use App\PriceMetas;

class PriceAdminController extends Controller
{
    public function index(){
        $prices = Prices::orderBy('updated_at', 'desc')->paginate(14);
        return view('backend.price.list',['prices'=>$prices]);
    }
    public function store(){        
        return view('backend.price.create');
    }

    public function create(Request $request){
        $this->validate($request,[
            'title'=>'required',
            'price'=>'required',
            'driver_type'=>'required'
        ],[
            'title.required'=>'Bạn chưa nhập tiêu đề',
            'price.required'=>'Bạn chưa nhập giá',
            'min_price.required'=>'Bạn chưa nhập mức giá tối thiểu'
        ]);
        if($request->driver_type == ""){
           $this->validate($request,[
                'driver_type'=>'required',
            ],[
                'driver_type.required'=>'Bạn chọn loại xe',
            ]);
        }

        $price = new Prices;
        $price->title = $request->title;
        $price->slug = $request->title;        
        $price->price = removeDot($request->price);
        $price->min_price = removeDot($request->min_price);
        $price->driver_type = $request->driver_type;                 
        if($price->save())
            $message = '<div class="alert alert-success">Thêm thành công</div>';
        else
            $message = '<div class="alert alert-danger">Thêm thất bại</div>';

        $request->session()->flash('success', $message);
        return redirect('/admin/prices/them');
    }
    
    public function edit($slug){
        $price = Prices::findBySlug($slug);
        return view('backend.price.edit',['price'=>$price]);
    }

    public function update(Request $request, $slug){
        $this->validate($request,[
            'title'=>'required',
            'price'=>'required',
            'driver_type'=>'required'
        ],[
            'title.required'=>'Bạn chưa nhập tiêu đề',
            'price.required'=>'Bạn chưa nhập giá',
            'min_price.required'=>'Bạn chưa nhập mức giá tối thiểu'
        ]);
        if($request->driver_type == ""){
           $this->validate($request,[
                'driver_type'=>'required',
            ],[
                'driver_type.required'=>'Bạn chọn loại xe',
            ]);
        }

        $price = Prices::findBySlug($slug);
        $price->title = $request->title;
        $price->slug = $request->title;        
        $price->price = removeDot($request->price);
        $price->min_price = removeDot($request->min_price);
        $price->driver_type = $request->driver_type;                 
        if($price->save())
            $message = '<div class="alert alert-success">Cập nhật thành công</div>';
        else
            $message = '<div class="alert alert-danger">Cập nhật thất bại</div>';

        $request->session()->flash('success', $message);
        return redirect('/admin/prices/sua/'.$price->slug);
    }

    //update slug
    public function updateSlug(Request $request){
       if($request->ajax()){
            $price = Prices::find($request->id);
            $price->slug = $request->slug;
            $price->save();
            return $price->slug;
        }
        return 'error';
    }
    
    public function delete($id){
        $price = Prices::find($id);
        $price->delete();
        return redirect('/admin/prices/')->with('success','Xóa thành công');
    }

    public function deleteMeta(Request $request){
        if($request->ajax()){
            $meta = PriceMetas::find($request->id);
            $meta->delete();
            return 'success';
        }        
        return 'error';        
    }
}
