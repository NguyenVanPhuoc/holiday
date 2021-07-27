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
use Validator;

class ReviewerAdminController extends Controller
{
   	public function index(){    	
    	$reviews = Reviewers::latest()->paginate(14);    	
    	return view('backend.reviews.list',['reviews'=>$reviews]);
    }
    
    public function store(){    
        $list_groupType = GroupType::orderBy('title')->get();
        $list_destination = Countries::where('parent_id', 0)->orderBy('title')->get();
        $list_tourStyle = CategoryTour::orderBy('title')->get();
        $list_city = getAllCountryByLevel(3, true);
        $data = [];	
        $data['list_groupType'] = $list_groupType;
        $data['list_destination'] = $list_destination;
        $data['list_tourStyle'] = $list_tourStyle;
        $data['list_city'] = $list_city;

    	return view('backend.reviews.create', $data);
    }

    public function create(Request $request){  

        $list_rules = [];
        $list_rules['name'] = 'required';
        $list_rules['title'] = 'required';
        $list_rules['group_type_id'] = 'required';
        $list_rules['list_destination'] = 'required';
        $list_rules['list_tour_style'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, Reviewers::getMessageRule());
        $validator->after(function($validator) use ($request) {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $to_date = date('Y-m-d', strtotime($request->to_date)); 
            if ($to_date < $from_date){ 
                $validator->errors()->add('to_date', 'To date must be later from day');
            }

        });

        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all()]);

        $from_date = ($request->from_date != '') ? date('Y-m-d', strtotime($request->from_date)) : NULL;
        $to_date = ($request->to_date != '') ? date('Y-m-d', strtotime($request->to_date)) : NULL;
        

        //$request['slug'] = $request->name;
        $request['from_date'] = $from_date;
        $request['to_date'] = $to_date;
        $request['list_destination'] = ($request->list_destination != '') ? implode(",", $request->list_destination) : '';
        $request['list_tour_style'] = ($request->list_tour_style != '') ? implode(",", $request->list_tour_style) : '';
        $request['list_city'] = ($request->list_city != '') ? implode(",", $request->list_city) : '';
        $review = Reviewers::create($request->all());
        //update slug
        updateSlug('reviewers', $request->title, $review->id);

        //seos
        createSeo($review->id, 'review', $request->meta_key, $request->meta_value);

        return response()->json(['success' => 'Add to success.', 'url' => route('storeReviewAdmin')]);
    }
    
    public function edit($id){
        $review = Reviewers::find($id); 
        $list_groupType = GroupType::orderBy('title')->get();
        $list_destination = Countries::where('parent_id', 0)->orderBy('title')->get();
        $list_tourStyle = CategoryTour::orderBy('title')->get();
        $list_city = getAllCountryByLevel(3, true);
        
        $data = [];
        $data['review'] = $review;
        $data['list_groupType'] = $list_groupType;
        $data['list_destination'] = $list_destination;
        $data['list_tourStyle'] = $list_tourStyle;
        $data['list_city'] = $list_city;
    	return view('backend.reviews.edit', $data);
    }

    public function update(Request $request, $id){  
        $review = Reviewers::findOrFail($id);

    	$list_rules = [];
        $list_rules['name'] = 'required';
        $list_rules['slug'] = 'required';
        $list_rules['title'] = 'required';
        $list_rules['group_type_id'] = 'required';
        $list_rules['list_destination'] = 'required';
        $list_rules['list_tour_style'] = 'required';

        $validator = Validator::make($request->all(), $list_rules, Reviewers::getMessageRule());
        $validator->after(function($validator) use ($request, $id) {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $to_date = date('Y-m-d', strtotime($request->to_date)); 
            if ($to_date < $from_date){ 
                $validator->errors()->add('to_date', 'To date must be later from day');
            }

            //validate slug
            $checkSlug = Reviewers::where('slug', $request->slug)->where('id', '<>', $id)->count();
            if($checkSlug > 0)
                $validator->errors()->add('slug_exist', 'The slug is already exist');

        });

        if ($validator->fails()) 
            return response()->json([ 'error' => $validator->errors()->all()]);

        $from_date = ($request->from_date != '') ? date('Y-m-d', strtotime($request->from_date)) : NULL;
        $to_date = ($request->to_date != '') ? date('Y-m-d', strtotime($request->to_date)) : NULL;
        //$request['slug'] = $request->name;
        $request['from_date'] = $from_date;
        $request['to_date'] = $to_date;
        $request['list_destination'] = ($request->list_destination != '') ? implode(",", $request->list_destination) : '';
        $request['list_tour_style'] = ($request->list_tour_style != '') ? implode(",", $request->list_tour_style) : '';
        $request['list_city'] = ($request->list_city != '') ? implode(",", $request->list_city) : '';

        //update review
        $review->update($request->only('name', 'slug', 'title', 'title_tag', 'content', 'from_date', 'to_date', 'gallery', 'list_destination', 'list_tour_style', 'list_city', 'group_type_id', 'image', 'banner', 'image_looking', 'image_request'));
        $review->touch();
        updateSlug('reviewers', $request->slug, $id);
        //seos
        updateSeo($id, 'review', $request->meta_key, $request->meta_value);
        return response()->json(['success' => 'Update to success.', 'url' => route('updateReviewAdmin', $id)]);
    }  	
	public function delete($id){
    	$reviewer = Reviewers::find($id);
    	$reviewer->delete();
        Seo::where('type', 'review')->where('post_id', $id)->delete();
    	return redirect()->route('reviewsAdmin')->with('success','Deleted Successfull.');
    }

    public function deleteAll(Request $request){

    }


    public function testExport(){
        $reviews = Reviewers::latest()->paginate(14);       

        /*export file word*/
        /*$html_table = view('backend.reviews.list',['reviews'=>$reviews])->render();
        $str = Reviewers::create_docfile_portrait($html_table);
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=vuviec-mau-3.doc");
        echo $str;*/
    }
}
