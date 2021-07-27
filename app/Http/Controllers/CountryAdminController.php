<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Countries;
use App\CountryCategory;
use App\Highlight;
use App\Seo;
use Validator;

class CountryAdminController extends Controller
{
    public function index(Request $request){
        /*test*/
        $test = Countries::where('parent_id', 0)->get(); 
        /*end test*/
        $per_page = 14; 
        if($request->ajax()){
            $list_country = Countries::query();
            if(isset($request->parent_id) && $request->parent_id != '')
                $list_country = $list_country->where('parent_id', $request->parent_id);
            if(isset($request->s) && $request->s != '')
                $list_country = $list_country->where('title', 'like', '%'.$request->s.'%');
            $list_country = $list_country->orderBy('position', 'asc')->latest()->paginate($per_page);
            $html = view('backend.countries.table', ['list_country' => $list_country])->render();
            return response()->json(['html' => $html]);
        }   
    	$list_country = Countries::query();
        if(isset($request->parent_id) && $request->parent_id != '')
            $list_country = $list_country->where('parent_id', $request->parent_id);
        if(isset($request->s) && $request->s != '')
            $list_country = $list_country->where('title', 'like', '%'.$request->s.'%');
        $list_country = $list_country->orderBy('created_at', 'desc')->paginate($per_page);
        $data = [];
        $data['list_country'] = $list_country;
    	return view('backend.countries.list', $data);
    }  

    public function store(){
    	return view('backend.countries.add');
    }

    public function create(Request $request){
    	$msg = 'error';
    	if($request->ajax()){
            //validate
            $list_rules = [];
            $list_rules['title'] = 'required';
            $list_rules['parent_id'] = 'required';

            $validator = Validator::make($request->all(), $list_rules, Countries::getMessageRule());
            if ($validator->fails()) 
                return response()->json([ 'error' => $validator->errors()->all() ]);

            /*$request['slug'] = $request->title;*/
            $country = Countries::create($request->all());
            updateSlug('countries', $request->title, $country->id);

            if($country->save()){
                //seo     
                $request['type'] = 'country';
                $request['key'] = $request->metakey;
                $request['value'] = $request->metaValue;
                $request['post_id'] = $country->id;
                Seo::create($request->only('type', 'key', 'value', 'post_id'));
            }
            /*$highlight = new Highlight;
            $highlight->country_id = $request->country_id;*/
            $highlight = Highlight::firstOrNew(['country_id' => $country->id]);
            $highlight->gallery = $request->gallery;
            $highlight->title_video = $request->title_video;          
            $highlight->desc_video = $request->desc_video;
            $highlight->video = $request->video;
            $highlight->image_request_one = $request->image_request_one;
            $highlight->image_request_two = $request->image_request_two;
            $highlight->save();
            
		    return response()->json(['success' => 'Add to success.', 'url' => route('storeCountryAdmin')]);
    	}
        return $msg;
    }

    public function edit($slug){
        $country = Countries::findBySlug($slug); 
        $haveHighlight = false;
        $highlight = Highlight::where('country_id', $country->id)->first();
        $seo = get_seo($country->id,'country');
        if($highlight)
            $haveHighlight = true;
        $data = [];
        $data['country'] = $country;
        $data['seo'] = $seo;
        $data['haveHighlight'] = $haveHighlight;
        $data['highlight'] = $highlight;
        return view('backend.countries.edit', $data);
    }

    public function update(Request $request, $slug){
        if($request->ajax()){
            $country = Countries::findBySlug($slug);
            //validate
            $list_rules = [];
            $list_rules['title'] = 'required';
            $list_rules['parent_id'] = 'required';
            $validator = Validator::make($request->all(), $list_rules, Countries::getMessageRule());
            if ($validator->fails()) 
                return response()->json([ 'error' => $validator->errors()->all() ]);

            /*$request['slug'] = str_slug($request->title, '-');*/

            $country->update($request->only('title', 'title_tag', 'slug', 'parent_id', 'color', 'short_desc', 'desc', 'best_time_to_visit', 'image', 'flag', 'icon', 'map' , 'status'));
            $country->touch();
            updateSlug('countries', $request->title, $country->id);
            //update seo
            $seo = Seo::where('type', 'country')->where('post_id', $country->id)->first();
            $request['type'] = 'country';
            $request['key'] = $request->metakey;
            $request['value'] = $request->metaValue;
            $request['post_id'] = $country->id;
            if(!$seo)
                Seo::create($request->only('type', 'key', 'value', 'post_id'));
            else
                $seo->update($request->only('type', 'key', 'value', 'post_id'));


            $highlight = Highlight::firstOrNew(['country_id' => $country->id]);
            // if(!$highlight) $highlight = new Highlight;
            $highlight->gallery = $request->gallery;
            $highlight->title_video = $request->title_video;          
            $highlight->desc_video = $request->desc_video;
            $highlight->video = $request->video;
            $highlight->image_request_one = $request->image_request_one;
            $highlight->image_request_two = $request->image_request_two;
            $highlight->save();
            //data send to view edit country
            
            return response()->json(['success' => 'Update to success.', 'url' => route('updateCountryAdmin', $country->slug)]);
        }
        return response()->json(['msg'=>'error']);
    }


    public function delete($id){
        $country = Countries::find($id);
        //delete Seo
        Seo::where('type', 'country')->where('post_id', $id)->delete();
        $country->delete();
        return redirect()->route('countryAdmin')->with('success', 'Delete successfull.');
    }

    //deleteAll
    public function deleteAll(Request $request){
        if($request->ajax()){
            $items = json_decode($request->items);
            if(count($items)>0){
                Seo::where('type', 'country')->whereIn('post_id', $items)->delete();
                Countries::destroy($items);

                $list_country = Countries::query();
                if(isset($request->parent_id) && $request->parent_id != '')
                    $list_country = $list_country->where('parent_id', $request->parent_id);
                if(isset($request->s) && $request->s != '')
                    $list_country = $list_country->where('title', 'like', '%'.$request->s.'%');
                $list_country = $list_country->latest()->paginate(14);
                $html = view('backend.countries.table', ['list_country' => $list_country])->render();
                return response()->json(['html' => $html]);
            }
        }
        return 'error';
    }

    //country haven't tour style
    public function countryCatAdmin(){
        $countries = Countries::where('parent_id', 0)->get();
        $country_cats = CountryCategory::orderBy('created_at', 'asc')->get();
        return view('backend.countries.countryCat', ['countries'=>$countries, 'country_cats'=>$country_cats]);
    }

    public function postCountryCatAdmin(Request $request){
        $msg = 'error';
        if($request->ajax()){
            $array_add = $request->array_add;
            $array_edit = $request->array_edit;

            if(count($array_add) > 0){ 
                foreach($array_add as $item){
                    $country_cat = new CountryCategory;
                    $country_cat->country_id = $item['country'];
                    $country_cat->cat_id = $item['cat'];
                    $country_cat->save();
                }
            }

            if(count($array_edit) > 0){
                foreach($array_edit as $item){
                    $country_cat = CountryCategory::find($item['id']);
                    $country_cat->country_id = $item['country'];
                    $country_cat->cat_id = $item['cat'];
                    $country_cat->save();
                }
            }

            $msg = 'success';
        }
        return $msg;
    }

    public function deleteCountryCatAdmin($id){
        $country_cat = CountryCategory::find($id);
        if($country_cat){
            $country_cat->delete();
            return redirect()->route('countryCatAdmin')->with('deleted','Successfully deleted.');
        }
    }

    public function search(Request $request){
        $s = $request->s;
        $parent_id = $request->parent_id; 
        $countries = Countries::query(); 
        if($s != ''){
            $countries = $countries->where('title','like','%'.$s.'%');
        }
        if($parent_id != ''){
            $countries = $countries->where('parent_id', $parent_id);
        }
        $countries = $countries->orderBy('created_at', 'desc')->paginate(14);
        return view('backend.countries.list',['countries'=>$countries, 's'=>$s, 'parent_id'=>$parent_id]);
    }

    public function searchFromList(Request $request){
        if($request->ajax()){
            $html = getHtmlCountriesOrderByTitle(0, 0, $request->keyword);
            return response()->json(['msg'=>'success', 'html'=>$html]);
        }
        return response()->json(['msg'=>'error']);
    }

    public function position(Request $request){
        $msg = 'error';
        if($request->ajax()){
            $routes = json_decode($request->routes);
            foreach ($routes as $item){
                Countries::where('id', $item->id)->update(['position' => $item->position]);
            }
            $msg = 'success';
        }
        return $msg;
    }

}
