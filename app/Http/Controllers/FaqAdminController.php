<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Faq;
use App\CategoryFaq;
use Validator;

class FaqAdminController extends Controller
{

	public function index(Request $request){
		$cat = $request->cat_id;
		$s =  $request->s;
		if($request->ajax()){
			$list_faq = Faq::query();
			if($s != ''){
	            $list_faq = $list_faq->where('title','like','%'.$s.'%');
	        }
	        if($cat != ''){
	            $list_faq = $list_faq->where('cat_id', $cat);
	        }
	        $list_faq = $list_faq->orderBy('position', 'asc')->orderBy('created_at', 'desc')->paginate(14);
            $html = view('backend.faqs.table', ['list_faq' => $list_faq])->render();
            return response()->json(['html' => $html]);
	    }
		$list_faq = Faq::query();
		if($s != ''){
            $list_faq = $list_faq->where('title','like','%'.$s.'%');
        }
        if($cat != ''){
            $list_faq = $list_faq->where('cat_id', $cat);
        }
		$list_faq = $list_faq->select('faqs.*')->orderBy('created_at', 'desc')->paginate(14);
		$list_cat = CategoryFaq::orderBy('title', 'asc')->get();
		
		$data = [
			'list_faq' => $list_faq,
			'list_cat' => $list_cat,
		];
		return view('backend.faqs.list', $data);
	}

	public function store(){
		$list_cat = CategoryFaq::orderBy('title', 'asc')->get();
		$data = [
			'list_cat' => $list_cat
		];
		return view('backend.faqs.create', $data);
	}

	public function create(Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all()]);

        $max_position = Faq::where('cat_id', $request->cat_id)->max('position');
        $request['position'] = ($max_position != NULL) ? $max_position : 1;
        $catFaq = Faq::create($request->only('title', 'content', 'position', 'cat_id', 'most_asked'));

       /* $faqs = new Faq;
        $faqs->title = $request->title;
        $faqs->content = $request->content;
        $faqs->position = $request->position;
        $faqs->cat_id = json_encode($request->cat_id);
        $faqs->save();*/
        return response()->json(['success' => 'Add to success.', 'url' => route('storeFaqAdmin')]);
	}

	public function edit($id){
		$faq = Faq::findOrFail($id);
		$list_cat = CategoryFaq::orderBy('title', 'asc')->get();
		$data = [
			'faq' => $faq,
			'list_cat' => $list_cat,
		];
		return view('backend.faqs.edit', $data);
	}

	public function update($id, Request $request){
		$list_rules = [];
        $list_rules['title'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all()]);

        Faq::where('id', $id)->update($request->only('title', 'content', 'position', 'cat_id', 'most_asked'));
        return response()->json(['success' => 'Update to success.', 'url' => route('updateFaqAdmin', $id)]);
	}

	public function delete($id){
		Faq::where('id', $id)->delete();
		return redirect()->route('faqsAdmin')->with('success', 'Delete successfull.');
	}

	public function deleteAll(Request $request){
		if($request->ajax()){
			$items = json_decode($request->items);
            if(count($items)>0){
                Faq::destroy($items);
            }
            $list_faq = filterFaq($request, 14, 1);
            $html = view('backend.faqs.table', ['list_faq' => $list_faq])->render();
			return response()->json(['html' => $html]);
		}
	}
	
}