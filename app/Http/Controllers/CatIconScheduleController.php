<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\CatIconSchedules;

class CatIconScheduleController extends Controller{
	public function index(){
		$catIcon = CatIconSchedules::orderBy('created_at', 'desc')->paginate(14);
		return view('backend.catIconSchedule.list', ['catIcon'=>$catIcon]);
	}
	public function store(){
		return view('backend.catIconSchedule.create');
	}
	public function create(Request $request){
		if($request->ajax()){
			$catIcon = new CatIconSchedules;
			$catIcon->title = $request->title;
			$catIcon->save();
			return response()->json(['msg'=>'success']);
		}
		return response()->json(['msg'=>'error']);
	}
	public function edit($id){
		$catIcon = CatIconSchedules::find($id);
		return view('backend.catIconSchedule.edit', ['catIcon'=>$catIcon]);
	}
	public function update(Request $request, $id){
		if($request->ajax()){
			$catIcon = CatIconSchedules::find($id);
			$catIcon->title = $request->title;
			$catIcon->save();
			return response()->json(['msg'=>'success']);
		}
		return response()->json(['msg'=>'error']);
	}
	public function delete($id){
		$catIcon = CatIconSchedules::find($id);
        $catIcon->delete();
        return redirect()->route('catIconSchedules')->with('success','Xóa thành công');
	}
}
