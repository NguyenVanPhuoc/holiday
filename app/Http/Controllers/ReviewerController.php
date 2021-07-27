<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Reviewers;
use App\GroupType;
use App\Countries;
use App\CategoryTour;
use App\Article;
use App\Pages;
use DB;
class ReviewerController extends Controller
{
	public function index(){
		$page = Pages::find(29);
        $seo = get_seo(29,'page');
		$limit = 6;
		$list_destination = getAllMainCountry();
        $list_tour_style = getListTourStyle();
        $list_group_type = GroupType::orderBy('title', 'asc')->get();
        $list_review = Reviewers::limit($limit)->get();
        //dd($list_review);
        $count_review = Reviewers::count();
		$data = [
			'page' => $page,
			'seo' => $seo,
			'list_destination' => $list_destination,
			'list_tour_style' => $list_tour_style,
			'list_group_type' => $list_group_type,
			'list_review' => $list_review,
			'limit' => $limit,
			'count_review' => $count_review,
		];
		return view('reviewers.list', $data);
	}
	public function filter(Request $request){
		$array_param = [];
		$array_country_id = ($request->array_country_id) ? $request->array_country_id : [];
		$array_tourstyle_id = ($request->array_tourstyle_id) ? $request->array_tourstyle_id : [];
		$group_type_id = ($request->group_type_id) ? $request->group_type_id : NULL;
		$limit = ($request->limit) ? $request->limit : NULL;
		$skip = ($request->skip) ? $request->skip : 0;
		$array_param['array_country_id'] =  $array_country_id;
		$array_param['array_tourstyle_id'] =  $array_tourstyle_id;
		$array_param['group_type_id'] =  $group_type_id;
		$array_param['limit'] =  $limit;
		$array_param['skip'] =  $skip;
		$array_filter = filterReviewFront($array_param);
		$list_review = $array_filter['list_review'];
		$total = $array_filter['total'];
        $destination = Reviewers::query();
        $group_type = Reviewers::query();
        $tour_style = Reviewers::query();
        if($array_country_id){
        		foreach ($array_country_id as $country_id) {
	                $group_type = $group_type->orwhereRaw("FIND_IN_SET($country_id, list_destination)");
	                $tour_style = $tour_style->orwhereRaw("FIND_IN_SET($country_id, list_destination)");
        		}
            }
        if($array_tourstyle_id){
        		foreach ($array_tourstyle_id as $style_id) {
	                $group_type = $group_type->whereRaw("FIND_IN_SET($style_id, list_tour_style)");
	                $destination = $destination->whereRaw("FIND_IN_SET($style_id, list_tour_style)");
        		}
            }
        if($group_type_id){
                $tour_style = $tour_style->where('group_type_id', $group_type_id);
                $destination = $destination->where('group_type_id', $group_type_id);
            }
        $destination = $destination->select('list_destination')->get();
        $group_type = $group_type->select('group_type_id')->get();
        $tour_style = $tour_style->select('list_tour_style')->get();
        $arr_dest = '';
        $arr_group = '';
        $arr_style = '';
        //dd($destination);
       	foreach ($destination as $value) {
       		$arr_dest .= $value->list_destination.',';
       	}
       	$abc= array_filter(array_unique(explode(',',$arr_dest)));
       	$list_destination = Countries::whereIn('id', $abc)->select('id','title','position')->orderBy('position','asc')->get();
       	foreach ($group_type as $value) {
       		$arr_group .= $value->group_type_id.',';
       	}
       	$bbb= array_filter(array_unique(explode(',',$arr_group)));
       	$list_group_type = GroupType::whereIn('id', $bbb)->select('id','title')->get();
       	foreach ($tour_style as $value) {
       		$arr_style .= $value->list_tour_style.',';
       	}
       	$bcd= array_filter(array_unique(explode(',',$arr_style)));
       	$list_tour_style = CategoryTour::whereIn('id', $bcd)->select('id','title','position')->orderBy('position','asc')->get();
       	//dd($destination);
		$html = '';
		$filter = '';
		$filter .= view('reviewers.filter', ['list_destination'=>$list_destination,'array_destinationID' => $array_country_id, 'list_group_type' => $list_group_type,'group_type_checked' => $group_type_id,'list_tour_style' => $list_tour_style,'tourstyle_checked' => $array_tourstyle_id])->render();
			if($skip > 0){
				if(count($list_review) > 0){
					foreach($list_review as $item){
						$html .= view('reviewers.item', ['item' => $item])->render();
					}
				}
			}else{
				if(count($list_review) > 0){
					$html .= '<div class="list-item row">';
						foreach($list_review as $item){
							$html .= view('reviewers.item', ['item' => $item])->render();
						}
					$html .= '</div>';
				}else
					$html .= 'No result';
			}
		if($skip == 0 && $total > ($skip + $limit)){
			$html .= '<div class="text-center wrap-readmore">
                        <a href="javascript:void(0)" class="view-more"> <span>View more</span></a>
                    </div>';
		}
		$view_more = 'hide';
		if($total > ($skip + $limit)) 
            	$view_more = 'show';
		return response()->json(['msg' => 'success', 'html' => $html, 'filter' => $filter, 'view_more' => $view_more, 'total' => $total]);
	}
	public function detail($slug){
		$review = Reviewers::findBySlug($slug);		
		if($review):
			$seo = get_seo($review->id, 'review'); 
			$array_cityID = ($review->list_city != '') ? explode(",", $review->list_city) : [];
			$list_city = Countries::join('highlights', 'countries.id', '=', 'highlights.country_id')
									->whereIn('countries.id', $array_cityID)
									->orderBy(DB::raw("FIELD(countries.id,".join(',',$array_cityID).")"))
									->select('countries.id', 'countries.title', 'countries.slug', 'countries.parent_id')
									->distinct()->get();
	        $list_group_type = GroupType::orderBy('title', 'asc')->get();
	        $title_style = explode(',',$review->list_tour_style);
	        $list_title_style=CategoryTour::whereIn('id',$title_style)->select('id','title')->get();
	        $list_otherReviews = Reviewers::where('id', '<>', $review->id)->limit(3)->get();
	        $list_blog = Article::orderBy('created_at', 'asc')->paginate(6);
	        //dd($list_city);
			$data = [
				'review' => $review,
				'seo' => $seo,
				'list_city' => $list_city,
				'list_group_type' => $list_group_type,
				'list_otherReviews' => $list_otherReviews,
				'list_title_style' => $list_title_style,
				'list_blog' => $list_blog,
			];
			return view('reviewers.detail', $data);
		else:
			return redirect()->route('404');
		endif;
	}
	public function filterOther(Request $request){
		$array_param = [];
		$array_country_id = ($request->array_country_id) ? $request->array_country_id : [];
		$array_tourstyle_id = ($request->array_tourstyle_id) ? $request->array_tourstyle_id : [];
		$group_type_id = ($request->group_type_id) ? $request->group_type_id : NULL;
		$limit = 30;
		$skip = ($request->skip) ? $request->skip : 0;
		$array_param['array_country_id'] =  $array_country_id;
		$array_param['array_tourstyle_id'] =  $array_tourstyle_id;
		$array_param['group_type_id'] =  $group_type_id;
		$array_param['current_id'] =  $request->current_id;
		$array_param['limit'] =  $limit;
		$array_param['skip'] =  $skip;
		$array_filter = filterReviewFront($array_param);
		$list_review = $array_filter['list_review'];
		$html = '';
		if(count($list_review) > 0){
			foreach($list_review as $reviewer){
				$html .= view('reviewers.item-medium', ['reviewer' => $reviewer])->render();
			}
		}else{
			$html .= 'No result';
		}
		return response()->json(['msg' => 'success', 'html' => $html]);
	}
}