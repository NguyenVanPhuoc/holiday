@php 
    $bg_img = getImgUrl($page->image); 
    $breadcrumb = Breadcrumbs::render('FAQs', 'Contact us');
    $title_top_h1 = 'CONTACT US';
    $site_title = $page->title .' | Sonasia Holiday';
@endphp
@extends('templates.master')
@section('title', $site_title)
@section('description',$seo->value)
@section('keywords', $seo->key)
@section('content')
<div id="contact-page" class="page form-page bg-gray singe-post page-only">
	<div class="image-header" style="background-image: url(<?php echo $bg_img; ?>);">
        <div class="wrap bottom">
            <div class="container">
                @if(isset($breadcrumb))
                    {!! $breadcrumb !!}
                @endif
                <h1 class="title-banner-1">{{ $title_top_h1 }}</h1>
            </div>
        </div>
    </div>
    <div class="contact-pages light-graynvp">
    	<div class="container">
    		<div class="top-intro text-center">{!! $page->content !!}</div>
    		<div class="content-contact">
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
	    				<div class="click-here text-center">
	    					<p>Note: This is the simple contact form. If you want to</p>
							<span class="pink">request a free quote.<span><a href="{{ route('createMyTrip') }}" class="pink font-semibold"> CLICK HERE</a>
	    				</div>
							<p class="text-right" style="font-style: italic;">(<span class="pink">*</span>) Mandatory fields</p>
	    				<div class="form light-graybg">
							<div class="box">
								<form id="contact-frm" autocomplete="off" action="#" method="POST" data-toggle="validator" role="form" name="contact" class="dev-form frm-contact">
									{!!csrf_field()!!}
									<input type="hidden" autocomplete="false" name="url-frm" value="{{route('updateContact')}}">
									<h4 class="desc-contact text-center pink">Personal information</h4>
									<div class="row">
										<p class="control-label title-lable">Your title & name<span class="required pink">*</span></p>
										<div id="frm-title"  class="form-group col-md-3 has-feedback">
											<div class="wrap-select">
												<select class="form-control" name="title" id="title" data-error="Not a valid title!" required>
													<option value="Mr.">Mr.&nbsp;</option>
													<option value="Mrs.">Mrs.&nbsp;</option>
													<option value="Ms.">Ms.&nbsp;</option>
												</select>
												<span class="icon_down"><i class="fas fa-chevron-down"></i></span>
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
											<label for="email" class="control-label">Email address <span class="pink">*</span></label>
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
									<h4 class="desc-contact text-center your-mess pink">Your message</h4>
									<div id="frm-subject" class="form-group has-feedback">
										<label for="subject" class="control-label">Subject<span class="pink">*</span></label>
										<div class="wrap-select">
											<select name="subject" id="subject" class="form-control" data-error="Not a valid subject" required> 
												<option value="">Choose your contact subject...</option>
												<option value="1">Customer service</option>
												<option value="2">Trip plan</option>
												<option value="3">Ongoing file</option>
												<option value="4">Media/Partnership</option>
												<option value="5">Miscellaneous</option>
												<option value="6">Sonasia Club</option>
												<option value="7">Others</option>
											</select>
											<span class="icon_down"><i class="fas fa-chevron-down"></i></span>
										</div>
										<div class="help-block with-errors"></div>
									</div>
									<div id="frm-message" class="form-group has-feedback">
										<label for="message" class="control-label">Message<span class="pink">*</span></label>
										<textarea name="message" id="message" class="form-control" rows="10" data-error="Not a valid message" placeholder="Type in your message here" required></textarea>
										<div class="help-block with-errors"></div>
									</div>
									<div class="g-recaptcha" data-sitekey="6LdNwNEUAAAAAAw5m1Nu-Ua9t5YZOe0BYU_womGv" ></div> 
									<div id="frm-newsletter" class="form-group">
										<div class="newsletter-wrap">
											<label class="checkbox checkbox-2">
											<input type="checkbox" name="newsletter" id="newsletter" checked><span class="checkmark"></span>Send me the latest news and promotion from Sonasia Holiday
											</label>
										</div>
									</div>
									<div class="text-center wrap-btn"><button type="submit" class="btn-page-2">Send<i class="fa fa-paper-plane" aria-hidden="true"></i></button></div>
									<p class="text-center title-sending">By sending this form, you agree with our<a href="{{ route('privacyPolicy') }}"><strong>Privacy policy</strong></a> </p>
								</form>
								<script src='https://www.google.com/recaptcha/api.js'></script>
							</div>
						</div>
	    			</div>
    			</div>
    		</div>
    	</div>
    </div>
	<div class="life-nvp" style="background-image: url('{!! getImgUrl(getDsMetas(317)) !!}');">
		<div class="container">
			<h2 class="title-life"><span>{!! getDsMetas(316) !!}</span></h2>
		</div>
	</div>
	<!-- Modal -->
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