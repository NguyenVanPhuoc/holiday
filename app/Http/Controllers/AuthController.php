<?php
namespace App\Http\Controllers;
use Validator, Input, Redirect; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User;
use App\UserMetas;
use App\Media;
use Illuminate\Support\Facades\Mail;
use App\ArticleCat;
use App\Article;

class AuthController extends Controller
{
    public function login(){
        if(Auth::check()){
            $user = Auth::User();
            if($user->level == "admin")
                return redirect('admin');
            else
                return redirect()->back();
        }        
        return view('login');
    }

    public function logout(){
        Auth::logout();
        return redirect(url('/'));
    }
    
    public function postLogin(Request $request){        
        if($request->ajax()):
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->pass])){
                $user = Auth::User();    
                if($user->level=="admin")
                    $url = url('admin');
                else
                    $url = url('/');
                return response()->json(['message'=>'success','url'=>$url]);
            }else{
                return response()->json(['message'=>'error']);
            }
        endif;        
    }

    public function register(){
        if(Auth::check()){
            if($user->level == "admin")
                return redirect('admin');
            else
                return redirect()->back();
        }
        return view('register');
    }
    public function postRegister(Request $request){               
        if($request->ajax()):
            $data = array();
            $data['_token'] = $request->token;
            //$data['captcha'] =  $request->captcha;
            $data['email'] =  $request->email;
            $validator = Validator::make($data,[
                //'captcha' => 'captcha',
                'email' => 'unique:users,email'
            ],[ 
                //'captcha.captcha'=>'Captcha không đúng, hãy thử lại captcha khác.',
                'email.unique'=>'Email đã tồn tại.',
            ]);
            if ($validator->passes()){
                $user = new User;
                $user->name = $request->name;
                $user->slug = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->pass);
                $user->level = 'member';                        
                if($user->save()){
                    $content = '<ul>';
                    $content .= '<li>Họ & tên: '.$request->name.'</li>';                    
                    $content .= '<li>Email: '.$request->email.'</li>';
                    $content .= '</ul>';
                    $data = array( 'email' => $request->email, 'name' => $request->name, 'from' => mailSystem(), 'message'=> $content);
                    /*Mail::send( 'mails.admin.register', compact('data'), function( $message ) use ($data){
                        $message->to(mailSystem())
                                ->from( $data['email'], $data['name'] )
                                ->subject('[Đăng ký thành viên] - '.$data['name']);
                    });*/
                }
                return response()->json(['message'=>'success']);               
            }else{
               return response()->json(['message'=>'error','error'=>$validator->errors()->all()]);
            }            
        endif;        
    }
    
    public function postResetPassword(Request $request){
        $this->validate($request,[
            'phone'=>'required',
            ],[
            'phone.required'=>'Vui lòng số điện thoại hoặc email'
            ]);
        $message = "<div class='alert alert-success'>Khôi phục thành công, mật khẩu mới đã chuyển vào email của bạn.</div>";
        $phone = trim($request->phone);
        $password = get_Otp();
        if(is_numeric($phone))
            $user = User::where("phone",$request->phone)->first();
        else
            $user = User::where("email",$request->phone)->first();
        
        if($user != NULL){
            $user->password = bcrypt($password);
            $user->save();
            $content = "Mật khẩu mới của bạn: ".$password;
            if(is_numeric($phone)){
                $postcode = aic_Send_SMS(trim($_POST['phone']),$content);
                if($postcode=="success")               
                    $message = "<div class='alert alert-success'>Khôi phục thành công, mật khẩu mới đã chuyển vào số phone của bạn.</div>";
                else
                    $message = "<div class='alert alert-danger'>Khôi phục thất bại, hệ thống đang bảo trì. Vui lòng thử lại sau!</div>";
            }else{                
                $data = array( 'email' => $user->email, 'name' => $user->name, 'from' => mailSystem(), 'address'=>address(), 'content'=> $content);
                Mail::send( 'mails.reset_password', compact('data'), function( $message ) use ($data)
                {
                    $message->to( $data['email'] )
                            ->from( $data['from'], $data['name'] )
                            ->subject( 'Phục hồi mật khẩu' );
                });
                $message = "<div class='alert alert-success'>Khôi phục thành công, mật khẩu mới đã chuyển vào email của bạn.</div>";
            }
        }else{
            $message = "<div class='alert alert-danger'>Số điện thoại hoặc email <strong>".$request->phone."</strong> không tồn tại trong hệ thống.</div>";
        }
        
        return redirect('/reset')->with(['message'=>$message]); 
    }
    //change password
    public function editPassword(){
        $user = Auth::User();          
        return view('members.password',['user'=>$user]); 
    }    
    public function updatePassword(Request $request){
        $this->validate($request,[
            'oldPass'=>'required',
            'newPass'=>'required',
            'confirmPass'=>'required',
            ],[
            'oldPass.required'=>'Bạn chưa nhập mật khẩu cũ.',
            'newPass.required'=>'Bạn chưa nhập mật khẩu mới.',
            'confirmPass.required'=>'Bạn chưa nhập lại mật khẩu.',
        ]);
        $user = Auth::User();
        $checkPass = password_verify($request->oldPass, $user->password);
        if($checkPass){
            $user->password = bcrypt($request->newPass);
            $user->save();
            $request->session()->flash('success','Đổi mật khẩu thành công.');
        }else{            
            $request->session()->flash('error','Mật khẩu cũ không đúng.');
        }
        return redirect('/profile/password');
    }

    public function profile(){
        $user = Auth::User();
        return view('members.profile',['user'=>$user]);
    }
    public function editAccount(){
        $user = Auth::User();
        return view('members.profile_edit',['user'=>$user]);
    }
    public function updateAccount(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'sex'=>'required',
            ],[
            'name.required'=>'Bạn chưa nhập họ & tên',
            'sex.required'=>'Bạn chưa chọn giới tính'
        ]);
        $user = Auth::User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->sex = $request->sex;
        $user->address = $request->address;
        if($user->save()){
            $userMeta = UserMetas::where('user_id',$user->id)->first();
            if(empty($userMeta)){
                $userMeta = new UserMetas;
                $userMeta->user_id = $user->id;
            }
            $userMeta->about = $request->about;
            $userMeta->save();
        }
        $request->session()->flash('success', '<div class="alert alert-success">Cập nhật thành công</div>');
        return redirect('/profile/edit');        
    }    
    //media account
    public function mediaProfile(){
        $user = Auth::User();
        $media = Media::where('user_id',$user->id)->latest()->paginate(14);
        return view('members.media',['media'=>$media]);
    }    
    /**
     * news     
     */
    public function storeNews(){
        if(Auth::check()){
            $user = Auth::User();
            $blogs = Article::where('user_id',$user->id)->latest()->paginate(14);
            return view('members.profile_news',['blogs'=>$blogs]);
        }
        return redirect('/');
    }
    //create
    public function createNews(){
        if(Auth::check()){
            return view('members.profile_createNews');
        }
        return redirect('/');
    }
    public function editNews($id){
        if(Auth::check()){
            $user = Auth::User();
            $article = Article::where('id',$id)->where('user_id',$user->id)->first();
            $seo = get_seo($article->id,'article');
            return view('members.profile_editNews',['article'=>$article,'seo'=>$seo]);
        }
        return redirect('/');
    }  
}
