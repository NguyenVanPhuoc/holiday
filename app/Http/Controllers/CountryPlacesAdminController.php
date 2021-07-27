<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Media;
use App\CountryBlog;
use App\Seo;
use App\Tag;
use Validator;

class CountryPlacesAdminController extends Controller
{
	public function index(){    	
    	$countries = CountryBlog::latest()->where('type', 'country_places')->paginate(15);    	
    	return view('backend.places.list_country_places',['countries'=>$countries]);
    }
    
    public function store(){   
        $list_country = getAllMainCountry();
        $data = [
            'list_country' => $list_country,
        ]; 	
    	return view('backend.places.create_country_places',$data);
    }

    public function create(Request $request){
        
        $list_rules = [];
        $list_rules['title'] = 'required';
        $list_rules['country_id'] = 'required';
        $validator = Validator::make($request->all(), $list_rules, getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        $request['type'] = 'country_places';
        $countries = CountryBlog::create($request->only('title', 'title_tag', 'desc', 'banner', 'banner_country', 'country_id', 'content_ready_yet', 'banner_plants', 'content_tips', 'type'));
        updateSlug('country_blogs', $request->title, $countries->id);
        createSeo($countries->id, 'country_blog', $request->meta_key, $request->meta_value);
        return response()->json(['success' => 'Add to success.']);
    }
    
    public function edit($id){
        $countries = CountryBlog::find($id);
        $list_country = getAllMainCountry();
        $seo = Seo::where('type','country_blog')->where('post_id',$countries->id)->first();
    	return view('backend.places.edit_country_places',['countries'=>$countries, 'seo'=>$seo , 'list_country'=>$list_country]);
    }

    public function update(Request $request, $id){    	
    	$list_rules['title'] = 'required';
        $validator = Validator::make($request->all(), $list_rules, getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);
        CountryBlog::where('id', $id)->update($request->only('title', 'title_tag', 'desc', 'banner', 'banner_country', 'content_ready_yet', 'banner_plants', 'content_tips'));
        updateSlug('country_blogs', $request->title, $id);
        updateSeo($id, 'country_blog', $request->meta_key, $request->meta_value);
        return response()->json(['success' => 'Update to success.', 'url' => route('updateCountryPlacesAdmin', $id)]);
    }
	// public function position(Request $request){
	// 	$message = "error";
	// 	if($request->ajax()):						
	// 		$routes = json_decode($request->routes);
	// 		foreach ($routes as $item):
	// 			$category = ArticleCat::find($item->id);
	// 			$category->position = $item->position;						
	// 			$category->save();
	// 		endforeach;
	// 		$message = "success";
	// 	endif;
	// 	return $message;
	// }
	public function delete($id){
		$seo = Seo::where('post_id',$id)->where('type','countries')->delete();
        $countries = CountryBlog::find($id);
        $countries->delete();
        return redirect()->route('countryPlacesAdmin')->with('success','Deleted successfull');
    }
}
