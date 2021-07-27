@extends('templates.master')
@section('title', $page->title)
@section('description', $seo->value)
@section('keywords', $seo->key)
@section('content')
<div id="landing_page" class="page bg-gray">
	<div class="image-header" style="background-image: url('{{asset('public/images/temp/homepage 3.jpg')}}');">
		<div class="seventday">
			{!! $page->content !!}
		</div>
	</div>
	<div class="content_landing">
		<div class="bg-grays">
			<div class="container">
				{!! getDsMetas(228) !!}
			</div>
		</div>
		<div class="desc_laos graybg">
			<div class="container">
				{!! getDsMetas(229) !!}
			</div>
		</div>
		<div class="content_biig">
			<div class="container">
				<div class="text-center icons_biig">
					<img src="{{asset('public/images/icons/biig_club/tour brief.png')}}" alt="image">
					<h3 class="title-h3 yellow">Tour brief </h3>
				</div>
				<div class="list-sustai">
					<div class="item light-graybg">
						<div class="thumb_img">
							<img src="{!! getImgUrl(getDsMetas(230)) !!}" alt="">
						</div>
						{!! getDsMetas(231) !!}
					</div>
					<div class="item light-graybg">
						<div class="thumb_img">
							<img src="{!! getImgUrl(getDsMetas(232)) !!}" alt="">
						</div>
						{!! getDsMetas(233) !!}
					</div>
					<div class="item light-graybg">
						<div class="thumb_img">
							<img src="{!! getImgUrl(getDsMetas(234)) !!}" alt="">
						</div>
						{!! getDsMetas(235) !!}
					</div>
					<div class="item light-graybg">
						<div class="thumb_img">
							<img src="{!! getImgUrl(getDsMetas(236)) !!}" alt="">
						</div>
						{!! getDsMetas(237) !!}
					</div>
					<div class="item light-graybg">
						<div class="thumb_img">
							<img src="{!! getImgUrl(getDsMetas(238)) !!}" alt="">
						</div>
						{!! getDsMetas(239) !!}
					</div>
					<div class="item light-graybg">
						<div class="thumb_img">
							<img src="{!! getImgUrl(getDsMetas(240)) !!}" alt="">
						</div>
						{!! getDsMetas(241) !!}
					</div>
					<div class="item light-graybg">
						<div class="thumb_img">
							<img src="{!! getImgUrl(getDsMetas(242)) !!}" alt="">
						</div>
						{!! getDsMetas(243) !!}
					</div>
					<div class="link_check">
						Check out all details of the tour right <a href="{!! getDsMetas(244) !!}" class="bgrays">here</a>
					</div>
				</div>
			</div>
		</div>
		<div class="desc_about graybg">
			<div class="container">
				{!! getDsMetas(245) !!}
			</div>
		</div>
		<div class="videos_trip">
			<div class="container text-center">
				<h3 class="title_video"><img src="{!! getImgUrl(getDsMetas(246)) !!}" alt=""><span>{!! getDsMetas(247) !!}</span></h3>
				{!! getDsMetas(248) !!}
				<div class="button_phone_tour text-center conditions">
					<a href="{!! getDsMetas(249) !!}" class="set_phone" download><img class="pink" src="{{asset('public/images/icons/biig_club/pdf.png')}}" alt="image">Terms & conditions of the promotional offer </a>
				</div>
			</div>
		</div>
		<div class="participate">
			<div class="container">
				<div class="text-center icons_biig benefits">
					<img src="{{asset('public/images/icons/landing page/how to participate.png')}}" alt="icon">
					<h3 class="title-h3 pink">How to participate ?</h3>
				</div>
				<div class="list-steps">
					<div class="item light-graybg text-center">
						<h4 class="pink">Step 1</h4>
						<div class="child">
							<span class="icon"><img src="{!! getImgUrl(getDsMetas(250)) !!}"></span>
							<h4 class="title-h4">{!! getDsMetas(251) !!}</h4>
							<span>If not done yet, just click <a class="btn_yellow" href="{!! getDsMetas(252) !!}">here </a></span>
						</div>
					</div>
					<div class="item light-graybg text-center">
						<h4 class="pink">Step 2</h4>
						<div class="child">
							<span class="icon"><img src="{!! getImgUrl(getDsMetas(253)) !!}"></span>
							<h4 class="title-h4">{!! getDsMetas(254) !!}</h4>
							<a class="btn btn_face" href="{!! getDsMetas(255) !!}"><img src="{{asset('public/images/icons/facebook1.png')}}"> Sign in with Facebook </a>
						</div>
					</div>
					<div class="item light-graybg text-center">
						<h4 class="pink">Step 3</h4>
						<div class="child">
							<span class="icon"><img src="{!! getImgUrl(getDsMetas(256)) !!}"></span>
							<h4 class="title-h4">{!! getDsMetas(257) !!}</h4>
							<span>Approximated time 4 <a class="btn_yellow" href="{!! getDsMetas(258) !!}">min </a></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-page">
			<div class="contact container">
			    <div class="form">
			        <form id="contact-frm" autocomplete="off" action="#" method="POST" data-toggle="validator" role="form" name="contact" class="dev-form frm-contact">
						{!!csrf_field()!!}
						<input type="hidden" autocomplete="false" name="url-frm" value="{{route('updateContact')}}">
						<h4 class="desc-contact text-center">Personal information</h4>
						<div class="row">
							<div id="frm-title"  class="form-group col-md-2 has-feedback">
								<label for="title" class="control-label">Title</label>
								<div class="wrap-select">
									<select class="form-control" name="title" id="title" data-error="Not a valid title!" required>
										<option value="Mr.">Mr.</option>
										<option value="Mrs.">Mrs.</option>
										<option value="Ms.">Ms.</option>
									</select>
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div if="frm-firstName" class="form-group col-md-5 has-feedback">
								<label for="firstName" class="control-label">First name</label>
								<input type="text" class="form-control" name="firstName" id="firstName" data-error="Not a valid first name!" placeholder="First name" required>
								<div class="help-block with-errors"></div>
							</div>
							<div if="frm-lastName" class="form-group col-md-5 has-feedback">
								<label for="lastName" class="control-label">Last name</label>
								<input type="text" class="form-control" name="lastName" id="lastName" data-error="Not a valid last name!" placeholder="Last name" required>
								<div class="help-block with-errors"></div>
							</div>
						</div>
						<div class="row">
							<div id="frm-email" class="form-group col-md-6 has-feedback">
								<label for="email" class="control-label">Email</label>
								<input type="email" class="form-control" name="email" id="email" data-error="Not a valid email address!" placeholder="Email" required>
								<div class="help-block with-errors"></div>
							</div>
							<div id="frm-phone" class="form-group col-md-6">
								<label for="areaCode" class="control-label"><span>Phone</span><span> - Option</span></label>
								<div class="input-group">
									<div class="input-group-btn">
										<div class="wrap-select">
											<select class="form-control" name="areaCode" id="areaCode" required>
												{!!option_country_code()!!}
											</select>
										</div>
									</div>
									<input type="text" class="form-control" name="numberPhone" id="numberPhone" data-error="Not a valid phone number!" required>
								</div>
								<div class="help-block with-errors"></div>
							</div>
						</div>
						<div class="row">
							<div id="frm-ageGroup" class="form-group col-md-6">
								<label for="ageGroup" class="control-label">Age group</label>
								<div class="input-group">
									<span class="input-group-addon">Select range</span>
									<select name="ageGroup" id="ageGroup" class="js-select2 form-control">
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
							<div id="frm-country" class="form-group col-md-6 has-feedback">
								<label for="country" class="control-label">Country</label>
								<div class="wrap-select">
									<select name="country" id="country" class="form-control chose-country" data-error="Not a valid country" required>
										{!!option_country_ncode()!!}
									</select>
								</div>
								<div class="help-block with-errors"></div>
							</div>                    
						</div>
						<h4 class="desc-contact text-center">Your message</h4>
						<div id="frm-subject" class="form-group has-feedback">
							<label for="subject" class="control-label">Subject</label>
							<div class="wrap-select">
								<select name="subject" id="subject" class="form-control" data-error="Not a valid subject" required> 
									<option value="1">Customer service</option>
									<option value="2">Trip plan</option>
									<option value="3">Ongoing file</option>
									<option value="4">Media/Partnership</option>
									<option value="5">Miscellaneous</option>
									<option value="6">BiiG Club</option>
								</select>
							</div>
							<div class="help-block with-errors"></div>
						</div>
						<div id="frm-message" class="form-group has-feedback">
							<label for="message" class="control-label">Message</label>
							<textarea name="message" id="message" class="form-control" rows="10" data-error="Not a valid message" placeholder="Type in your message here" required></textarea>
							<div class="help-block with-errors"></div>
						</div>
						<div id="frm-newsletter" class="form-group">
							<label for="newsletter" class="control-label">Newsletter</label>
							<div class="newsletter-wrap">
								<label class="checkbox checkbox-2">
								<input type="checkbox" name="newsletter" id="newsletter" checked><span class="checkmark"></span>I want to receive BiiG Holiday news & promotions (once or twice per month)
								</label>
							</div>
						</div>
						<div id="frm-sponsor" class="form-group">
							<label for="sponsor" class="control-label"><span>Sponsor</span><span> - Optional</span></label>
							<p>If you are recommended by an existing BiiG Holiday customer, please specify his name</p>
							<div class="row">
								<div id="frm-titleIntro"  class="col-md-2 form-group">
									<div class="wrap-select">
										<select class="form-control" name="titleIntro" id="titleIntro">
											<option value="">Title</option>
											<option value="Mr.">Mr.</option>
											<option value="Mrs.">Mrs.</option>
											<option value="Ms.">Ms.</option>
										</select>
									</div>
								</div>
								<div id="frm-firstNameIntro" class="col-md-5 form-group">
									<input type="text" class="form-control" name="firstNameIntro" id="firstNameIntro" placeholder="First name">
								</div>
								<div id="frm-lastNameIntro" class="col-md-5 form-group">
									<input type="text" class="form-control" name="lastNameIntro" id="lastNameIntro" placeholder="Last name">
								</div>
							</div>
						</div>
						<div class="g-recaptcha" data-sitekey="6LdNwNEUAAAAAAw5m1Nu-Ua9t5YZOe0BYU_womGv" ></div>
						<h3 class="text-center ">Good to go ?</h3>
						<div class="text-center wrap-btn"><button type="submit" class="btn-page-2"><i class="fa fa-paper-plane" aria-hidden="true"></i>Send</button></div>
						<p class="text-center">By submitting this form, you agree to our privacy policy.<a href="#">Find out more</a> </p>
					</form>
					<script src='https://www.google.com/recaptcha/api.js'></script>
					</div>
			    </div>
			</div>
		</div>
	</div>
</div>
@stop