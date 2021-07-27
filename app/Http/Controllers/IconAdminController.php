<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Icon;
use Validator;

class IconAdminController extends Controller
{
	public function create(Request $request){
		//validate
        $list_rules = [];
        $list_rules['title'] = 'required';

		$validator = Validator::make($request->all(), $list_rules, Icon::getMessageRule());

		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        //action DB
        $icon = new Icon;
        $icon->title = $request->title;
        $icon->type = $request->type;
        if($request->pink_icon)
        	$icon->pink_icon = $request->pink_icon;
       	$icon->save();

       	$data_return = [];
       	$data_return['success'] = 'Add to success.';
       	if($request->url_return)
       		$data_return['url'] = $request->url_return;

        return response()->json($data_return);
	}

	public function update($id, Request $request){
		//validate
        $list_rules = [];
        $list_rules['title'] = 'required';

		$validator = Validator::make($request->all(), $list_rules, Icon::getMessageRule());

		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        
        //action DB
        $icon = Icon::findOrFail($id);
        $icon->title = $request->title;
        if($request->pink_icon)
        	$icon->pink_icon = $request->pink_icon;
       	$icon->save();

       	$data_return = [];
       	$data_return['success'] = 'Update to success.';

        return response()->json($data_return);
	}


}