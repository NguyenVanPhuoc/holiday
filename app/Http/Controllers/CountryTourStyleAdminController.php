<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Media;
use App\Reviewers;
use App\Countries;
use App\CategoryTour;
use App\Seo;
use App\GroupType;
use App\CountryTourStyle;
use Validator;

class CountryTourStyleAdminController extends Controller
{
   	public function index(Request $request){    	
        $per_page = 14;
        if($request->ajax()){
            $list_country_tourStyle = CountryTourStyle::join('category_tours', 'country_tour_styles.cat_id', '=', 'category_tours.id')
                                                    ->join('countries', 'country_tour_styles.country_id', '=', 'countries.id');
            if(isset($request->s) && $request->s != '')
                $list_country_tourStyle = $list_country_tourStyle->where('country_tour_styles.title', 'like', '%'. $request->s .'%');
            if(isset($request->cat_id) && $request->cat_id != '')
                $list_country_tourStyle = $list_country_tourStyle->where('category_tours.id', $request->cat_id);
            if(isset($request->country_id) && $request->country_id != '')
                $list_country_tourStyle = $list_country_tourStyle->where('countries.id', $request->country_id);
            $list_country_tourStyle = $list_country_tourStyle->orderBy('country_tour_styles.created_at', 'desc')
                                                    ->distinct()
                                                    ->select('country_tour_styles.*', 'countries.title as country_title', 'category_tours.title as category_title')
                                                    ->paginate($per_page);
            $html = view('backend.countryTourStyles.table', ['list_country_tourStyle' => $list_country_tourStyle])->render();
            return response()->json(['html' => $html]);
        }
    	$list_country_tourStyle = CountryTourStyle::join('category_tours', 'country_tour_styles.cat_id', '=', 'category_tours.id')
                                                    ->join('countries', 'country_tour_styles.country_id', '=', 'countries.id')
                                                    ->orderBy('country_tour_styles.created_at')
                                                    ->distinct()
                                                    ->select('country_tour_styles.*', 'countries.title as country_title', 'category_tours.title as category_title')
                                                    ->paginate($per_page);
        $list_country = Countries::where('parent_id', 0)->orderBy('title')->select('id', 'title')->get();
        $list_cat = CategoryTour::orderBy('title')->get();                                            
        $data = [];
        $data['list_country_tourStyle'] = $list_country_tourStyle;
        $data['list_country'] = $list_country;
        $data['list_cat'] = $list_cat;
        return view('backend.countryTourStyles.list', $data);
    }
    
    public function store(){    
        $list_country = Countries::where('parent_id', 0)->orderBy('title')->select('id', 'title')->get();
        $list_cat = CategoryTour::orderBy('title')->get();
        $list_city = getAllCity();
        $data = [];
        $data['list_country'] = $list_country;
        $data['list_cat'] = $list_cat;
        $data['list_city'] = $list_city;
        return view('backend.countryTourStyles.create', $data);
    }

    public function create(Request $request){ 
        /*validate*/
        $list_rules = [];
        $list_rules['title'] = 'required';
        $list_rules['cat_id'] = 'required';
        $list_rules['country_id'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, CountryTourStyle::getMessageRule());

        $validator->after(function($validator) use ($request) {
            //check exist
            $post_exist = CountryTourStyle::where('cat_id', $request->cat_id)->where('country_id', $request->country_id)->first();
            if($post_exist)
                $validator->errors()->add('exist', 'Country tour style is already exist.');
        });
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        /*insert DB*/
        //$request['slug'] = $request->title;
        $request['list_city'] = (isset($request->city_id)) ? implode(",", $request->city_id) : NULL;
        $country_tour_style = CountryTourStyle::create($request->only('title', 'title_tag', 'desc', 'text_tour', 'list_content', 'text_city', 'list_city', 'text_review', 'image_content', 'image', 'image_looking', 'image_request', 'cat_id', 'country_id'));
        //update slug
        updateSlug('country_tour_styles', $request->title, $country_tour_style ->id);
        createSeo($country_tour_style->id, 'country_tour_style', $request->meta_key, $request->meta_value);

        return response()->json(['success' => 'Add to success.', 'url' => route('storeCountryTourStyleAdmin')]);
    }
    
    public function edit($id){
        $country_tourStyle = CountryTourStyle::findOrFail($id);
        $list_country = Countries::where('parent_id', 0)->orderBy('title')->select('id', 'title')->get();
        $list_cat = CategoryTour::orderBy('title')->get();
        $list_city = getAllCity();
        $data = [];
        $data['country_tourStyle'] = $country_tourStyle;
        $data['list_country'] = $list_country;
        $data['list_cat'] = $list_cat;
        $data['list_city'] = $list_city;
        return view('backend.countryTourStyles.edit', $data);
    }

    public function update(Request $request, $id){  
        $country_tourStyle = CountryTourStyle::findOrFail($id);
        $list_rules['title'] = 'required';
        $list_rules['cat_id'] = 'required';
        $list_rules['country_id'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, CountryTourStyle::getMessageRule());

        $validator->after(function($validator) use ($request, $id) {
            //check exist
            $post_exist = CountryTourStyle::where('cat_id', $request->cat_id)->where('country_id', $request->country_id)->first();
            if($post_exist && ($post_exist->id != $id))
                $validator->errors()->add('exist', 'Country tour style is already exist.');
        });
        if($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        $request['list_city'] = (isset($request->city_id)) ? implode(",", $request->city_id) : NULL;
        $country_tourStyle->update($request->only('title', 'title_tag', 'desc', 'text_tour', 'list_content', 'text_city', 'list_city', 'text_review', 'image_content', 'image','image_looking', 'image_request', 'cat_id', 'country_id'));
        $country_tourStyle->touch();
        //update slug of table country_tour_styles
        updateSlug('country_tour_styles', $request->slug, $id);
        //update seos
        updateSeo($country_tourStyle->id, 'country_tour_style', $request->meta_key, $request->meta_value);

        return response()->json(['success' => 'Update to success.', 'url' => route('updateCountryTourStyleAdmin', $id)]);
    }  	
	public function delete($id){
    	CountryTourStyle::where('id', $id)->delete();
        Seo::where('type', 'country_tour_style')->where('post_id', $id)->delete();
    	return redirect()->route('countryTourStylesAdmin')->with('success','Deleted Successfull.');
    }

    public function deleteAll(Request $request){
        if($request->ajax()){
            $items = json_decode($request->items);
            if(count($items)>0){
                foreach($items as $id){
                    $seo = Seo::where('post_id',$id)->where('type','country_tour_style')->delete();
                }
                CountryTourStyle::destroy($items);
            }
            $list_country_tourStyle = CountryTourStyle::join('category_tours', 'country_tour_styles.cat_id', '=', 'category_tours.id')
                                                    ->join('countries', 'country_tour_styles.country_id', '=', 'countries.id');
            if(isset($request->s) && $request->s != '')
                $list_country_tourStyle = $list_country_tourStyle->where('country_tour_styles.title', 'like', '%'. $request->s .'%');
            if(isset($request->cat_id) && $request->cat_id != '')
                $list_country_tourStyle = $list_country_tourStyle->where('category_tours.id', $request->cat_id);
            if(isset($request->country) && $request->country != '')
                $list_country_tourStyle = $list_country_tourStyle->where('countries.id', $request->country_id);
            $list_country_tourStyle = $list_country_tourStyle->orderBy('country_tour_styles.created_at')
                                                    ->distinct()
                                                    ->select('country_tour_styles.*', 'countries.title as country_title', 'category_tours.title as category_title')
                                                    ->paginate(14);
            $html = view('backend.countryTourStyles.table', ['list_country_tourStyle' => $list_country_tourStyle])->render();
            return response()->json(['html' => $html]);
        }
        return  'error';
    }
}
