<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Consultant;
use App\ConsultantTourGuide;
use App\Media;
use App\Highlight;
use App\Seo;
use App\Countries;
use Validator;

class TourGuideAdminController extends Controller
{
	public function index(Request $request){    	
        $per_page = 14;
        $page = (isset($request->page) && $request->page != '') ? $request->page : 1;
        $request['type'] = 'tour_guide';
        $list_tourGuide = filterConsultantTourGuide($request, $per_page, $page);

        if($request->ajax()){
            $html = view('backend.tourGuides.table', ['list_tourGuide' => $list_tourGuide])->render();
            return response()->json(['html' => 'success', 'html' => $html]);
        }

        $list_tourStyle = get_categories_tour();
        $list_country = getListMainCountry();
        $data = [
            'list_tourGuide' => $list_tourGuide,
            'list_tourStyle' => $list_tourStyle,
            'list_country' => $list_country,
        ];
    	return view('backend.tourGuides.list', $data);
    }

    public function store(){
        $list_country = getListMainCountry();
        $list_tour = getToursOrderByTitle();
        $list_hotel = getHotelsOrderByTitle();
        $list_highlight = Highlight::get();

        $data = [
            'list_country' => $list_country,
            'list_tour' => $list_tour,
            'list_hotel' => $list_hotel,
            'list_highlight' => $list_highlight,
        ];

    	return view('backend.tourGuides.create', $data);
    }

    public function create(Request $request){
        $list_rules = [];
        $list_rules['title'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, getMessageRule());
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        $request['type'] = 'tour_guide';
        $request['favourite_tour'] = (count($request->array_favourite_tour) > 0) ? implode(",", $request->array_favourite_tour) : NULL;
        $request['favourite_highlight'] = (count($request->array_favourite_highlight) > 0) ? implode(",", $request->array_favourite_highlight) : NULL;
        $request['favourite_hotel'] = (count($request->array_favourite_hotel) > 0) ? implode(",", $request->array_favourite_hotel) : NULL;

        /*insert to DB*/
        //consultant_tour_guides
        $consultant_tourGuide = ConsultantTourGuide::create($request->only('title', 'short_desc', 'desc', 'text_tour', 'text_highlight', 'text_hotel', 'favourite_tour', 'favourite_highlight', 'favourite_hotel', 'type', 'country_id', 'image', 'banner'));
        updateSlug('consultant_tour_guides', $request->title, $consultant_tourGuide->id);
        //seos
        createSeo($consultant_tourGuide->id, 'consultant_tour_guide', $request->meta_key, $request->meta_value);

        return response()->json(['success' => 'Add to success.', 'url' => route('storeTourGuideAdmin')]);
    }

    public function edit($id){
    	$tour_guide = ConsultantTourGuide::findOrFail($id);
        $seo = get_seo($tour_guide->id, 'consultant_tour_guide'); 
        $list_country = getListMainCountry();
        $list_tour = getToursOrderByTitle();
        $list_hotel = getHotelsOrderByTitle();
        $list_highlight = Highlight::get();

        $data = [
            'tour_guide' => $tour_guide,
            'seo' => $seo,
            'list_country' => $list_country,
            'list_tour' => $list_tour,
            'list_hotel' => $list_hotel,
            'list_highlight' => $list_highlight,
        ];

        return view('backend.tourGuides.edit', $data);
    }


    public function update($id, Request $request){
        $tour_guide = ConsultantTourGuide::findOrFail($id);
        $list_rules = [];
        $list_rules['title'] = 'required';
        $list_rules['slug'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, getMessageRule());
        if($request->slug != '' && $tour_guide->slug != $request->slug){
            $validator->after(function($validator) use ($request){
                $existSlug = checkExistSlugLevel1($request->slug);
                if($existSlug)
                    $validator->errors()->add('slug', 'The slug is already exist');
            });
        }
        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all() ]);

        $request['favourite_tour'] = (count($request->array_favourite_tour) > 0) ? implode(",", $request->array_favourite_tour) : NULL;
        $request['favourite_highlight'] = (count($request->array_favourite_highlight) > 0) ? implode(",", $request->array_favourite_highlight) : NULL;
        $request['favourite_hotel'] = (count($request->array_favourite_hotel) > 0) ? implode(",", $request->array_favourite_hotel) : NULL;

        /*insert to DB*/
        //consultant_tour_guides
        ConsultantTourGuide::where('id', $id)->update($request->only('title', 'short_desc', 'desc', 'text_tour', 'text_highlight', 'text_hotel', 'favourite_tour', 'favourite_highlight', 'favourite_hotel', 'country_id', 'image', 'banner'));
        updateSlug('consultant_tour_guides', $request->title, $id);
        //seos
        updateSeo($id, 'consultant_tour_guide', $request->meta_key, $request->meta_value);

        return response()->json(['success' => 'Update to success.', 'url' => route('editTourGuideAdmin', $id)]);
    }


    public function delete($id){
        deleteSeo($id, 'consultant_tour_guide');
        ConsultantTourGuide::where('id', $id)->delete();
        return redirect()->route('tourGuidesAdmin')->with('success', 'Delete successfull.');
    }

    public function deleteAll(Request $request){
        $msg = "error";
        if($request->ajax()){
            $items = json_decode($request->items);
            if(count($items)>0){
                Seo::where('type', 'consultant_tour_guide')->whereIn('id', $items)->delete();
                ConsultantTourGuide::destroy($items);
            }
            $msg = "success";
        }
        return $msg;
    }

}