<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Media;
use App\Countries;
use App\Duration;
use App\Seo;
use App\CountryTourDuration;
use Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CountryTourDurationAdminController extends Controller
{
   	public function index(Request $request){    
        $per_page = 14; 
        $page = (isset($request->page) && $request->page != '') ? $request->page : 1;
        $list_countryTourDuration = $this->filter($request, $per_page, $page); 

        if($request->ajax()){
            $html = view('backend.countryTourDuration.table', ['list_countryTourDuration' => $list_countryTourDuration])->render();
            return response()->json(['html' => $html]);
        }

        $list_country = Countries::where('parent_id', 0)->orderBy('title')->select('id', 'title')->get();
        $list_duration = Duration::all();	
        $data = [
            'list_countryTourDuration' => $list_countryTourDuration,
            'list_country' => $list_country,
            'list_duration' => $list_duration,
        ];
        return view('backend.countryTourDuration.list', $data);
    }
    
    public function store(){ 
        $list_country = Countries::where('parent_id', 0)->orderBy('title')->select('id', 'title')->get();
        $list_duration = Duration::all();
        $data = [];
        $data['list_country'] = $list_country;
        $data['list_duration'] = $list_duration;
        return view('backend.countryTourDuration.create', $data);   
    }

    public function create(Request $request){  
        /*validate*/
        $list_rules = [];
        $list_rules['title'] = 'required';
        $list_rules['duration_id'] = 'required';
        $list_rules['country_id'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, CountryTourDuration::getMessageRule());

        $validator->after(function($validator) use ($request) {
            //check exist
            $post_exist = CountryTourDuration::where('duration_id', $request->duration_id)->where('country_id', $request->country_id)->first();
            if($post_exist)
                $validator->errors()->add('exist', 'Country tour duration is already exist.');
        });
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);  

        /*insert DB*/
        $country_tour_duration = CountryTourDuration::create($request->only('title', 'title_tag', 'desc', 'text_list_content', 'list_content', 'image', 'image_looking', 'image_request', 'country_id', 'duration_id'));
        updateSlug('country_tour_durations', $request->title, $country_tour_duration ->id);
        createSeo($country_tour_duration->id, 'country_tour_duration', $request->meta_key, $request->meta_value);

        return response()->json(['success' => 'Add to success.', 'url' => route('storeCountryTourDurationAdmin')]);
    }
    
    public function edit($id){
        $countryTourDuration = CountryTourDuration::findOrFail($id);
        $list_country = Countries::where('parent_id', 0)->orderBy('title')->select('id', 'title')->get();
        $list_duration = Duration::all();
        //dd($countryTourDuration);
        $data = [];
        $data['countryTourDuration'] = $countryTourDuration;
        $data['list_country'] = $list_country;
        $data['list_duration'] = $list_duration;
        return view('backend.countryTourDuration.edit', $data); 
    }

    public function update(Request $request, $id){  
         /*validate*/
        $list_rules = [];
        $list_rules['title'] = 'required';
        $list_rules['duration_id'] = 'required';
        $list_rules['country_id'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, CountryTourDuration::getMessageRule());

        $validator->after(function($validator) use ($request, $id) {
            //check exist
            $post_exist = CountryTourDuration::where('duration_id', $request->duration_id)->where('country_id', $request->country_id)->where('id', '<>', $id)->first();
            if($post_exist)
                $validator->errors()->add('exist', 'Country tour duration is already exist.');
        });
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);  

        /*insert DB*/
        $countryTourDuration = CountryTourDuration::findOrFail($id);
        $countryTourDuration->update($request->only('title', 'title_tag', 'desc', 'text_list_content', 'list_content', 'image', 'image_looking', 'image_request', 'country_id', 'duration_id'));
        //update slug of table country_tour_styles
        updateSlug('country_tour_durations', $request->slug, $id);
        $countryTourDuration->touch();
        //update seos
        updateSeo($countryTourDuration->id, 'country_tour_duration', $request->meta_key, $request->meta_value);

        return response()->json(['success' => 'Update to success.', 'url' => route('updateCountryTourDurationAdmin', $id)]);
    }  	

	public function delete($id){
        CountryTourDuration::where('id', $id)->delete();
        deleteSeo($id, 'country_tour_duration');
        return redirect()->route('countryTourDurationsAdmin')->with('success','Deleted Successfull.');
    }

    public function deleteAll(Request $request){
        if($request->ajax()){
            $items = json_decode($request->items);
            if(count($items)>0){
                foreach($items as $id){
                    deleteSeo($id, 'country_tour_duration');
                }
                CountryTourDuration::destroy($items);
            }

            $per_page = 14; 
            $page = (isset($request->page) && $request->page != '') ? $request->page : 1;
            $list_countryTourDuration = $this->filter($request, $per_page, $page);
            $html = view('backend.countryTourDuration.table', ['list_countryTourDuration' => $list_countryTourDuration])->render();

            return response()->json(['html' => $html]);
        }
        return  'error';
    }

    private function filter($request, $per_page = 14, $page = 1){
        $countryTourDurations = CountryTourDuration::query();

        if(isset($request->s) && $request->s != '')
            $countryTourDurations = $countryTourDurations->where('title', 'LIKE', '%'. $request->s .'%');

        if(isset($request->country_id) && $request->country_id != '')
            $countryTourDurations = $countryTourDurations->where('country_id', $request->country_id);

        if(isset($request->duration_id) && $request->duration_id != '')
            $countryTourDurations = $countryTourDurations->where('duration_id', $request->duration_id);

        $countryTourDurations = $countryTourDurations->latest()->get();

        $items = $countryTourDurations instanceof Collection ? $countryTourDurations : Collection::make($countryTourDurations);
         
        $list_countryTourDuration = new LengthAwarePaginator($items->forPage($page, $per_page), count($items), $per_page, $page);
        return $list_countryTourDuration;
    }
}
