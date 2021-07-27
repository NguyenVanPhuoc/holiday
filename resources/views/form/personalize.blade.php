@php 
    $bg_img = getImgUrl($page->image); 
    $breadcrumb = Breadcrumbs::render('FAQs', $page->title );
    $title_top_h1 = isset($_GET['title']) ? $_GET['title'] : '';
    $site_title =  'Personalize “'.$title_top_h1.'” | Sonasia Holiday';
@endphp
@extends('templates.master')
@section('title', $site_title)
@section('description',$seo->value)
@section('keywords', $seo->key)
@section('content')
<div id="personalize" class="page form-page bg-gray singe-post page-only personalize">
     <div class="image-header" style="background-image: url(<?php echo $bg_img; ?>);">
        <div class="wrap bottom">
            <div class="container">
                @if(isset($breadcrumb))
                    {!! $breadcrumb !!}
                @endif
                <span class="title-banner-2">- {{ $page->title }} -</span>
                <h1 class="title-banner-1">{{$title_top_h1}}</h1>
            </div>
        </div>
    </div>
    <div class="contact-pages light-graynvp">
        <div class="container">
            <div class="top-intro text-center">{!! $page->content !!}</div>
            <div class="content-personalize">
                <div class="row">
                    @desktop
                    <div id="sidebar" class="col-md-3">
                        @include('sidebars/sidebar_form')
                    </div>
                    @enddesktop
                    <div id="content" class="col-md-9 content-right">
                        <div class="connected light-graybg">
                            <div class="stay-connect">  
                                <span class="btn btn-connect">STAY CONNECTED</span>
                            </div>
                            <ul class="info-contact no-list-style">
                                <li><a href="tel:{{phone()}}"><img class="icon" src="{{asset('public/images/WhatsApp.png')}}" alt="bee-white"> {{phone()}}</a></li>
                                <li><a href="mailto:{{mailSystem()}}"><img class="icon" src="{{asset('public/images/Mailicon.png')}}" alt="bee-white"> {{mailSystem()}}</a></li>
                            </ul>   
                        </div>
                        <p class="text-right" style="font-style: italic;">(<span class="pink">*</span>) Mandatory fields</p>
                        <div class="form light-graybg">
                            <div class="box">
                                <form id="personalize-frm" autocomplete="off" action="#" method="POST" data-toggle="validator" role="form" name="contact" class="dev-form frm-personalize">
                                    {{csrf_field()}}
                                    <input type="hidden" autocomplete="false" name="url-frm" value="{{route('updatePersonalize')}}">
                                    <h4 class="desc-contact text-center pink">Personal information</h4>
                                    <div class="row">
                                        <p class="control-label title-lable">Your title & name<span class="required pink">*</span></p>
                                        <div id="frm-title"  class="form-group col-md-3 has-feedback">
                                            <div class="wrap-select">
                                                <select class="form-control js-select2" name="title" id="title" data-error="Not a valid title!" required>
                                                    <option value="Mr.">Mr.&nbsp;</option>
                                                    <option value="Mrs.">Mrs.&nbsp;</option>
                                                    <option value="Ms.">Ms.&nbsp;</option>
                                                </select>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div id="frm-fullName" class="form-group col-md-9 has-feedback">
                                            <input type="text" class="form-control" name="fullName" id="fullName" data-error="Not a valid full name!" placeholder="Full name" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="frm-email" class="form-group col-md-6 has-feedback">
                                            <label for="email" class="control-label">Email address<span class="pink">*</span></label>
                                            <input type="email" class="form-control" name="email" id="email" data-error="Not a valid email address!" placeholder="email@domain.com" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div id="frm-phone" class="form-group col-md-6">
                                            <label for="areaCode" class="control-label">Phone number</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control numberphone" name="numberPhone" id="numberPhone" >
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="frm-ageGroup" class="form-group col-md-6">
                                            <label for="ageGroup" class="control-label">Approximated age<span class="pink">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">Select range</span>
                                                <select name="ageGroup" id="ageGroup" class="form-control js-select2">
                                                    <option value="18-25" selected>18-25</option>
                                                    <option value="26-30">26-30</option>
                                                    <option value="31-35">31-35</option>
                                                    <option value="36-40">36-40</option>
                                                    <option value="41-45">41-45</option>
                                                    <option value="46-50">46-50</option>
                                                    <option value="51-55">51-55</option>
                                                    <option value="56-60">56-60</option>
                                                    <option value="61-65">61-65</option>
                                                    <option value="65-up">66-up</option>
                                                </select>
                                                
                                            </div>
                                        </div>
                                        <div id="frm-condition" class="form-group has-feedback col-md-6">
                                            <label for="condition" class="control-label">Physical condition<span class="pink">*</span></label>
                                            <div class="wrap-select">
                                                <select name="condition" id="condition" class="form-control js-select2" data-error="Not a valid condition!" required> 
                                                    <option value="Excellent">Excellent</option>
                                                    <option value="Good to Excellent">Good to Excellent</option>
                                                    <option value="Good">Good</option>
                                                    <option value="Average to Good">Average to Good </option>
                                                    <option value="Average">Average</option>
                                                </select>
                                            </div>
                                        </div> 
                                    </div>
                                    <div id="frm-physical" class="form-group has-feedback">
                                        <label for="physical" class="control-label">Further notes on physical condition</label>
                                        <textarea name="physical" id="physical" class="form-control" data-error="Please fill out this field.!"  placeholder="I prefer nature activities, I can walk up to 3 hours per day or more with some rests along the way"></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>                     
                                    <label class="control-label">Number of traveler(s)<span class="pink">*</span></label>
                                    <div class="row num-travel">
                                        <div id="frm-numAdult" class="form-group col-md-6 col-vp">
                                            <div class="input-group">
                                                <span class="input-group-addon">Adult</span>
                                                <select name="numAdult" id="numAdult" class="form-control js-select2" data-error="Numbers adult other 0!" required>
                                                    <option value="1" >1</option>
                                                    @for($i = 2; $i <= 40; $i++) :
                                                        <option value="{{$i}}">{{$i}}</option>
                                                    @endfor;
                                                </select>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div id="frm-numTeenager" class="form-group col-md-6 col-vp">
                                            <div class="input-group">
                                                <span class="input-group-addon">Teenager(s) 13-18 y.o.</span>
                                                <select name="numTeenager" id="numTeenager" class="form-control js-select2">
                                                    <option value="0" selected>0</option>
                                                    @for($i=1; $i<=10; $i++) :
                                                        <option value="{{$i}}">{{$i}}</option>
                                                    @endfor;
                                                </select>
                                            </div>
                                        </div>
                                        <div id="frm-numChild" class="form-group col-md-6 col-vp">
                                            <div class="input-group">
                                                <span class="input-group-addon">Child 2-12 y.o.</span>
                                                <select name="numChild" id="numChild" class="form-control js-select2">
                                                    <option value="0" selected>0</option>
                                                    @for($i=1; $i<=10; $i++) :
                                                        <option value="{{$i}}">{{$i}}</option>
                                                    @endfor;
                                                </select>
                                            </div>
                                        </div>
                                        <div id="frm-numBaby" class="form-group col-md-6 col-vp">
                                            <div class="input-group">
                                                <span class="input-group-addon">Infant(s) < 2 y.o.</span>
                                                <select name="numBaby" id="numBaby" class="form-control js-select2">
                                                    <option value="0" selected>0</option>
                                                    @for($i=1; $i<=5; $i++) :
                                                        <option value="{{$i}}">{{$i}}</option>
                                                    @endfor;
                                                </select>
                                            </div>
                                        </div>
                                    </div>   
                                    <h4 class="desc-contact text-center pink your-mess">Project information</h4>
                                    <div class="row arravel-duration">
                                        <div id="frm-arrivalDate" class="form-group col-md-6 has-feedback">
                                            <label for="arrivalDate" class="control-label">Arrival date<span class="pink">*</span></label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control" name="arrivalDate" id="arrivalDate" data-error="Not a valid arrival date!" required>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div id="frm-duration" class="form-group col-md-6">
                                            <label for="duration" class="control-label">Duration<span class="pink">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">Number of day(s)</span>
                                                <select name="duration" id="duration" class="form-control js-select2">
                                                    <option value="0" selected>0</option>
                                                    @for($i=1; $i<=100; $i++) :
                                                        <option value="{{$i}}">{{$i}}</option>
                                                    @endfor;
                                                </select>
                                            </div>
                                        </div>                              
                                    </div>
                                    <p class="departure">Your approximate departure date: <span class="date-duration pink"></span></p>
                                    <div id="frm-explainTrip" class="form-group has-feedback">
                                        <label for="explainTrip" class="control-label">What do you expect from this trip?</label>
                                        <textarea name="explainTrip" id="explainTrip" class="form-control" data-error="Please fill out this field.!"  placeholder="To have contact with the local people? To learn more about local culture? or..."></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>  
                                    <div id="frm-otherDest" class="form-group">
                                        <label for="otherDest" class="control-label">Is there anything you wish to add or remove?</label>
                                        <textarea name="otherDest" id="otherDest" class="form-control" placeholder="From activites to accomodation, food or transport"></textarea>
                                    </div>
                                    <div id="frm-project" class="form-group">
                                        <label for="project" class="control-label">For this project,...</label>
                                        <div class="radio-rq">
                                            <div class="selected">
                                                <label class="checkbox checkbox-2">
                                                    <input type="radio" name="information" id="information" value="Checking some information" required>
                                                    <span class="checkmark"></span>I am checking some information, nothing for sure
                                                </label>
                                            </div>
                                        </div>
                                        <div class="radio-rq">
                                            <div class="selected">
                                                <label class="checkbox checkbox-2">
                                                    <input type="radio" name="proposal" id="proposal" value="Waiting for proposal" required>
                                                    <span class="checkmark"></span>I know where I am going, I am waiting for proposal to decide completely
                                                </label>
                                            </div>
                                        </div>
                                        <div class="radio-rq">
                                            <div class="selected">
                                                <label class="checkbox checkbox-2">
                                                    <input type="radio" name="quickly" id="information" value="Book quickly" required>
                                                    <span class="checkmark"></span>Safe date and destination, I plan to book quickly
                                                </label>
                                            </div>
                                        </div>
                                        <div class="radio-rq">
                                            <div class="selected">
                                                <label class="checkbox checkbox-2">
                                                    <input type="radio" name="ideas" id="ideas" value="Ideas and advice." required>
                                                    <span class="checkmark"></span>Safe project, and despite my research, I am open to in-depth ideas and advice.
                                                </label>
                                            </div>
                                        </div>
                                    </div>  
                                    <div id="frm-accommodation" class="form-group">
                                        <label for="accommodation" class="control-label">Accommodation type<span class="pink">*</span></label>
                                        <div class="row custom-checkbox">
                                            <div class="col-md-6 radio-rq">
                                                <div class="selected">
                                                    <label class="checkbox checkbox-2">
                                                        <input type="radio" name="accommodation" id="accommodation" value="Standard 2 stars" required>
                                                        Standard 2 stars
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 radio-rq">
                                                <div class="selected">
                                                    <label class="checkbox checkbox-2">
                                                        <input type="radio" name="accommodation" id="accommodation" value="Comfort 3 stars" required>
                                                        Comfort 3 stars
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 radio-rq">
                                                <div class="selected">
                                                    <label class="checkbox checkbox-2">
                                                        <input type="radio" name="accommodation" id="accommodation" value="First Class 4 stars" required>
                                                        First Class 4 stars
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 radio-rq">
                                                <div class="selected">
                                                    <label class="checkbox checkbox-2">
                                                        <input type="radio" name="accommodation" id="accommodation" value="Superior 5 stars" required>
                                                        Superior 5 stars
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 radio-rq">
                                                <div class="selected">
                                                    <label class="checkbox checkbox-2">
                                                        <input type="radio" name="accommodation" id="accommodation" value="Luxury 5 stars +" required>
                                                        Luxury 5 stars +
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 radio-rq">
                                                <div class="selected">
                                                    <label class="checkbox checkbox-2">
                                                        <input type="radio" name="accommodation" id="accommodation" value="Homestay" required>Homestay
                                                    </label>
                                                </div>
                                            </div>
                                        </div>     
                                    </div>  
                                    <label class="control-label">Room arrangement</label>
                                    <div class="row num-room">
                                        <div class="col-md-6">
                                            <div id="frm-doubleRoom" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Double Room</span>
                                                    <select name="doubleRoom" id="doubleRoom" class="form-control js-select2">
                                                        <option value="1" selected>1</option>
                                                        @for($i = 2; $i <= 25; $i++) :
                                                            <option value="{{$i}}">{{$i}}</option>
                                                        @endfor;
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="frm-individualRoom" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Single Room</span>
                                                    <select name="individualRoom" id="individualRoom" class="form-control js-select2">
                                                        <option value="0">0</option>
                                                        @for($i = 1; $i <= 50; $i++) :
                                                            <option value="{{$i}}">{{$i}}</option>
                                                        @endfor;
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="frm-twinRoom" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Twin Room</span>
                                                    <select name="twinRoom" id="twinRoom" class="form-control js-select2">
                                                        <option value="0" selected>0</option>
                                                        @for($i=1; $i<=25; $i++) :
                                                            <option value="{{$i}}">{{$i}}</option>
                                                        @endfor;
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="frm-tripleRoom" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Triple room</span>
                                                    <select name="tripleRoom" id="tripleRoom" class="form-control js-select2">
                                                        <option value="0">0</option>
                                                        @for($i = 1; $i <= 15; $i++) :
                                                            <option value="{{$i}}">{{$i}}</option>
                                                        @endfor;
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="frm-accommodation" class="form-group has-feedback">
                                        <label for="physical" class="control-label">Further notes for accommodation</label>
                                        <textarea name="accommon" id="accommon" class="form-control" data-error="Please fill out this field.!"  placeholder="Quiet room on the second floor? Connecting rooms for family? Room overlooking the river? etc"></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div> 
                                    <div id="frm-meals" class="form-group">
                                        <label for="tourType" class="control-label">Meals preferences</label>
                                        <p>Breakfasts are usually included at hotel</p>
                                        <div class="row custom-checkbox">
                                            <div class="col-md-6 radio-rq">
                                                <div class="selected">
                                                    <label class="checkbox checkbox-2">
                                                        <input type="radio" name="meals" class="meal-option" id="halfBorad" value="Half-board">Half board
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 radio-rq">
                                                <div class="selected">
                                                    <label class="checkbox checkbox-2">
                                                        <input type="radio" name="meals" class="meal-option" id="fullBoard" value="Full-board">Full board
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="mealsTrip">
                                            <textarea name="mealsTrips" id="mealsTrips" class="form-control" placeholder="Please specify here if you have any allergy or special diet"></textarea>
                                        </div>  
                                    </div>
                                    <div id="frm-budgetPerson" class="form-group">
                                        <label for="budgetPerson" class="control-label">Budget per person</label>
                                        <p>Excluding international flight tickets</p>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="text" name="budgetPerson" id="budgetPerson" class="onlynumber" placeholder="Type in amount">
                                            </span>
                                            <select name="currencyPerson" id="currencyPerson" class="form-control js-select2">
                                                <option value="USD" selected>USD</option>
                                                <option value="EUR">EUR</option> 
                                            </select>
                                        </div>
                                            <p>Your total estimated expense: <span class="pink">USD0.00 </span> (excluding international flight)</p>
                                    </div>   
                                    <h4 class="desc-contact text-center pink">AFFILIATE</h4>  
                                    <div id="frm-canContact" class="form-group">
                                        <label>Are you recommended by an existing Sonasia Holiday customer?</label>
                                        <div class="row custom-checkbox">
                                            <div class="col-md-6 radio-rq">
                                                <div class="selected">
                                                    <label class="checkbox checkbox-2">
                                                        <input type="radio" name="canContact" id="callYes" value="Yes">Yes
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 radio-rq active">
                                                <div class="selected">
                                                    <label class="checkbox checkbox-2">
                                                        <input type="radio" name="canContact" id="callNo" checked value="No">No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>                  
                                    </div>
                                    <div id="frm-sponsor" class="form-group">
                                        <label for="sponsor" class="control-label">Please specify his/her name<span class="pink">*</span></label>
                                        <div class="row">
                                            <div id="frm-titleIntro"  class="col-md-3 form-group">
                                                <div class="wrap-select">
                                                    <select class="form-control js-select2" name="titleIntro" id="titleIntro">
                                                        <option value="Mr.">Mr.</option>
                                                        <option value="Mrs.">Mrs.</option>
                                                        <option value="Ms.">Ms.</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="frm-fullNameIntro" class="col-md-9 form-group">
                                                <input type="text" class="form-control" name="fullNameIntro" id="fullNameIntro" placeholder="Full name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="g-recaptcha" data-sitekey="6LdNwNEUAAAAAAw5m1Nu-Ua9t5YZOe0BYU_womGv" ></div> 
                                    <div id="frm-newsletter" class="form-group">
                                        <div class="newsletter-wrap">
                                            <label class="checkbox checkbox-2">
                                            <input type="checkbox" name="newsletter" id="newsletter" checked><span class="checkmark"></span>Send me the latest news and promotion from Sonasia Holiday
                                            </label>
                                        </div>
                                    </div>
                                    <div class="text-center wrap-btn">
                                        <button type="submit" class="btn-page-2">Send<i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                    </div>
                                    <p class="text-center title-sending">By sending this form, you agree with our <a href="{{ route('privacyPolicy') }}"><strong>Privacy policy</strong></a></p>
                                </form>
                                <script src='https://www.google.com/recaptcha/api.js'></script>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
     <div class="life-nvp" style="background-image: url('{!! getImgUrl(getDsMetas(321)) !!}');">
        <div class="container">
            <h2 class="title-life"><span>{!! getDsMetas(320) !!}</span></h2>
        </div>
    </div>
    <!-- Modal -->
    <div id="personalizeModal" class="modal fade modal-preview" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">Preview</h2>
                </div>
                <div class="modal-body scrollbar-inner">
                    <div class="item md-info">
                        <h4>Your personal information</h4>
                        <div class="box-modal">
                            <ul class="clearfix no-list-style">
                                <li class="fullName">Fullname: <span></span></li>
                                <li class="are-group">Are group: <span></span></li>
                                <li class="email">Email: <span></span></li>
                                <li class="phone">Phone: <span></span></li>
                                <li class="country">Country: <span></span></li>
                                <li class="newsletter">Newsletter: <span></span></li>
                                <li class="travel-of">Number of Travelers: <span></span></li>
                                <li class="phy-cal">Physical conditions of participants: <span></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="item md-project">
                        <h4>Your Project information</h4>
                        <div class="box-modal">
                            <div class="row">
                                <div class="col-md-7 text-area">
                                    <p>Explain us what you expect from this trip
                                    <span class="project-item1"></span></p>
                                    <p>Tell us if there is anything you wish to personalize
                                    <span class="project-item2"></span></p>
                                    <p>Please specify here if you have any allergy or special diet
                                    <span class="project-item3"></span></p>
                                </div>
                                <div class="col-md-5">
                                    <ul class="full no-list-style">
                                        <li class="arrival">Arrival date: <span></span></li>
                                        <li class="duration">Duration: <span></span></li>
                                        <li class="accommodation">Accommodation type: <span></span></li>
                                        <li class="room">Number of room: <span></span></li>
                                        <li class="person">Budget per person: <span></span></li>
                                        <li class="meals">Meals preferences: <span></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item md-better">
                        <h4>To know you better</h4>
                        <div class="box-modal">
                            <div class="row">
                                <div class="col-md-6 text-area">
                                    <p>Describe your hobbies, passion and what you dislike
                                    <span class="better-item1"></span></p>
                                </div>
                                <div class="col-md-6 text-area">
                                    <p>Describe your last long haul travel experience
                                    <span class="better-item2"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item md-phone">
                        <h4>Set up a phone call</h4>
                        <div class="box-modal">
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="full no-list-style">
                                        <li class="text-can">Can we contact you by phone to further understand your project: <span></span></li>
                                        <li class="apps-call">Preferred channel to reach you: <span></span></li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="full no-list-style">
                                        <li class="app-date">Appointment date: <span></span></li>
                                        <li class="app-zone">Appointment time zone: <span></span></li>
                                        <li class="app-slot">Appointment time slot: <span></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item md-phone">
                        <h4>Sponsorship</h4>
                        <div class="box-modal">
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="full no-list-style">
                                        <li class="text-recon">Are you recommended by an existing Sonasia Holiday customer? : <span></span></li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="full no-list-style">
                                        <li class="sponsor">Sponsored by: <span></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>Close</button>
                </div>
            </div>
        </div>
    </div>
	<div id="errorForm" class="modal fade alertForm" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<img src="{{asset('public/images/bee/base_fill.png')}}" alt=""/>
					<h3>Oops!</h3>
					<p>Please fill in the required information.</p>
				</div>
			</div>
		</div>
    </div>
    <div id="successForm" class="modal fade alertForm" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<img src="{{asset('public/images/bee/base_fill.png')}}" alt=""/>
					<h3>Thank you for your interest !!</h3>
                    <p>We have well received your request. <br/> One of our consultant will reply you shortly.</p>
                    <p>For any further question, feel free to contact us at <a href="mailto:info@biig-holiday.com">info@biig-holiday.com</a></p>
                    <div class="text-center wrap-btn"><a href="{{route('home')}}" class="btn-page-2"><i class="fa fa-home" aria-hidden="true"></i>Homepage</a></div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop