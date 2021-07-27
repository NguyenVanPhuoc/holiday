<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Attractions;
use App\Media;
use App\Seo;
use App\Icon;
use Validator;

class AttractionAdminController extends Controller
{
	public function index(){    	
    	$attractions = Attractions::orderBy('created_at', 'desc')->paginate(14);
    	return view('backend.attractions.list',['attractions'=>$attractions]);
    }

    public function store(){
        $list_icon = Icon::where('type', 'attraction')->orderBy('title', 'asc')->get();
        $list_highlight = getAllCountryByLevel(3, true);
        $data = [];
        $data['list_icon'] = $list_icon;
        $data['list_highlight'] = $list_highlight;

        return view('backend.attractions.create', $data);
    }

    public function create(Request $request){
        if($request->ajax()){
            //validate
            $list_rules = [];
            $list_rules['title'] = 'required';
            $list_rules['country_id'] = 'required';

            $validator = Validator::make($request->all(), $list_rules, Attractions::getMessageRule());

            if ($validator->fails()) 
                return response()->json([ 'error' => $validator->errors()->all() ]);

            //action DB
            $attraction = new Attractions;
            $attraction->title = $request->title;
            $attraction->slug = $request->title;
            $attraction->desc = $request->desc;
            $attraction->gallery = $request->gallery;  
            if($request->list_icon && (count($request->list_icon) > 0))
                $attraction->list_icon = implode(",", $request->list_icon);
            $attraction->country_id = $request->country_id;
            if($request->categories && (count($request->categories) > 0))
                $attraction->cat_id = implode(",", $request->categories);  
            $attraction->image = $request->image;  
            $attraction->save();

            return response()->json(['success' => 'Add to success.', 'url' => route('storeAttractionAdmin')]);
        }
        return response()->json([ 'error' => 'Error' ]);
    }

    public function edit($slug){
        $attraction = Attractions::findBySlug($slug);
        $list_icon = Icon::where('type', 'attraction')->orderBy('title', 'asc')->get();
        $list_highlight = getAllCountryByLevel(3, true);
        $data = [];
        $data['attraction'] = $attraction;
        $data['list_icon'] = $list_icon;
        $data['list_highlight'] = $list_highlight;

        return view('backend.attractions.edit', $data);
    }

    public function update($slug, Request $request){
        if($request->ajax()){
            //validate
            $list_rules = [];
            $list_rules['title'] = 'required';
            $list_rules['country_id'] = 'required';

            $validator = Validator::make($request->all(), $list_rules, Attractions::getMessageRule());

            if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

            //action db
            $attraction = Attractions::findBySlug($slug);
            $attraction->title = $request->title;
            $attraction->slug = $request->title;
            $attraction->desc = $request->desc;
            $attraction->gallery = $request->gallery;  
            if($request->list_icon && (count($request->list_icon) > 0))
                $attraction->list_icon = implode(",", $request->list_icon);
            $attraction->country_id = $request->country_id; 
            if($request->categories && (count($request->categories) > 0))
                $attraction->cat_id = implode(",", $request->categories);   
            $attraction->image = $request->image;  
            $attraction->save();
            $attraction->touch();
            return response()->json(['success'=>'Update to success', 'url' => route('editAttractionAdmin', ['slug'=>$attraction->slug])]);
        }
        return response()->json(['msg'=>'error']);
    }

    public function delete($id){
        $attraction = Attractions::find($id);
        $attraction->delete();
        return redirect()->route('attractionsAdmin')->with('success', 'Delete Success.');
    }

    //deleteAll
    public function deleteAll(Request $resquest){
        $message = "error";
        if($resquest->ajax()){
            $items = json_decode($resquest->items);
            if(count($items)>0){
                Attractions::destroy($items);
            }
            $message = "success";
        }
        return $message;
    }

    public function search(Request $request){
        $s = $request->s;
        $country_id = $request->country_id;
        $attractions = Attractions::query();
        if($s != ''){
            $attractions = $attractions->where('title','like','%'.$s.'%');
        }
        if($country_id != ''){
            $attractions = $attractions->where('country_id', $country_id);
        }
        $attractions = $attractions->orderBy('created_at', 'desc')->paginate(14);
        return view('backend.attractions.list',['attractions'=>$attractions, 's'=>$s, 'country_id'=>$country_id]);
    }


    /*
    * icons attraction
    */
    public function indexIcon(){
        $list_icon = Icon::where('type', 'attraction')->latest()->paginate(14);
        $data = [];
        $data['list_icon'] = $list_icon;
        return view('backend.attractions.icons.list', $data);
    }

    public function storeIcon(){
        return view('backend.attractions.icons.create');
    } 

    public function eitIcon($id){
        $icon = Icon::findOrFail($id);
        $data = [];
        $data['icon'] = $icon;

        return view('backend.attractions.icons.edit', $data);
    }

    public function deleteIcon($id){
        $icon = Icon::findOrFail($id);
        $icon->delete();
        return redirect()->route('iconsAttractionAdmin')->with('success', 'Delete Success.');
    }

    //deleteAll
    public function deleteAllIcon(Request $resquest){
        $message = "error";
        if($resquest->ajax()){
            $items = json_decode($resquest->items);
            if(count($items)>0){
                Icon::destroy($items);
            }
            $message = "success";
        }
        return $message;
    }
}
