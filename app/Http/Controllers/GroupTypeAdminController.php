<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Media;
use App\GroupType;
use Validator;


class GroupTypeAdminController extends Controller
{
	public function index(){
		$list_groupType = GroupType::latest()->paginate();
		$data = [];
		$data['list_groupType'] = $list_groupType;
		return view('backend.groupTypes.list', $data);
	}

	public function store(){
		return view('backend.groupTypes.create');
	}

	public function create(Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, GroupType::getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        $request['slug'] = $request->title;
        GroupType::create($request->all());

        return response()->json(['success' => 'Add to success.', 'url' => route('storeGroupTypeAdmin')]);

	}	

	public function edit($slug){
		$group_type = GroupType::findBySlug($slug);
		$data = [];
		$data['group_type'] = $group_type;
		return view('backend.groupTypes.edit', $data);
	}

	public function update($slug, Request $request){
		$group_type = GroupType::findBySlug($slug);

		$list_rules = [];
        $list_rules['title'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, GroupType::getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        $request['slug'] = str_slug($request->title, '-');
        $group_type->update($request->only('title', 'slug'));

        return response()->json(['success' => 'Update to success.', 'url' => route('updateGroupTypeAdmin', $group_type->slug)]);
	}

	public function delete($id){
        $country = GroupType::find($id);
        $country->delete();
        return redirect()->route('groupTypesAdmin')->with('success','Deleted successfull.');
    }

    //deleteAll
    public function deleteAll(Request $resquest){
        $msg = "error";
        if($resquest->ajax()){
            $items = json_decode($resquest->items);
            if(count($items)>0){
                GroupType::destroy($items);
            }
            $msg = "success";
        }
        return $msg;
    }
}