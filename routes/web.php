<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/ 
Route::get('ajax_regen_captcha', function(){
    return captcha_src();
});
//resize image
Route::get('image/{scr}/{w}/{h}', function($src, $w=100, $h=100){
	$caheimage = Image::cache(function($image) use ($src, $w, $h){
		return $image->make('public/uploads/'.$src)->fit($w, $h);
	}, 10, true);
	$extention = explode(".", $src);
	return $caheimage->response($extention[1]);
});
Route::get('404', ['as' => '404', 'uses' => 'ErrorController@notfound']);
Route::get('500', ['as' => '500', 'uses' => 'ErrorController@fatal']);
Route::group(['prefix'=>'page'],function(){
	Route::get('/{slug}', 'PagesController@page');
	Route::post('/about',['as'=>'filterTourAbout', 'uses'=>'TourController@filterTourAbout']);
});
Route::get('/', ['as'=>'home','uses'=>'PagesController@index']);
Route::post('/search-nationality', ['as'=>'searchNation','uses'=>'PagesController@searchNation']);
Route::get('/contact', ['as'=>'contact','uses'=>'FormPagesController@contact']);
Route::post('/contact', ['as'=>'updateContact','uses'=>'FormPagesController@updateContact']);
Route::get('/setup-call-phone', ['as'=>'setupCallPhone','uses'=>'FormPagesController@setupCallPhone']);
Route::post('/setup-call-phone', ['as'=>'updateSetupCallPhone','uses'=>'FormPagesController@updateSetupCallPhone']);
Route::get('/request', ['as'=>'createMyTrip','uses'=>'FormPagesController@createMyTrip']);
Route::post('/request', ['as'=>'updateCreateMyTrip','uses'=>'FormPagesController@updateCreateMyTrip']);
Route::get('/personalize', ['as'=>'createPersonalize','uses'=>'FormPagesController@createPersonalize']);
Route::post('/personalize', ['as'=>'updatePersonalize','uses'=>'FormPagesController@updatePersonalize']);
Route::get('/feedback', ['as'=>'createFeedback','uses'=>'FormPagesController@createFeedback']);
Route::post('/feedback', ['as'=>'updateFeedback','uses'=>'FormPagesController@updateFeedback']);
Route::post('/fileupload', ['as'=>'fileUpload','uses'=>'FormPagesController@fileUpload']);
// Route::get('/p/{slug}', ['as'=>'page','uses'=>'PagesController@page']);
Route::get('/p/faq', ['as'=>'createFaq','uses'=>'PagesController@createFaq']);

Route::get('/faqs', ['as'=>'faqs','uses'=>'FaqController@index']);
Route::post('/search-faqs', ['as'=>'searchFaqs','uses'=>'FaqController@search']);
Route::get('/sonasia-club', ['as'=>'biigClub','uses'=>'PagesController@biigClub']);
Route::get('/responsible-travel', ['as'=>'responsibleTravel','uses'=>'PagesController@responsibleTravel']);
Route::get('/3-c-booking-steps', ['as'=>'bookingSteps','uses'=>'PagesController@bookingSteps']);
Route::get('/landing-page', ['as'=>'landingPage','uses'=>'PagesController@landingPage']);
Route::get('/about-us', ['as'=>'aboutPage','uses'=>'PagesController@aboutPage']);
Route::get('/booking-conditions', ['as'=>'bookingConditions','uses'=>'PagesController@bookingConditions']);
Route::get('/terms-of-use', ['as'=>'termOfUse','uses'=>'PagesController@termOfUse']);
Route::get('/privacy-policy', ['as'=>'privacyPolicy','uses'=>'PagesController@privacyPolicy']);
Route::post('/code-tour', ['as'=>'searchCodeTour','uses'=>'PagesController@searchCodeTour']);

/*
* ATTRACTION
*/
//load more attraction
Route::post('load-more-attraction', ['as'=>'loadMoreAttraction','uses'=>'AttractionController@loadMore']);
//filter attraction by icon
Route::post('filter-attraction-by-icon', ['as'=>'filterAttractionByIcon','uses'=>'AttractionController@filterByIcon']);
Route::post('filter-hotel',['as'=>'filterHotel', 'uses'=>'HotelController@filterHotel']);
/*
* END ATTRACTION
*/

Route::group(['prefix'=>'reviews'], function(){
	Route::get('/',['as'=>'clientsReview', 'uses'=>'ReviewerController@index']);
	Route::get('/{slug}',['as'=>'detailClientReview', 'uses'=>'ReviewerController@detail']);
	Route::post('/filter',['as'=>'filterReviewer', 'uses'=>'ReviewerController@filter']);
	Route::post('/filter-other',['as'=>'filterOtherReviewer', 'uses'=>'ReviewerController@filterOther']);
});

//search hotel by name
Route::post('search-hotel-by-name/{city_id}', ['as'=>'searchHotelByName','uses'=>'HotelController@searchByName']);

/*
* Multi country group
*/
Route::group(['prefix'=>'asia-tour-packages'], function(){
	// tours
	Route::get('/',['as'=>'asiaTour', 'uses'=>'TourController@asiaTour']);
    Route::post('/', ['as'=>'loadMoreTourAsia', 'uses'=>'TourController@loadMoreTourAsia']);
	Route::get('/{slug}',['as'=>'tourMultiDes', 'uses'=>'TourController@tourMultiDes']);
	Route::get('/{region}/{duration}/{cat}/{per_page}/{page}',
		['as'=>'toursMultiParamByMulti', 
		'uses'=>'TourController@toursMultiParamByMulti']
	);
});

/*
* Country group {$country-slug}.package-tour
*/
Route::group(['prefix'=>'{slug_country}'.'-tour-packages'], function(){
	Route::get('/',['as'=>'countryTour', 'uses'=>'TourController@countryTour']);
	Route::post('/', ['as'=>'loadMoreTourCountry', 'uses'=>'TourController@loadMoreTourCountry']);
	//Route::post('/perpage', ['as'=>'PerPageTourCountry', 'uses'=>'TourController@PerPageTourCountry']);
	Route::get('/{slug}',['as'=>'tour', 'uses'=>'TourController@tour']);
	Route::get('/{region}/{duration}/{cat}/{per_page}/{page}',
		['as'=>'toursMultiParamByCountry', 
		'uses'=>'TourController@toursMultiParamByCountry']
	);
	
});


/*
* Country group {$country-slug}.travel
*/
Route::group(['prefix'=>'{slug_country}'.'-travel'], function(){
	//overview
	Route::get('/',['as'=>'overviewCountry', 'uses'=>'CountryController@overview']);
	Route::get('/places-to-visit',['as'=>'countryPlaceToVisit', 'uses'=>'CountryController@countryPlaceToVisit']);
	
	//travel tip
	Route::get('/guide-tips',['as'=>'countryGuide', 'uses'=>'GuideController@countryGuide']);
	//country cultural insight
	Route::get('/culture-insights',['as'=>'countryCultural', 'uses'=>'GuideController@countryCultural']);
	//country market guides
	Route::get('/market-guides',['as'=>'countryMarket', 'uses'=>'GuideController@countryMarket']);
	//country things to do
	Route::get('/things-to-do',['as'=>'countryThingsToDo', 'uses'=>'GuideController@countryThingsToDo']);
	//accommodation
	Route::get('/accommodation',['as'=>'countryHotel', 'uses'=>'HotelController@countryHotel']);
	Route::get('/quick-search-accommodation',['as'=>'quickSearchHotel', 'uses'=>'HotelController@quickSearch']);
	// Route::get('/blog',['as'=>'countryBlog', 'uses'=>'ArticleFrontController@blogCountry']);
	//Route::get('/{slug_region}-accommodation',['as'=>'listHotel', 'uses'=>'HotelController@listHotel']);
	Route::get('/accommodation/{city}/{star}/{location}/{special}/{per_page}/{page}',
		['as'=>'countryHotelsByMultiParam', 
		'uses'=>'HotelController@countryHotelsByMultiParam']
	);
	Route::get('/{slug}/{city}/{star}/{location}/{special}/{per_page}/{page}',
		['as'=>'regionHotelsByMultiParam', 
		'uses'=>'HotelController@regionHotelsByMultiParam']
	); // {slug} is slug region . '-accommodation'
	Route::get('/{slug}/{star}/{location}/{special}/{per_page}/{page}',
		['as'=>'cityHotelsByMultiParam', 
		'uses'=>'HotelController@cityHotelsByMultiParam']
	); // {slug} is slug city . '-accommodation' 


	//Places to visit region
	//Route::get('/{slug_region}',['as'=>'regionPlaceToVisit', 'uses'=>'CountryController@regionPlaceToVisit']);
	Route::get('/{slug}',['as'=>'postTypeCountryTravel', 'uses'=>'CountryController@postTypeCountryTravel']);
	Route::post('search-market-guides',['as'=>'searchCatMarketGuide', 'uses'=>'GuideController@searchCatMarketGuide']);

	//ajax load place to visit
	Route::post('search-place-to-visit',['as'=>'loadHighlight', 'uses'=>'CountryController@seachHighlight']);
	Route::post('search-place-to-visit-hotel',['as'=>'loadHighlightHotel', 'uses'=>'CountryController@seachHighlightHotel']);
	Route::post('search-place-to-visit-cities',['as'=>'loadCities', 'uses'=>'CountryController@seachCitiesCountry']);
	Route::post('search-place-to-visit-nations',['as'=>'searchNationality', 'uses'=>'CountryController@searchNationality']);
	//ajax load things to do
	Route::post('search-things-to-do',['as'=>'loadThingToDo', 'uses'=>'GuideController@seachThingToDo']);
	Route::post('search-tour-style',['as'=>'loadTourStyleOfCountry', 'uses'=>'CountryTourStyleController@searchTourStyleOfCountry']);
});



Route::group(['prefix'=>'sonabee'], function(){
	Route::get('/',['as'=>'blog', 'uses'=>'ArticleFrontController@index']);
	Route::get('/search-result', ['as'=>'searchBlog', 'uses'=> 'ArticleFrontController@search']);
	Route::get('/{slug}', ['as'=>'blogCall', 'uses'=>'ArticleFrontController@blogCall']);
	Route::get('/{country_slug}/{cate_slug}', ['as'=>'blogCountryCate', 'uses'=>'ArticleFrontController@blogCountryCate']);
	//Route::get('/{slug_cat}',['as'=>'blogCat', 'uses'=>'ArticleFrontController@blogCat']);
	//Route::get('/{slug_country}',['as'=>'blogCountry', 'uses'=>'ArticleFrontController@blogCountry']);
	//Route::get('/{slug_country}/{slug}',['as'=>'blogDetail', 'uses'=>'ArticleFrontController@blogDetail']);
	Route::post('/', ['as'=>'loadMoreBlog', 'uses'=>'ArticleFrontController@loadMoreBlog']);
	Route::post('/search',['as'=>'blogSearch', 'uses'=>'ArticleFrontController@blogSearch']);
	Route::post('/{slug}', ['as'=>'loadMoreBlogCountry', 'uses'=>'ArticleFrontController@loadMoreBlogCountry']);
	Route::post('/cate/{slug_cat}', ['as'=>'loadMoreCat', 'uses'=>'ArticleFrontController@loadMoreCat']);
	Route::post('/{country_slug}/{cate_slug}', ['as'=>'loadMoreBlogCountryCat', 'uses'=>'ArticleFrontController@loadMoreBlogCountryCat']);
});


Route::get('login', ['as'=>'login','uses'=>'AuthController@login']);
Route::post('login', ['as'=>'postLogin','uses'=>'AuthController@postLogin']);
Route::get('logout', ['as'=>'logout','uses'=>'AuthController@logout']);
Route::get('register', ['as'=>'register','uses'=>'AuthController@register']);
Route::post('register', ['as'=>'postRegister','uses'=>'AuthController@postRegister']);

Route::group(['prefix'=>'profile','middleware'=>'memberLogin'],function(){
	Route::get('/',['as'=>'profile', 'uses'=>'AuthController@storeNews']);	
	Route::get('news',['as'=>'newsProfile', 'uses'=>'AuthController@storeNews']);
	Route::get('news/create',['as'=>'storeNews', 'uses'=>'AuthController@createNews']);
	Route::post('news/create',['as'=>'createNewsProfile', 'uses'=>'AuthController@createNews']);
	Route::get('news/edit/{id}',['as'=>'editNewsProfile', 'uses'=>'AuthController@editNews']);
	Route::post('news/edit/{id}',['as'=>'updateNewsProfile', 'uses'=>'AuthController@updateNews']);	
	Route::get('edit',['as'=>'editProfile', 'uses'=>'AuthController@editAccount']);
	Route::post('edit',['as'=>'updateProfile', 'uses'=>'AuthController@updateAccount']);
	Route::get('password',['as'=>'editPassword', 'uses'=>'AuthController@editPassword']);
	Route::post('password',['as'=>'updatePassword', 'uses'=>'AuthController@updatePassword']);	
	Route::get('media',['as'=>'mediaProfile', 'uses'=>'MediaController@index']);
	Route::get('media/create',['as'=>'storeMediaProfile', 'uses'=>'MediaController@store']);
	Route::post('media/create',['as'=>'createMediaProfile', 'uses'=>'MediaController@create']);
	Route::get('media/edit/{id}',['as'=>'editMediaProfile', 'uses'=>'MediaController@edit']);
	Route::post('media/edit/{id}',['as'=>'updateMediaProfile', 'uses'=>'MediaController@update']);
	Route::get('media/delete/{id}',['as'=>'deleteMediaProfile', 'uses'=>'MediaController@delete']);	
	Route::post('media/delete',['as'=>'deleteMediasProfile', 'uses'=>'MediaController@deleteAll']);
	Route::post('avatar',['as'=>'avatarMediaProfile', 'uses'=>'MediaController@changeAvatar']);
	Route::post('library',['as'=>'libraryProfile', 'uses'=>'MediaController@library']);
	Route::post('delete-library',['as'=>'deleteLibraryProfile', 'uses'=>'MediaController@deleteLibrary']);
	Route::post('change-banner',['as'=>'bannerProfile', 'uses'=>'MediaController@changeBanner']);
	Route::post('change-avatar',['as'=>'avatarProfile', 'uses'=>'MediaController@changeAvatar']);
});


/*
* Tours Group
*/
Route::group(['prefix'=>'tours'],function(){
		
	Route::post('/filter-tours',['as'=>'filterTour', 'uses'=>'TourController@filterTour']);
	Route::post('/filter-tours-2',['as'=>'filterTour2', 'uses'=>'TourController@filterTour2']);
    Route::post('/filter-tours-asia',['as'=>'filterTourAsia', 'uses'=>'TourController@filterTourAsia']);
});





Route::group(['prefix'=>'admin','middleware'=>'adminLogin'],function(){
	Route::get('/',['as'=>'indexAdmin','uses'=>'ArticleAdminController@index']);
	//pages
	Route::group(['prefix'=>'pages'],function(){
		Route::get('/',['as'=>'pagesAdmin','uses'=>'PageAdminController@index']);
		Route::get('/create',['as'=>'storePageAdmin','uses'=>'PageAdminController@store']);
		Route::post('/create',['as'=>'createPageAdmin','uses'=>'PageAdminController@create']);
		Route::get('/edit/{id}',['as'=>'editPageAdmin','uses'=>'PageAdminController@edit']);
		Route::post('/edit/{id}',['as'=>'updatePageAdmin','uses'=>'PageAdminController@update']);
		Route::get('/delete/{id}',['as'=>'deletePageAdmin','uses'=>'PageAdminController@delete']);
	});
	//blogs	
	Route::group(['prefix'=>'blog'],function(){
		Route::get('/',['as'=>'blogAdmin','uses'=>'ArticleAdminController@index']);		
		Route::get('create',['as'=>'storeBlogAdmin','uses'=>'ArticleAdminController@store']);
		Route::post('create',['as'=>'createBlogAdmin','uses'=>'ArticleAdminController@create']);
		Route::get('/edit/{id}',['as'=>'editBlogAdmin','uses'=>'ArticleAdminController@edit']);
		Route::post('/edit/{id}',['as'=>'updateBlogAdmin','uses'=>'ArticleAdminController@update']);
		Route::get('/delete/{id}',['as'=>'deleteBlogAdmin','uses'=>'ArticleAdminController@delete']);
		Route::get('/delete-all',['as'=>'deleteBlogsAdmin','uses'=>'ArticleAdminController@deleteAll']);
		Route::get('/search',['as'=>'searchBlogAdmin','uses'=>'ArticleAdminController@search']);

		Route::post('/delete-row-content/',['as'=>'deleteRowContent','uses'=>'ArticleAdminController@deleteRowContent']);
		Route::post('/search-from-list', ['as'=>'searchBlogFromListAdmin', 'uses'=>'ArticleAdminController@searchFromList']);
		Route::get('/country-categories',['as'=>'countryCatBlogAdmin','uses'=>'ArticleAdminController@countryCat']);
		Route::post('/save-country-categories',['as'=>'saveCountryCatBlogAdmin','uses'=>'ArticleAdminController@saveCountryCat']);
	});
	//categories
	Route::group(['prefix'=>'categories'],function(){
		Route::get('/',['as'=>'categoriesAdmin','uses'=>'ArticleCatController@index']);		
		Route::get('create',['as'=>'storeCategoryAdmin','uses'=>'ArticleCatController@store']);
		Route::post('create',['as'=>'createCategoryAdmin','uses'=>'ArticleCatController@create']);
		Route::get('/edit/{id}',['as'=>'editCategoryAdmin','uses'=>'ArticleCatController@edit']);
		Route::post('/edit/{id}',['as'=>'updateCategoryAdmin','uses'=>'ArticleCatController@update']);
		Route::get('/delete/{id}',['as'=>'deleteCategoryAdmin','uses'=>'ArticleCatController@delete']);
		Route::post('/position',['as'=>'positionCategoryAdmin','uses'=>'ArticleCatController@position']);
	});
	//country Blogs
	Route::group(['prefix'=>'country-blog'],function(){
		Route::get('/',['as'=>'countryBlogAdmin','uses'=>'CountryBlogAdminController@index']);		
		Route::get('create',['as'=>'storeCountryBlogAdmin','uses'=>'CountryBlogAdminController@store']);
		Route::post('create',['as'=>'createCountryBlogAdmin','uses'=>'CountryBlogAdminController@create']);
		Route::get('/edit/{id}',['as'=>'editCountryBlogAdmin','uses'=>'CountryBlogAdminController@edit']);
		Route::post('/edit/{id}',['as'=>'updateCountryBlogAdmin','uses'=>'CountryBlogAdminController@update']);
		Route::get('/delete/{id}',['as'=>'deleteCountryBlogAdmin','uses'=>'CountryBlogAdminController@delete']);
	});
	//country Places to visit
	Route::group(['prefix'=>'country-places'],function(){
		Route::get('/',['as'=>'countryPlacesAdmin','uses'=>'CountryPlacesAdminController@index']);		
		Route::get('create',['as'=>'storeCountryPlacesAdmin','uses'=>'CountryPlacesAdminController@store']);
		Route::post('create',['as'=>'createCountryPlacesAdmin','uses'=>'CountryPlacesAdminController@create']);
		Route::get('/edit/{id}',['as'=>'editCountryPlacesAdmin','uses'=>'CountryPlacesAdminController@edit']);
		Route::post('/edit/{id}',['as'=>'updateCountryPlacesAdmin','uses'=>'CountryPlacesAdminController@update']);
		Route::get('/delete/{id}',['as'=>'deleteCountryPlacesAdmin','uses'=>'CountryPlacesAdminController@delete']);
	});
	//country Tour
	Route::group(['prefix'=>'country-tour'],function(){
		Route::get('/',['as'=>'countryTourAdmin','uses'=>'CountryTourAdminController@index']);		
		Route::get('create',['as'=>'storeCountryTourAdmin','uses'=>'CountryTourAdminController@store']);
		Route::post('create',['as'=>'createCountryTourAdmin','uses'=>'CountryTourAdminController@create']);
		Route::get('/edit/{id}',['as'=>'editCountryTourAdmin','uses'=>'CountryTourAdminController@edit']);
		Route::post('/edit/{id}',['as'=>'updateCountryTourAdmin','uses'=>'CountryTourAdminController@update']);
		Route::get('/delete/{id}',['as'=>'deleteCountryTourAdmin','uses'=>'CountryTourAdminController@delete']);
	});
	//country Guide
	Route::group(['prefix'=>'country-guide'],function(){
		Route::get('/',['as'=>'countryGuideAdmin','uses'=>'CountryGuideAdminController@index']);		
		Route::get('create',['as'=>'storeCountryGuideAdmin','uses'=>'CountryGuideAdminController@store']);
		Route::post('create',['as'=>'createCountryGuideAdmin','uses'=>'CountryGuideAdminController@create']);
		Route::get('/edit/{id}',['as'=>'editCountryGuideAdmin','uses'=>'CountryGuideAdminController@edit']);
		Route::post('/edit/{id}',['as'=>'updateCountryGuideAdmin','uses'=>'CountryGuideAdminController@update']);
		Route::get('/delete/{id}',['as'=>'deleteCountryGuideAdmin','uses'=>'CountryGuideAdminController@delete']);
	});
	//brands	
	Route::group(['prefix'=>'brands'],function(){
		Route::get('/',['as'=>'brandsAdmin','uses'=>'BrandAdminController@index']);		
		Route::get('create',['as'=>'storeBrandAdmin','uses'=>'BrandAdminController@store']);
		Route::post('create',['as'=>'createBrandAdmin','uses'=>'BrandAdminController@create']);
		Route::get('/edit/{id}',['as'=>'editBrandAdmin','uses'=>'BrandAdminController@edit']);
		Route::post('/edit/{id}',['as'=>'updateBrandAdmin','uses'=>'BrandAdminController@update']);
		Route::get('/delete/{id}',['as'=>'deleteBrandAdmin','uses'=>'BrandAdminController@delete']);
	});
	//slides	
	Route::group(['prefix'=>'slides'],function(){
		Route::get('/',['as'=>'slidesAdmin','uses'=>'SlideAdminController@index']);		
		Route::get('create',['as'=>'storeSlideAdmin','uses'=>'SlideAdminController@store']);
		Route::post('/create',['as'=>'createSlideAdmin','uses'=>'SlideAdminController@create']);
		Route::get('/edit/{id}',['as'=>'editSlideAdmin','uses'=>'SlideAdminController@edit']);
		Route::post('/edit/{id}',['as'=>'updateSlideAdmin','uses'=>'SlideAdminController@update']);
		Route::get('/delete/{id}',['as'=>'deleteSlideAdmin','uses'=>'SlideAdminController@delete']);		
	});
	//users	
	Route::group(['prefix'=>'users'],function(){
		Route::get('/',['as'=>'users','uses'=>'UserController@index']);		
		Route::get('role/{level}',['as'=>'levelAdmin','uses'=>'UserController@getUserByLevel']);
		Route::get('create',['as'=>'storeAdmin','uses'=>'UserController@store']);
		Route::post('create',['as'=>'createAdmin','uses'=>'UserController@create']);		
		Route::get('edit/{id}',['as'=>'editAdmin','uses'=>'UserController@edit']);
		Route::post('edit/{id}',['as'=>'updateAdmin','uses'=>'UserController@update']);
		Route::get('delete/{id}',['as'=>'deleteAdmin','uses'=>'UserController@delete']);
	});
	//group metas
	Route::group(['prefix'=>'group-meta'],function(){
		Route::get('/',['as'=>'metas','uses'=>'GroupMetaController@index']);		
		Route::get('create',['as'=>'storeMeta','uses'=>'GroupMetaController@store']);
		Route::post('/create',['as'=>'createMeta','uses'=>'GroupMetaController@create']);		
		Route::get('/edit/{id}',['as'=>'editMeta','uses'=>'GroupMetaController@edit']);
		Route::post('/edit/{id}',['as'=>'updateMeta','uses'=>'GroupMetaController@update']);				
		Route::post('/delete/{id}',['as'=>'deleteGroupMeta','uses'=>'GroupMetaController@delete']);
	});
	//Reviewers
	Route::group(['prefix'=>'reviews'],function(){
		Route::get('/',['as'=>'reviewsAdmin','uses'=>'ReviewerAdminController@index']);
		Route::get('create',['as'=>'storeReviewAdmin','uses'=>'ReviewerAdminController@store']);
		Route::post('create',['as'=>'createReviewAdmin','uses'=>'ReviewerAdminController@create']);
		Route::get('edit/{id}',['as'=>'editReviewAdmin','uses'=>'ReviewerAdminController@edit']);
		Route::post('edit/{id}',['as'=>'updateReviewAdmin','uses'=>'ReviewerAdminController@update']);		
		Route::get('/delete/{id}',['as'=>'deleteReviewAdmin','uses'=>'ReviewerAdminController@delete']);				
		Route::post('/delete-all',['as'=>'deleteAllReviewAdmin','uses'=>'ReviewerAdminController@deleteAll']);				
		Route::get('/export',['as'=>'testExport','uses'=>'ReviewerAdminController@testExport']);				
	});
	//System
	Route::group(['prefix'=>'setting'],function(){
		Route::get('/option',['as'=>'setting','uses'=>'OptionsAdminController@index']);
		Route::get('/social-media',['as'=>'settingSocial','uses'=>'OptionsAdminController@socialMedia']);
		Route::post('/edit-system',['as'=>'editSytem','uses'=>'OptionsAdminController@updateSystem']);
		Route::post('/edit-social',['as'=>'editSocial','uses'=>'OptionsAdminController@updateSocial']);
		Route::post('/edit-social2',['as'=>'editSocialv2','uses'=>'OptionsAdminController@updateSocialv2']);
		Route::post('/media',['as'=>'systemMedia','uses'=>'OptionsAdminController@media']);
	});
	
	//menus	
	Route::group(['prefix'=>'menu'],function(){
		Route::get('/',['as'=>'menu','uses'=>'MenuController@index']);
		Route::get('/create',['as'=>'storeMenu','uses'=>'MenuController@store']);
		Route::post('/create',['as'=>'creatMenu','uses'=>'MenuController@create']);		
		Route::get('/edit/{id}',['as'=>'editMenu','uses'=>'MenuController@edit']);
		Route::post('/edit/{id}',['as'=>'updateMenu','uses'=>'MenuController@update']);
		Route::get('/sub/{id}',['as'=>'storeSubMenu','uses'=>'MenuController@storeSubMenu']);
		Route::post('/sub/{id}',['as'=>'createSubMenu','uses'=>'MenuController@createSubMenu']);
		Route::get('/delete/{id}',['as'=>'deleteMenu','uses'=>'MenuController@delete']);
		Route::post('/loadType',['as'=>'loadType','uses'=>'MenuController@loadType']);
		Route::post('/search',['as'=>'searchMenu','uses'=>'MenuController@search']);
	});
	/**
	 * Media
	 */
	Route::group(['prefix'=>'media'],function(){
		Route::get('/',['as'=>'media','uses'=>'MediaAdminController@index']);
		Route::get('create',['as'=>'addMedia', 'uses'=>'MediaAdminController@store']);
		Route::post('create',['as'=>'createMedia', 'uses'=>'MediaAdminController@create']);
		Route::get('edit/{id}',['as'=>'editMedia', 'uses'=>'MediaAdminController@edit']);
		Route::post('edit/{id}',['as'=>'updateMedia', 'uses'=>'MediaAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteMedia','uses'=>'MediaAdminController@delete']);
		Route::post('delete-all/',['as'=>'deleteAllMedia','uses'=>'MediaAdminController@deleteAll']);
		Route::post('load-by-cat',['as'=>'loadByCatMedia', 'uses'=>'MediaAdminController@loadByCat']);
		Route::post('load-more',['as'=>'loadMoreMedia', 'uses'=>'MediaAdminController@loadMore']);
		Route::post('detail',['as'=>'detailMedia', 'uses'=>'MediaAdminController@getDetail']);
		Route::post('attribute',['as'=>'atrributeMedia', 'uses'=>'MediaAdminController@changeAttribute']);
		Route::post('change-category',['as'=>'changeCatMedia', 'uses'=>'MediaAdminController@changeCategory']);
		Route::get('/search',['as'=>'search','uses'=>'MediaAdminController@search']);
	});
	Route::group(['prefix'=>'media-cat'],function(){
		Route::get('/',['as'=>'mediaCat','uses'=>'MediaCatAdminController@index']);
		Route::get('create',['as'=>'storeMediaCat', 'uses'=>'MediaCatAdminController@store']);
		Route::post('create',['as'=>'createMediaCat', 'uses'=>'MediaCatAdminController@create']);
		Route::get('edit/{id}',['as'=>'editMediaCat', 'uses'=>'MediaCatAdminController@edit']);
		Route::post('edit/{id}',['as'=>'updateMediaCat', 'uses'=>'MediaCatAdminController@update']);
		Route::get('/delete/{id}',['as'=>'deleteMediaCat','uses'=>'MediaCatAdminController@delete']);
		Route::post('/delete-all/',['as'=>'deleteAllMediaCat','uses'=>'MediaCatAdminController@deleteAll']);
		Route::post('/position',['as'=>'positionAllMediaCat','uses'=>'MediaCatAdminController@position']);
	});
	//delete media with ajax
	Route::post('/delete-media',['as'=>'deleteMediaSingle','uses'=>'MediaAdminController@deleteMediaSingle']);
	Route::post('/loadMedia',['as'=>'loadMedia','uses'=>'MediaAdminController@loadMedia']);		
	Route::post('load-more-page',['as'=>'loadMorePage','uses'=>'MediaAdminController@loadMorePage']);
	Route::post('filter-media',['as'=>'filterMedia','uses'=>'MediaAdminController@searchMedia']);
	Route::post('search-cat-media',['as'=>'searchCatMedia','uses'=>'MediaAdminController@searchCatMedia']);

	/*
	* Country
	*/
	Route::group(['prefix'=>'country'],function(){
		Route::get('/',['as'=>'countryAdmin','uses'=>'CountryAdminController@index']);
		Route::get('/create',['as'=>'storeCountryAdmin','uses'=>'CountryAdminController@store']);
		Route::post('/create',['as'=>'createCountryAdmin','uses'=>'CountryAdminController@create']);
		Route::get('edit/{slug}',['as'=>'editCountryAdmin', 'uses'=>'CountryAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateCountryAdmin', 'uses'=>'CountryAdminController@update']);
		Route::get('/delete/{id}',['as'=>'deleteCountryAdmin','uses'=>'CountryAdminController@delete']);
		Route::get('/delete-all/',['as'=>'deleteAllCountry','uses'=>'CountryAdminController@deleteAll']);
		Route::post('position',['as'=>'positionCountry','uses'=>'CountryAdminController@position']);
		Route::get('/have-not-tour-style/',['as'=>'countryCatAdmin','uses'=>'CountryAdminController@countryCatAdmin']);
		Route::post('/have-not-tour-style/',['as'=>'postCountryCatAdmin','uses'=>'CountryAdminController@postCountryCatAdmin']);
		Route::get('/have-not-tour-style/delete/{id}',['as'=>'deleteCountryCatAdmin','uses'=>'CountryAdminController@deleteCountryCatAdmin']);

		Route::get('/search',['as'=>'searchCountryAdmin','uses'=>'CountryAdminController@search']);
		Route::post('/search-from-list', ['as'=>'searchCountryFromListAdmin', 'uses'=>'CountryAdminController@searchFromList']);
	});
	/*
	* Category Tour
	*/
	Route::group(['prefix'=>'category-tour'],function(){
		Route::get('/',['as'=>'catTourAdmin','uses'=>'CategoryTourAdminController@index']);
		Route::get('/create',['as'=>'storeCatTourAdmin','uses'=>'CategoryTourAdminController@store']);
		Route::post('/create',['as'=>'createCatTourAdmin','uses'=>'CategoryTourAdminController@create']);
		Route::get('edit/{slug}',['as'=>'editCatTourAdmin','uses'=>'CategoryTourAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateCatTourAdmin','uses'=>'CategoryTourAdminController@update']);
		Route::get('/delete/{id}',['as'=>'deleteCatTourAdmin','uses'=>'CategoryTourAdminController@delete']);
		Route::post('/position',['as'=>'positionCatTourAdmin','uses'=>'CategoryTourAdminController@position']);
	});
	/*
	* Duration
	*/
	Route::group(['prefix'=>'duration'],function(){
		Route::get('/',['as'=>'durationAdmin','uses'=>'DurationAdminController@index']);
		Route::get('/create',['as'=>'storeDurationAdmin','uses'=>'DurationAdminController@store']);
		Route::post('/create',['as'=>'createDurationAdmin','uses'=>'DurationAdminController@create']);
		Route::get('edit/{slug}',['as'=>'editDurationAdmin','uses'=>'DurationAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateDurationAdmin','uses'=>'DurationAdminController@update']);
		Route::get('/delete/{id}',['as'=>'deleteDurationAdmin','uses'=>'DurationAdminController@delete']);
		Route::post('/position',['as'=>'positionDurationAdmin','uses'=>'DurationAdminController@position']);
	});
	/*
	* Tour
	*/
	Route::group(['prefix'=>'tour'], function(){
		Route::get('/',['as'=>'tourAdmin', 'uses'=>'TourAdminController@index']);
		Route::get('/create',['as'=>'storeTourAdmin','uses'=>'TourAdminController@store']);
		Route::post('/create',['as'=>'createTourAdmin','uses'=>'TourAdminController@create']);
		Route::get('edit/{slug}',['as'=>'editTourAdmin','uses'=>'TourAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateTourAdmin','uses'=>'TourAdminController@update']);
		Route::get('/delete/{id}',['as'=>'deleteTourAdmin','uses'=>'TourAdminController@delete']);
		Route::post('/delete-all/',['as'=>'deleteAllTour','uses'=>'TourAdminController@deleteAll']);
		Route::get('/search',['as'=>'searchTourAdmin','uses'=>'TourAdminController@search']);
		Route::post('/delete-shedule/',['as'=>'deleteScheduleTour','uses'=>'TourAdminController@deleteSchedule']);
		Route::post('/search-from-list', ['as'=>'searchTourFromListAdmin', 'uses'=>'TourAdminController@searchFromList']);
		Route::post('position',['as'=>'positionDaysTour','uses'=>'TourAdminController@position']);
	});

	/*
	* icons detail schedule
	*/
	Route::group(['prefix'=>'icons-detail-schedule'],function(){
		Route::get('/',['as'=>'iconSchedules','uses'=>'IconScheduleController@index']);
		Route::get('/create',['as'=>'storeIconSchedules','uses'=>'IconScheduleController@store']);
		Route::post('/create',['as'=>'createIconSchedules','uses'=>'IconScheduleController@create']);
		Route::get('edit/{id}',['as'=>'editIconSchedules','uses'=>'IconScheduleController@edit']);
		Route::post('edit/{id}',['as'=>'updateIconSchedules','uses'=>'IconScheduleController@update']);
		Route::get('/delete/{id}',['as'=>'deleteIconSchedules','uses'=>'IconScheduleController@delete']);
		Route::post('/delete-all/',['as'=>'deleteAllIconSchedules','uses'=>'IconScheduleController@deleteAll']);
		Route::get('/search',['as'=>'searchIconSchedules','uses'=>'IconScheduleController@searchIconSchedules']);
	});
	/*
	* categories icons detail schedule
	*/
	Route::group(['prefix'=>'category-icon-schedule'],function(){
		Route::get('/',['as'=>'catIconSchedules','uses'=>'CatIconScheduleController@index']);
		Route::get('/create',['as'=>'storeCatIconSchedules','uses'=>'CatIconScheduleController@store']);
		Route::post('/create',['as'=>'createCatIconSchedules','uses'=>'CatIconScheduleController@create']);
		Route::get('edit/{id}',['as'=>'editCatIconSchedules','uses'=>'CatIconScheduleController@edit']);
		Route::post('edit/{id}',['as'=>'updateCatIconSchedules','uses'=>'CatIconScheduleController@update']);
		Route::get('/delete/{id}',['as'=>'deleteCatIconSchedules','uses'=>'CatIconScheduleController@delete']);
	});

	//consultants
	Route::group(['prefix'=>'consultants'],function(){
		Route::get('/',['as'=>'consultantsAdmin','uses'=>'ConsultantsAdminController@index']);		
		Route::get('create',['as'=>'storeConsultantAdmin','uses'=>'ConsultantsAdminController@store']);
		Route::post('create',['as'=>'createConsultantAdmin','uses'=>'ConsultantsAdminController@create']);		
		Route::get('edit/{id}',['as'=>'editConsultantAdmin','uses'=>'ConsultantsAdminController@edit']);
		Route::post('edit/{id}',['as'=>'updateConsultantAdmin','uses'=>'ConsultantsAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteConsultantAdmin','uses'=>'ConsultantsAdminController@delete']);
		Route::get('/delete-all',['as'=>'deleteAllConsultantAdmin','uses'=>'ConsultantsAdminController@deleteAll']);
	});

	//tour guide
	Route::group(['prefix'=>'tour-guide'],function(){
		Route::get('/',['as'=>'tourGuidesAdmin','uses'=>'TourGuideAdminController@index']);		
		Route::get('create',['as'=>'storeTourGuideAdmin','uses'=>'TourGuideAdminController@store']);
		Route::post('create',['as'=>'createTourGuideAdmin','uses'=>'TourGuideAdminController@create']);		
		Route::get('edit/{id}',['as'=>'editTourGuideAdmin','uses'=>'TourGuideAdminController@edit']);
		Route::post('edit/{id}',['as'=>'updateTourGuideAdmin','uses'=>'TourGuideAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteTourGuideAdmin','uses'=>'TourGuideAdminController@delete']);
		Route::get('/delete-all',['as'=>'deleteAllTourGuideAdmin','uses'=>'TourGuideAdminController@deleteAll']);
	});

	//bloggers
	Route::group(['prefix'=>'bloggers'],function(){
		Route::get('/',['as'=>'bloggersAdmin','uses'=>'BloggerAdminController@index']);		
		Route::get('create',['as'=>'storeBloggerAdmin','uses'=>'BloggerAdminController@store']);
		Route::post('create',['as'=>'createBloggerAdmin','uses'=>'BloggerAdminController@create']);		
		Route::get('edit/{id}',['as'=>'editBloggerAdmin','uses'=>'BloggerAdminController@edit']);
		Route::post('edit/{id}',['as'=>'updateBloggerAdmin','uses'=>'BloggerAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteBloggerAdmin','uses'=>'BloggerAdminController@delete']);
		Route::get('/delete-all',['as'=>'deleteAllBloggerAdmin','uses'=>'BloggerAdminController@deleteAll']);
	});

	/*
	* Category travel tips
	*/
	Route::group(['prefix'=>'cat-travel-tips'],function(){
		Route::get('/',['as'=>'catGuidesAdmin','uses'=>'CatGuideAdminController@index']);
		Route::get('/create',['as'=>'storeCatGuideAdmin','uses'=>'CatGuideAdminController@store']);
		Route::post('/create',['as'=>'createCatGuideAdmin','uses'=>'CatGuideAdminController@create']);
		Route::get('edit/{slug}',['as'=>'editCatGuideAdmin','uses'=>'CatGuideAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateCatGuideAdmin','uses'=>'CatGuideAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteCatGuideAdmin','uses'=>'CatGuideAdminController@delete']);
		Route::get('delete-all',['as'=>'deleteAllCatGuideAdmin','uses'=>'CatGuideAdminController@deleteAll']);
		Route::post('position',['as'=>'positionCatGuideAdmin','uses'=>'CatGuideAdminController@position']);
	});

	/*
	* Category cultural guides
	*/
	Route::group(['prefix'=>'cat-cultural-guides'],function(){
		Route::get('/',['as'=>'catCulturalsAdmin','uses'=>'CatCulturalAdminController@index']);
		Route::get('/create',['as'=>'createCatCulturalAdmin','uses'=>'CatCulturalAdminController@store']);
		Route::post('/create',['as'=>'storeCatCulturalAdmin','uses'=>'CatCulturalAdminController@create']);
		Route::get('edit/{id}',['as'=>'editCatCulturalAdmin','uses'=>'CatCulturalAdminController@edit']);
		Route::post('edit/{id}',['as'=>'updateCatCulturalAdmin','uses'=>'CatCulturalAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteCatCulturalAdmin','uses'=>'CatCulturalAdminController@delete']);
	});
	/*
	* Category nationality guides
	*/
	Route::group(['prefix'=>'nationality'],function(){
		Route::get('/',['as'=>'Nationality','uses'=>'CatNationAdminController@index']);
		Route::get('/create',['as'=>'storeNationalityAdmin','uses'=>'CatNationAdminController@create']);
		Route::post('/create',['as'=>'createNationalityAdmin','uses'=>'CatNationAdminController@store']);
		Route::get('edit/{id}',['as'=>'editNationalityAdmin','uses'=>'CatNationAdminController@edit']);
		Route::post('edit/{id}',['as'=>'updateNationalityAdmin','uses'=>'CatNationAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteNationalityAdmin','uses'=>'CatNationAdminController@delete']);
	});

	/*
	* Category things to do
	*/
	Route::group(['prefix'=>'cat-things-to-do'],function(){
		Route::get('/',['as'=>'catThingsToDoAdmin','uses'=>'CatThingToDoAdminController@index']);
		Route::get('/create',['as'=>'storeCatThingToDoAdmin','uses'=>'CatThingToDoAdminController@store']);
		Route::post('/create',['as'=>'createCatThingToDoAdmin','uses'=>'CatThingToDoAdminController@create']);
		Route::get('edit/{slug}',['as'=>'editCatThingToDoAdmin','uses'=>'CatThingToDoAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateCatThingToDoAdmin','uses'=>'CatThingToDoAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteCatThingToDoAdmin','uses'=>'CatThingToDoAdminController@delete']);
	});

	//travel tips
	Route::group(['prefix'=>'travel-tips'],function(){
		Route::get('/',['as'=>'guidesAdmin','uses'=>'GuideAdminController@index']);		
		Route::get('create',['as'=>'storeGuideAdmin','uses'=>'GuideAdminController@store']);
		Route::post('create',['as'=>'createGuideAdmin','uses'=>'GuideAdminController@create']);		
		Route::get('edit/{id}',['as'=>'editGuideAdmin','uses'=>'GuideAdminController@edit']);
		Route::post('edit/{id}',['as'=>'updateGuideAdmin','uses'=>'GuideAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteGuideAdmin','uses'=>'GuideAdminController@delete']);
		Route::get('/delete-all',['as'=>'deleteAllGuideAdmin','uses'=>'GuideAdminController@deleteAll']);
		Route::get('/search',['as'=>'searchGuideAdmin','uses'=>'GuideAdminController@search']);
	});

	//cultural guides
	Route::group(['prefix'=>'cultural-guide'],function(){
		Route::get('/',['as'=>'culturalsAdmin','uses'=>'CulturalAdminController@index']);		
		Route::get('create',['as'=>'storeCulturalAdmin','uses'=>'CulturalAdminController@store']);
		Route::post('create',['as'=>'createCulturalAdmin','uses'=>'CulturalAdminController@create']);		
		Route::get('edit/{slug}',['as'=>'editCulturalAdmin','uses'=>'CulturalAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateCulturalAdmin','uses'=>'CulturalAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteCulturalAdmin','uses'=>'CulturalAdminController@delete']);
		Route::get('/delete-all',['as'=>'deleteAllCulturalAdmin','uses'=>'CulturalAdminController@deleteAll']);
		Route::get('/search',['as'=>'searchCulturalAdmin','uses'=>'CulturalAdminController@search']);
	});
	//market guides
	Route::group(['prefix'=>'market-guide'],function(){
		Route::get('/',['as'=>'marketAdmin','uses'=>'MarketAdminController@index']);		
		Route::get('create',['as'=>'storeMarketAdmin','uses'=>'MarketAdminController@store']);
		Route::post('create',['as'=>'createMarketAdmin','uses'=>'MarketAdminController@create']);		
		Route::get('edit/{slug}',['as'=>'editMarketAdmin','uses'=>'MarketAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateMarketAdmin','uses'=>'MarketAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteMarketAdmin','uses'=>'MarketAdminController@delete']);
		Route::get('/delete-all',['as'=>'deleteAllMarketAdmin','uses'=>'MarketAdminController@deleteAll']);
		Route::get('/search',['as'=>'searchMarketAdmin','uses'=>'MarketAdminController@search']);
	});

	//sub-cultural guides
	Route::group(['prefix'=>'sub-cultural-guide'],function(){
		Route::get('/',['as'=>'subCulturalsAdmin','uses'=>'SubCulturalAdminController@index']);		
		Route::get('create',['as'=>'storeSubCulturalAdmin','uses'=>'SubCulturalAdminController@store']);
		Route::post('create',['as'=>'createSubCulturalAdmin','uses'=>'SubCulturalAdminController@create']);		
		Route::get('edit/{slug}',['as'=>'editSubCulturalAdmin','uses'=>'SubCulturalAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateSubCulturalAdmin','uses'=>'SubCulturalAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteSubCulturalAdmin','uses'=>'SubCulturalAdminController@delete']);
		Route::post('/delete-all',['as'=>'deleteAllSubCulturalAdmin','uses'=>'SubCulturalAdminController@deleteAll']);
		Route::get('/search',['as'=>'searchSubCulturalAdmin','uses'=>'SubCulturalAdminController@search']);
	});

	//Things to do
	Route::group(['prefix'=>'things-to-do'],function(){
		Route::get('/',['as'=>'thingsToDoAdmin','uses'=>'ThingToDoAdminController@index']);		
		Route::get('create',['as'=>'storeThingToDoAdmin','uses'=>'ThingToDoAdminController@store']);
		Route::post('create',['as'=>'createThingToDoAdmin','uses'=>'ThingToDoAdminController@create']);		
		Route::get('edit/{slug}',['as'=>'editThingToDoAdmin','uses'=>'ThingToDoAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateThingToDoAdmin','uses'=>'ThingToDoAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteThingToDoAdmin','uses'=>'ThingToDoAdminController@delete']);
		Route::get('/delete-all',['as'=>'deleteAllThingToDoAdmin','uses'=>'ThingToDoAdminController@deleteAll']);
	});

	//Attraction
	Route::group(['prefix'=>'attraction'],function(){
		Route::get('/',['as'=>'attractionsAdmin','uses'=>'AttractionAdminController@index']);		
		Route::get('create',['as'=>'storeAttractionAdmin','uses'=>'AttractionAdminController@store']);
		Route::post('create',['as'=>'createAttractionAdmin','uses'=>'AttractionAdminController@create']);		
		Route::get('edit/{slug}',['as'=>'editAttractionAdmin','uses'=>'AttractionAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateAttractionAdmin','uses'=>'AttractionAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteAttractionAdmin','uses'=>'AttractionAdminController@delete']);
		Route::get('/delete-all',['as'=>'deleteAllAttractionAdmin','uses'=>'AttractionAdminController@deleteAll']);
		Route::get('/search',['as'=>'searchAttractionAdmin','uses'=>'AttractionAdminController@search']);

		//list icon attraction
		Route::group(['prefix'=>'icon'],function(){
			Route::get('/',['as'=>'iconsAttractionAdmin','uses'=>'AttractionAdminController@indexIcon']);	
			Route::get('create',['as'=>'storeIconAttractionAdmin','uses'=>'AttractionAdminController@storeIcon']);
			Route::get('edit/{id}',['as'=>'editIconAttractionAdmin','uses'=>'AttractionAdminController@eitIcon']);
			Route::get('delete/{id}',['as'=>'deleteIconAttractionAdmin','uses'=>'AttractionAdminController@deleteIcon']);
			Route::post('/delete-all',['as'=>'deleteAllIconAttractionAdmin','uses'=>'AttractionAdminController@deleteAllIcon']);
		});
	});

	//Facilities
	Route::group(['prefix'=>'facilites'],function(){
		Route::get('/',['as'=>'facilitiesAdmin','uses'=>'FacilitiesAdminController@index']);		
		Route::get('create',['as'=>'storeFacilityAdmin','uses'=>'FacilitiesAdminController@store']);
		Route::post('create',['as'=>'createFacilityAdmin','uses'=>'FacilitiesAdminController@create']);		
		Route::get('edit/{slug}',['as'=>'editFacilityAdmin','uses'=>'FacilitiesAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateFacilityAdmin','uses'=>'FacilitiesAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteFacilityAdmin','uses'=>'FacilitiesAdminController@delete']);
		Route::post('/delete-all',['as'=>'deleteAllFacilityAdmin','uses'=>'FacilitiesAdminController@deleteAll']);
	});

	//hotels (accomodation)
	Route::group(['prefix'=>'accommodation'],function(){
		Route::get('/',['as'=>'hotelsAdmin','uses'=>'HotelAdminController@index']);		
		Route::get('create',['as'=>'storeHotelAdmin','uses'=>'HotelAdminController@store']);
		Route::post('create',['as'=>'createHotelAdmin','uses'=>'HotelAdminController@create']);		
		Route::get('edit/{slug}',['as'=>'editHotelAdmin','uses'=>'HotelAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateHotelAdmin','uses'=>'HotelAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteHotelAdmin','uses'=>'HotelAdminController@delete']);
		Route::get('/delete-all',['as'=>'deleteAllHotelAdmin','uses'=>'HotelAdminController@deleteAll']);

		Route::post('/delete-attraction-hotel', ['as'=>'deleteAttractionHotel', 'uses'=>'HotelAdminController@deleteAttHotel']);
		Route::post('/search-from-list', ['as'=>'searchHotelFromListAdmin', 'uses'=>'HotelAdminController@searchFromList']);
	});

	//Star rating hotel
	Route::group(['prefix'=>'star-rating'],function(){
		Route::get('/',['as'=>'starRatingsAdmin','uses'=>'StarRatingAdminController@index']);		
		Route::get('create',['as'=>'storeStarRatingAdmin','uses'=>'StarRatingAdminController@store']);
		Route::post('create',['as'=>'createStarRatingAdmin','uses'=>'StarRatingAdminController@create']);		
		Route::get('edit/{slug}',['as'=>'editStarRatingAdmin','uses'=>'StarRatingAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateStarRatingAdmin','uses'=>'StarRatingAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteStarRatingAdmin','uses'=>'StarRatingAdminController@delete']);
		Route::post('/position',['as'=>'positionStarRatingAdmin','uses'=>'StarRatingAdminController@position']);
	});

	//location hotel
	Route::group(['prefix'=>'location-hotel'],function(){
		Route::get('/',['as'=>'locationHotelsAdmin','uses'=>'LocationHotelAdminController@index']);		
		Route::get('create',['as'=>'storeLocationHotelAdmin','uses'=>'LocationHotelAdminController@store']);
		Route::post('create',['as'=>'createLocationHotelAdmin','uses'=>'LocationHotelAdminController@create']);		
		Route::get('edit/{slug}',['as'=>'editLocationHotelAdmin','uses'=>'LocationHotelAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateLocationHotelAdmin','uses'=>'LocationHotelAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteLocationHotelAdmin','uses'=>'LocationHotelAdminController@delete']);
		Route::post('/position',['as'=>'positionLocationHotelAdmin','uses'=>'LocationHotelAdminController@position']);
	});

	//special hotel
	Route::group(['prefix'=>'special-hotel'],function(){
		Route::get('/',['as'=>'specialHotelsAdmin','uses'=>'SpecialHotelAdminController@index']);		
		Route::get('create',['as'=>'storeSpecialHotelAdmin','uses'=>'SpecialHotelAdminController@store']);
		Route::post('create',['as'=>'createSpecialHotelAdmin','uses'=>'SpecialHotelAdminController@create']);		
		Route::get('edit/{slug}',['as'=>'editSpecialHotelAdmin','uses'=>'SpecialHotelAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateSpecialHotelAdmin','uses'=>'SpecialHotelAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteSpecialHotelAdmin','uses'=>'SpecialHotelAdminController@delete']);
		Route::post('/position',['as'=>'positionSpecialHotelAdmin','uses'=>'SpecialHotelAdminController@position']);
	});

	/*
	* Banner
	*/
	Route::group(['prefix'=>'banners'],function(){
		Route::get('/',['as'=>'bannersAdmin','uses'=>'BannerAdminController@index']);		
		Route::post('/',['as'=>'postbannerAdmin','uses'=>'BannerAdminController@save']);		
		Route::get('/change-post-banner',['as'=>'changePostBannerAdmin','uses'=>'BannerAdminController@changePost']);
	});

	/*
	* Places to visit (Highlight)
	*/
	Route::group(['prefix'=>'places-to-visit'],function(){
		Route::get('/',['as'=>'highlightsAdmin','uses'=>'HighlightAdminController@index']);
		Route::get('/create',['as'=>'storeHighlightAdmin','uses'=>'HighlightAdminController@store']);		
		Route::post('/create',['as'=>'createHighlightAdmin','uses'=>'HighlightAdminController@create']);	
		Route::get('edit/{slug}',['as'=>'editHighlightAdmin','uses'=>'HighlightAdminController@edit']);	
		Route::post('edit/{slug}',['as'=>'updateHighlightAdmin','uses'=>'HighlightAdminController@update']);	
		Route::get('delete/{id}',['as'=>'deleteHighlightAdmin','uses'=>'HighlightAdminController@delete']);	
		Route::get('/delete-all}',['as'=>'deleteAllHighlightAdmin','uses'=>'HighlightAdminController@deleteAll']);	
	});
	/*
	* overview (country)
	*/
	Route::group(['prefix'=>'overview'],function(){
		Route::get('/',['as'=>'overviewsAdmin','uses'=>'OverviewAdminController@index']);
		Route::get('/create',['as'=>'storeOverviewAdmin','uses'=>'OverviewAdminController@store']);		
		Route::post('/create',['as'=>'createOverviewAdmin','uses'=>'OverviewAdminController@create']);	
		Route::get('edit/{slug}',['as'=>'editOverviewAdmin','uses'=>'OverviewAdminController@edit']);	
		Route::post('edit/{slug}',['as'=>'updateOverviewAdmin','uses'=>'OverviewAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteOverviewAdmin','uses'=>'OverviewAdminController@delete']);	
		Route::get('/delete-all}',['as'=>'deleteAllOverviewAdmin','uses'=>'OverviewAdminController@deleteAll']);		
	});
	/*end overview*/

	/*
	* Icons
	*/
	Route::group(['prefix'=>'icons'],function(){
		Route::post('/create',['as'=>'createIconAdmin','uses'=>'IconAdminController@create']);
		Route::post('edit/{id}',['as'=>'updateIconAdmin','uses'=>'IconAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteIconAdmin','uses'=>'IconAdminController@delete']);
	});

	/*
	* Group Type
	*/
	Route::group(['prefix'=>'group-types'],function(){
		Route::get('/', ['as' => 'groupTypesAdmin', 'uses' => 'GroupTypeAdminController@index']);
		Route::get('/create',['as'=>'storeGroupTypeAdmin','uses'=>'GroupTypeAdminController@store']);
		Route::post('/create',['as'=>'createGroupTypeAdmin','uses'=>'GroupTypeAdminController@create']);
		Route::get('edit/{slug}', ['as' => 'editGroupTypeAdmin', 'uses' => 'GroupTypeAdminController@edit']);
		Route::post('edit/{slug}',['as'=>'updateGroupTypeAdmin','uses'=>'GroupTypeAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteGroupTypeAdmin','uses'=>'GroupTypeAdminController@delete']);
		Route::get('delete-all',['as'=>'deleteAllGroupTypeAdmin','uses'=>'GroupTypeAdminController@deleteAll']);
	});

	/*
	* Country tour style
	*/
	Route::group(['prefix'=>'country-tour-styles'],function(){
		Route::get('/', ['as' => 'countryTourStylesAdmin', 'uses' => 'CountryTourStyleAdminController@index']);
		Route::get('/create',['as'=>'storeCountryTourStyleAdmin','uses'=>'CountryTourStyleAdminController@store']);
		Route::post('/create',['as'=>'createCountryTourStyleAdmin','uses'=>'CountryTourStyleAdminController@create']);
		Route::get('edit/{id}', ['as' => 'editCountryTourStyleAdmin', 'uses' => 'CountryTourStyleAdminController@edit']);
		Route::post('edit/{id}',['as'=>'updateCountryTourStyleAdmin','uses'=>'CountryTourStyleAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteCountryTourStyleAdmin','uses'=>'CountryTourStyleAdminController@delete']);
		Route::get('delete-all',['as'=>'deleteAllCountryTourStyleAdmin','uses'=>'CountryTourStyleAdminController@deleteAll']);
	});

	/*
	* Country tour duration
	*/
	Route::group(['prefix'=>'country-tour-duration'],function(){
		Route::get('/', ['as' => 'countryTourDurationsAdmin', 'uses' => 'CountryTourDurationAdminController@index']);
		Route::get('/create',['as'=>'storeCountryTourDurationAdmin','uses'=>'CountryTourDurationAdminController@store']);
		Route::post('/create',['as'=>'createCountryTourDurationAdmin','uses'=>'CountryTourDurationAdminController@create']);
		Route::get('edit/{id}', ['as' => 'editCountryTourDurationAdmin', 'uses' => 'CountryTourDurationAdminController@edit']);
		Route::post('edit/{id}',['as'=>'updateCountryTourDurationAdmin','uses'=>'CountryTourDurationAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteCountryTourDurationAdmin','uses'=>'CountryTourDurationAdminController@delete']);
		Route::get('delete-all',['as'=>'deleteAllCountryTourDurationAdmin','uses'=>'CountryTourDurationAdminController@deleteAll']);
	});

	/**
	 * Category FAQ
	 */
	Route::group(['prefix'=>'category-faqs'],function(){
		Route::get('/', ['as' => 'catFaqsAdmin', 'uses' => 'CategoryFaqAdminController@index']);
		Route::get('/create', ['as' => 'storeCategoryFaqAdmin', 'uses' => 'CategoryFaqAdminController@store']);
		Route::post('/create', ['as' => 'createCategoryFaqAdmin', 'uses' => 'CategoryFaqAdminController@create']);
		Route::get('edit/{id}', ['as' => 'editCategoryFaqAdmin', 'uses' => 'CategoryFaqAdminController@edit']);
		Route::post('edit/{id}', ['as' => 'updateCategoryFaqAdmin', 'uses' => 'CategoryFaqAdminController@update']);
		Route::get('delete/{id}', ['as' => 'deleteCategoryFaqAdmin', 'uses' => 'CategoryFaqAdminController@delete']);
	});

	Route::group(['prefix'=>'faqs'],function(){
		Route::get('/', ['as' => 'faqsAdmin', 'uses' => 'FaqAdminController@index']);
		Route::get('/create', ['as' => 'storeFaqAdmin', 'uses' => 'FaqAdminController@store']);
		Route::post('/create', ['as' => 'createFaqAdmin', 'uses' => 'FaqAdminController@create']);
		Route::get('edit/{id}', ['as' => 'editFaqAdmin', 'uses' => 'FaqAdminController@edit']);
		Route::post('edit/{id}', ['as' => 'updateFaqAdmin', 'uses' => 'FaqAdminController@update']);
		Route::get('delete/{id}', ['as' => 'deleteFaqAdmin', 'uses' => 'FaqAdminController@delete']);
		Route::get('delete-all', ['as' => 'deleteAllFaqAdmin', 'uses' => 'FaqAdminController@deleteAll']);
	});

});


/**
 * post type level 1
 */
Route::get('/{slug}', ['as'=>'postType', 'uses'=>'PagesController@postType']);