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
use App\Overview;
use Validator;

class OverviewAdminController extends Controller
{
	public function index(){
		$list_overview = Overview::join('countries', 'overviews.country_id', '=', 'countries.id')
								->select('overviews.*', 'countries.title', 'countries.slug')
								->latest('overviews.created_at')
								->distinct()
								->paginate(14);
		$data = [];
		$data['list_overview'] = $list_overview;
		return view('backend.overviews.list', $data);
	}

	public function store(Request $request){
		$overview_existID = Overview::pluck('country_id')->toArray();
		$list_overview = Countries::where('parent_id', 0)->whereNotIn('id', $overview_existID)->orderBy('title')->select('id', 'title')->get();
		$array_CountryID = Countries::where('parent_id', 0);
		

		//$list_thingToDo = CategoryGuide::where('post_type', 'thing_to_do')->orderBy('title', 'asc')->get();

		$array_CountryID = $array_CountryID->pluck('id')->toArray();
		$array_regionID = Countries::whereIn('parent_id', $array_CountryID)->pluck('id')->toArray();
		$list_city = Countries::whereIn('parent_id', $array_regionID)->orderBy('title')->get(); 	

		$data = [];
		$data['list_overview'] = $list_overview;
		//$data['list_thingToDo'] = $list_thingToDo;
		$data['list_city'] = $list_city;
		return view('backend.overviews.create', $data);
	}

	public function create(Request $request){
		//validate
        $list_rules = [];
        $list_rules['country_id'] = 'required';

		$validator = Validator::make($request->all(), $list_rules, Overview::getMessageRule());

		$request['list_main_city'] = ($request->list_main_city != '') ? implode(",", $request->list_main_city) : ''; //convert to string $request->list_main_city
		//$request['best_things_to_do'] = ($request->best_things_to_do != '') ? implode(",", $request->best_things_to_do) : ''; //convert to string 

		if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        //insert to DB
        $overview = Overview::create($request->all());

        return response()->json(['success' => 'Add to success.', 'url' => route('storeOverviewAdmin'), 'test' => $request->all()]);
	}

	public function edit($slug){
		$country = Countries::findBySlug($slug);
		$overview = Overview::where('country_id', $country->id)->first();
		$array_regionID = Countries::where('parent_id', $country->id)->pluck('id')->toArray();
		$list_city = Countries::whereIn('parent_id', $array_regionID)->orderBy('title')->get(); 
		//$list_thingToDo = CategoryGuide::where('post_type', 'thing_to_do')->orderBy('title', 'asc')->get();

		$data = [];
		$data['country'] = $country;
		$data['overview'] = $overview;
		//$data['list_thingToDo'] = $list_thingToDo;
		$data['list_city'] = $list_city;

		return view('backend.overviews.edit', $data);
	}

	public function update($slug, Request $request){
		$country = Countries::findBySlug($slug);
		$overview = Overview::where('country_id', $country->id)->first();

		unset($request['country_id']);
		unset($request['_token']);
		$request['list_main_city'] = ($request->list_main_city != '') ? implode(",", $request->list_main_city) : ''; //convert to string $request->list_main_city
		//$request['best_things_to_do'] = ($request->best_things_to_do != '') ? implode(",", $request->best_things_to_do) : ''; //convert to string 
		Overview::where('country_id', $country->id)->update($request->all());

        return response()->json(['success' => 'Update to success.', 'url' => route('updateOverviewAdmin', $country->slug)]);
	}

	public function delete($id){
        $highlight = Overview::where('id', $id)->delete();
        return redirect()->route('overviewsAdmin')->with('success', 'Deleted successfull.');
    }

    public function deleteAll(Request $request){
    	$items = json_decode($request->items);
        if(count($items)>0){
            Overview::destroy($items);
        }
        $list_overview = Overview::join('countries', 'overviews.country_id', '=', 'countries.id')
								->select('overviews.*', 'countries.title', 'countries.slug')
								->latest('overviews.created_at')
								->distinct()
								->paginate(14);
		$html = view('backend.overviews.table', ['list_overview' => $list_overview])->render();
		return response()->json(['html' => $html]);
    }
}