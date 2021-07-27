<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Media;
use App\User;
use App\UserMetas;

class CustomerAdminController extends Controller
{
	public function index(){
        $users = User::where('level','=','customer')->latest()->paginate(14);		
    	return view('backend.customer.list', ['users'=>$users]);
    }

   //add user
    public function store(){
    	return view('backend.customer.add');
    }

    public function create(Request $request){
    	$this->validate($request,[
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'phone'=>'required|unique:users,phone',
            'password'=>'required|min:3|max:32',
            'confirmPassword'=>'required|same:password'
        ],[
            'name.required'=>'Bạn chưa nhập họ & tên',
            'email.required'=>'Bạn chưa nhập email',
            'email.email'=>'Email không đúng định dạng(ví dụ: lqviet.it@gmail.com)',
            'email.unique'=>'Email đã tồn tại',
            'phone.required'=>'Nhập số điện thoại',
            'phone.unique'=>'Số điện thoại đã tồn tại',
            'password.required'=>'Bạn chưa nhập mật khẩu',
            'password.min'=>'Mật khẩu ít nhất 3 kí tự',
            'password.max'=>'Mật khẩu tối đa 32 kí tự',
            'confirmPassword.required'=>'Bạn chưa nhập lại mật khẩu',
            'confirmPassword.same'=>'Mật khẩu nhập lại chưa khớp'
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->slug = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->sex = $request->sex;
        $user->password = bcrypt($request->password);
        $user->level = 'customer';
        if($request->image!="") $user->image = $request->image;
        $user->save();      
        $request->session()->flash('success', 'Thêm thành công');
        return view('backend.customer.add');
    }

    //edit user
    public function edit($slug){
        $user = User::findBySlug($slug);
        return view('backend.customer.edit',['user'=>$user]);
    }

    public function update(Request $request, $slug){
    	$this->validate($request,[
            'name'=>'required',
        ],[
            'name.required'=>'Bạn chưa nhập họ & tên',
        ]);
        $user = User::findBySlug($slug);
        $user->name = $request->name;
        $user->slug = $request->slug;
        $user->email = $request->email;
        $user->sex = $request->sex; 
        if($request->changePassword=="on"){
            $this->validate($request,[
                'password'=>'required|min:3|max:32',
                'confirmPassword'=>'required|same:password'
            ],[
                'password.required'=>'Bạn chưa nhập mật khẩu',
                'password.min'=>'Mật khẩu ít nhất 3 kí tự',
                'password.max'=>'Mật khẩu tối đa 32 kí tự',
                'confirmPassword.required'=>'Bạn chưa nhập lại mật khẩu',
                'confirmPassword.same'=>'Mật khẩu nhập lại chưa khớp'
            ]);
            $user->password = bcrypt($request->password);
        }              
        if($request->image!="") $user->image = $request->image;
        $user->save();      
        $request->session()->flash('success', 'Sửa thành công');
        return redirect('/admin/khach-hang/sua/'.$user->slug);
    }

    //update slug
    public function updateSlug(Request $request){
       if($request->ajax()){
            $user = User::find($request->id);
            $user->slug = $request->slug;
            $user->save();
            return $user->slug;
        }
        return 'error';
    }

    //delete user
    public function delete($id){
    	$user = User::find($id);
    	$user->delete();
    	return redirect('admin/khach-hang')->with('success','Xóa thành công');
    }
}
