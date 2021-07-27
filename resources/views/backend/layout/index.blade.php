<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description')">
    <meta name="key" content="@yield('key')">    
    <meta name="author" content="Vietsmiler">
    <title>Admin - @yield('title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/b2bcbfcb51.css">    
    <link rel="stylesheet" href="{{asset('public/css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/checkbox_radio.css')}}">    
    <link rel="stylesheet" href="{{asset('public/css/scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('public/admin/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('public/admin/css/bootstrap-colorpicker.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/pnotify.custom.min.css')}}">    
    <link rel="stylesheet" href="{{asset('public/css/select2.min.css')}}">   
    @yield('css') 
    <link href="{{asset('public/admin/css/admin.css')}}" rel="stylesheet" type="text/css">       
    <!-- <script src="{{asset('public/js/jquery.min.js')}}" type="text/javascript"></script>    -->   
    <script src="//code.jquery.com/jquery-2.2.2.min.js"></script>  
    <script src="{{asset('public/admin/js/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/admin/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script src="{{ asset('public/admin/ckeditor/ckeditor.js') }}"></script>    
    
    <script src="{{asset('public/admin/js/dropzone.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/admin/js/bootstrap-colorpicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/js/validator.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/js/validator.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/js/jquery.scrollbar.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/js/cleave.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/js/sortable.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/js/pnotify.custom.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/js/select2.min.js')}}" type="text/javascript"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.3.7/jquery.jscroll.js"></script>
    @yield('js')
    <script src="{{asset('public/admin/js/admin.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/admin/js/custom-multi-select.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/admin/js/form-custom.js')}}" type="text/javascript"></script>
    <!--flatpickr-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
   <!--  <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css"> -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{asset('public/js/flatpickr.js')}}" type="text/javascript"></script><!--//flatpickr-->
    @handheld
    <link rel="stylesheet" href="{{asset('public/admin/css/responsive.css')}}">
    <script src="{{ asset('public/admin/js/responsive.js') }}" type="text/javascript"></script>
    @endhandheld
    <script>
        function ckeditor(name){
            CKEDITOR.replace(name, {
                filebrowserBrowseUrl: '{{ asset('public/admin/ckfinder/ckfinder.html') }}',
                filebrowserImageBrowseUrl: '{{ asset('public/admin/ckfinder/ckfinder.html?type=Images') }}',
                filebrowserFlashBrowseUrl: '{{ asset('public/admin/ckfinder/ckfinder.html?type=Flash') }}',
                filebrowserUploadUrl: '{{ asset('public/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',
                filebrowserImageUploadUrl: '{{ asset('public/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
                filebrowserFlashUploadUrl: '{{ asset('public/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
            } );
        }

        //preview image
        function filePreview(input, id){
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#'+id+' .image img').attr('src',e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function(){
            $(".img-upload .image input").change(function(){
                var id = $(this).parents(".img-upload").attr("id");
                $(this).parents(".img-upload").find(".thumb-media").val("");
                filePreview(this, id);
            });
        })
    </script>
</head>
<body>
    <div id="wrapper">
        <div id="sidebar">
            <h1 id="logo"><a href="{{URL::to('/admin')}}">{!! getLogo() !!}</a><a href="{{route('home')}}" target="_blank" class="front-end"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></h1>
            <div class="wrap-sidebar scrollbar-inner">
                <nav id="menu" role="navigation">
                    <ul>                    
                        <li class="has-children{{ Request::is('admin/pages','admin/pages/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-home" aria-hidden="true"></i>Pages</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/pages') ? ' class=active' : '' }}><a href="{{URL::to('/admin/pages')}}">All pages</a></li>
                                <li{{ Request::is('admin/pages/create') ? ' class=active' : '' }}><a href="{{URL::to('/admin/pages/create')}}">Add new</a></li>
                            </ul>
                        </li>                  
                        <li class="has-children{{ Request::is('admin','admin/blog','admin/blog/*','admin/categories','admin/categories/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Blogs</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/blog') ? ' class=active' : '' }}><a href="{{ route('blogAdmin') }}">All blogs</a></li>
                                <li{{ Request::is('admin/blog/create') ? ' class=active' : '' }}><a href="{{ route('storeBlogAdmin') }}">Add new</a></li>
                                <li{{ Request::is('admin/categories') ? ' class=active' : '' }}><a href="{{ route('categoriesAdmin') }}">Categories Blog</a></li>
                                <li{{ Request::is('admin/country-categories') ? ' class=active' : '' }}><a href="{{ route('countryCatBlogAdmin') }}">Country Categories Blog</a></li>
                                <li{{ Request::is('admin/country-blogs') ? ' class=active' : '' }}><a href="{{ route('countryBlogAdmin') }}">Country Blogs</a></li>
                            </ul>
                        </li> 
                        <li class="has-children{{ Request::is('admin/country','admin/country/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-globe" aria-hidden="true"></i>Country</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/country') ? ' class=active' : '' }}><a href="{{route('countryAdmin')}}">All countries</a></li>
                                <li{{ Request::is('admin/country/create') ? ' class=active' : '' }}><a href="{{route('storeCountryAdmin')}}">Add new</a></li>
                                <!-- <li{{ Request::is('admin/country/') ? ' class=active' : '' }}><a href="{{route('countryCatAdmin')}}">Haven't Tour Style</a></li> -->
                                <li{{ Request::is('admin/country-places') ? ' class=active' : '' }}><a href="{{ route('countryPlacesAdmin') }}">Country places to visit</a></li>
                            </ul>
                        </li>
                        <li class="has-children{{ Request::is('admin/overview','admin/overview/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-eye" aria-hidden="true"></i>Overview</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/overview') ? ' class=active' : '' }}><a href="{{route('overviewsAdmin')}}">All overviews</a></li>
                                <li{{ Request::is('admin/overview/create') ? ' class=active' : '' }}><a href="{{route('storeOverviewAdmin')}}">Add new</a></li>
                            </ul>
                        </li>
                        <!-- <li class="has-children{{ Request::is('admin/places-to-visit','admin/places-to-visit/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-star-o" aria-hidden="true"></i>Places to visit</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/places-to-visit') ? ' class=active' : '' }}><a href="{{route('highlightsAdmin')}}">All places to visit</a></li>
                                <li{{ Request::is('admin/places-to-visit/create') ? ' class=active' : '' }}><a href="{{route('storeHighlightAdmin')}}">Add new</a></li>
                                <li{{ Request::is('admin/country-places') ? ' class=active' : '' }}><a href="{{ route('countryPlacesAdmin') }}">Country places to visit</a></li>
                            </ul>
                        </li> -->
                        <li class="has-children{{ Request::is('admin/tour','admin/tour/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-suitcase" aria-hidden="true"></i>Tour</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/tour') ? ' class=active' : '' }}><a href="{{route('tourAdmin')}}">All Tours</a></li>
                                <li{{ Request::is('admin/tour/create') ? ' class=active' : '' }}><a href="{{route('storeTourAdmin')}}">Add new</a></li>
                                <li{{ Request::is('admin/category-tour') ? ' class=active' : '' }}><a href="{{route('catTourAdmin')}}">Tour Style</a></li>
                                <li{{ Request::is('admin/duration') ? ' class=active' : '' }}><a href="{{route('durationAdmin')}}">Duration</a></li>
                                <li{{ Request::is('admin/country-tour') ? ' class=active' : '' }}><a href="{{ route('countryTourAdmin') }}">Country Tour</a></li>
                            </ul>
                        </li>
                        <li class="has-children{{ Request::is('admin/country-tour-styles','admin/country-tour-styles/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i>Country Tour Style</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/country-tour-styles') ? ' class=active' : '' }}><a href="{{route('countryTourStylesAdmin')}}">All Country tour styles</a></li>
                                <li{{ Request::is('admin/country-tour-styles/create') ? ' class=active' : '' }}><a href="{{route('storeCountryTourStyleAdmin')}}">Add new</a></li>
                            </ul>
                        </li>
                        <li class="has-children{{ Request::is('admin/country-tour-duration','admin/country-tour-duration/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-clock-o" aria-hidden="true"></i>Country Tour Duration</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/country-tour-duration') ? ' class=active' : '' }}><a href="{{route('countryTourDurationsAdmin')}}">All Country tour duration</a></li>
                                <li{{ Request::is('admin/country-tour-duration/create') ? ' class=active' : '' }}><a href="{{ route('storeCountryTourDurationAdmin') }}">Add new</a></li>
                            </ul>
                        </li>
                        <li class="has-children{{ Request::is('admin/accommodation','admin/accommodation/*', 'admin/star-rating', 'admin/star-rating/*', 'admin/location-hotel', 'admin/location-hotel/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-bed" aria-hidden="true"></i>Accommodation</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/accommodation') ? ' class=active' : '' }}><a href="{{ route('hotelsAdmin') }}">All accommodation</a></li>
                                <li{{ Request::is('admin/accommodation/create') ? ' class=active' : '' }}><a href="{{ route('storeHotelAdmin') }}">Add new</a></li>
                                <li{{ Request::is('admin/star-rating') ? ' class=active' : '' }}><a href="{{ route('starRatingsAdmin') }}">Star rating</a></li>
                                <li{{ Request::is('admin/location-hotel') ? ' class=active' : '' }}><a href="{{ route('locationHotelsAdmin') }}">Location</a></li>
                                <li{{ Request::is('admin/special-hotel') ? ' class=active' : '' }}><a href="{{ route('specialHotelsAdmin') }}">Special</a></li>
                                <li{{ Request::is('admin/facilities') ? ' class=active' : '' }}><a href="{{route('facilitiesAdmin')}}">Facilities</a></li>
                            </ul>
                        </li> 
                        <li class="has-children{{ Request::is('admin/attraction','admin/attraction/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i>Attraction</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/attraction') ? ' class=active' : '' }}><a href="{{ route('attractionsAdmin') }}">All attraction</a></li>
                                <li{{ Request::is('admin/attraction/create') ? ' class=active' : '' }}><a href="{{ route('storeAttractionAdmin') }}">Add new</a></li>
                                <li{{ Request::is('admin/attraction/icon') ? ' class=active' : '' }}><a href="{{ route('iconsAttractionAdmin') }}">List icon</a></li>
                            </ul>
                        </li> 
                         <li class="has-children{{ Request::is('admin/icons-detail-schedule','admin/icons-detail-schedule/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-suitcase" aria-hidden="true"></i>Icons Detail Schedule</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/icons-detail-schedule') ? ' class=active' : '' }}><a href="{{route('iconSchedules')}}">All Icons</a></li>
                                <li{{ Request::is('admin/tour/create') ? ' class=active' : '' }}><a href="{{route('storeIconSchedules')}}">Add new</a></li>
                                <li{{ Request::is('admin/category-icon-schedule') ? ' class=active' : '' }}><a href="{{route('catIconSchedules')}}">Categories Icon</a></li>
                            </ul>
                        </li> 
                        <li class="has-children{{ Request::is('admin/travel-tips','admin/travel-tips/*', 'admin/cat-travel-tips', 'admin/cat-travel-tips/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-lightbulb-o" aria-hidden="true"></i>Travel tips</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/travel-tips') ? ' class=active' : '' }}><a href="{{ route('guidesAdmin') }}">All Travel Tips</a></li>
                                <li{{ Request::is('admin/travel-tips/create') ? ' class=active' : '' }}><a href="{{route('storeGuideAdmin')}}">Add new</a></li>
                                <li{{ Request::is('admin/cat-travel-tips') ? ' class=active' : '' }}><a href="{{route('catGuidesAdmin')}}">Categories Travel tips</a></li>
                                <li{{ Request::is('admin/country-guide') ? ' class=active' : '' }}><a href="{{ route('countryGuideAdmin') }}">Country Guide</a></li>
                            </ul>
                        </li>  
                        <li class="has-children{{ Request::is('admin/market-guide','admin/market-guide/*', 'admin/cat-market-guides', 'admin/cat-market-guides/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-suitcase" aria-hidden="true"></i>Market Guides</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/market-guide') ? ' class=active' : '' }}><a href="{{ route('marketAdmin') }}">All Market Guides</a></li>
                                <li{{ Request::is('admin/market-guide/create') ? ' class=active' : '' }}><a href="{{route('storeMarketAdmin')}}">Add new</a></li>
                                <!-- <li{{ Request::is('admin/cat-cultural-guides') ? ' class=active' : '' }}><a href="{{route('catCulturalsAdmin')}}">Categories Cultural guide</a></li> -->
                                <li{{ Request::is('admin/nationality') ? ' class=active' : '' }}><a href="{{route('Nationality')}}">Nationality</a></li>
                                {{-- <li{{ Request::is('admin/sub-cultural-guide') ? ' class=active' : '' }}><a href="{{route('subCulturalsAdmin')}}">Sub-Cultural Guide</a></li> --}}
                            </ul>
                        </li>  
                        {{-- <li class="has-children{{ Request::is('admin/things-to-do','admin/things-to-do/*', 'admin/cat-things-to-do', 'admin/cat-things-to-do/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-check-circle-o" aria-hidden="true"></i>Things to do</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/things-to-do') ? ' class=active' : '' }}><a href="{{ route('thingsToDoAdmin') }}">All Things to do</a></li>
                                <li{{ Request::is('admin/things-to-do/create') ? ' class=active' : '' }}><a href="{{route('storeThingToDoAdmin')}}">Add new</a></li>
                                <li{{ Request::is('admin/cat-things-to-do') ? ' class=active' : '' }}><a href="{{route('catThingsToDoAdmin')}}">Categories Things to do</a></li>
                            </ul>
                        </li> 
                        <li class="has-children{{ Request::is('admin/brands','admin/brands/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-cubes" aria-hidden="true"></i>Đối tác</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/brands') ? ' class=active' : '' }}><a href="{{route('brandsAdmin')}}">Tất cả</a></li>
                                <li{{ Request::is('admin/brands/create') ? ' class=active' : '' }}><a href="{{route('createBrandAdmin')}}">Thêm mới</a></li>
                            </ul>
                        </li>   --}}
                        <li class="has-children{{ Request::is('admin/reviews','admin/reviews/*', 'admin/group-types', 'admin/group-types/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-thumbs-o-up"></i>Reviews</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/reviews') ? ' class=active' : '' }}><a href="{{route('reviewsAdmin')}}">All reviews</a></li>
                                <li{{ Request::is('admin/review/create') ? ' class=active' : '' }}><a href="{{route('storeReviewAdmin')}}">Add new</a></li>
                                <li{{ Request::is('admin/group-types') ? ' class=active' : '' }}><a href="{{route('groupTypesAdmin')}}">Group types</a></li>
                            </ul>
                        </li>
                        <li class="has-children{{ Request::is('admin/faqs','admin/faqs/*', 'admin/category-faqs', 'admin/category-faqs/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-question-circle" aria-hidden="true"></i>FAQs</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/faqs') ? ' class=active' : '' }}><a href="{{ route('faqsAdmin') }}">All FAQs</a></li>
                                <li{{ Request::is('admin/faqs/create') ? ' class=active' : '' }}><a href="{{ route('storeFaqAdmin') }}">Add new</a></li>
                                <li{{ Request::is('admin/category-faqs') ? ' class=active' : '' }}><a href="{{ route('catFaqsAdmin') }}">Category FAQs</a></li>
                            </ul>
                        </li>
                        {{-- <li class="has-children{{ Request::is('admin/slides','admin/slides/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-sliders"></i>Slides</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/slides') ? ' class=active' : '' }}><a href="{{route('slidesAdmin')}}">All slides</a></li>
                                <li{{ Request::is('admin/slides/create') ? ' class=active' : '' }}><a href="{{route('storeSlideAdmin')}}">Add new</a></li>
                            </ul>
                        </li>   --}}                
                        <li class="has-children{{ Request::is('admin/users','admin/users/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-users" aria-hidden="true"></i>Users</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/users') ? ' class=active' : '' }}><a href="{{route('users')}}">All users</a></li>
                                <li{{ Request::is('admin/users/create') ? ' class=active' : '' }}><a href="{{route('storeAdmin')}}">Add new</a></li>
                            </ul>
                        </li>
                        <li class="has-children{{ Request::is('admin/consultants','admin/consultants/*', 'admin/tour-guide', 'admin/tour-guide/*', 'admin/bloggers', 'admin/bloggers/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-users" aria-hidden="true"></i>Consultants</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/consultants') ? ' class=active' : '' }}><a href="{{ route('consultantsAdmin') }}">All consultants</a></li>
                                <li{{ Request::is('admin/consultants/create') ? ' class=active' : '' }}><a href="{{ route('storeConsultantAdmin') }}">Add new</a></li>
                                <li{{ Request::is('admin/tour-guide') ? ' class=active' : '' }}><a href="{{ route('tourGuidesAdmin') }}">All tour guide</a></li>
                                <li{{ Request::is('admin/bloggers') ? ' class=active' : '' }}><a href="{{ route('bloggersAdmin') }}">All bloggers</a></li>
                            </ul>
                        </li>
                        <li class="has-children{{ Request::is('admin/group-meta','admin/group-meta/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-th-large"></i>Meta field</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/group-meta') ? ' class=active' : '' }}><a href="{{route('metas')}}">All fields</a></li>
                                <li{{ Request::is('admin/group-meta/create') ? ' class=active' : '' }}><a href="{{route('storeMeta')}}">Add new</a></li>
                            </ul>
                        </li>
                        <li class="has-children{{ Request::is('admin/media','admin/media/*','admin/media-cat','admin/media-cat/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-file-image-o" aria-hidden="true"></i></i>Media</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/media') ? ' class=active' : '' }}><a href="{{route('media')}}">All medias</a></li>
                                <li{{ Request::is('admin/media/create') ? ' class=active' : '' }}><a href="{{route('addMedia')}}">Add new</a></li>
                                <li{{ Request::is('admin/media/media-cat') ? ' class=active' : '' }}><a href="{{route('mediaCat')}}">Categories media</a></li>
                            </ul>
                        </li>
                       {{--  <li class="has-children{{ Request::is('admin/banners')? ' active': '' }}">
                            <a href="{{ route('bannersAdmin') }}"><i class="fa fa-picture-o" aria-hidden="true"></i>Banner</a>
                        </li> --}}
                        <li class="has-children{{ Request::is('admin/setting','admin/setting/*','admin/menu','admin/menu/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-cog"></i>Settings</a>
                            <ul class="sub-menu">
                                <li{{ Request::is('admin/menu','admin/menu/*') ? ' class=active' : '' }}><a href="{{route('menu')}}">Menu</a></li>
                                <li{{ Request::is('admin/setting/option') ? ' class=active' : '' }}><a href="{{route('setting')}}">System</a></li>
                                <li{{ Request::is('admin/setting/socail') ? ' class=active' : '' }}><a href="{{route('settingSocial')}}">Socail Media</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>  
            </div>
        </div>
        <div id="content">
            <header>@include('backend.layout.header')</header>
            <main>
                @yield('content')
            </main>
            <footer>{!! copyright() !!}</footer>
        </div>
    </div>
    <div id="overlay"></div>
    <div class="loading"><img src="{{ asset('public/images/loading_red.gif') }}" alt="loading"></div>
</body>
</html>