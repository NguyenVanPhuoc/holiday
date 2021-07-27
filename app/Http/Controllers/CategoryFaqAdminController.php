<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CategoryFaq;
use Validator;

class CategoryFaqAdminController extends Controller
{

	public function index(){
		$list_cat = CategoryFaq::orderBy('position', 'asc')->get();
		$data = [
			'list_cat' => $list_cat
		];
		return view('backend.catFaqs.list', $data);
	}

	public function store(){
		return view('backend.catFaqs.create');
	}

	public function create(Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all()]);

        $max_position = CategoryFaq::max('position');
        $request['position'] = ($max_position != NULL) ? $max_position : 1;
        $catFaq = CategoryFaq::create($request->only('title', 'position', 'white_icon', 'yellow_icon'));
        return response()->json(['success' => 'Add to success.', 'url' => route('storeCategoryFaqAdmin')]);

	}

	public function edit($id){
		$catFaq = CategoryFaq::findOrFail($id);
		$data = [
			'catFaq' => $catFaq
		];
		return view('backend.catFaqs.edit', $data);
	}

	public function update($id, Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all()]);

        CategoryFaq::where('id', $id)->update($request->only('title', 'white_icon', 'yellow_icon'));
        return response()->json(['success' => 'Update to success.', 'url' => route('editCategoryFaqAdmin', $id)]);
	}

	public function delete($id){
		CategoryFaq::where('id', $id)->delete();
		return redirect()->route('catFaqsAdmin')->with('success', 'Delete successfull.');
	}
}