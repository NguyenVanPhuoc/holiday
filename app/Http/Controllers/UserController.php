<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User;
use App\Media;

class UserController extends Controller
{
	public function index(){
        $users = User::latest()->paginate(14);
    	return view('backend.user.list',['users'=>$users]);
    }    
    //view all
    public function getUserByLevel($level){
    	$users = User::where('level', '=', $level)->latest()->paginate(14);
    	return view('backend.user.list',['users'=>$users]);
    }

   //add user
    public function store(){        
    	return view('backend.user.create');
    }

    public function create(Request $request){
    	$this->validate($request,[
    		'name'=>'required',
            'email'=>'required|email|unique:users,email',
    		'phone'=>'required|unique:users,phone',
    		'password'=>'required|min:3|max:32',
            'confirmPassword'=>'required|same:password',
    		'role'=>'required',
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
            'confirmPassword.same'=>'Mật khẩu nhập lại chưa khớp',
    		'role'=>'Vui lòng chọn vai trò.',
    	]);        
    	$user = new User;
        $user->name = $request->name;
    	$user->slug = $request->name;
    	$user->phone = $request->phone;
    	$user->email = $request->email;
        if($request->sex!="") $user->sex = $request->sex;    	
    	$user->password = bcrypt($request->password);
    	$user->level = $request->role;
        if($request->image!="") $user->image = $request->image;
    	$user->save();    	
    	$request->session()->flash('success', 'Thêm thành công');
    	return view('backend.user.create');
    }

    //edit user
    public function edit($id){
    	$user = User::find($id);
    	return view('backend.user.edit',['user'=>$user]);    	
    }

    public function update(Request $request, $id){
    	$this->validate($request,[
            'name'=>'required',
            'sex'=>'required',
    		'role'=>'required',
    	],[
            'name.required'=>'Vui lòng nhập họ & tên.',
            'sex.required'=>'Vui lòng chọn giới tính.',
    		'role.required'=>'Vui lòng chọn vai trò.',
    	]);
    	$user = User::find($id);
    	$user->name = $request->name;
    	$user->phone = $request->phone;    	
        $user->sex = $request->sex;
    	$user->level = $request->role;
        if($user->phone != $request->phone){
            $this->validate($request,[
                'phone' => 'required|unique:users',
            ],[
                'phone.unique'=>'Số điện thoại đã tồn tại trong hệ thống.',
            ]);
        }
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
    	return redirect('/admin/users/edit/'.$user->id);
    }

    public function media(Request $request){
        if($request->ajax()){
            $html = media();
            return json_encode($html);
        }
        return 'error';
    }
    //delete user
    public function delete($id){
    	$user = User::find($id);
    	$user->delete();
    	return redirect('a/users')->with('success','Xóa thành công');
    }
}
