@extends('backend.layout.index')
@section('title','Add Accommodation')
@section('content')
@php
	$countries = getCountryLevel1();
	$stars = getListStarRatings();
	$locations = getListLocationHotels();
	$specials = getListSpecialHotels();
	$attractions = getListAttraction();
@endphp
<div id="create-hotel" class="page route">
	<div class="head">
		<a href="{{route('hotelsAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All accommodation</a>
		<h1 class="title">Add Accommodation</h1>		
	</div>
	<div class="main">
		<form action="{{ route('createHotelAdmin') }}" method="post" class="dev-form create-hotel activity-form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div class="form-group" id="frm-title">
						<label for="title">Title<small>(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" />
					</div>
					<div id="frm-title-tag" class="form-group">
						<label for="title_tag">Title tag (SEO title) 65-70 characters</label>
						<span class="count-characters"></span>
						<input type="text" name="title_tag" class="form-control" placeholder="Title tag (SEO title) 65-70 characters" class="frm-input">
					</div>
					<div id="frm-metaKey" class="form-group">
						<label for="metakey">Keyword (SEO)</label>
						<input type="text" name="meta_key" class="form-control" placeholder="Input keyword (SEO)" class="frm-input">
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="metaValue">Meta Description (SEO) 150-160 characters</label>
						<span class="count-characters"></span>
						<textarea name="meta_value" placeholder="Input meta description (SEO) 150-160 characters" class="form-control"></textarea>
					</div>
					<div id="frm-desc" class="form-group">
						<label for="content">Description</label>
						<textarea name="desc" id="editor"></textarea>
					</div>
					<div id="frm-map" class="form-group">
						<label>Map</label>
						<textarea name="map" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<label>Tripadvisor Code</label>
						<textarea name="tripadvisor_code" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<label>Tripadvisor Link</label>
						<input type="text" name="tripadvisor_link" class="form-control" />
					</div>
					<div class="form-group">
						<label>Website Link</label>
						<input type="text" name="website_link" class="form-control" />
					</div>
					
					<div id="frm-gallery" class="form-group img-upload">
						<label for="content">Gallery</label>
						<div class="wrap-gallery"></div>
						<div class="bot-wrap">
							<a href="{{ route('loadMedia') }}" class="btn btn-default library-gallery">Add to gallery</a>
							<input type="hidden" name="gallery" class="thumb-media" value="">
						</div>
					</div>
					<div id="frm-facility" class="form-group">
						<label>Facilities</label>
						<select multiple class="select2" name="facilities[]">
							@foreach($list_facility as $fa)
								<option value="{{ $fa->id }}">{{ $fa->title }}</option>
							@endforeach
						</select>
					</div>
					<div id="frm-nearby" class="form-group table-sortable">
						<input type="hidden" class="string-value" name="list_add_nearby" value="">
						<label for="content">Attraction nearby</label>
						<table class="field row-style">
							<tbody class="sortable"></tbody>
						</table>
						<a href="javascript:void(0)" class="btn add-row">Add row</a>
						<div class="data-box">
							<div class="attraction field-row">
								<div class="row-left"><label>Attraction</label></div>
								<div class="row-right">
									<select class="select2-append form-control">
										<option value="">Attraction</option>
										@foreach($list_attraction as $attraction)
											<option value="{{ $attraction->id }}">{{ $attraction->title }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="distance field-row">
								<div class="row-left"><label>Distance (km)</label></div>
								<div class="row-right">
									<input type="number" step="0.1" name="sch-title-1" class="form-control">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<section id="sb-country" class="box-wrap">
							<h2 class="title">Country</h2>
							<div class="desc list">
	                            <ul class="no-list-style list-item scrollbar-inner">
	                                {!! getListCheckCountry(0, 0) !!}
	                            </ul>						
							</div>		
						</section>

						<section id="frm-star-rating" class="box-wrap">
							<h2 class="title">Star rating</h2>
							<select name="star_rating_id">
								<option value="">--Star rating--</option>
								@foreach ($stars as $item)
	                        		<option value="{{$item->id}}">{{$item->title}}</option>
	                        	@endforeach
							</select>
						</section>

						<section id="frm-location" class="box-wrap">
							<h2 class="title">Location</h2>
	                        <select name="location_id">
								<option value="">--Location--</option>
								@foreach ($locations as $item)
	                        		<option value="{{$item->id}}">{{$item->title}}</option>
	                        	@endforeach
							</select>
						</section>

						<section id="frm-special" class="box-wrap">
							<h2 class="title">Special</h2>
							<div class="desc list">
	                            <ul class="no-list-style list-item scrollbar-inner">
	                            	@foreach($specials as $item)
		                                <li class="checkbox checkbox-success">
		                                	<input value="{{ $item->id }}" type="checkbox" name="special[]" id="special-{{ $item->id }}">
											<label for="special-{{ $item->id }}">{{ $item->title }}</label>
										</li>
									@endforeach
	                            </ul>						
							</div>		
						</section>

						<section id="sb-image" class="box-wrap">
							<h2 class="title">Featured Image</h2>
							<div id="frm-image" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Ảnh đại diện')!!}
									<input type="hidden" name="image" class="thumb-media" value="" />
								</div>
							</div>
						</section>
					</div>
					<div class="group-fixed">
						<section id="sb-action">
							<div class="group-action">
								<button type="submit" name="submit" class="btn">Save</button>
								<a href="#" class="btn btn-cancel">Cancel</a>									
							</div>
						</section>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">
	ckeditor("editor");
	/*$(function() {
       $("#create-hotel").on('click','form .group-action button',function(){
	       	var _token = $("form input[name='_token']").val();
	       	var title = $("#frm-title input").val();
	       	var title_tag = $("form #frm-title-tag input").val();
	       	var desc = CKEDITOR.instances['editor'].getData();
	       	var image = $("#frm-image input").val();
	       	var map = $('#frm-map textarea').val();
	       	var gallery = $('#frm-gallery input[name=gallery]').val();
	       	var metaKey = $("#frm-metaKey input").val();
	       	var metaValue = $("#frm-metaValue textarea").val();
	       	var star_rating = $('#frm-star-rating a.dropdown-toggle').attr('data-value');
	       	var location = $('#frm-location a.dropdown-toggle').attr('data-value');
	       	var array_facility_id = $('#frm-facility select').val();
	       	var countries = new Array();
	       	var specials = new Array();
	       	var nearby = new Array();
	       	var errors = new Array();
	       	var error_count = 0;

	       	$("#sb-country .list-item li").each(function(){
	       		if($(this).find("input").is(':checked')){
	       			countries.push($(this).find("input").val());
	       		}
	       	});

	       	$("#frm-special .list-item li").each(function(){
	       		if($(this).find("input").is(':checked')){
	       			specials.push($(this).find("input").val());
	       		}
	       	});

	       	$('#frm-nearby tbody tr').each(function(){
	       		var ob = {};
	       		ob.attraction = $(this).find('.attraction select').val();
	       		ob.distance = $(this).find('.distance input').val();
	       		nearby.push(ob);
	       	}); 

	       	if(title==""){
	       		errors.push("Please input title");
	       	}
	       	var i;
	   		var html = "<ul>";
	       	for(i = 0; i < errors.length; i++){
	       		if(errors[i] != ""){
	       			html +='<li>'+errors[i]+'</li>';
	       			error_count += 1;
	       		}
	       	}   
	       	html += "</ul>";
	       	if(error_count>0){
		       	new PNotify({
					title: 'Error ('+error_count+')',
					text: html,						    
					hide: true,
					delay: 6000,
				});
	       	}else{
	       		$('#overlay').show();
	       		$('.loading').show();
				$.ajax({
					type:'POST',            
					url:'{{ route("createHotelAdmin") }}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
						'title_tag': title_tag,
						'desc': desc,
						'map': map,
						'gallery': gallery,
						'metaKey': metaKey,
						'metaValue': metaValue,
						'image': image,
						'countries': countries,
						'specials': specials,
						'star_rating': star_rating,
						'location': location,
						'nearby': JSON.stringify(nearby),
						'list_facility': array_facility_id.toString()
					},
				}).done(function(data) { 
					$('#overlay').hide();
	       			$('.loading').hide();
					if(data=="success"){				       					       	
						new PNotify({
							title: 'Successfully',
							text: 'Add to success.',
							type: 'success',
							hide: true,
							delay: 2000,
						});	
						window.location.reload(true);				
					}else{
						new PNotify({
							title: 'Error',
							text: 'The system is busy. Please try again. ',					    
							hide: true,
							delay: 2000,
						});
					}	           		
				});
			}       	
       	return false;
       });
   	});	*/
</script>
@stop