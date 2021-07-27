<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Hotels;
use App\Media;
use App\Seo;
use App\CountryHotel;
use App\AttractionHotels;
use App\Attractions;
use App\Facilities;
use Validator;

class HotelAdminController extends Controller
{
	public function index(Request $request){    
        $per_page = 14;
        $page = isset($request->page) ? $request->page : 1;
        $country_id = isset($request->country_id) ? $request->country_id : NULL;
    	$list_hotel = filterHotelAdmin($request, $per_page, $page);
        if($request->ajax()){
            $html = view('backend.hotels.table', ['list_hotel' => $list_hotel])->render();
            return response()->json(['msg' => 'success', 'html' => $html]);
        }
        $list_city = getAllCountryByLevel(3, true);
        $data = [
            'list_hotel' => $list_hotel,
            'list_city' => $list_city,
        ];
    	return view('backend.hotels.list', $data);
    }

    public function store(){
        $list_attraction = Attractions::orderBy('title', 'asc')->get();
        $list_facility = Facilities::orderBy('title', 'asc')->get();
        $data = [
            'list_attraction' => $list_attraction,
            'list_facility' => $list_facility
        ];
    	return view('backend.hotels.create', $data);
    }

    public function create(Request $request){
    	if($request->ajax()){
            //validate
            $list_rules = [];
            $list_rules['title'] = 'required';
            $list_rules['country'] = 'required';

            $validator = Validator::make($request->all(), $list_rules, Hotels::getMessageRule());

            if ($validator->fails()) 
                return response()->json([ 'error' => $validator->errors()->all()]);

            //action to DB
            $countries = $request->country;
            $nearby_add = json_decode($request->list_add_nearby);
            $special_id = isset($request->special) ? implode(",", $request->special) : '';
            $facilities = ($request->facilities) ? implode(",", $request->facilities) : '';

            //insert to table hotels
            $data_hotel = [
                'title' => $request->title,
                'title_tag' => $request->title_tag,
                'desc' => $request->desc,
                'map' => $request->map,
                'gallery' => $request->gallery,
                'facilities' => $facilities,
                'tripadvisor_code' => $request->tripadvisor_code,
                'tripadvisor_link' => $request->tripadvisor_link,
                'website_link' => $request->website_link,
                'image' => $request->image,
                'star_rating_id' => $request->star_rating_id,
                'location_id' => $request->location_id,
                'special_id' => $special_id,
            ];
            $hotel = Hotels::create($data_hotel);
            //update slug
            updateSlug('hotels', $request->title, $hotel->id);
            //insert to table seos
            createSeo($hotel->id, 'hotel', $request->meta_key, $request->meta_value);
            //insert to country_hotels
            foreach($countries as $country_id){
                CountryHotel::create(['country_id' => $country_id, 'hotel_id' => $hotel->id]);
            }
            //insert to table attraction_hotels
            if($nearby_add){
                foreach ($nearby_add as $item) {
                    AttractionHotels::create([
                        'distance' => $item->distance,
                        'position' => $item->position,
                        'hotel_id' => $hotel->id,
                        'attraction_id' => $item->attraction,
                    ]);
                }
            }

            return response()->json(['success' => 'Add to success.', 'url' => route('storeHotelAdmin')]);
    	}
        return response()->json([ 'error' => 'Error' ]);
    }

    public function edit($slug){
        $hotel = Hotels::findBySlug($slug);
        $list_facility = Facilities::orderBy('title', 'asc')->get();
        $data = [
            'hotel'=>$hotel, 
            'list_facility' => $list_facility
        ];
        return view('backend.hotels.edit', $data);
    }

    public function update($slug, Request $request){
        if($request->ajax()){

            //validate
            $list_rules = [];
            $list_rules['title'] = 'required';
            $list_rules['country'] = 'required';

            $validator = Validator::make($request->all(), $list_rules, Hotels::getMessageRule());

            if ($validator->fails()) 
                return response()->json([ 'error' => $validator->errors()->all()]);

            //action to DB
            $hotel = Hotels::findBySlug($slug);
            $countries = $request->country;
            $nearby_add = json_decode($request->list_add_nearby);
            $nearby_edit = json_decode($request->list_edit_nearby);
            $special_id = isset($request->special) ? implode(",", $request->special) : '';
            $facilities = ($request->facilities) ? implode(",", $request->facilities) : '';

            //insert to table hotels
            $data_hotel = [
                'title' => $request->title,
                'title_tag' => $request->title_tag,
                'desc' => $request->desc,
                'map' => $request->map,
                'gallery' => $request->gallery,
                'facilities' => $facilities,
                'tripadvisor_code' => $request->tripadvisor_code,
                'tripadvisor_link' => $request->tripadvisor_link,
                'website_link' => $request->website_link,
                'image' => $request->image,
                'star_rating_id' => $request->star_rating_id,
                'location_id' => $request->location_id,
                'special_id' => $special_id,
            ];
            Hotels::where('slug', $slug)->update($data_hotel);
            //$hotel->touch();

            //update slug
            $newSlug = updateSlug('hotels', $request->title, $hotel->id);
            //update seos
            updateSeo($hotel->id, 'hotel', $request->meta_key, $request->meta_value);
            /*country_hotels*/
            $array_idCountryHotel = getArrayCountryIdOfHotel($hotel->id);
            //add if country id not exist in list added before
            if(count($countries) > 0){
                foreach($countries as $country_id){
                    if(! in_array($country_id, $array_idCountryHotel))
                        CountryHotel::create(['country_id' => $country_id, 'hotel_id' => $hotel->id]);
                }
            }
            //remove country id if not exist in list new add
            if(count($array_idCountryHotel) > 0){
                foreach($array_idCountryHotel as $country_id){
                    if(! in_array($country_id, $countries))
                        CountryHotel::where('hotel_id', $hotel->id)->where('country_id', $country_id)->delete();
                }
            }
            
            /*attraction_hotels*/
            //add attraction_hotels
            if($nearby_add){
                foreach ($nearby_add as $item) {
                    AttractionHotels::create([
                        'distance' => $item->distance,
                        'position' => $item->position,
                        'hotel_id' => $hotel->id,
                        'attraction_id' => $item->attraction,
                    ]);
                }
            }
            //edit attraction_hotels
            if($nearby_edit){
                foreach ($nearby_edit as $item) {
                    AttractionHotels::where('id', $item->id)->update([
                        'distance' => $item->distance,
                        'position' => $item->position,
                        'attraction_id' => $item->attraction,
                    ]);
                }
            }

            return response()->json(['success' => 'Update to success.', 'url' => route('updateHotelAdmin', $newSlug)]);
        }
        return response()->json([ 'error' => 'Error' ]);
    }

    public function delete($id){
        //delete seos
        deleteSeo($id, 'hotel');
        //delete hotels
        Hotels::where('id', $id)->delete();
        return redirect()->route('hotelsAdmin')->with('success', 'Delete Success.');
    }

    //deleteAll
    public function deleteAll(Request $resquest){
        $message = "error";
        if($resquest->ajax()){
            $items = json_decode($resquest->items);
            //delete seos
            Seo::whereIn('post_id', $items)->where('type', 'hotel')->delete();
            //delete hotels
            if(count($items)>0){
                Hotels::destroy($items);
            }
            $message = "success";
        }
        return $message;
    }


    public function deleteAttHotel(Request $request){
        $msg = 'error';
        if($request->ajax()){
            $attrHotel = AttractionHotels::find($request->id);
            if($attrHotel) $attrHotel->delete();
            $msg = 'success';
        }
        return $msg;
    }

    //search from list
    public function searchFromList(Request $request){
        if($request->ajax()){
            $html = '';
            $hotels = Hotels::where('title', 'LIKE', '%'.$request->keyword.'%')->orderBy('title', 'asc')->get();
            if($hotels){
                foreach($hotels as $item){
                    $html .= '<li class="item-'. $item->id .'" data-id="'. $item->id .'" title="'. $item->title .'">';
                        $html .= $item->title;
                    $html .= '</li>';
                }
            }
            return response()->json(['msg'=>'success', 'html'=>$html]);
        }
        return response()->json(['msg'=>'error']);
    }
}
