<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Media;
use App\Tours;
use App\Schedules;
use App\Seo;
use App\CountryTours;
use App\CatTourMetas;
use App\CategoryGuide;
use App\TourCatGuide;
use App\Duration;

class TourAdminController extends Controller
{
	public function index(){ 
        $tours = Tours::orderBy('created_at', 'desc')->paginate(14); 
        return view('backend.tours.list',['tours'=>$tours]);
    }

    public function store(){
        $list_thingToDo = CategoryGuide::where('post_type', 'thing_to_do')->orderBy('title', 'asc')->get();
        $list_highlight = getAllPlaceToVisit();
        $data = [
            'list_thingToDo' => $list_thingToDo,
            'list_highlight' => $list_highlight,
        ];
        return view('backend.tours.create', $data);
    }

    public function create(Request $request){
    	$msg = 'error';
    	if($request->ajax()){
            $durations = Duration::select('id', 'min' , 'max')->get();
            foreach ($durations as $key => $value) {
                if($request->number >= $value->min && $request->number <= $value->max) {
                    $duration_id = $value->id;
                    break;
                }
            }
            $array_countries = $request->array_country;
            $array_cats = $request->array_cat;
            $array_thingToDo = $request->array_thingsToDo;
            $array_highlightID = $request->array_highlightID;

    		$tour = new Tours;
            if(!empty($tour->duration_id != '')) 
            $tour->duration_id = $duration_id;
            $tour->number = $request->number;
    		$tour->title = $request->title;
            $tour->slug = $request->title;
    		$tour->title_tag = $request->title_tag;
    		$tour->code = $request->code;
    		$tour->gallery = $request->array_gallery;
            $tour->map = $request->map;
    		$tour->content = $request->content;
            $tour->desc_price = $request->desc_price;
    		$tour->must_see_1 = $request->must_see_1;
    		$tour->must_see_2 = $request->must_see_2;
    		$tour->must_see_3 = $request->must_see_3;
    		$tour->must_see_4 = $request->must_see_4;
            if($array_highlightID != '' && $array_highlightID != NULL)
    		$tour->itinerary = implode(",", $array_highlightID);
            $tour->price = $request->price;
            if($array_cats != '' && $array_cats != NULL)
    		  $tour->cat_id = implode(",", $request->array_cat);
            $tour->image = $request->image;
            $tour->image_pdf = $request->image_pdf;
            $tour->pdf = $request->pdf;
            $tour->image_request = $request->image_request;
            $tour->image_personalize = $request->image_personalize;
            /*if($array_countries != '' && $array_countries != NULL)
                $tour->country_id = implode(",",$array_countries);*/
    		if($tour->save()){
                //schedule
                if($request->array_schedule){
                    $array_schedule = $request->array_schedule;
                    foreach($array_schedule as $item){
                        $meals = $icons = ''; 
                        if($item['meal']) $meals = json_encode($item['meal']); 
                        if($item['icon']) $icons = json_encode($item['icon']); 
                        $schedule = new Schedules;
                        $schedule->title = $item['title'];
                        $schedule->gallery = $item['gallery'];
                        //$schedule->brief = $item['brief'];
                        $schedule->content = $item['content'];
                        $schedule->notes = $item['notes'];
                        if(!empty($item['meal'])) 
                            $schedule->meal = json_encode($item['meal']);
                        if(!empty($item['icon'])) 
                            $schedule->icon = json_encode($item['icon']);
                        $schedule->tour_id = $tour->id;
                        $schedule->save();
                    }
                }

                //country_tours
                if($array_countries != '' && $array_countries != NULL){
                    foreach($array_countries as $value){
                        $country_tour = new CountryTours;
                        $country_tour->tour_id = $tour->id;
                        $country_tour->country_id = $value;
                        $country_tour->save();
                    }
                }

                //cat_tour_metas
                if($array_cats != '' && $array_cats != NULL){
                    foreach($array_cats as $value){
                        $cat_tour_meta = new CatTourMetas;
                        $cat_tour_meta->tour_id = $tour->id;
                        $cat_tour_meta->cat_id = $value;
                        $cat_tour_meta->save();
                    }
                }

                //tour category guide
                if($array_thingToDo){ //array category guide
                    foreach($array_thingToDo as $value){
                        TourCatGuide::create(['tour_id' => $tour->id, 'cat_guide_id' => $value]);
                    }
                }

                //seo
                $seo = new Seo;
                $seo->key = $request->metaKey;
                $seo->value = $request->metaValue;
                $seo->type = "tour";
                $seo->post_id = $tour->id;
                $seo->save();
                 
            }
    		$msg = 'success';
    	}
    	return $msg;
    }

    public function edit($slug , Request $request){
        $tour = Tours::findBySlugOrFail($slug);
        $list_countryid = Tours::join('country_tours', 'tours.id', '=', 'country_tours.tour_id')
                                ->where('country_tours.tour_id', $tour->id)
                                ->distinct()->pluck('country_tours.country_id')
                                ->toArray();
        $list_schedule = Schedules::where('tour_id', $tour->id)->orderBy('position', 'asc')->get();
        $list_thingToDo = CategoryGuide::where('post_type', 'thing_to_do')->orderBy('title', 'asc')->get();
        $array_thingToDoId = TourCatGuide::where('tour_id', $tour->id)->pluck('cat_guide_id')->toArray();
        $array_highlightID = ($tour->itinerary != '') ? explode(",", $tour->itinerary) : [];
        $seo = get_seo($tour->id,'tour');
        $list_highlight = getAllPlaceToVisit();
        $data = [
            'tour'=>$tour, 
            'list_schedule'=>$list_schedule, 
            'seo'=>$seo, 
            'list_countryid'=>$list_countryid,
            'list_thingToDo' => $list_thingToDo,
            'array_thingToDoId' => $array_thingToDoId,
            'list_highlight' => $list_highlight,
            'array_highlightID' => $array_highlightID,
        ];
        return view('backend.tours.edit', $data);
    }

    public function update($slug, Request $request){
        $msg = array();
        $status = 'error';
        if($request->ajax()){
            $durations = Duration::select('id', 'min' , 'max')->get();
            foreach ($durations as $key => $value) {
                if($request->number >= $value->min && $request->number <= $value->max) {
                    $duration_id = $value->id;
                    break;
                }
            }
            $array_countries = $request->array_country;
            $array_cats = $request->array_cat;
            $array_thingToDo = $request->array_thingsToDo;
            $array_highlightID = $request->array_highlightID;
            $itinerary = !empty($request->array_cat) ? implode(",",$request->array_cat) : NULL;

            $tour = Tours::findBySlug($slug);
            $tour->duration_id = $duration_id;
            $tour->number = $request->number;
            $tour->title = $request->title;
            $tour->slug = $request->slug;
            $tour->title_tag = $request->title_tag;
            $tour->code = $request->code;
            $tour->gallery = $request->array_gallery;
            $tour->map = $request->map;
            $tour->content = $request->content;
            $tour->desc_price = $request->desc_price;
            $tour->must_see_1 = $request->must_see_1;
            $tour->must_see_2 = $request->must_see_2;
            $tour->must_see_3 = $request->must_see_3;
            $tour->must_see_4 = $request->must_see_4;
            $tour->itinerary = $itinerary;
            $tour->price = $request->price;
            if($array_cats != '' && $array_cats != NULL)
              $tour->cat_id = implode(",",$request->array_cat);
            $tour->image = $request->image;
            $tour->image_pdf = $request->image_pdf;
            $tour->pdf = $request->pdf;
            $tour->image_request = $request->image_request;
            $tour->image_personalize = $request->image_personalize;
            /*if($array_countries != '' && $array_countries != NULL)
                $tour->country_id = implode(",",$request->array_country);*/
            if($tour->save()){
                $tour->touch(); //update updated_at
                //schedule edit
                if($request->array_schedule_edit){
                    $array_schedule_edit = $request->array_schedule_edit;
                    foreach($array_schedule_edit as $item){
                        $schedule = Schedules::find($item['id']);
                        $schedule->title = $item['title'];
                        $schedule->gallery = $item['gallery'];
                        $schedule->position = $item['position'];
                        $schedule->content = $item['content'];
                        $schedule->notes = $item['notes'];
                        if(!empty($item['meal']))  $schedule->meal = json_encode($item['meal']);
                            else $schedule->meal = NULL;
                        if(!empty($item['icon'])) 
                            $schedule->icon = json_encode($item['icon']);
                        $schedule->tour_id = $tour->id;
                        $schedule->save();
                    }
                }
                //schedule add new
                if($request->array_schedule){
                    $array_schedule = $request->array_schedule;
                    foreach($array_schedule as $item){
                        $schedule = new Schedules;
                        $schedule->title = $item['title'];
                        $schedule->gallery = $item['gallery'];
                        $schedule->position = $item['position'];
                        $schedule->content = $item['content'];
                        $schedule->notes = $item['notes'];
                        if(!empty($item['meal'])) 
                            $schedule->meal = json_encode($item['meal']);
                        if(!empty($item['icon'])) 
                            $schedule->icon = json_encode($item['icon']);
                        $schedule->tour_id = $tour->id;
                        $schedule->save();
                    }
                }

                //country_tours
                if($array_countries != '' && $array_countries != NULL){
                    foreach($array_countries as $value){
                        $country_tour = CountryTours::where('tour_id', $tour->id)->where('country_id', $value)->first();
                        if(!$country_tour) 
                        {
                            $country_tour = new CountryTours;
                            $country_tour->tour_id = $tour->id;
                            $country_tour->country_id = $value;
                            $country_tour->save();
                        }
                    }

                    //check if country_id in list DB no exist in $array_countries -> delete
                    $country_tours =  CountryTours::where('tour_id', $tour->id)->get();
                    foreach($country_tours as $item){
                        if(! in_array($item->country_id, $array_countries))
                            $item->delete();
                    }
                }

                //cat_tour_metas
                if($array_cats != '' && $array_cats != NULL){
                    foreach($array_cats as $value){
                        $cat_tour_meta = CatTourMetas::where('tour_id', $tour->id)->where('cat_id', $value)->first();
                        if(!$cat_tour_meta){
                            $cat_tour_meta = new CatTourMetas;
                            $cat_tour_meta->tour_id = $tour->id;
                            $cat_tour_meta->cat_id = $value;
                            $cat_tour_meta->save();
                        }
                    }
                }

                $array_thingToDoSelected = TourCatGuide::where('tour_id', $tour->id)->pluck('cat_guide_id')->toArray();
                //add tour category guide
                if($array_thingToDo){//add
                    foreach($array_thingToDo as $value){
                        if(!in_array($value, $array_thingToDoSelected))
                            TourCatGuide::create(['tour_id' => $tour->id, 'cat_guide_id' => $value]);
                    }
                }
                //delete tour category guide
                if($array_thingToDoSelected){
                    foreach($array_thingToDoSelected as $value){
                        if(!in_array($value, $array_thingToDo))
                            TourCatGuide::where('tour_id', $tour->id)->where('cat_guide_id', $value)->delete();
                    }
                }

                //seo
                if($request->metaKey && $request->metaValue){
                    $seo = Seo::where('post_id',$tour->id)->where('type','tour')->first();
                    if(!$seo) $seo = new Seo;
                    $seo->key = $request->metaKey;
                    $seo->value = $request->metaValue;
                    $seo->type = "tour";
                    $seo->post_id = $tour->id;
                    $seo->save();
                }   
            }
            $status = 'success';
            $msg['url'] = route('editTourAdmin', ['slug'=>$tour->slug]);
        }
        $msg['status'] = $status;
        return $msg;
    }

    public function delete($id){
        $seo = Seo::where('post_id',$id)->where('type','tour');
        if($seo) $seo->delete();
        $tour = Tours::find($id);
        $tour->delete();
        return redirect('/admin/tour/')->with('success','Xóa thành công');
    }

    //deleteAll
    public function deleteAll(Request $resquest){
        $message = "error";
        if($resquest->ajax()){
            $items = json_decode($resquest->items);
            if(count($items)>0){
                foreach($items as $item){
                    $seo = Seo::where('post_id',$item)->where('type','tour');
                    if($seo) $seo->delete();
                }
                Tours::destroy($items);
            }
            $message = "success";
        }
        return $message;
    }

    // public function search(Request $request){
    //     $category = $request->category;
    //     $s = $request->s;
    //     if($category!="" && $s!="")
    //         $tours = Tours::where('title','like','%'.$s.'%')->whereRaw("find_in_set($category,cat_id)")->latest()->paginate(14);
    //     elseif($category=="" && $s!="")
    //         $tours = Tours::where('title','like','%'.$s.'%')->latest()->paginate(14);
    //     else
    //         $tours = Tours::orderBy('created_at', 'desc')->paginate(14);
    //     return view('backend.tours.list',['tours'=>$tours, 's'=>$s, 'category'=>$category]);
    // }
     public function search(Request $request){
        $s = $request->s;
        $category = $request->category;
        $country_id = $request->country_id;
        $tours = Tours::query();
        if($s != ''){
            $tours = $tours->where('title','like','%'.$s.'%');
        }
        if($category != ''){
            $tours = $tours->where('cat_id', $category);
        }
        if($country_id != ''){
            $tours = $tours->join('country_tours','country_tours.tour_id', '=' , 'tours.id')
                            ->where('country_tours.country_id', $country_id);
        }
        $tours = $tours->select('tours.*')->orderBy('created_at', 'desc')->paginate(14);
        return view('backend.tours.list',['tours'=>$tours, 's'=>$s, 'category'=>$category, 'country_id'=>$country_id]);
    }

    //delete schedule
    public function deleteSchedule(Request $request){
        $msg = 'error';
        if($request->ajax()){
            $schedule = Schedules::find($request->id);
            if($schedule){
                $schedule->delete();
                $msg = "success";
            }
        }
        return $msg;
    }

    //search from list
    public function searchFromList(Request $request){
        if($request->ajax()){
            $html = '';
            $tours = Tours::where('title', 'LIKE', '%'.$request->keyword.'%')->orderBy('title', 'asc')->get();
            if($tours){
                foreach($tours as $item){
                    $html .= '<li class="item-'. $item->id .'" data-id="'. $item->id .'" title="'. $item->title .'">';
                        $html .= $item->title;
                    $html .= '</li>';
                }
            }
            return response()->json(['msg'=>'success', 'html'=>$html]);
        }
        return response()->json(['msg'=>'error']);
    }
    /*
    * sortable table days
    */
    public function position(Request $request){
        $msg = 'error';
        if($request->ajax()){
            $routes = json_decode($request->routes);
            foreach ($routes as $item){
                Schedules::where('id', $item->id)->update(['position' => $item->position]);
            }
            $msg = 'success';
        }
        return $msg;
    }

}