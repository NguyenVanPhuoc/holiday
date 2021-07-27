@php 
    $bg_img = getImgUrl($page->image); 
    $breadcrumb = Breadcrumbs::render('FAQs', $page->title );
    $title_top_h1 = $page->title;
    $site_title =  $page->title. ' | Sonasia Holiday';
    $bg_looking= getImgUrl(getDsMetas(322));
    $bg_request= getImgUrl(getDsMetas(323));
    $regions = getAllCountryByLevel(1);
    $durations = getListDuration();
    $styles = getAllCountryTourStyle();
@endphp
@extends('templates.master')
@section('title', $site_title)
@section('description',$seo->value)
@section('keywords', $seo->key)
@section('content')
<div id="feedback" class="page form-page bg-gray singe-post page-only feedback">
     <div class="image-header" style="background-image: url(<?php echo $bg_img; ?>);">
        <div class="wrap bottom">
            <div class="container">
                @if(isset($breadcrumb))
                    {!! $breadcrumb !!}
                @endif
                <h1 class="title-banner-1">{{$title_top_h1}}</h1>
            </div>
        </div>
    </div>
    <div class="contact-pages light-graynvp">
        <div class="container">
            <div class="top-intro text-center">{!! $page->content !!}</div>
        </div>
        <div class="list-partner graybg text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 experience">
                        <img src="{{asset('public/images/temp/step 2.png')}}" alt="image">
                        <h3 class="title">{{ __('You are welcome to share your experience...')}}</h3>
                    </div>
                    <div class="col-md-8 list_exper">
                        <div class="item">
                            <a href="#" target="_blank">
                                <img src="{{asset('public/images/temp/Tripadvisor-grey.png')}}" alt="image">
                            </a>
                        </div>
                        <div class="item size_fit">
                            <a href="#" target="_blank">
                                <img src="{{asset('public/images/temp/Petit fute.png')}}" alt="image">
                            </a>
                        </div>
                        <div class="item size_thumb">
                            <a href="#" target="_blank">
                                <img src="{{asset('public/images/temp/facebook.png')}}" alt="image">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container content-feedbeck">
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
                            <form id="feedbeck-frm" autocomplete="off" action="#" method="POST" data-toggle="validator" role="form" name="contact" class="dev-form frm-feedbeck">
                                {{csrf_field()}}
                                <input type="hidden" autocomplete="false" name="url-frm" value="{{route('updateFeedback')}}">
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
                                    <div class="col-md-6 has-feedback">
                                        <div id="frm-code" class="form-group">
                                            <label for="code" class="control-label">Code of tour</label>
                                            <input type="text" class="form-control" name="code" id="code">
                                        </div>
                                        <div id="frm-PeriodDate">
                                            <label for="PeriodDate" class="control-label">Period of travel</label>
                                            <div class="input-group date form-group" id="fromPeriodDate" >
                                                <input type="text" class="form-control" name="fromPeriodDate" placeholder="From" data-error="Not a valid arrival date!" required>
                                                <span class="input-group-addon date-peri"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                            <div class="input-group date form-group" id="toPeriodDate">
                                                <input type="text" class="form-control" name="toPeriodDate" placeholder="To" data-error="Not a valid arrival date!" required>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 has-feedback">
                                        <div class="bkg-white">
                                            <h4 class="rating-scale">RATING SCALE</h4>
                                            <ul class="list-scale">
                                                <li class="excellent"> = Excellent</li>
                                                <li class="very_good"> = Very good</li>
                                                <li class="good"> = Good</li>
                                                <li class="average"> = Average</li>
                                                <li class="poor"> = Poor</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="desc-contact text-center pink ">YOUR TRAVEL CONSULTANT</h4>
                                <div class="row row-mobi">
                                    <div class="col-md-4 text-center">
                                        <p>Knowledge</p>
                                        <div class="rate-cs" id="knowledge" data-rate="3"></div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <p>Helpfulness</p>
                                        <div class="rate-cs" id="helpfulness" data-rate="3"></div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <p>Courteousness</p>
                                        <div class="rate-cs" id="courteousness" data-rate="3"></div>
                                    </div>
                                </div>
                                <h4 class="desc-contact text-center pink mar-top">YOUR TOUR GUIDE(S)</h4>
                                <div id="frm-feedback-rpt">   
                                    <div class="sortable">
                                        <div class="guide-number">
                                            <div class="row">
                                                <div class="col-md-6 has-feedback guide-1">
                                                    <div id="frm-guide" class="form-group">
                                                        <input type="text" class="form-control" name="guide" id="guide" placeholder="Guide name*">
                                                    </div>
                                                    <div id="frm-places" class="form-group">
                                                        <input type="text" class="form-control" name="places" id="places" placeholder="Places to visit">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 has-feedback date-1">
                                                    <div id="frm-GuideDate">
                                                        <div class="input-group date form-group">
                                                            <input type="text" class="form-control" name="fromGuideDate" id="fromGuideDate" placeholder="From" data-error="Not a valid arrival date!" required>
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                        </div>
                                                        <div class="input-group date form-group">
                                                            <input type="text" class="form-control" name="toGuideDate" id="toGuideDate" placeholder="To" data-error="Not a valid arrival date!" required>
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                        </div>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row row-mobi-col">
                                                <div class="col-md-3 text-center raty-1">
                                                    <p>Language</p>
                                                    <div class="rate-cs" id="language" data-rate="3"></div>
                                                </div>
                                                <div class="col-md-3 text-center raty-2">
                                                    <p>Knowledge</p>
                                                    <div class="rate-cs" id="knowlg" data-rate="3"></div>
                                                </div>
                                                <div class="col-md-3 text-center raty-3">
                                                    <p>Explanation</p>
                                                    <div class="rate-cs" id="explanation" data-rate="3"></div>
                                                </div>
                                                <div class="col-md-3 text-center raty-4">
                                                    <p>Attitude</p>
                                                    <div class="rate-cs" id="attitude" data-rate="3"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="btn btn-guide add-guide">Another guide</span>
                                </div>
                                <h4 class="desc-contact text-center pink mar-top">TOUR PROGRAM</h4>
                                <div class="row row-mobi">
                                    <div class="col-md-4 text-center">
                                        <p>Organization</p>
                                        <div class="rate-cs" id="organization" data-rate="3"></div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <p>Flexibility</p>
                                        <div class="rate-cs" id="flexibility" data-rate="3"></div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <p>Rhythm</p>
                                        <div class="rate-cs" id="rhythm" data-rate="3"></div>
                                    </div>
                                </div>
                                <h4 class="desc-contact text-center pink mar-top">YOUR ACCOMMODATION</h4>
                                <div id="frm-hottel-rpt">   
                                    <div class="sortable">
                                        <div class="hottel-number">
                                            <div class="row">
                                                <div class="col-md-6 has-feedback accommos-1">
                                                    <div id="frm-accommos" class="form-group">
                                                        <input type="text" class="form-control" name="accommodation" id="accommodation" placeholder="Accommodation name">
                                                    </div>
                                                    <div id="frm-city" class="form-group">
                                                        <input type="text" class="form-control" name="city" id="city" placeholder="City">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 has-feedback accomDate-1">
                                                    <div id="frm-AccomDate">
                                                        <div class="input-group date form-group">
                                                            <input type="text" class="form-control" name="fromAccomDate" id="fromAccomDate" placeholder="From" data-error="Not a valid arrival date!" required>
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                        </div>
                                                        <div class="input-group date form-group">
                                                            <input type="text" class="form-control" name="toAccomDate" id="toAccomDate" placeholder="To" data-error="Not a valid arrival date!" required>
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                        </div>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row row-mobi">
                                                <div class="col-md-4 text-center review-1">
                                                    <p>Comfort</p>
                                                    <div class="rate-cs" id="comfort" data-rate="3"></div>
                                                </div>
                                                <div class="col-md-4 text-center review-2">
                                                    <p>Location</p>
                                                    <div class="rate-cs" id="location" data-rate="3"></div>
                                                </div>
                                                <div class="col-md-4 text-center review-3">
                                                    <p>Cleanliness</p>
                                                    <div class="rate-cs" id="cleanliness" data-rate="3"></div>
                                                </div>
                                            </div>
                                            <div class="row row-mobi">
                                                <div class="col-md-4 text-center review-4">
                                                    <p>Facilities</p>
                                                    <div class="rate-cs" id="facilities" data-rate="3"></div>
                                                </div>
                                                <div class="col-md-4 text-center review-5">
                                                    <p>Staffs</p>
                                                    <div class="rate-cs" id="staffs" data-rate="3"></div>
                                                </div>
                                                <div class="col-md-4 text-center review-6">
                                                    <p>Breakfast</p>
                                                    <div class="rate-cs" id="breakfast" data-rate="3"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="btn btn-guide add-hottel">Another hotel</span>
                                </div>
                                <h4 class="desc-contact text-center pink mar-top">TRANSPORTATION</h4>
                                <div class="row row-mobi">
                                    <div class="col-md-4 text-center">
                                        <p>Driver</p>
                                        <div class="rate-cs" id="driver" data-rate="3"></div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <p>Safety</p>
                                        <div class="rate-cs" id="safety" data-rate="3"></div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <p>Comfort</p>
                                        <div class="rate-cs" id="comfort_vp" data-rate="3"></div>
                                    </div>
                                </div>
                                <h4 class="desc-contact text-center pink mar-top">RESTAURANT</h4>
                                <div class="row row-mobi">
                                    <div class="col-md-4 text-center">
                                        <p>Food</p>
                                        <div class="rate-cs" id="food" data-rate="3"></div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <p>Service</p>
                                        <div class="rate-cs" id="service" data-rate="3"></div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <p>Atmosphere</p>
                                        <div class="rate-cs" id="atmosphere" data-rate="3"></div>
                                    </div>
                                </div>
                                <h4 class="desc-contact text-center pink mar-top">HOW DID YOU HEAR ABOUT US?</h4>
                                <div id="frm-about-us">
                                    <div class="row custom-checkbox">
                                        <div class="col-md-4 check-req">
                                            <div class="selected">
                                                <div class="checkbox checkbox-2">
                                                    <input type="checkbox" name="about_us[]" id="about_us" value="Word of mouth">
                                                    <span>Word of mouth</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 check-req">
                                            <div class="selected">
                                                <div class="checkbox checkbox-2">
                                                    <input type="checkbox" name="about_us[]" id="about_us" value="Social media">
                                                    <span>Social media</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 check-req">
                                            <div class="selected">
                                                <div class="checkbox checkbox-2">
                                                    <input type="checkbox" name="about_us[]" id="about_us" value="Search engine">
                                                    <span>Search engine</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 check-req">
                                            <div class="selected">
                                                <div class="checkbox checkbox-2">
                                                    <input type="checkbox" name="about_us[]" id="about_us" value="Partner">
                                                    <span>Partner</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 check-req">
                                            <div class="selected">
                                                <div class="checkbox checkbox-2">
                                                    <input type="checkbox" name="about_us[]" id="about_us" value="Travel forum">
                                                    <span>Travel forum</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 open_orther">
                                            <div class="selected">
                                                <div class="checkbox checkbox-2">
                                                    <span>Others</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="frm-specify" class="form-group has-feedback">
                                        <textarea name="specify" id="specify" class="form-control" data-error="Please fill out this field.!"  placeholder="Please specify how you hear about us..."></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <h4 class="desc-contact text-center pink mar-top">FURTHER COMMENTS</h4>
                                <div id="frm-comments" class="form-group has-feedback">
                                    <textarea name="comments" id="comments" class="form-control" data-error="Please fill out this field.!"  placeholder="Tell us your experience and share your overall feedback"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div id="frm-agree" class="form-group">
                                    <div class="newsletter-wrap">
                                        <label class="checkbox checkbox-2">
                                        <input type="checkbox" name="agree" id="agree" checked>
                                        <span class="checkmark"></span><span class="font-semibold">I agree to show my feedback on the website</span>
                                        </label>
                                    </div>
                                </div>
                                <h4 class="desc-contact text-center pink mar-top">UPLOAD YOUR TRAVEL PHOTOS</h4>
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="dropzone dropzone_v1" id="dropzone" action="{{ route('fileUpload') }}">
                                            {{csrf_field()}}
                                                <img class="icon" src="{{asset('public/images/upload.png')}}" alt="upload">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="upload-pictures choose-files">
                                            <img class="icon" src="{{asset('public/images/choose-file.png')}}" alt="upload">
                                            <p class="title-pictures">Choose files</p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="upload-files" value=''/>
                                <!-- Preview collection of uploaded documents -->
                                <div class="preview-container dz-preview uploaded-files">
                                    <div id="previews">
                                        <div id="onyx-dropzone-template">
                                            <div class="onyx-dropzone-info">
                                                <div class="thumb-container">
                                                    <img data-dz-thumbnail />
                                                </div>
                                                <div class="details">
                                                    <div>
                                                        <span data-dz-name></span> <span data-dz-size></span>
                                                    </div>
                                                    <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                                                    <div class="dz-error-message"><span data-dz-errormessage></span></div>
                                                    <div class="actions">
                                                        <a href="#!" data-dz-remove><i class="fa fa-times"></i></a>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $list_destination = getAllMainCountry();
                                @endphp
                                <h4 class="desc-contact text-center pink mar-top">WHERE IS YOUR NEXT DESTINATION?</h4>
                                @if(isset($list_destination))
                                    <div id="frm-destination">
                                        <div class="row custom-checkbox">
                                        @foreach($list_destination as $item)
                                            <div class="col-md-4 check-req">
                                                <div class="selected">
                                                    <div class="checkbox checkbox-2">
                                                        <input type="checkbox" name="destination[]" id="destination" value="{{ $item->title }}" required>
                                                        <span>{{ $item->title }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                            <div class="col-md-4 open_orther">
                                                <div class="selected">
                                                    <div class="checkbox checkbox-2">
                                                        <span>Others</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="frm-explainTrip" class="form-group has-feedback">
                                            <textarea name="explainTrip" id="explainTrip" class="form-control" data-error="Please fill out this field.!"  placeholder="Please specify the other destinations you wish to include in your trip"></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                @endif
                                <div class="g-recaptcha" data-sitekey="6LdNwNEUAAAAAAw5m1Nu-Ua9t5YZOe0BYU_womGv" ></div> 
                                <div id="frm-newsletter" class="form-group">
                                    <div class="newsletter-wrap">
                                        <label class="checkbox checkbox-2">
                                        <input type="checkbox" name="newsletter" id="newsletter" checked>
                                        <span class="checkmark"></span><span class="font-semibold">Send me the latest news and promotion from Sonasia Holiday</span>
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
        <div class="content-places content-nvp">
            <div class="looking looking-tour-mobile"  style="background-image: url('{{ $bg_looking }}');">
                 @include('parts.looking-tour')
            </div>
            <div class="tready-yet light-graynvp">
                <div class="container">
                    <div class="header-sec text-center">
                        <div class="title-sec">
                            <span class="title pink">NOT READY YET?</span>
                        </div>
                        <div class="desc_p">
                            {!! getDsMetas(305) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="our_destinations padding_center light-graybg asia_our">
                <div class="container">
                    <div class="header-sec text-center">
                        <div class="title-sec">
                            <span class="title pink">OUR DESTINATIONS</span>
                        </div>
                    </div>
                     @include('parts.AsiaTourDetails.our_destinations')
                </div>
            </div>
            <div class="plans-travels light-graynvp padding_center slide_owl">
                <div class="container">
                    <div class="header-sec text-center">
                        <div class="title-sec">
                            <span class="title pink">PLANS BY TRAVEL THEME</span>
                        </div>
                    </div>
                     @include('parts.AsiaTourDetails.plans_travel_theme')
                </div>
            </div>
            <div class="plans-time light-graybg">
                <div class="padding_center">
                    <div class="container">
                        <div class="header-sec text-center">
                            <div class="title-sec">
                                <span class="title pink">PLANS BY TIME FRAME</span>
                            </div>
                        </div>
                        @include('parts.AsiaTourDetails.plans_time_frame')
                    </div>
                </div>
            </div>
            <div class="bot-tour light-graybg top-bot">
                <a href="{{ route('asiaTour') }}" class="btn btn-tour">All tour packages</a>
            </div>
            <div class="request back-none" style="background-image: url('{{ $bg_request }}')">
                @php
                    $img_request = getDsMetas(260);
                    $title_request = getDsMetas(301);
                @endphp
                @include('parts.request')
            </div>
            <div class="preparing light-graybg slide_owl asia_guide">
                <div class="container">
                    <div class="header-sec text-center">
                        <div class="title-sec">
                            <span class="title pink">TRAVEL TIPS & GUIDE</span>
                        </div>
                        <div class="desc_p">{!! getDsMetas(290) !!}</div>
                    </div>
                    @include('parts.list_nation')
                </div>
            </div>
            <div class="section-blog slide_owl">
                <div class="container">
                    <div class="header-sec text-center">
                        <div class="title-sec">
                            <span class="title pink">{!! getDsMetas(293) !!}</span>
                        </div>
                    </div>
                    @include('parts.list_blog')
                </div>
            </div>
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
                    <h3>Thank you for your valued feedback!</h3>
                    <p>We have successfully received your feedback., which helps us instantly improve our services</p>
                    <p>For any further inquiry, feel free to contact us at<a href="mailto:{{mailSystem()}}">{{mailSystem()}}</a></p>
                    <div class="text-center wrap-btn"><a href="{{route('home')}}" class="btn-page-2"><i class="fa fa-home" aria-hidden="true"></i>Homepage</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
   window.onbeforeunload = function (e) {
        var e = e || window.event;
        //IE & Firefox
        if (e) {
            e.returnValue = 'Are you sure?';
        }
        // For Safari
         return 'Are you sure?';
    };
</script>
@stop