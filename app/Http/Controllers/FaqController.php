<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Faq;
use App\CategoryFaq;
use App\Article;
use App\Pages;

class FaqController extends Controller
{
	public function index(){
		$page = Pages::find(28);
        $seo = get_seo(28,'page');
		$list_faq = Faq::limit(50)->get();
		$list_cat = CategoryFaq::orderBy('position', 'asc')->get();
		$list_blog = Article::orderBy('created_at', 'asc')->paginate(6);
		$list_asked = Faq::where('most_asked',1)->get();
		$data = [
			'list_faq' => $list_faq,
			'list_cat' => $list_cat,
			'list_blog'=> $list_blog,
			'list_asked'=> $list_asked,
			'page'=> $page,
			'seo'=> $seo,
		];
		return view('faq.index', $data);
	}

	public function search(Request $request){
		$request['s'] = $request->keyword;
		$list_faq = filterFaq($request, NULL, NULL);
		$html = '';
		foreach ($list_faq as $item) {
			$html .= '<li><a href="#faq-'. $item->id .'" data-cat-id="#cat-'. $item->category->id .'" >'. $item->title .'</a></li>';
		}
		return response()->json(['msg' => 'success', 'html' => $html]);
	}
}
