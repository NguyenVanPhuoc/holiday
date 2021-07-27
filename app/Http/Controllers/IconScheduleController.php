<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\IconsDetailSchedules;
use App\CatIconSchedules;

class IconScheduleController extends Controller{
	public function index(){
		$iconSchedules = IconsDetailSchedules::orderBy('created_at', 'desc')->paginate(14);
		return view('backend.iconSchedule.list', ['iconSchedules'=>$iconSchedules]);
	}
	public function store(){
		$categories = CatIconSchedules::orderBy('created_at', 'desc')->get();
		return view('backend.iconSchedule.create', ['categories'=>$categories]);
	}

	public function create(Request $request){
		if($request->ajax()){
			$icon = new IconsDetailSchedules;
			$icon->title = $request->title;
			$icon->icon = $request->icon;
			$icon->white_icon = $request->white_icon;
			$icon->yellow_icon = $request->yellow_icon;
			$icon->cat_id = $request->cat_id;
			$icon->save();
			return response()->json(['msg'=>'success']);
		}
		return response()->json(['msg'=>'error']);
	}

	public function edit($id){
		$categories = CatIconSchedules::orderBy('created_at', 'desc')->get();
		$icon = IconsDetailSchedules::find($id);
		return view('backend.iconSchedule.edit', ['categories'=>$categories, 'icon'=>$icon]);
	}

	public function update(Request $request, $id){
		if($request->ajax()){
			$icon = IconsDetailSchedules::find($id);
			$icon->title = $request->title;
			$icon->icon = $request->icon;
			$icon->white_icon = $request->white_icon;
			$icon->yellow_icon = $request->yellow_icon;
			$icon->cat_id = $request->cat_id;
			$icon->save();
			return response()->json(['msg'=>'success']);
		}
		return response()->json(['msg'=>'error']);
	}
	public function delete($id){
		$icon = IconsDetailSchedules::find($id);
        $icon->delete();
        return redirect()->route('iconSchedules')->with('success','Xóa thành công');
	}

	//deleteAll
    public function deleteAll(Request $resquest){
        $message = "error";
        if($resquest->ajax()){
            $items = json_decode($resquest->items);
            if(count($items)>0){
                IconsDetailSchedules::destroy($items);
            }
            $message = "success";
        }
        return $message;
    }
     public function searchIconSchedules(Request $request){
        $s = $request->s;
        $category = $request->category;
        $iconSchedules = IconsDetailSchedules::query();
        if($s != ''){
            $iconSchedules = $iconSchedules->where('icons_detail_schedules.title','like','%'.$s.'%');
        }
        if($category != ''){
            $iconSchedules = $iconSchedules->join('cat_icon_schedules','icons_detail_schedules.cat_id','=','cat_icon_schedules.id')
            			->where('icons_detail_schedules.cat_id', $category);
        }
        $iconSchedules = $iconSchedules->select('icons_detail_schedules.*')->orderBy('created_at', 'desc')->paginate(14);
        return view('backend.iconSchedule.list', ['iconSchedules'=>$iconSchedules, 's'=>$s, 'category'=>$category]);
    }
}
