<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Options;
use App\Media;
use App\User;

class OptionsAdminController extends Controller
{
    public function index(){        
        $option = Options::find(2);
        return view('backend.option.system',['option'=>$option]);
    }
    
    public function socialMedia(){      
        //$option = Options::select('facebook','youtube','google','twitter','instagram')->first();
        $option = Options::select('social_media')->find(2);
        return view('backend.option.socialMediav2',['option'=>$option]);

    }

    public function updateSystem(Request $request){
        $option = Options::find(2);
        if($request->logo != "") $option->logo = $request->logo;
        if($request->logo_colorful != "") $option->logo_colorful = $request->logo_colorful;
        if($request->favicon != "") $option->favicon = $request->favicon;            
        if($request->logo_sonabee != "") $option->logo_sonabee = $request->logo_sonabee;            
        $option->title = $request->title;
        $option->phone = $request->phone;
        $option->email = $request->email;
        $option->address = $request->address;
        $option->copyright = $request->copyright;
        $option->page_id = json_encode($request->page_id);        
        $option->show_gallery = json_encode($request->show_gallery);        
        $option->save();  
        $request->session()->flash('success', 'Sửa thành công');
        return redirect('/admin/setting/option/');
    }
    
    public function media(Request $request){
        if($request->ajax()){
            $html = media();
            return json_encode($html);    
        }
        return 'error';
    }
    public function updateSocial(Request $request){
        $option = Options::find(2);
        $option->facebook = $request->facebook;
        $option->youtube = $request->youtube;
        $option->google = $request->google;
        $option->twitter = $request->twitter;
        $option->instagram = $request->instagram;
        $option->save();
        $request->session()->flash('success', 'Sửa thành công');
        return redirect('/admin/setting/social-media/');
    }

    public function updateSocialv2(Request $request){
        $option = Options::find(2);
        $zzz = array();
        $data = array();
        $data['name'] = 'Facebook';
        $data['link'] = $request->Facebook;
        $data['image'] = $request->Facebook_img;
        $zzz[] = json_encode($data);
        $data['name'] = 'Instagram';
        $data['link'] = $request->Instagram;
        $data['image'] = $request->Instagram_img;
        $zzz[] = json_encode($data);
        $data['name'] = 'Pinterest';
        $data['link'] = $request->Pinterest;
        $data['image'] = $request->Pinterest_img;
        $zzz[] = json_encode($data);
        $data['name'] = 'Youtube';
        $data['link'] = $request->Youtube;
        $data['image'] = $request->Youtube_img;
        $zzz[] = json_encode($data);
        $data['name'] = 'Twitter';
        $data['link'] = $request->Twitter;
        $data['image'] = $request->Twitter_img;
        $zzz[] = json_encode($data);
        $data['name'] = 'Tripadvisor';
        $data['link'] = $request->Tripadvisor;
        $data['image'] = $request->Tripadvisor_img;
        $zzz[] = json_encode($data);
        $data['name'] = 'Routard';
        $data['link'] = $request->Routard;
        $data['image'] = $request->Routard_img;
        $zzz[] = json_encode($data);
        $data['name'] = 'Petitfute';
        $data['link'] = $request->Petitfute;
        $data['image'] = $request->Petitfute_img;
        $zzz[] = json_encode($data);
        Options::where('id', $option->id)->update(['social_media' => implode(';',$zzz)]);
        $request->session()->flash('success', 'Sửa thành công');
        return redirect(route('settingSocial'));

    }
}