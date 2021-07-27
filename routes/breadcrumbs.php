<?php 
use App\CountryArticle;


// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Sonasia', route('home'));
});
// SonaBee
Breadcrumbs::register('SonaBee', function ($breadcrumbs) {
    $breadcrumbs->push('SonaBee', route('blog'));
});

//Asia tour
Breadcrumbs::register('asiaTour', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Asia tour packages'); 
});

Breadcrumbs::register('countryTravel', function ($breadcrumbs, $country) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($country->title, route('overviewCountry', $country->slug)); 
});
// Home > page
Breadcrumbs::register('page', function ($breadcrumbs, $page) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($page->title, route('page',$page->slug));
});
// Home > contact
Breadcrumbs::register('contact', function ($breadcrumbs, $page) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($page->title, route('page',$page->slug));
});
// Home > blog
Breadcrumbs::register('blog', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Tin tức', route('blog'));    
});

//country places to vistit
Breadcrumbs::register('countryPlaceToVisit', function ($breadcrumbs, $country) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($country->title.' travel', route('countryPlaceToVisit', $country->slug)); 
    $breadcrumbs->push('Places to visit'); 
});

//region places to vistit
Breadcrumbs::register('regionPlaceToVisit', function ($breadcrumbs, $country, $region_title) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($country->title, '#'); 
    $breadcrumbs->push($region_title); 
});
//detail place to visit
Breadcrumbs::register('placeToVisit', function ($breadcrumbs, $country, $region, $highlight_title) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($country->title.' travel', route('overviewCountry',['slug_country'=>$country->slug]));
    $breadcrumbs->push('Places to visit', route('countryPlaceToVisit', $country->slug));
    $breadcrumbs->push($highlight_title);
});

//detail travel tip
Breadcrumbs::register('detailTravelTip', function ($breadcrumbs, $country, $guide_title) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($country->title.' travel', route('overviewCountry',['slug_country'=>$country->slug]));
    $breadcrumbs->push('Tips & Guide', route('countryGuide', $country->slug)); 
    $breadcrumbs->push($guide_title);
});
//detail merket guide
Breadcrumbs::register('detailMarket', function ($breadcrumbs, $country, $guide_title) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($country->title.' travel', route('overviewCountry',['slug_country'=>$country->slug]));
    $breadcrumbs->push('Tips & Guide', route('countryMarket', $country->slug)); 
    $breadcrumbs->push($guide_title);
});
//detail cultural insight
Breadcrumbs::register('detailCultural', function ($breadcrumbs, $country, $guide_title) {
    $breadcrumbs->parent('countryTravel', $country);
    $breadcrumbs->push('Cultural insight', route('countryCultural', $country->slug)); 
    $breadcrumbs->push($guide_title); 
});

//detail thing to do
Breadcrumbs::register('detailThingToDo', function ($breadcrumbs, $country, $guide_title) {
    $breadcrumbs->parent('countryTravel', $country); 
    $breadcrumbs->push('Things to do', route('countryThingsToDo', $country->slug)); 
    $breadcrumbs->push($guide_title); 
});

//country guide & tip
Breadcrumbs::register('countryGuide', function ($breadcrumbs, $country) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($country->title.' travel', route('overviewCountry',['slug_country'=>$country->slug]));
    $breadcrumbs->push('Tips & Guide'); 
});

//country cultural insights
Breadcrumbs::register('countryCultural', function ($breadcrumbs, $country) {
    $breadcrumbs->parent('countryTravel', $country); 
    $breadcrumbs->push('Cultural insights'); 
});

//country things to do
Breadcrumbs::register('countryThingsToDo', function ($breadcrumbs, $country) {
    $breadcrumbs->parent('countryTravel', $country);
    $breadcrumbs->push('Things to do'); 
});

//overview country
Breadcrumbs::register('overviewCountry', function ($breadcrumbs, $country_title) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($country_title .' travel');  
});

//country accommodation
Breadcrumbs::register('countryHotel', function ($breadcrumbs, $country) {
    $breadcrumbs->parent('countryTravel', $country);
    $breadcrumbs->push('Accommodation'); 
});

//region accommodation
Breadcrumbs::register('regionHotel', function ($breadcrumbs, $country, $region_title) {
    $breadcrumbs->parent('countryTravel', $country);
    $breadcrumbs->push('Accommodation', route('countryHotel', $country->slug));
    $breadcrumbs->push($region_title);
});

//city accommodation
Breadcrumbs::register('cityHotel', function ($breadcrumbs, $country, $region, $city_title) {
    $breadcrumbs->parent('countryTravel', $country);
    $breadcrumbs->push('Accommodation', route('countryHotel', $country->slug));
    $breadcrumbs->push($region->title, route('postTypeCountryTravel', ['slug_country' => $country->slug, 'slug' => $region->slug . '-accommodation']));
    $breadcrumbs->push($city_title);
});

//detail accommodation
Breadcrumbs::register('detailHotel', function ($breadcrumbs, $country, $region, $city, $hotel_title) {
    $breadcrumbs->parent('countryTravel', $country);
    $breadcrumbs->push('Accommodation', route('countryHotel', $country->slug));
    $breadcrumbs->push($region->title, route('postTypeCountryTravel', ['slug_country' => $country->slug, 'slug' => $region->slug . '-accommodation']));
    $breadcrumbs->push($city->title, route('postTypeCountryTravel', ['slug_country' => $country->slug, 'slug' => $city->slug . '-accommodation']));
    $breadcrumbs->push($hotel_title);
});

//country tour style
Breadcrumbs::register('countryTourStyle', function ($breadcrumbs, $country, $tour_style) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($country->title.' travel', route('overviewCountry',['slug_country'=>$country->slug]));
    $breadcrumbs->push('Tour packages', route('countryTour',['slug_country'=>$country->slug]));
    $breadcrumbs->push($tour_style);
});
//country tour duration
Breadcrumbs::register('countryTourDuration', function ($breadcrumbs, $country, $tour_duration) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($country->title.' travel', route('overviewCountry',['slug_country'=>$country->slug]));
    $breadcrumbs->push('Tour packages', route('countryTour',['slug_country'=>$country->slug]));
    $breadcrumbs->push($tour_duration);
});

//country tour
Breadcrumbs::register('countryTour', function ($breadcrumbs, $country) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($country->title.' travel', route('overviewCountry',['slug_country'=>$country->slug]));
    $breadcrumbs->push('Tour Packages');
});

//tour detail
Breadcrumbs::register('detailTour', function ($breadcrumbs, $country, $title_tour) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($country->title.' travel', route('overviewCountry',['slug_country'=>$country->slug]));
    $breadcrumbs->push('Tour packages', route('countryTour',['slug_country'=>$country->slug]));
    $breadcrumbs->push($title_tour);
});
//tour detail Asia
Breadcrumbs::register('detailAsiaTour', function ($breadcrumbs, $title_tour) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Asia tour packages', route('asiaTour'));
    //$breadcrumbs->push('Tour packages', route('countryTour',['slug_country'=>$country->slug]));
    $breadcrumbs->push($title_tour);
});
//country blog
Breadcrumbs::register('countryBlog', function ($breadcrumbs, $country_title) {
    $breadcrumbs->parent('SonaBee');
    // $breadcrumbs->push('Asia Blog', route('blog'));
    $breadcrumbs->push($country_title);
});

//category blog
Breadcrumbs::register('categoryBlog', function ($breadcrumbs, $cat_title) {
    $breadcrumbs->parent('SonaBee');
    $breadcrumbs->push($cat_title);
});

//country category blog
Breadcrumbs::register('countryCatBlog', function ($breadcrumbs, $country, $cat_title) {
    $breadcrumbs->parent('SonaBee');
    $breadcrumbs->push($country->title, route('blogCall', $country->slug));
    $breadcrumbs->push($cat_title);
});

//search blog
Breadcrumbs::register('searchBlog', function ($breadcrumbs) {
    $breadcrumbs->parent('SonaBee');
    $breadcrumbs->push('Search result');
});

//blog detail
Breadcrumbs::register('blogDetail', function ($breadcrumbs, $country, $blog) {
    $countryArticles = getAllCountriesId($blog->id);     
    $breadcrumbs->push('SonaBee', route('blog'));   
    if($countryArticles == 1){
       $breadcrumbs->push($country->title, route('blogCall', $country->slug));
    }else{
        $breadcrumbs->push('Asia', route('blog'));
    }
    $breadcrumbs->push($blog->title);
});

//about us parent
Breadcrumbs::register('aboutUsParent', function ($breadcrumbs,$page) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('About us', route('aboutPage'));
    $breadcrumbs->push($page->title);
});

//blogger
Breadcrumbs::register('blogger', function ($breadcrumbs, $blogger_title) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('About us', '#');
    $breadcrumbs->push('Sonasia Team', '#');
    $breadcrumbs->push($blogger_title);
});

//about us child
Breadcrumbs::register('aboutUsChild', function ($breadcrumbs, $title_page) {
    $breadcrumbs->parent('aboutUsParent');
    $breadcrumbs->push($title_page);
});
//FAQs
Breadcrumbs::register('FAQs', function ($breadcrumbs, $title_page) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($title_page);
});
//detail review
Breadcrumbs::register('detailReview', function ($breadcrumbs, $title) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('About us', '#');
    $breadcrumbs->push('Clients feedback', route('clientsReview'));
    $breadcrumbs->push($title);
});

Breadcrumbs::register('pageDS', function ($breadcrumbs, $page) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($page->title);
});