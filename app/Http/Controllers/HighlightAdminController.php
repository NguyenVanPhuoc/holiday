<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Media;
use App\Seo;
use App\Countries;
use App\Attractions;
use App\Highlight;
use App\PostGuide;
use App\CategoryGuide;
use Validator;


class HighlightAdminController extends Controller
{
	public function index(Request $request){
		$per_page = 14;
		if($request->ajax()){
			$list_highlight = Highlight::join('countries', 'highlights.country_id', '=', 'countries.id')
									->select('highlights.*', 'countries.title', 'countries.slug');
			if(isset($request->s) && $request->s != '')
				$list_highlight = $list_highlight->where('countries.title', 'LIKE', '%'. $request->s .'%');						
			$list_highlight = $list_highlight->latest('highlights.created_at')->distinct()->paginate($per_page);
			$html = view('backend.highlights.table', ['list_highlight' => $list_highlight])->render();
			return response()->json(['html' => $html]);
		}
		$list_highlight = Highlight::join('countries', 'highlights.country_id', '=', 'countries.id')
									->select('highlights.*', 'countries.title', 'countries.slug')
									->latest('highlights.created_at')->distinct()->paginate($per_page);
		$data = [];
		$data['list_highlight'] = $list_highlight;
		return view('backend.highlights.list', $data);
	}

	public function store(){
		//get list places to visit not yet create in places to visit
		$array_existCityID = Highlight::pluck('country_id')->toArray();
		$array_CountryID = Countries::where('parent_id', 0)->pluck('id')->toArray();
		$array_regionID = Countries::whereIn('parent_id', $array_CountryID)->pluck('id')->toArray();
		$list_city = Countries::whereIn('parent_id', $array_regionID)
							->whereNotIn('id', $array_existCityID)
							->orderBy('title', 'asc')->select('id', 'title')->get();

		$list_attraction = Attractions::orderBy('title', 'asc')->select('id', 'title')->get();
		$list_highlight = getAllCountryByLevel(3, true);
		$list_thingToDo = CategoryGuide::where('post_type', 'thing_to_do')->orderBy('title', 'asc')->get(); 

		$data = [];
		$data['list_city'] = $list_city;
		$data['list_attraction'] = $list_attraction;
		$data['list_highlight'] = $list_highlight;
		$data['list_thingToDo'] = $list_thingToDo;

		return view('backend.highlights.create', $data);
	}

	public function create(Request $request){
		//validate
        $list_rules = [];
        $list_rules['country_id'] = 'required';

		$validator = Validator::make($request->all(), $list_rules, Highlight::getMessageRule());

		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        //action DB
        $highlight = new Highlight;
        $highlight->text_map = $request->text_map;
        $highlight->gallery = $request->gallery;
        $highlight->text_attraction_sec = $request->text_attraction_sec;
        $highlight->text_hotel_sec = $request->text_hotel_sec;
        if($request->list_thingToDo && (count($request->list_thingToDo) > 0))
        	$highlight->things_to_do = implode(",", $request->list_thingToDo);
        $highlight->country_id = $request->country_id;
        $highlight->save();

        return response()->json(['success' => 'Add to success.', 'url' => route('storeHighlightAdmin')]);
	}

	public function edit($slug){
		$city = Countries::findBySlug($slug);
		$highlight = Highlight::where('country_id', $city->id)->first();
		$list_attraction = Attractions::orderBy('title', 'asc')->select('id', 'title')->get();
		$list_highlight = getAllCountryByLevel(3, true);
		$list_thingToDo = CategoryGuide::where('post_type', 'thing_to_do')->orderBy('title', 'asc')->get(); 

		$data = [];
		$data['city'] = $city;
		$data['highlight'] = $highlight;
		$data['list_attraction'] = $list_attraction;
		$data['list_highlight'] = $list_highlight;
		$data['list_thingToDo'] = $list_thingToDo;

		return view('backend.highlights.edit', $data);
 	}

 	public function update($slug, Request $request){
 		$city = Countries::findBySlug($slug);
 		$highlight = Highlight::where('country_id', $city->id)->first();

 		$highlight->text_map = $request->text_map;
        $highlight->gallery = $request->gallery;
        $highlight->text_attraction_sec = $request->text_attraction_sec;
        $highlight->text_hotel_sec = $request->text_hotel_sec;
        if($request->list_thingToDo && (count($request->list_thingToDo) > 0))
        	$highlight->things_to_do = implode(",", $request->list_thingToDo);
        $highlight->save();
        $highlight->touch();
		
		return response()->json(['success' => 'Update to success.', 'url' => route('updateHighlightAdmin', $slug )]);
 	}

 	public function delete($id){
        $highlight = Highlight::where('id', $id)->delete();
        return redirect()->route('highlightsAdmin')->with('success', 'Deleted successfull.');
    }

    public function deleteAll(Request $request){
    	$items = json_decode($request->items);
        if(count($items)>0){
            Highlight::destroy($items);
        }
        $list_highlight = Highlight::join('countries', 'highlights.country_id', '=', 'countries.id')
									->select('highlights.*', 'countries.title', 'countries.slug');
		if(isset($request->s) && $request->s != '')
			$list_highlight = $list_highlight->where('countries.title', 'LIKE', '%'. $request->s .'%');						
		$list_highlight = $list_highlight->latest('highlights.created_at')->distinct()->paginate(14);
		$html = view('backend.highlights.table', ['list_highlight' => $list_highlight])->render();
		return response()->json(['html' => $html]);
    }

	
}