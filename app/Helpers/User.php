<?php
use App\User;
use App\UserMetaMetas;

//check login 
if(!function_exists('checkLogin')){
	function checkLogin(){
		return Auth::check();
	}
}

//get current user
if(!function_exists('getCurrentUser')){
	function getCurrentUser(){
		if(Auth::check()){
			$user = Auth::User();
			return $user;
		}
		return;
	}
}

//get current user
if(!function_exists('getCurrentUser')){
	function getCurrentUser(){
		if(Auth::check()){
			$user = Auth::User();
			return $user;
		}
		return;
	}
}

/**
* get user meta in UserMetaMetas
* @param $user_id, $meta_key
* @return $meta_value
*/
if(!function_exists('getUserMetaMetas')) {
	function getUserMetaMetas($user_id,$meta_key) {
		$res = UserMetaMetas::select('meta_value')->where(['user_id'=>$user_id, 'meta_key'=>$meta_key])->first();
		if($res) return $res->meta_value;
			else return FALSE;
	}
}

/**
* create/update user meta in UserMetaMetas
* @param $user_id, $meta_key, $meta_value
* @return success/fail
*/
if(!function_exists('updateUserMetaMetas')) {
	function updateUserMetaMetas($user_id, $meta_key, $meta_value) {
		$res = UserMetaMetas::firstOrCreate(array('user_id'=>$user_id, 'meta_key'=>$meta_key));
		if($res) {
			UserMetaMetas::where('id', $res->id)->update(array('meta_value'=>$meta_value));
			return TRUE;
		}else return FALSE;
	}
}

/**
* Display option of all user (role == admin || role == mod)
* @return html
*/
if(!function_exists('displayOptionModUser')) {
	function displayOptionModUser($array=array()) {
		$users = User::select('id', 'name', 'level')->where('level','admin')->orWhere('level', 'mod')->get();
		$html = '';
		if($users)
			foreach ($users as $user) {
				// $title = (getUserMetaMetas($user->id,'degree') ? getUserMetaMetas($user->id,'degree').' ' : '').$user->name.(getUserMetaMetas($user->id,'regency') ? ' -'.getUserMetaMetas($user->id,'regency') : '');
				$title = (getUserMetaMetas($user->id,'degree') ? getUserMetaMetas($user->id,'degree').' - ' : '').$user->name;
				$html .= '<option value="'.$user->id.'"'.(count($array) > 0 && in_array($user->id, $array) ? 'selected' : '').'>'.$title.'</option>';
			}
		return $html;	
	}
}

/**
* Display Invitee by user_id
* @param $user_id
* @return html
*/
if(!function_exists('displayInviteeById')) {
	function displayInviteeById($user_id) {
		$user = User::find($user_id);
		$html = '';
		if($user) {
			$html .= '<div class="info">';
                $html .= image($user->image,62,62,$user->name);
                $html .= '<div class="desc">';
                    $html .= '<h4 class="name"><small>Khách mời:</small> ';
                    if(getUserMetaMetas($user->id, 'degree')) $html .= '<span>'.getUserMetaMetas($user->id, 'degree').'</span>';
                    $html .= $user->name.'</h4>';
                    if(getUserMetaMetas($user->id, 'regency')) $html .= '<p class="job">'.getUserMetaMetas($user->id, 'regency').'</p>';
                $html .= '</div>';
            $html .= '</div>';
		}
		return $html;
	}
}