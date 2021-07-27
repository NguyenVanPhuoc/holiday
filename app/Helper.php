<?php
use Illuminate\Support\Facades\DB;
use App\User;
use App\UserMetas;
use App\Options;
use App\Pages;
use App\Media;
use App\Prices;
use App\ArticleCat;
use App\Article;
use App\Seo;
use App\Menu;
use App\MenuMetas;
use App\Brand;
use App\SlideDetail;
use App\Reviewers;
use App\MediaCat;
use App\Countries;
use App\CategoryTour;
use App\CategoryGuide;
use App\Tours;
use App\Duration;
use App\CatIconSchedules;
use App\IconsDetailSchedules;
use App\Guides;
use App\ConsultantTourGuide;
use App\Bloggers;
use App\Metas;
use App\CountryTours;
use App\CategoryFaq;



include('Helpers/TableContent.php');
include('Helpers/Countries.php');
include('Helpers/Hotels.php');
include('Helpers/Hotels.php');
include('Helpers/Attractions.php');
include('Helpers/Tours.php');
include('Helpers/Consultants.php');
include('Helpers/Articles.php');
include('Helpers/CategoryTours.php');
include('Helpers/Durations.php');
include('Helpers/Banner.php');
include('Helpers/Guide.php');
include('Helpers/PostGuide.php');
include('Helpers/Seo.php');
include('Helpers/CountryTourStyle.php');
include('Helpers/CountryTourDuration.php');
include('Helpers/Reviewer.php');
include('Helpers/Page.php');
include('Helpers/ConsultantTourGuide.php');
include('Helpers/Blogger.php');
include('Helpers/Faq.php');
include('Helpers/User.php');
include('Helpers/CategoryGuide.php');
/**
 * option
 */
if (! function_exists('getLogo')) {
	function getLogo(){
		$option = Options::select('logo')->first();
		if($option->logo){
			$image = Media::find($option->logo);
			return imageAuto($image->id,'logo'); 
		}
		return;
	}
}
if (! function_exists('getLogoColorful')) {
	function getLogoColorful(){
		$option = Options::select('logo_colorful')->first();
		if($option->logo_colorful){
			$image = Media::find($option->logo_colorful);
			return imageAuto($image->id,'logo colorful'); 
		}
		return;
	}
}
if (! function_exists('getLogoSonabee')) {
	function getLogoSonabee(){
		$option = Options::select('logo_sonabee')->first();
		if($option->logo_sonabee){
			$image = Media::find($option->logo_sonabee);
			return imageAuto($image->id,'logo_sonabee'); 
		}
		return;
	}
}
if (! function_exists('getLogoInMail')) {
	function getLogoInMail(){
		$option = Options::select('logo')->first();
		if($option->logo){
			$image = Media::find($option->logo);
			return '<img style="display: inline-block; max-width: 100%; height: auto; vertical-align: middle;" 
					src="'.asset("public/uploads").'/'.$image->image_path.'" alt="logo"/>'; 
		}
		return;
	}
}
if (! function_exists('favicon')) {
	function favicon(){
		$option = Options::select('favicon')->first();
		if($option->favicon){
			$image = Media::find($option->favicon);
			return url('/public/uploads').'/'.$image->image_path;
		}
		return;
	}
}
if (! function_exists('mailSystem')) {
    function mailSystem(){
        $option = Options::select('email')->first();
        if($option->email){			
			return $option->email;
		}
		return;
    }
}
if (! function_exists('copyright')) {
	function copyright(){
		$option = Options::select('copyright')->first();
        if($option->copyright) return $option->copyright;
		return;
	}
}
if (! function_exists('address')) {
	function address(){
		$option = Options::select('address')->first();
        if($option->address) return $option->address;
		return;
	}
}
if (! function_exists('phone')) {
	function phone(){
		$option = Options::select('phone')->first();
        if($option->phone)	return $option->phone;
		return;
	}
}
/*
* Socail
*/
if (! function_exists('social')) {
	function social(){
		$option = Options::select('social_media')->find(2);
		$str  = $option->social_media;
		$items = explode(';',$str);
		$html = '<ul class="list-social list-social-1 no-list-style">';
		foreach($items as $item):
			$item = json_decode($item, true);
			$name = $item['name'];
			$link = $item['link'];
			$image = $item['image'];
			if($link !="" && $name == 'Facebook' ):
			$html .= '<li>
				<a href="'.$link.'" target="_blank">
					<span class="icon"><i class="fab fa-facebook-f"></i></span>
					<span class="title">'.$name.'</span>
				</a>
			</li>';
			endif;
			if($link !="" && $name == 'Instagram' ):
			$html .= '<li>
				<a href="'.$link.'" target="_blank">
					<span class="icon"><i class="fab fa-instagram"></i></span>
					<span class="title">'.$name.'</span>
				</a>
			</li>';
			endif;
			if($link !="" && $name == 'Pinterest' ):
			$html .= '<li>
				<a href="'.$link.'" target="_blank">
					<span class="icon"><i class="fa fa-pinterest-p" aria-hidden="true"></i></span>
					<span class="title">'.$name.'</span>
				</a>
			</li>';
			endif;
			if($link !="" && $name == 'Youtube' ):
			$html .= '<li>
				<a href="'.$link.'" target="_blank">
					<span class="icon"><i class="fab fa-youtube"></i></span>
					<span class="title">'.$name.'</span>
				</a>
			</li>';
			endif;
			if($link !="" && $name == 'Twitter' ):
			$html .= '<li>
				<a href="'.$link.'" target="_blank">
					<span class="icon"><i class="fab fa-twitter"></i></span>
					<span class="title">'.$name.'</span>
				</a>
			</li>';
			endif;
		endforeach;
		$html .= '</ul>';
		return $html;
	}
}
/*
* Socail2
*/
if (! function_exists('social2')) {
	function social2(){
		$option = Options::select('social_media')->find(2);
		$str  = $option->social_media;
		$items = explode(';',$str);
		$html = '<div class="list-social2">';
		foreach($items as $item):
			$item = json_decode($item, true);
			$name = $item['name'];
			$link = $item['link'];
			$image = $item['image'];
			if($link !="" && $name == 'Tripadvisor' ):
			$html .= '<div class="item icon">
                    <a href="'.$link.'" target="_blank">
                        <img src="'.getImgUrl($image).'" alt="image">
                    </a>
                </div>';
			endif;
			if($link !="" && $name == 'Routard' ):
			$html .= '<div class="item">
                    <a href="'.$link.'" target="_blank">
                        <img src="'.getImgUrl($image).'" alt="image">
                    </a>
                </div>';
			endif;
			if($link !="" && $name == 'Petitfute' ):
			$html .= '<div class="item icon">
                    <a href="'.$link.'" target="_blank">
                        <img src="'.getImgUrl($image).'" alt="image">
                    </a>
                </div>';
			endif;	
		endforeach;
		$html .= '</div>';
		return $html;
	}
}
/*
* Socail3
*/
if (! function_exists('social3')) {
	function social3(){
		$option = Options::select('social_media')->find(2);
		$str  = $option->social_media;
		$items = explode(';',$str);
		$html = '<ul class="icon">';
		foreach($items as $item):
			$item = json_decode($item, true);
			$name = $item['name'];
			$link = $item['link'];
			$image = $item['image'];
			if($link !="" && $name == 'Tripadvisor' ):
			$html .= '<li>
        				<a href="'.$link.'" target="_blank">
	                        <img src="'.getImgUrl($image).'" alt="image" class="show">
	                        <img src="'.asset('public/images/temp/tripadvisor - Green.png').'" alt="image" class="hide">
	                    </a>
	                </li>';
			endif;
			if($link !="" && $name == 'Petitfute' ):
			$html .= '<li>
        				<a href="#" target="_blank">
	                        <img src="'.getImgUrl($image).'" alt="image" class="show">
	                        <img src="'.asset('public/images/temp/Petit-fute-color.png').'" alt="image" class="hide">
	                    </a>
	                </li>';
			endif;
			if($link !="" && $name == 'Facebook' ):
			$html .= '<li class="size_thumb">
        				<a href="#" target="_blank">
	                        <img src="'.asset('public/images/temp/facebook.png').'" alt="image" class="show">
	                        <img src="'.asset('public/images/temp/Facebook- blue.png').'" alt="image" class="hide">
	                    </a>
	                </li>';
			endif;	
		endforeach;
		$html .= '</ul>';
		return $html;
	}
}
/*
* Socail blog
*/

if (! function_exists('socialBlog')) {
	function socialBlog(){
		$option = Options::select('facebook','youtube','google','twitter','instagram')->first();
		$html = '<ul class="list-social list-social-1 no-list-style">';
		if($option->facebook!="" || $option->facebook!=null)
			$html .= '<li>
				<a href="'.$option->facebook.'" target="_blank">
					<span class="icon">
						<img class="not-hover" src="'.asset('public/images/icons/facebook.png').'" alt="">
						<img class="hover" src="'.asset('public/images/icons/facebook-gold.png').'" alt="">
					</span>
					<span class="title">Facebook</span>
				</a>
			</li>';
		if($option->youtube!="" || $option->youtube!=null)
			$html .= '<li>
				<a href="'.$option->youtube.'" target="_blank">
					<span class="icon">
						<img class="not-hover" src="'.asset('public/images/icons/youtube.png').'" alt="">
						<img class="hover" src="'.asset('public/images/icons/youtube-gold.png').'" alt="">
					</span>
					<span class="title">Youtube</span>
				</a>
			</li>';            
		if($option->twitter!="" || $option->twitter!=null)
			$html .= '<li>
				<a href="'.$option->twitter.'" target="_blank">
					<span class="icon">
						<img class="not-hover" src="'.asset('public/images/icons/twitter.png').'" alt="">
						<img class="hover" src="'.asset('public/images/icons/twitter-gold.png').'" alt="">
					</span>
					<span class="title">Twitter</span>
				</a>
			</li>';
		if($option->instagram!="" || $option->instagram!=null)
			$html .= '<li>
				<a href="'.$option->instagram.'" target="_blank">
					<span class="icon">
						<img class="not-hover" src="'.asset('public/images/icons/instagram.png').'" alt="">
						<img class="hover" src="'.asset('public/images/icons/instagram-gold.png').'" alt="">
					</span>
					<span class="title">Instagram</span>
				</a>
			</li>';
		$html .= '</ul>';
		return $html;
	}
}


/**
 * Socail share
 */
if (! function_exists('socialShare')) {
	function socialShare($url, $title){	
		$shares = Share::load($url, $title)->services('facebook', 'gplus', 'twitter');
		$html = '';
		foreach($shares as $key => $value):
			switch ($key) {
				case 'facebook':
					$icon = '<i class="fab fa-facebook-f"></i>';
					break;
				case 'gplus':
					$icon = '<i class="fab fa-google-plus-g"></i>';
					break;	
				default:
					$icon = '<i class="fab fa-twitter"></i>';
					break;
			}
			$html .= '<li><a href="'.$value.'" class="'.$key.'" target="_blank">'.$icon.'</a></li>';
		endforeach;		
		return $html;
	}
}
/**
 * media
 */
if (! function_exists('getMedia')) {
	function getMedia($id){
		return Media::find($id);
	}
}
if (! function_exists('media')) {
	function media(){
		$user = Auth::User();
		$media = Media::latest()->where('user_id',$user->id)->get();
		$html = "";
		if(count($media)>0):
			$html .="<ul class='list-media'>";
			foreach ($media as $item) {
				$path = url('/').'/image/'.$item->image_path.'/150/100';
				$html .= '<li id="image-'.$item->id.'"><div class="wrap"><img src="'.$path.'" alt="'.$item->image_path.'" data-date="'.$item->updated_at.'" data-image="'.url('public/uploads').'/'.$item->image_path.'" /></div></li>';
			}
			$html .= "</ul>";
		endif;
		return $html;
	}
}
if (! function_exists('getMediaCats')) {
	function getMediaCats(){
		return MediaCat::orderBy('position', 'asc')->get();
	}
}
if (! function_exists('getMediaCat')) {
	function getMediaCat($id){
		return MediaCat::find($id);
	}
}
if (! function_exists('getAuthor')) {
	function getAuthor(){
		return User::where('level', '=', 'admin')->orderBy('created_at', 'desc')->get();
	}
}
/**
 * custom image
 * @var string url, width, height, alt
 * @return string url
 */
if (! function_exists('image')) {
	function image($id='', $w, $h, $alt){
		$image = Media::find($id);
		if(!empty($image))
			$html = '<img src="/image/'.$image->image_path.'/'.$w.'/'.$h.'" alt="'.$alt.'"/>';
		else
			$html = '<img src="/image/noimage.png/'.$w.'/'.$h.'" alt="'.$alt.'"/>';
		return $html;
	}
}
//image auto
if (! function_exists('imageAuto')) {
	function imageAuto($id, $alt){
		$image = Media::find($id);
		if(!empty($image))
			$html = '<img src="/public/uploads/'.$image->image_path.'" alt="'.$alt.'">';
		else
			$html = '<img src="/public/uploads/noimage.png" alt="'.$alt.'"/>';
		return $html;
	}
}
//image auto
if (! function_exists('getImgUrl')) {
	function getImgUrl($id){
		$image = Media::find($id);
		if(!empty($image))
			$imgUrl = url('/public/uploads').'/'.$image->image_path;
		else
			$imgUrl = url('/public/uploads/noimage.png');
		return $imgUrl;
	}
}
//image auto
if (! function_exists('imageAuto')) {
	function imageAuto($id, $alt){
		$image = Media::find($id);
		if(!empty($image))
			$html = '<img src="'.url('/public/uploads').'/'.$image->image_path.'" alt="'.$alt.'">';
		else
			$html .= '<img src="'.url('/public/uploads/noimage.png').'" alt="'.$alt.'"/>';
		return $html;
	}
}

if (! function_exists('getImgUrlConfig')) {
	function getImgUrlConfig($id,$w,$h){
		$image = Media::find($id);
		if(!empty($image))
			$imgUrl = route('home').'/image/'.$image->image_path.'/'.$w.'/'.$h;
		else
			$imgUrl = route('home').'/image/noimage.png/'.$w.'/'.$h;
		return $imgUrl;
	}
}

if (! function_exists('image_multi_country')) {
	function image_multi_country($id='', $w, $h, $alt){
		$image = Media::find($id);
		if(!empty($image))
			$html = '<img src="/image/'.$image->image_path.'/'.$w.'/'.$h.'" alt="'.$alt.'"/>';
		else
			$html = '<img src="/public/images/multi-country.jpg/'.$w.'/'.$h.'" alt="'.$alt.'"/>';
		return $html;
	}
}

/**
* create tracking order
*/
if (! function_exists('tracking')) {
	function tracking(){
		return substr(base64_encode(sha1(mt_rand())), 0, 10);
	}
}

//number format
if (! function_exists('currency')) {
	function currency($number){
		return number_format($number,'0',',','.').' đ';
	}
}
if (! function_exists('numberFormat')) {
	function numberFormat($number){         
		return number_format($number,0,".",".");
	}
}
/**
 * order status
 */
if (! function_exists('getStatus')) {
	function getStatus($code){
		switch ($code) {
			case 1:
				return "Chờ duyệt";
				break;
			case 2:
				return "Đã duyệt";
				break;
			case 3:
				return "Lưu nháp";
				break;			
			default:
				return "Hủy";
				break;
		}
	}
}
if (! function_exists('getStatusHtml')) {
	function getStatusHtml($id,$status){
		if($status != ''){
			$value = $status;
			$title = getStatus($status);
			$class = ' class="active"';
		}else{			
			$value = 2;
			$title = getStatus(2);
		}
		$html = '<a href="#" class="dropdown-toggle" id="'.$id.'" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-value="'.$value.'">'.$title.'</a>';
		$html .='<div class="dropdown-menu" aria-labelledby="'.$id.'">';
		$html .='<div class="list-item">';
		for($i=1; $i<5; $i++){
			if($i==$value)
				$html .='<a href="#" data-value="'.$i.'" class="active">'.getStatus($i).'</a>';	
			else
				$html .='<a href="#" data-value="'.$i.'">'.getStatus($i).'</a>';
		}
		$html .='</div>';
		$html .='</div>';
		return $html;
	}
}
//get user by ID
if (! function_exists('getUser')) {
	function getUser($id){        
		return User::find($id);
	}
}
if (! function_exists('getUserMeta')) {
	function getUserMeta($id){
		return UserMetas::where('user_id',$id)->first();
	}
}
if (! function_exists('getRoleHtml')) {
	function getRoleHtml($level=null){		
		$roles = array('admin' =>'Admin', 'editor'=>'Editor', 'member'=>'Member');
		$html ='<select name="role">';
		$html .='<option value="">--Select--</option>';
		foreach ($roles as $key => $value) {
			if($key == $level)
				$checked = ' selected';
			else
				$checked = '';
			$html .='<option value="'.$key.'"'.$checked.'>'.$value.'</option>';	
		}
		$html .='</select>';
		return $html;
	}
}
//get page by id
if (! function_exists('getPage')) {
	function getPage($id){
		return Pages::find($id);
	}
}

//date convert
if (! function_exists('dateConvert')) {
	function dateConvert($date){
		return date('Y-m-d',strtotime($date));
	}
}
//date show
if (! function_exists('dateShow')) {
	function dateShow($date){
		return date('d/m/Y',strtotime($date));
	}
}

// date month/day/yeader
if (! function_exists('dateMonthFirst')) {
	function dateMonthFirst($date){
		return date('M d, Y',strtotime($date));
	}
}
//number format
if (! function_exists('removeDot')) {
	function removeDot($number){
		return str_replace(".","",$number);
	}
}
//routes
if (! function_exists('get_routes')) {
	function get_routes(){        
		return TourCat::orderBy('position', 'asc')->get();
	}
}
if (! function_exists('get_route')) {
	function get_route($id){        
		return TourCat::find($id);
	}
}
//blog
if (! function_exists('get_categories')) {
	function get_categories(){        
		return ArticleCat::orderBy('position', 'asc')->get();
	}
}
//countries
if (! function_exists('get_countries')) {
	function get_countries($id){        
		return Countries::find($id);
	}
}

if (! function_exists('get_category')) {
	function get_category($id){        
		return ArticleCat::find($id);
	}
}
if (! function_exists('get_category_icon_schedules')) {
	function get_category_icon_schedules($id){        
		return CatIconSchedules::find($id);
	}
}
if (! function_exists('get_category_media')) {
	function get_category_media($id){        
		return MediaCat::find($id);
	}
}

if (! function_exists('get_newBlog')) {
	function get_newBlog($offset, $number){        
		return Article::orderBy('created_at', 'asc')->offset($offset)->limit($number)->get();
	}
}
if (! function_exists('countRecoredCat')) {
	function countRecoredCat($id){        
		return Article::where('cat_id',$id)->count();
	}
}
//get name ids
if (! function_exists('get_titleByIds')) {
	function get_titleByIds($ids, $type){
		$list_ids = explode(",", $ids);
		$list = array();
		$count = 0;
		switch ($type) {
			case 'route':
			foreach ($list_ids as $id) {
				$type = get_route($id);
				if($type){
					$list[$count] = $type->title;
					$count++;    
				}
			}
			break;
			case 'category':
			foreach ($list_ids as $id) {
				$type = get_category($id);
				if($type){
					$list[$count] = $type->title;
					$count++;    
				}
			}
			break;            
			default:
			$list = array();
			break;
		}         
		return $list;
	}
}


/**
 * Menu
 */
if (! function_exists('menuType')) {
	function menuType($type=null){        
		$html ='<div class="dropdown show type col-md-5">';
		$html .= '<a class="dropdown-toggle" href="#" role="button" id="dropdown-type" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.getNameType($type).'</a>';            
		$html .= '<div class="dropdown-menu" aria-labelledby="dropdown-type">';
		$html .='<div class="list-item">';
		if($type == "home")
			$html .= '<a href="#home" data-value="trang chủ" class="active">Trang chủ</a>';
		else
			$html .= '<a href="#home" data-value="trang chủ">Trang chủ</a>';
		if($type == "page")
			$html .= '<a href="#page" data-value="trang nội dung" class="active">Trang nội dung</a>';
		else
			$html .= '<a href="#page" data-value="trang nội dung">Trang nội dung</a>';
		if($type == "blog")
			$html .= '<a href="#blog" data-value="blog" class="active">Blog</a>';
		else
			$html .= '<a href="#blog" data-value="blog">Blog</a>';
		if($type == "category")
			$html .= '<a href="#category" data-value="Danh mục" class="active">Danh mục blog</a>';
		else
			$html .= '<a href="#category" data-value="Danh mục">Danh mục blog</a>';
		if($type == "link")
			$html .= '<a href="#link" data-value="link chỉ định" class="active">Link chỉ định</a>';
		else
			$html .= '<a href="#link" data-value="link chỉ định">Link chỉ định</a>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		return $html;
	}
}
/**
 * slides
 */
if (! function_exists('getSlideDetail')) {
	function getSlideDetail($id){
		return SlideDetail::where('slide_id',$id)->orderBy('position','asc')->get();
	}
}
//get sub menu
if (! function_exists('getSubMenu')) {
	function getSubMenu($id){
		return MenuMetas::where('parent',0)->where('menu_id',$id)->orderBy('position','asc')->get();
	}
}
if (! function_exists('get_childrenMenu')) {
	function get_childrenMenu($id){
		return MenuMetas::where('parent',$id)->orderBy('position','asc')->get();
	}
}
//get name type
if (! function_exists('getNameType')) {
	function getNameType($type){        
		switch ($type) {
			case 'home':
			$text = "Trang chủ";
			break;
			case 'page':
			$text = "Trang nội dung";
			break;
			case 'product':
			$text = "Sản phẩm";
			break;
			case 'products':
			$text = "Tất cả sản phẩm";
			break;
			case 'collection':
			$text = "Danh mục sản phẩm";
			break;
			case 'blog':
			$text = "Blog";
			break;

			default:
			$text = "Link chỉ định";
			break;
		}
		return $text;
	}
}
if (! function_exists('get_link')) {
	function get_link($id){
		$menuMeta = MenuMetas::find($id);
		switch ($menuMeta->type) {
			case 'home':
				$html = url('/');
				break;
			case 'page':
				$object = Pages::find($menuMeta->value);
				$html = url('/p/'.$object->slug.'.html');
				break;
			case 'blog':
				$object = Article::find($menuMeta->value);
				$html = url('/tin-tuc/'.$object->slug.'.html');
				break;
			case 'category':
				$object = ArticleCat::find($menuMeta->value);
				if($object)
					$html = url('/b/'.$object->slug.'.html');
				else
					$html = url('/');
				break;
			case 'link':
			$html = url($menuMeta->value);
			break;

			default:
				$html = "#";
				break;
		}
		return $html;
	}
}
//get menu
if (! function_exists('get_parentMenu')) {
	function get_parentMenu($id){        
		return Menu::find($id);
	}
}
//get submenu by id
if (! function_exists('get_menu')) {
	function get_menu($id){        
		return MenuMetas::where('menu_id',$id)->where('parent',0)->orderBy('position', 'asc')->get();
	}
}
//limit string
if (! function_exists('str_limit')) {
	function str_limit($str, $number){        
		return str_limit($str, $number, '...');
	}
}
/**
 * views
 */
if (! function_exists('set_view')) {
	function set_view($id){
		$blog = Article::find($id);
		$blog->view = $blog->view + 1;
		$blog->save();
	}
}
/**
 * brands
 */
if (! function_exists('get_brands')) {
	function get_brands(){        
		return Brand::latest()->get();
	}
}
/**
 * Money
 */
if (! function_exists('getTypeMoney')) {
	function getTypeMoney(){
		return array('1'=>array('id'=>1,'name'=>'VND','proportion'=>1),);
	}
}
if (! function_exists('get_money')) {
	function get_money($id){
		return getTypeMoney()[$id];
	}
}
/**
 * reviews
 */
if (! function_exists('getReviews')) {
	function getReviews(){
		return Reviewers::select('name','image','content')->orderBy('updated_at', 'desc')->paginate(14);
	}
}

//
/*if (! function_exists('getParentCountry')) {
	function getParentCountry($country_id){
		$countries = Countries::where('parent_id', $country_id)->get();
		return $countries;
	}
}*/

if (! function_exists('getCountryById')) {
	function getCountryById($id){
		$country = Countries::findOrFail($id);
		if($country)
			return $country;
		return;
	}
}

if (! function_exists('getParentCountry')) {
	function getParentCountry($country_id, $level){
		$countries = Countries::where('parent_id', $country_id)->orderBy('title', 'asc')->get();
		$html = '';
		if(!empty($countries)){
			$level ++;
			$c = '';
			if($level > 1){
				for($i=0; $i<$level-1;$i++){
					$c .= '&nbsp;&nbsp;&nbsp;';
				}
			}
 			foreach($countries as $item){
				$html .= '<li><a href="#'.$item->slug.'" data-value="'.$item->id.'" >'.$c.$item->title.'</a></li>';
				$html .= getParentCountry($item->id, $level);
			}
		}
		return $html;
	}
}

if (! function_exists('getListCheckCountry')) {
	function getListCheckCountry($country_id, $level){
		$countries = Countries::where('parent_id', $country_id)->get();
		$html = '';
		if(!empty($countries)){
			$level ++;
			$c = '';
			if($level > 1){
				for($i=0; $i<$level-1;$i++){
					$c .= '<span class="empty-padding"></span>';
				}
			}
 			foreach($countries as $item){
				$html .= '<li class="checkbox checkbox-success">'.$c.
							'<input value="'.$item->id.'" type="checkbox" name="country[]" id="country-'.$item->id.'">
							<label for="country-'.$item->id.'">'.$item->title.'</label>
						</li>';
				$html .= getListCheckCountry($item->id, $level);
			}
		}
		return $html;
	}
}

if (! function_exists('getListCheckParentCountry')) {
	function getListCheckParentCountry(){
		$countries = Countries::where('parent_id', 0)->get();
		$html = '';
		if(!empty($countries)){
 			foreach($countries as $item){
				$html .= '<li class="checkbox checkbox-success">
							<input value="'.$item->id.'" type="checkbox" name="country[]" id="country-'.$item->id.'">
							<label for="country-'.$item->id.'">'.$item->title.'</label>
						</li>';
			}
		}
		return $html;
	}
}


if (! function_exists('getListCheckCategoryFaqs')) {
	function getListCheckCategoryFaqs($array = array()){
		$category = CategoryFaq::orderBy('title', 'asc')->get();;
		$html = '';
		if(!empty($category)){
 			foreach($category as $item){
				$html .= '<li class="checkbox checkbox-success">
							<input value="'.$item->id.'" type="checkbox" name="cat_id[]" id="cat_id-'.$item->id.'"'.(in_array($item->id, $array) ? 'checked' : '').'>
							<label for="cat_id-'.$item->id.'">'.$item->title.'</label>
						</li>';
			}
		}
		return $html;
	}
}
/*
* load object 
*/
if(!function_exists('load_object')){
	function load_object(){
		$objs = json_decode('[
		{"ccode":"US","value":"1","name":"USA","mcode":"+1"},
		{"ccode":"GB","value":"44","name":"UK","mcode":"+44"},
		{"ccode":"DZ","value":"213","name":"Algeria","mcode":"+213"},
		{"ccode":"AD","value":"376","name":"Andorra","mcode":"+376"},
		{"ccode":"AO","value":"244","name":"Angola","mcode":"+244"},
		{"ccode":"AI","value":"1264","name":"Anguilla","mcode":"+1264"},
		{"ccode":"AG","value":"1268","name":"Antigua & Barbuda","mcode":"+1268"},
		{"ccode":"AR","value":"54","name":"Argentina","mcode":"+54"},
		{"ccode":"AM","value":"374","name":"Armenia","mcode":"+374"},
		{"ccode":"AW","value":"297","name":"Aruba","mcode":"+297"},
		{"ccode":"AU","value":"61","name":"Australia","mcode":"+61"},
		{"ccode":"AT","value":"43","name":"Austria","mcode":"+43"},
		{"ccode":"AZ","value":"994","name":"Azerbaijan","mcode":"+994"},
		{"ccode":"BS","value":"1242","name":"Bahamas","mcode":"+1242"},
		{"ccode":"BH","value":"973","name":"Bahrain","mcode":"+973"},
		{"ccode":"BD","value":"880","name":"Bangladesh","mcode":"+880"},
		{"ccode":"BB","value":"1246","name":"Barbados","mcode":"+1246"},
		{"ccode":"BY","value":"375","name":"Belarus","mcode":"+375"},
		{"ccode":"BE","value":"32","name":"Belgium","mcode":"+32"},
		{"ccode":"BZ","value":"501","name":"Belize","mcode":"+501"},
		{"ccode":"BJ","value":"229","name":"Benin","mcode":"+229"},
		{"ccode":"BM","value":"1441","name":"Bermuda","mcode":"+1441"},
		{"ccode":"BT","value":"975","name":"Bhutan","mcode":"+975"},
		{"ccode":"BO","value":"591","name":"Bolivia","mcode":"+591"},
		{"ccode":"BA","value":"387","name":"BosniaHerzegovina","mcode":"+387"},
		{"ccode":"BW","value":"267","name":"Botswana","mcode":"+267"},
		{"ccode":"BR","value":"55","name":"Brazil","mcode":"+55"},
		{"ccode":"BN","value":"673","name":"Brunei","mcode":"+673"},
		{"ccode":"BG","value":"359","name":"Bulgaria","mcode":"+359"},
		{"ccode":"BF","value":"226","name":"BurkinaFaso","mcode":"+226"},
		{"ccode":"BI","value":"257","name":"Burundi","mcode":"+257"},
		{"ccode":"KH","value":"855","name":"Cambodia","mcode":"+855"},
		{"ccode":"CM","value":"237","name":"Cameroon","mcode":"+237"},
		{"ccode":"CA","value":"1","name":"Canada","mcode":"+1"},
		{"ccode":"CV","value":"238","name":"Cape Verde Islands","mcode":"+238"},
		{"ccode":"KY","value":"1345","name":"Cayman Islands","mcode":"+1345"},
		{"ccode":"CF","value":"236","name":"Central African Republic","mcode":"+236"},
		{"ccode":"CL","value":"56","name":"Chile","mcode":"+56"},
		{"ccode":"CN","value":"86","name":"China","mcode":"+86"},
		{"ccode":"CO","value":"57","name":"Colombia","mcode":"+57"},
		{"ccode":"KM","value":"269","name":"Comoros","mcode":"+269"},
		{"ccode":"CG","value":"242","name":"Congo","mcode":"+242"},
		{"ccode":"CK","value":"682","name":"CookIslands","mcode":"+682"},
		{"ccode":"CR","value":"506","name":"CostaRica","mcode":"+506"},
		{"ccode":"HR","value":"385","name":"Croatia","mcode":"+385"},
		{"ccode":"CU","value":"53","name":"Cuba","mcode":"+53"},
		{"ccode":"CY","value":"90","name":"Cyprus-North","mcode":"+90"},
		{"ccode":"CY","value":"357","name":"Cyprus-South","mcode":"+357"},
		{"ccode":"CZ","value":"420","name":"Czech Republic","mcode":"+420"},
		{"ccode":"DK","value":"45","name":"Denmark","mcode":"+45"},
		{"ccode":"DJ","value":"253","name":"Djibouti","mcode":"+253"},
		{"ccode":"DM","value":"1809","name":"Dominica","mcode":"+1809"},
		{"ccode":"DO","value":"1809","name":"DominicanRepublic","mcode":"+1809"},
		{"ccode":"EC","value":"593","name":"Ecuador","mcode":"+593"},
		{"ccode":"EG","value":"20","name":"Egypt","mcode":"+20"},
		{"ccode":"SV","value":"503","name":"El Salvador","mcode":"+503"},
		{"ccode":"GQ","value":"240","name":"Equatorial Guinea","mcode":"+240"},
		{"ccode":"ER","value":"291","name":"Eritrea","mcode":"+291"},
		{"ccode":"EE","value":"372","name":"Estonia","mcode":"+372"},
		{"ccode":"ET","value":"251","name":"Ethiopia","mcode":"+251"},
		{"ccode":"FK","value":"500","name":"Falkland Islands","mcode":"+500"},
		{"ccode":"FO","value":"298","name":"Faroe Islands","mcode":"+298"},
		{"ccode":"FJ","value":"679","name":"Fiji","mcode":"+679"},
		{"ccode":"FI","value":"358","name":"Finland","mcode":"+358"},
		{"ccode":"FR","value":"33","name":"France","mcode":"+33"},
		{"ccode":"GF","value":"594","name":"French Guiana","mcode":"+594"},
		{"ccode":"PF","value":"689","name":"French Polynesia","mcode":"+689"},
		{"ccode":"GA","value":"241","name":"Gabon","mcode":"+241"},
		{"ccode":"GM","value":"220","name":"Gambia","mcode":"+220"},
		{"ccode":"GE","value":"7880","name":"Georgia","mcode":"+7880"},
		{"ccode":"DE","value":"49","name":"Germany","mcode":"+49"},
		{"ccode":"GH","value":"233","name":"Ghana","mcode":"+233"},
		{"ccode":"GI","value":"350","name":"Gibraltar","mcode":"+350"},
		{"ccode":"GR","value":"30","name":"Greece","mcode":"+30"},
		{"ccode":"GL","value":"299","name":"Greenland","mcode":"+299"},
		{"ccode":"GD","value":"1473","name":"Grenada","mcode":"+1473"},
		{"ccode":"GP","value":"590","name":"Guadeloupe","mcode":"+590"},
		{"ccode":"GU","value":"671","name":"Guam","mcode":"+671"},
		{"ccode":"GT","value":"502","name":"Guatemala","mcode":"+502"},
		{"ccode":"GN","value":"224","name":"Guinea","mcode":"+224"},
		{"ccode":"GW","value":"245","name":"Guinea-Bissau","mcode":"+245"},
		{"ccode":"GY","value":"592","name":"Guyana","mcode":"+592"},
		{"ccode":"HT","value":"509","name":"Haiti","mcode":"+509"},
		{"ccode":"HN","value":"504","name":"Honduras","mcode":"+504"},
		{"ccode":"HK","value":"852","name":"HongKong","mcode":"+852"},
		{"ccode":"HU","value":"36","name":"Hungary","mcode":"+36"},
		{"ccode":"IS","value":"354","name":"Iceland","mcode":"+354"},
		{"ccode":"IN","value":"91","name":"India","mcode":"+91"},
		{"ccode":"ID","value":"62","name":"Indonesia","mcode":"+62"},
		{"ccode":"IQ","value":"964","name":"Iraq","mcode":"+964"},
		{"ccode":"IR","value":"98","name":"Iran","mcode":"+98"},
		{"ccode":"IE","value":"353","name":"Ireland","mcode":"+353"},
		{"ccode":"IL","value":"972","name":"Israel","mcode":"+972"},
		{"ccode":"IT","value":"39","name":"Italy","mcode":"+39"},
		{"ccode":"JM","value":"1876","name":"Jamaica","mcode":"+1876"},
		{"ccode":"JP","value":"81","name":"Japan","mcode":"+81"},
		{"ccode":"JO","value":"962","name":"Jordan","mcode":"+962"},
		{"ccode":"KZ","value":"7","name":"Kazakhstan","mcode":"+7"},
		{"ccode":"KE","value":"254","name":"Kenya","mcode":"+254"},
		{"ccode":"KI","value":"686","name":"Kiribati","mcode":"+686"},
		{"ccode":"KP","value":"850","name":"Korea-North","mcode":"+850"},
		{"ccode":"KR","value":"82","name":"Korea-South","mcode":"+82"},
		{"ccode":"KW","value":"965","name":"Kuwait","mcode":"+965"},
		{"ccode":"KG","value":"996","name":"Kyrgyzstan","mcode":"+996"},
		{"ccode":"LA","value":"856","name":"Laos","mcode":"+856"},
		{"ccode":"LV","value":"371","name":"Latvia","mcode":"+371"},
		{"ccode":"LB","value":"961","name":"Lebanon","mcode":"+961"},
		{"ccode":"LS","value":"266","name":"Lesotho","mcode":"+266"},
		{"ccode":"LR","value":"231","name":"Liberia","mcode":"+231"},
		{"ccode":"LY","value":"218","name":"Libya","mcode":"+218"},
		{"ccode":"LI","value":"417","name":"Liechtenstein","mcode":"+417"},
		{"ccode":"LT","value":"370","name":"Lithuania","mcode":"+370"},
		{"ccode":"LU","value":"352","name":"Luxembourg","mcode":"+352"},
		{"ccode":"MO","value":"853","name":"Macao","mcode":"+853"},
		{"ccode":"MK","value":"389","name":"Macedonia","mcode":"+389"},
		{"ccode":"MG","value":"261","name":"Madagascar","mcode":"+261"},
		{"ccode":"MW","value":"265","name":"Malawi","mcode":"+265"},
		{"ccode":"MY","value":"60","name":"Malaysia","mcode":"+60"},
		{"ccode":"MV","value":"960","name":"Maldives","mcode":"+960"},
		{"ccode":"ML","value":"223","name":"Mali","mcode":"+223"},
		{"ccode":"MT","value":"356","name":"Malta","mcode":"+356"},
		{"ccode":"MH","value":"692","name":"Marshall Islands","mcode":"+692"},
		{"ccode":"MQ","value":"596","name":"Martinique","mcode":"+596"},
		{"ccode":"MR","value":"222","name":"Mauritania","mcode":"+222"},
		{"ccode":"YT","value":"269","name":"Mayotte","mcode":"+269"},
		{"ccode":"MX","value":"52","name":"Mexico","mcode":"+52"},
		{"ccode":"FM","value":"691","name":"Micronesia","mcode":"+691"},
		{"ccode":"MD","value":"373","name":"Moldova","mcode":"+373"},
		{"ccode":"MC","value":"377","name":"Monaco","mcode":"+377"},
		{"ccode":"MN","value":"976","name":"Mongolia","mcode":"+976"},
		{"ccode":"MS","value":"1664","name":"Montserrat","mcode":"+1664"},
		{"ccode":"MA","value":"212","name":"Morocco","mcode":"+212"},
		{"ccode":"MZ","value":"258","name":"Mozambique","mcode":"+258"},
		{"ccode":"MN","value":"95","name":"Myanmar","mcode":"+95"},
		{"ccode":"NA","value":"264","name":"Namibia","mcode":"+264"},
		{"ccode":"NR","value":"674","name":"Nauru","mcode":"+674"},
		{"ccode":"NP","value":"977","name":"Nepal","mcode":"+977"},
		{"ccode":"NL","value":"31","name":"Netherlands","mcode":"+31"},
		{"ccode":"NC","value":"687","name":"NewCaledonia","mcode":"+687"},
		{"ccode":"NZ","value":"64","name":"NewZealand","mcode":"+64"},
		{"ccode":"NI","value":"505","name":"Nicaragua","mcode":"+505"},
		{"ccode":"NE","value":"227","name":"Niger","mcode":"+227"},
		{"ccode":"NG","value":"234","name":"Nigeria","mcode":"+234"},
		{"ccode":"NU","value":"683","name":"Niue","mcode":"+683"},
		{"ccode":"NF","value":"672","name":"Norfolk Islands","mcode":"+672"},
		{"ccode":"NP","value":"670","name":"Northern Marianas","mcode":"+670"},
		{"ccode":"NO","value":"47","name":"Norway","mcode":"+47"},
		{"ccode":"OM","value":"968","name":"Oman","mcode":"+968"},
		{"ccode":"PK","value":"92","name":"Pakistan","mcode":"+92"},
		{"ccode":"PW","value":"680","name":"Palau","mcode":"+680"},
		{"ccode":"PA","value":"507","name":"Panama","mcode":"+507"},
		{"ccode":"PG","value":"675","name":"Papua New Guinea","mcode":"+675"},
		{"ccode":"PY","value":"595","name":"Paraguay","mcode":"+595"},
		{"ccode":"PE","value":"51","name":"Peru","mcode":"+51"},
		{"ccode":"PH","value":"63","name":"Philippines","mcode":"+63"},
		{"ccode":"PL","value":"48","name":"Poland","mcode":"+48"},
		{"ccode":"PT","value":"351","name":"Portugal","mcode":"+351"},
		{"ccode":"PR","value":"1787","name":"PuertoRico","mcode":"+1787"},
		{"ccode":"QA","value":"974","name":"Qatar","mcode":"+974"},
		{"ccode":"RE","value":"262","name":"Reunion","mcode":"+262"},
		{"ccode":"RO","value":"40","name":"Romania","mcode":"+40"},
		{"ccode":"RU","value":"7","name":"Russia","mcode":"+7"},
		{"ccode":"RW","value":"250","name":"Rwanda","mcode":"+250"},
		{"ccode":"SM","value":"378","name":"SanMarino","mcode":"+378"},
		{"ccode":"ST","value":"239","name":"SaoTome & Principe","mcode":"+239"},
		{"ccode":"SA","value":"966","name":"Saudi Arabia","mcode":"+966"},
		{"ccode":"SN","value":"221","name":"Senegal","mcode":"+221"},
		{"ccode":"CS","value":"381","name":"Serbia","mcode":"+381"},
		{"ccode":"SC","value":"248","name":"Seychelles","mcode":"+248"},
		{"ccode":"SL","value":"232","name":"Sierra Leone","mcode":"+232"},
		{"ccode":"SG","value":"65","name":"Singapore","mcode":"+65"},
		{"ccode":"SK","value":"421","name":"Slovak Republic","mcode":"+421"},
		{"ccode":"SI","value":"386","name":"Slovenia","mcode":"+386"},
		{"ccode":"SB","value":"677","name":"Solomon Islands","mcode":"+677"},
		{"ccode":"SO","value":"252","name":"Somalia","mcode":"+252"},
		{"ccode":"ZA","value":"27","name":"South Africa","mcode":"+27"},
		{"ccode":"ES","value":"34","name":"Spain","mcode":"+34"},
		{"ccode":"LK","value":"94","name":"SriLanka","mcode":"+94"},
		{"ccode":"SH","value":"290","name":"St.Helena","mcode":"+290"},
		{"ccode":"KN","value":"1869","name":"St.Kitts","mcode":"+1869"},
		{"ccode":"SC","value":"1758","name":"St.Lucia","mcode":"+1758"},
		{"ccode":"SR","value":"597","name":"Suriname","mcode":"+597"},
		{"ccode":"SD","value":"249","name":"Sudan","mcode":"+249"},
		{"ccode":"SZ","value":"268","name":"Swaziland","mcode":"+268"},
		{"ccode":"SE","value":"46","name":"Sweden","mcode":"+46"},
		{"ccode":"CH","value":"41","name":"Switzerland","mcode":"+41"},
		{"ccode":"SY","value":"963","name":"Syria","mcode":"+963"},
		{"ccode":"TW","value":"886","name":"Taiwan","mcode":"+886"},
		{"ccode":"TJ","value":"992","name":"Tajikistan","mcode":"+992"},
		{"ccode":"TH","value":"66","name":"Thailand","mcode":"+66"},
		{"ccode":"TG","value":"228","name":"Togo","mcode":"+228"},
		{"ccode":"TO","value":"676","name":"Tonga","mcode":"+676"},
		{"ccode":"TT","value":"1868","name":"Trinidad & Tobago","mcode":"+1868"},
		{"ccode":"TN","value":"216","name":"Tunisia","mcode":"+216"},
		{"ccode":"TR","value":"90","name":"Turkey","mcode":"+90"},
		{"ccode":"TM","value":"993","name":"Turkmenistan","mcode":"+993"},
		{"ccode":"TC","value":"1649","name":"Turks & Caicos Islands","mcode":"+1649"},
		{"ccode":"TV","value":"688","name":"Tuvalu","mcode":"+688"},
		{"ccode":"UG","value":"256","name":"Uganda","mcode":"+256"},
		{"ccode":"UA","value":"380","name":"Ukraine","mcode":"+380"},
		{"ccode":"AE","value":"971","name":"United Arab Emirates","mcode":"+971"},
		{"ccode":"UY","value":"598","name":"Uruguay","mcode":"+598"},
		{"ccode":"UZ","value":"998","name":"Uzbekistan","mcode":"+998"},
		{"ccode":"VU","value":"678","name":"Vanuatu","mcode":"+678"},
		{"ccode":"VA","value":"379","name":"VaticanCity","mcode":"+379"},
		{"ccode":"VE","value":"58","name":"Venezuela","mcode":"+58"},
		{"ccode":"VN","value":"84","name":"Vietnam","mcode":"+84"},
		{"ccode":"VG","value":"1","name":"Virgin Islands - British","mcode":"+1"},
		{"ccode":"VI","value":"1","name":"Virgin Islands - US","mcode":"+1"},
		{"ccode":"WF","value":"681","name":"Wallis & Futuna","mcode":"+681"},
		{"ccode":"YE","value":"967","name":"Yemen","mcode":"+967"},
		{"ccode":"ZM","value":"260","name":"Zambia","mcode":"+260"},
		{"ccode":"ZW","value":"263","name":"Zimbabwe","mcode":"+263"}]');
		return $objs;
	}
}

/*
* get ip infi vistor
*/
if(! function_exists('ip_info')){
	function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
		$output = NULL;
		if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
			$ip = $_SERVER["REMOTE_ADDR"];
			if ($deep_detect) {
				if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_CLIENT_IP'];
			}
		}
		$purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
		$support    = array("country", "countrycode", "state", "region", "city", "location", "address");
		$continents = array(
			"AF" => "Africa",
			"AN" => "Antarctica",
			"AS" => "Asia",
			"EU" => "Europe",
			"OC" => "Australia (Oceania)",
			"NA" => "North America",
			"SA" => "South America"
		);
		if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
			$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
			if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
				switch ($purpose) {
					case "location":
						$output = array(
							"city"           => @$ipdat->geoplugin_city,
							"state"          => @$ipdat->geoplugin_regionName,
							"country"        => @$ipdat->geoplugin_countryName,
							"country_code"   => @$ipdat->geoplugin_countryCode,
							"continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
							"continent_code" => @$ipdat->geoplugin_continentCode
						);
						break;
					case "address":
						$address = array($ipdat->geoplugin_countryName);
						if (@strlen($ipdat->geoplugin_regionName) >= 1)
							$address[] = $ipdat->geoplugin_regionName;
						if (@strlen($ipdat->geoplugin_city) >= 1)
							$address[] = $ipdat->geoplugin_city;
						$output = implode(", ", array_reverse($address));
						break;
					case "city":
						$output = @$ipdat->geoplugin_city;
						break;
					case "state":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "region":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "country":
						$output = @$ipdat->geoplugin_countryName;
						break;
					case "countrycode":
						$output = @$ipdat->geoplugin_countryCode;
						break;
				}
			}
		}
		return $output;
	}
}
/*
* get country based ip info
*/
if( !function_exists('option_country_ncode')){
	function option_country_ncode(){
		$current = ip_info("Visitor", "country");
		$res = "";
		$objs =load_object();
			foreach ($objs as $obj) { 
			if($current == $obj->name){
				$res .= '<option value="'.$obj->name.'" selected>'.$obj->name.'</option>';
				} else {
				$res .= '<option value="'.$obj->name.'">'.$obj->name.'</option>';
			}}
			return $res;
	}
}
/*
* get code area based ip info
*/
if(! function_exists('option_country_code')){
	function option_country_code(){
	$current = ip_info("Visitor", "country");
	$objs =load_object();
	$res = "";
		foreach ($objs as $obj) { 
		if($current == $obj->name){
			$res .= '<option value="'.$obj->mcode.'" selected>'.$obj->mcode.'</option>';
			} else {
			$res .= '<option value="'.$obj->mcode.'">'.$obj->mcode.'</option>';
		}}
		return $res;
	}
}
/*
* remove duplicate data form json timezone
*/
if(! function_exists('unique_multidim_array')){
	function unique_multidim_array($array, $key) { 
		$temp_array = array(); 
		$i = 0; 
		$key_array = array(); 
		
		foreach($array as $val) { 
			if (!in_array($val[$key], $key_array)) { 
				$key_array[$i] = $val[$key]; 
				$temp_array[$i] = $val; 
			} 
			$i++; 
		} 
		return $temp_array; 
	} 
}
/*
* get time zone based ip info
*/
if(! function_exists('option_timezone')){
	function option_timezone() {
		$current = ip_info("Visitor", "countrycode");
		$str = file_get_contents(asset('resources/views/timezone/timezones.json'));
		$json = json_decode($str, true);
		$json = unique_multidim_array($json,'timezone');
		$res = "";
		foreach ($json as $jsons) { 
		if($current == $jsons['country']){
			$res .= '<option value="'.$jsons['timezone'].'" selected>'.$jsons['timezone'].'</option>';
			} else {
			$res .= '<option value="'.$jsons['timezone'].'">'.$jsons['timezone'].'</option>';
		}}
		return $res;
	}
}
/*
* Tour
*/
// count tour in category
if (! function_exists('countTourInCat')) {
	function countTourInCat($id){        
		return Tours::whereRaw("find_in_set($id,cat_id)")->count();
	}
}



//get icon category of tour
if(! function_exists('getIconCatOftour')){
	function getIconCatOftour($id){
		$html = '';
		$tour = Tours::find($id);
		if($tour && $tour->cat_id){
			$html .= '<ul class="no-list-style icon-cat-tour">';
			$array_cat = explode(',',$tour->cat_id);
			foreach($array_cat as $cat_id){
				$cat = get_category_tour($cat_id);
				$html .= '<li>';
					$html .= imageAuto($cat->white_icon, $tour->title);
					$html .= '<span>'.$cat->title.'</span>';
				$html .= '</li>';
			}
			$html .= '</ul>';
		}
		return $html;
	}
}

/*
* Categories Tour
*/
//get categories tour
if(! function_exists('get_categories_tour')){
	function get_categories_tour(){
		return CategoryTour::orderBy('position', 'asc')->get();
	}
}
if(! function_exists('get_icon_schedules')){
	function get_icon_schedules(){
		return CatIconSchedules::orderBy('created_at', 'desc')->get();
	}
}
if (! function_exists('get_category_tour')) {
	function get_category_tour($id){        
		return CategoryTour::find($id);
	}
}

if (! function_exists('get_title_category_tour')) {
	function get_title_category_tour($id){        
		return CategoryTour::select('title')->find($id);
	}
}

if (! function_exists('get_category_tour_by_slug')) {
	function get_category_tour_by_slug($slug){        
		return CategoryTour::findBySlug($slug);
	}
}
if (! function_exists('get_market_nation_by_slug')) {
	function get_market_nation_by_slug($slug){        
		return CategoryGuide::findBySlug($slug);
	}
}
/*
* Duration
*/
if(!function_exists('get_list_duration')){
	function get_list_duration(){
		return Duration::all();
	}
}
if(! function_exists('getDurationById')){
	function getDurationById($id){
		return Duration::find($id);
	}
}
/*
* Countries
*/
if(! function_exists('getListMainCountry')){
	function getListMainCountry(){
		return Countries::where('parent_id', 0)->orderBy('position', 'asc')->limit(5)->get();
	}
}

//get country level 1
if(!function_exists('getCountryLevel1')){
	function getCountryLevel1(){
		return Countries::where('parent_id', 0)->get();
	}
}

/*
* count country of tour
*/
if(!function_exists('get_country_of_tour')){
	function get_country_of_tour($tour_id){
		$countries = CountryTours::select('country_id')->where('tour_id', $tour_id)->pluck('country_id')->toArray();
		$array = array();
		foreach($countries as $country_id){
			$country = Countries::find($country_id);
			if($country && $country->parent_id == 0){
				$array[] = $country;
			}
		}
		return $array;
	}
}
/*
* count country of blog
*/
if(!function_exists('getCountryOfBlog')){
	function getCountryOfBlog($blog_id){
		$blog = Article::find($blog_id);
		$countries = explode(",", $blog->country_id);
		$array = array();
		foreach($countries as $country_id){
			$country = Countries::find($country_id);
			if($country && $country->parent_id == 0){
				$array[] = $country;
			}
		}
		return $array;
	}
}
/*
* get slug country of tour
*/
if(!function_exists('get_slug_country_of_tour')){
	function get_slug_country_of_tour($tour_id){
		$tour = Tours::find($tour_id);
		$slug_country = '';
		$countries = get_country_of_tour($tour->id); 
		//$countries = Countries::where('parent_id', 1)->get();
		if($countries){
			if(count($countries) >= 2){
				$slug_country = 'asia';
			}
			else if(count($countries) == 1){
				$slug_country = $countries[0]->slug;
			}
			else{
				$slug_country = 'any';
			}
		}
		return $slug_country;
	}
}

if(!function_exists('getSlugCountryOfBlog')){
	function getSlugCountryOfBlog($blog_id){
		$blog = Article::find($blog_id);
		$slug_country = '';
		$countries = getCountryOfBlog($blog->id); 
		if(count($countries) >= 2){
			$slug_country = 'multi';
		}
		else if(count($countries) == 1){
			$slug_country = $countries[0]->slug;
		}
		else{
			$slug_country = 'any';
		}
		return $slug_country;
	}
}


if(!function_exists('get_str_meal_tour')){
	function get_str_meal_tour($json){
		$array_meal = json_decode($json);
		$html = '';
		if($array_meal == '') : 
			$html = '<span class="uppercase">[none]</span>';
		else : 
			$a1 = array('b','l','d');
			$res = array_intersect($a1, $array_meal);
			$meal = '';
			for($i=0; $i<count($a1); $i++) : 
				if ($i != 0) $meal .= '/';
				if(isset($res[$i])) $meal .= $res[$i]; 
    			else $meal .= '-';
			endfor; 
			$html = '<span class="uppercase">['.$meal.']</span>';
		endif; 
		return $html;
	}
}

//get flag country
if(!function_exists('get_flag_country')){
	function get_flag_country($str){
		$array_country = explode(",", $str);
		$temp_country;
		$count = 0;
		$html = '';
		foreach($array_country as $country_id){
			$country = Countries::find($country_id);
			if($country  && $country->parent_id == 0){
				$count++;
				$temp_country = $country;
			}
		}
		if($count >= 2){
			//get multi flag (chwua co)
			$html .= '<img src="'.asset("/public/images/").'" alt= "multi-flag" />';
		}
		else if($count == 1){
			$html .= imageAuto($temp_country->flag, $temp_country->title);
		}
		return $html;
	}
}

if(!function_exists('getContentListTour')){
	function getContentListTour($objects){
		$html = '';
		if($objects){
			foreach($objects as $tour){
				$slug_country = get_slug_country_of_tour($tour->id);
				
				$html .= '<div class="col-md-6">';
					$html .= '<div class="item">';
						$html .= '<div class="gr-btn-tour">';
							$html .= '<div class="btn-tour share-tour">';
								$html .= '<a href="#"></a>';
								$html .= '<div class="share-group graybg">';
									$html .= '<a target="_blank" href="http://www.facebook.com/sharer.php?u=&p[title]="><i class="fa fa-facebook" aria-hidden="true"></i></a>
														<a target="_blank" href="http://twitter.com/share?text=&url="><i class="fa fa-twitter" aria-hidden="true"></i></a>
														<a target="_blank" href="http://pinterest.com/pin/create/button/?url=&description="><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
														<a target="_blank" href="https://plus.google.com/share?url="><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
								$html .= '</div>';
							$html .= '</div>';
							$html .= '<div class="btn-tour view-tour">';
								$html .= '<a href="'.route('tour', ['slug_country'=>$slug_country,'slug'=>$tour->slug]).'" class="btn-page-2 whitebg">View tour</a>';
							$html .= '</div>';
							$html .= '<div class="btn-tour add-wishlist">
				                    	<a href="#"></a>
				                    </div>';
						$html .= '</div>';

						$html .= '<div class="octagonal">';
							$html .= '<div class="wrap-octagonal">';
								$html .= '<div class="image">';
									$html .= '<a class="thumb" href="'. route('tour', ['slug_country'=>$slug_country,'slug'=>$tour->slug]) .'">';
										$html .= image($tour->image, 490, 300, $tour->title);
									$html .= '</a>';
									$html .= '<a href="'. route('tour', ['slug_country'=>$slug_country,'slug'=>$tour->slug]) .'" class="title"><span>'.$tour->title.'</span></a>';
									$html .= '<div class="icon-cat">'.getIconCatOftour($tour->id).'</div>';
								$html .= '</div>';
							$html .= '</div>';
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</div>';
			}
		}

		return $html;
	}
}

if(!function_exists('getPaginate')){
	function getPaginate($ob){ 
		$html = '';
		$html .= $ob->render('custom_view');
		return $html; 
	}
}

//get category icon schedule by ID
if(!function_exists('CatIconScheduleByID')){
	function CatIconScheduleByID($cat_id){
		$cat = CatIconSchedules::find($cat_id);
		return $cat;
	}
}
//get list icon schedule by category
if(!function_exists('getIconScheduleAdmin')){
	function getIconScheduleAdmin(){
		$html = '';
		$cats = CatIconSchedules::orderBy('created_at', 'asc')->get();
		foreach($cats as $cat){
			$icons = IconsDetailSchedules::orderBy('created_at', 'asc')
			            ->where('cat_id', $cat->id)->get();
			$html .= '<div class="cat-icons" data-id="'. $cat->id .'" >';
				$html .= '<strong class="cat-title">'. $cat->title .'</strong>';
				$html .= '<ul class="no-list-style">';
				foreach($icons as $icon){
					$html .= '<li class="checkbox checkbox-success">';
						$html .= '<input value="'. $icon->id .'" type="checkbox" name="icon[]">';
						$html .= '<label for="'. $icon->id .'">'. $icon->title .'</label>';
					$html .= '</li>';
				}
				$html .= '</ul>';
			$html .= '</div>';
		}
		return $html;
	}
}

//get list categories of icon schedule
if(!function_exists('getListCatIconSchedule')){
	function getListCatIconSchedule(){
		$cats = CatIconSchedules::orderBy('created_at', 'asc')->get();
		return $cats;
	}
}

//get list icon schedule by category 
if(! function_exists('getIconScheduleByCat')){
	function getIconScheduleByCat($cat_id){
		$icons = IconsDetailSchedules::orderBy('created_at', 'asc')
			            ->where('cat_id', $cat_id)->get();
	    return $icons;
	}
}

//get getIconScheduleByID
if(!function_exists('getIconScheduleByID')){
	function getIconScheduleByID($id){
		$icon = IconsDetailSchedules::find($id);
		return $icon; 
	}
}
//convert size to unit
if(!function_exists('formatSizeUnits')){
	function formatSizeUnits($bytes){
	    if ($bytes >= 1073741824){
	        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
	    }elseif ($bytes >= 1048576){
	        $bytes = number_format($bytes / 1048576, 2) . ' MB';
	    }elseif ($bytes >= 1024){
	        $bytes = number_format($bytes / 1024, 2) . ' KB';
	    }elseif ($bytes > 1){
	        $bytes = $bytes . ' bytes';
	    }elseif ($bytes == 1){
	        $bytes = $bytes . ' byte';
	    }else{
	        $bytes = '0 bytes';
	    }
	    return $bytes;
	}
}
//image type
if(!function_exists('checkImage')){
	function checkImage($file_type){
	    $images = array('jpg','png','gif');
	    if(in_array($file_type,$images))
	    	return 1;
	    return 0;
	}
}
//date convert
if (! function_exists('dateConvert')) {
	function dateConvert($date){
		return date('Y-m-d',strtotime($date));
	}
}

//get list cultural guides
if(!function_exists('getListCulturalGuides')){
	function getListCulturalGuides(){
		$guides = Guides::where('post_type', 'cultural')->orderBy('long_title', 'asc')->get();
		return $guides;
	}
}

//get guide by ID
if(!function_exists('getGuideByID')){
	function getGuideByID($id){
		$guide = Guides::find($id);
		return $guide;
	}
}

/**
 * create slug
 * @param string $table_name, string title, int $id
 */
if(! function_exists('updateSlug')){
	function updateSlug($table_name, $title, $id){
		/*$slug = str_slug($title, '-');
		$count = DB::table($table_name)->where('slug', $slug)->count();
		if($count > 0)
			$slug = $slug . '-' . $count;
		DB::table($table_name)->where('id', $id)->update(['slug' => $slug]);*/

		$slug = str_slug($title, '-');
		//check current slug is exist
		$count_exist = DB::table($table_name)->where('slug', $slug)->where('id', '<>', $id)->get();
		if(count($count_exist) > 0){
			$related_post = getRelatedPostBySlug($table_name, $slug, $id);
			if(count($related_post) > 0){
				for($i = 1; $i <= 10; $i++){
					$newSlug = $slug . '-' . $i;
					$releated_inLoop = getRelatedPostBySlug($table_name, $newSlug, $id);
					if(count($releated_inLoop) == 0){
						$slug = $newSlug;
						break;
					}
				}
			}
		}
		DB::table($table_name)->where('id', $id)->update(['slug' => $slug]);
		return $slug;
	}
}

/**
 * get related post by slug
 * @param $table_name, string $slug, int $id (current id)
 * @return list object                           
 */
if(! function_exists('getRelatedPostBySlug')){
	function getRelatedPostBySlug($table_name, $slug, $id){
		return DB::table($table_name)->where('slug', 'like', $slug.'%')->whereNotIn('id', [$id])->get();
	}
}

/**
 * make beauty text
 * @param string $text
 * @return text trim & remove white space redundancy
 */
if(! function_exists('beautyText')){
	function beautyText($text){
		return preg_replace('/\s+/', ' ', trim($text));
	}
}

/**
 * get message rule
 */
if(! function_exists('getMessageRule')){
	function getMessageRule(){
        return [
            'title.required' => 'Please input the title',
            'slug.required' => 'Please input the slug',
            'slug.same' => 'The slug is already exist',
        ];
    }
}

/**
 * check exist slug level 1
 * @param string $slug
 * @return bool
 */
if(! function_exists('checkExistSlugLevel1')){
	function checkExistSlugLevel1($slug){
		//consultant_tour_guides
		$consultantTourGuide = ConsultantTourGuide::findBySlug($slug);
		if($consultantTourGuide)
			return true;

		//blogger
		$blogger = Bloggers::findBySlug($slug);
		if($blogger)
			return true;
		return false;
	}
}
/**
* GetMeta content by $meta_id
* @param $meta_id
* @return content of metaField
*/
if(! function_exists('getDsMetas')){
	function getDsMetas($meta_id){
		$meta = Metas::find($meta_id);
		if($meta) return Metas::find($meta_id)->content;
			else return FALSE;
	}
}