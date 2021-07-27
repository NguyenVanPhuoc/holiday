@extends('templates.master')
@section('title','Setup phone call')
@section('content')
<div id="setupCallPhone-page" class="page form-page bg-gray" >
    <div class="image-header" style="background-image: url('{{asset('public/images/temp/set_up_phone_call.jpg')}}');">
        <div class="wrap bottom">
            <div class="container">
                <img src="{{asset('public/images/temp/icons/set_up_phone_call.png')}}" alt="Create My Trip">
                <h1 class="title-banner">Set up a phone call</h1>
            </div>
        </div>
    </div>
	<div class="container">
		<div class="form">
			<div class="box">
					<div class="desc text-center">
						<p>Would like us to call you at a specific time ?</p>
						<p>We are in tune with you, just let us know by filling the form below and our <br/> customer care agent will be availabe to inform you</p>
					</div>	
				<form id="setupCallPhone-frm" autocomplete="off" action="#" method="POST" data-toggle="validator" role="form" name="contact" class="dev-form frm-setupCallPhone">
					{{csrf_field()}}
					<input type="hidden" autocomplete="false" name="url-frm" value="{{route('updateSetupCallPhone')}}">
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
						<div id="frm-phone" class="form-group col-md-6 has-feedback">
							<label for="areaCode" class="control-label">Phone number</label>
							<div class="input-group">
								<div class="input-group-btn">
									<div class="wrap-select">
										<select class="form-control" name="areaCode" id="areaCode" required>
											{!!option_country_code()!!}
										</select>
									</div>
								</div>
								<input type="text" class="form-control" name="numberPhone" id="numberPhone" data-error="Not a valid number phone!" required>
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
						<div id="frm-country" class="form-group col-md-6">
							<label for="country" class="control-label">Country</label>
							<div class="wrap-select">
								<select name="country" id="country" class="form-control chose-country" data-error="Not a valid country" required>
									{!!option_country_ncode()!!}
								</select>
							</div>
						</div>                    
					</div>
                    <h4 class="desc-contact text-center">Set up a phone call</h4>
                    <div class="row">
                        <div id="frm-appointmentDate" class="form-group col-md-6 has-feedback">
                            <label for="appointmentDate" class="control-label">Appointment date</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" name="appointmentDate" id="appointmentDate" required>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div id="frm-timeZone" class="form-group col-md-6">
                            <label for="timeZone" class="control-label">Appointment time zone</label>
                            <div class="wrap-select">
                                <select name="timeZone" id="timeZone" class="form-control">
                                    {!!option_timezone()!!}
                                </select>
                            </div>
                        </div>								
                    </div>
                    <div id="frm-timeSlot" class="form-group">
                        <label>Appointment time slot</label>
                        <p>Select below the most convenient time (your local time) for us to call you. It is possible to choose multiple time slots.</p>
                        <div class="row custom-checkbox">
                            <div class="col-md-3 item">
                                <label><input type="checkbox" name="timeSlot[]" id="timeSlot" class="form-control" value="8-9 AM"><span>8-9 AM</span></label>	
                            </div>
                            <div class="col-md-3 item">
                                <label><input type="checkbox" name="timeSlot[]" id="timeSlot" class="form-control" value="9-10 AM"><span>9-10 AM</span></label>	
                            </div>
                            <div class="col-md-3 item">
                                <label><input type="checkbox" name="timeSlot[]" id="timeSlot" class="form-control" value="10-11 AM"><span>10-11 AM</span></label>	
                            </div>
                            <div class="col-md-3 item">
                                <label><input type="checkbox" name="timeSlot[]" id="timeSlot" class="form-control" value="11 AM-12 PM"><span>11 AM-12 PM</span></label>	
                            </div>
                            <div class="col-md-3 item">
                                <label><input type="checkbox" name="timeSlot[]" id="timeSlot" class="form-control" value="12-1 PM"><span>12-1 PM</span></label>	
                            </div>
                            <div class="col-md-3 item">
                                <label><input type="checkbox" name="timeSlot[]" id="timeSlot" class="form-control" value="1-2 PM"><span>1-2 PM</span></label>	
                            </div>
                            <div class="col-md-3 item">
                                <label><input type="checkbox" name="timeSlot[]" id="timeSlot" class="form-control" value="2-3 PM"><span>2-3 PM</span></label>	
                            </div>
                            <div class="col-md-3 item">
                                <label><input type="checkbox" name="timeSlot[]" id="timeSlot" class="form-control" value="3-4 PM"><span>3-4 PM</span></label>	
                            </div>
                            <div class="col-md-3 item">
                                <label><input type="checkbox" name="timeSlot[]" id="timeSlot" class="form-control" value="4-5 PM"><span>4-5 PM</span></label>	
                            </div>
                            <div class="col-md-3 item">
                                <label><input type="checkbox" name="timeSlot[]" id="timeSlot" class="form-control" value="5-6 PM"><span>5-6 PM</span></label>	
                            </div>
                        </div>
                    </div>
					<div id="frm-mobileApp" class="form-group">
                        <label><span>Preferred channel to reach you</span><span> - Optional</span></label>
                        <p><?php echo __('If you prefer us to call you through a mobile app instead of the phone network, please select it below.'); ?></p>
                        <ul class="row socials m-app list-inline">
                            <li class="col-md-4">
                                <label>
                                    <input type="checkbox" name="mobileApp[]" id="whatsapp" value="Whatsapp">
                                    <span><img src="{{asset('public/images/temp/icons/whatsapp-logo.png')}}" alt=""></span>
                                </label>
                                <input type="text" name="whatsapp_id" class="form-control hide" placeholder="Your WhatsApps Number">
                                <span class="app-name hide">WhatsApps</span>															
                            </li>
                            <li class="col-md-4">
                                <label>
                                    <input type="checkbox" name="mobileApp[]" id="messenger" value="Facebook">
                                    <span><img src="{{asset('public/images/temp/icons/messenger.png')}}" alt=""></span>
                                </label>
                                <input type="text" name="facebook_id" class="form-control hide" placeholder="Your Facebook Name">
                                <span class="app-name hide">Facebook Messenger</span>
                            </li>									
                            <li class="col-md-4">
                                <label>
                                    <input type="checkbox" name="mobileApp[]" id="skype" value="Skype">
                                    <span><img src="{{asset('public/images/temp/icons/skype-logo.png')}}" alt=""></span>				
                                </label>
                                <input type="text" name="skype_id" class="form-control hide" placeholder="Your Skype Name">
                                <span class="app-name hide">Skype</span>
                            </li>							
                        </ul>
                    </div>
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
					</div>
				</form>
				<script src='https://www.google.com/recaptcha/api.js'></script>
			</div>
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