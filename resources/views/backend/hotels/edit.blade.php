@extends('backend.layout.index')
@section('title','Edit Accommodation')
@section('content')
@php
	$countries = getCountryLevel1();
	$stars = getListStarRatings();
	$locations = getListLocationHotels();
	$specials = getListSpecialHotels();
	$attractions = getListAttraction();

	$seo = get_seo($hotel->id,'hotel');
	if($seo){ 
		$meta_key = $seo->key; 
		$meta_value = $seo->value;
	}else{
		$meta_key = "";
		$meta_value = "";
	}
	$gallery = json_decode($hotel->gallery);
	$array_facility_id = ($hotel->facilities != '') ? explode(",", $hotel->facilities) : [];
	$nearbys = getListNearByHotel($hotel->id); 

@endphp
<div id="edit-hotel" class="page route">
	<div class="head">
		<a href="{{route('hotelsAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All accommodation</a>
		<h1 class="title">Edit Accommodation</h1>		
	</div>
	<div class="main">
		<form action="{{ route('updateHotelAdmin', $hotel->slug) }}" method="post" class="dev-form activity-form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div class="form-group" id="frm-title">
						<label for="title">Title<small>(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" value="{{$hotel->title}}" />
					</div>
					<div id="frm-title-tag" class="form-group">
							<label for="title_tag">Title tag (SEO title) 65-70 characters</label>
						<span class="count-characters">( {{strlen($hotel->title_tag)}} characters )</span>
						<input type="text" name="title_tag" class="form-control" placeholder="Title tag (SEO title) 65-70 characters" class="frm-input" value="{{$hotel->title_tag}}" >
					</div>
					<div id="frm-metaKey" class="form-group">
						<label for="metakey">Keyword (SEO)</label>
						<input type="text" name="meta_key" class="form-control" placeholder="Input keyword (SEO)" class="frm-input" value="{{$meta_key}}" >
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="metaValue">Meta Description (SEO) 150-160 characters</label>
						<span class="count-characters">( {{strlen($meta_value)}} characters )</span>
						<textarea name="meta_value" placeholder="Input meta description (SEO) 150-160 characters" class="form-control">{{$meta_value}}</textarea>
					</div>
					<div id="frm-desc" class="form-group">
						<label for="content">Description</label>
						<textarea name="desc" id="editor">{!! $hotel->desc !!}</textarea>
					</div>
					<div id="frm-map" class="form-group">
						<label>Map</label>
						<textarea name="map" class="form-control">{{ $hotel->map }}</textarea>
					</div>
					<div class="form-group">
						<label>Tripadvisor Code</label>
						<textarea name="tripadvisor_code" class="form-control">{{ $hotel->tripadvisor_code }}</textarea>
					</div>
					<div class="form-group">
						<label>Tripadvisor Link</label>
						<input type="text" name="tripadvisor_link" class="form-control" value="{{ $hotel->tripadvisor_link }}" />
					</div>
					<div class="form-group">
						<label>Website Link</label>
						<input type="text" name="website_link" class="form-control" value="{{ $hotel->website_link }}" />
					</div>
					<div id="frm-gallery" class="form-group img-upload">
						<label for="content">Gallery</label>
						<div class="wrap-gallery">
							@if($gallery)
								@foreach($gallery as $value)
									@php $image = getMedia($value); @endphp
									<div class="gallery-item item-{{$value}}" data-id="{{$value}}" >
										<div class="wrap-item">
											{!! imageAuto($value, $hotel->title) !!}
											<span class="remove-gallery">x</span>
										</div>
									</div>
								@endforeach
							@endif
						</div>
						<div class="bot-wrap">
							<a href="{{ route('loadMedia') }}" class="btn btn-default library-gallery">Add to gallery</a>
							<input type="hidden" name="gallery" class="thumb-media" value="{{ $hotel->gallery }}">
						</div>
					</div>
					<div id="frm-facility" class="form-group">
						<label>Facilities</label>
						<select multiple class="select2" data-order="{{ $hotel->facilities }}" name="facilities[]">
							@foreach($list_facility as $fa)
								<option value="{{ $fa->id }}" @if(in_array($fa->id, $array_facility_id)) selected @endif>{{ $fa->title }}</option>
							@endforeach
						</select>
					</div>
					<div id="frm-nearby" class="form-group table-sortable">
						<input type="hidden" class="string-value" name="list_add_nearby" value="">
						<input type="hidden" class="string-value" name="list_edit_nearby" value="">
						<label for="content">Attraction nearby</label>
						<table class="field row-style">
							<tbody class="sortable">
								
								@if($nearbys)
									@foreach($nearbys as $key => $item)
										@php
											$attraction = getAttactionByID($item->attraction_id);
										@endphp
										
										<tr class="edit" data-id="{{$item->id}}" data-position="{{$item->position}}">
											<td>{{$key+1}}</td>
											<td>
												<div class="attraction field-row">
													<div class="row-left"><label>Attraction</label></div>
													<div class="row-right">
														<select class="select2 form-control">
															<option value="">Attraction</option>
															@foreach($attractions as $attr)
																<option value="{{ $attr->id }}" @if($attr->id == $item->attraction_id) selected @endif>
																	{{ $attr->title }}
																</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="distance field-row">
													<div class="row-left"><label>Distance (km)</label></div>
													<div class="row-right">
														<input type="text" step="0.1" name="sch-title-1" class="form-control" value="{{$item->distance}}" />
													</div>
												</div>
											</td>
											<td class="delete text-center">
												<div class="del-tooltip">
													<a href="#" class="remove-row"><span>─</span></a>
													<div class="tooltip">
														<div class="wrap">Bạn đồng ý xóa?
															<div id="d-yes"><a href="{{ route('deleteAttractionHotel') }}" class="yes">Yes</a></div>
															<div id="d-no"><a href="#" class="no">Cancel</a></div>
														</div>
													</div>
												</div>
											</td>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>
						<a href="javascript:void(0)" class="btn add-row">Add row</a>
						<div class="data-box">
							<div class="attraction field-row">
								<div class="row-left"><label>Attraction</label></div>
								<div class="row-right">
									<select class="select2-append form-control">
										<option value="">Attraction</option>
										@foreach($attractions as $attr)
											<option value="{{ $attr->id }}">
												{{ $attr->title }}
											</option>
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
							<input type="hidden" name="countries_active" value="{{getListIDCountryHotel($hotel->id)}}" />
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
	                        		<option value="{{$item->id}}" @if($item->id == $hotel->star_rating_id) selected @endif >{{$item->title}}</option>
	                        	@endforeach
							</select>
						</section>

						<section id="frm-location" class="box-wrap">
							<h2 class="title">Location</h2>
	                        <select name="location_id">
								<option value="">--Location--</option>
								@foreach ($locations as $item)
	                        		<option value="{{$item->id}}" @if($item->id == $hotel->location_id) selected @endif>{{$item->title}}</option>
	                        	@endforeach
							</select>
						</section>

						<section id="frm-special" class="box-wrap">
							<h2 class="title">Special</h2>
							@php 
								$special_active = explode(',',$hotel->special_id);
							@endphp
							<div class="desc list">
	                            <ul class="no-list-style list-item scrollbar-inner">
	                            	@foreach($specials as $item)
	                            		@if($special_active)
                                    		@php if(in_array($item->id, $special_active)) $check = 'checked'; else $check = '';  @endphp
                                    	@endif
		                                <li class="checkbox checkbox-success">
		                                	<input value="{{ $item->id }}" type="checkbox" name="special[]" id="special-{{ $item->id }}" {{$check}} />
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
									{!!image($hotel->image, 150,150, $hotel->title)!!}
									<input type="hidden" name="image" class="thumb-media" value="{{$hotel->image}}" />
								</div>
							</div>
						</section>
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($hotel->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($hotel->updated_at)) }}</li>
							</ul>
						</section>
					</div>
					<div class="group-fixed">
						<section id="sb-action">
							<div class="group-action">
								<a href="{{ route('deleteHotelAdmin',['slug'=>$hotel->id]) }}" class="btn btn-delete">Delete</a>
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
       $("#edit-hotel").on('click','form .group-action button',function(){
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
	       		var action = 'action';
	       		var id = $(this).attr('data-id');
	       		var position = $(this).attr('data-position');
	       		if($(this).hasClass('edit')) action = 'edit';
	       		ob.attraction = $(this).find('.attraction select').val();
	       		ob.distance = $(this).find('.distance input').val();
	       		ob.action = action;
	       		ob.position = position;
	       		if(id != undefined) ob.id = id;
	       		nearby.push(ob);
	       	}); console.log(nearby);

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
					url:'{{ route("updateHotelAdmin", ["slug"=>$hotel->slug]) }}',
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
					if(data.msg=="success"){				       					       	
						new PNotify({
							title: 'Successfully',
							text: 'Update to success.',
							type: 'success',
							hide: true,
							delay: 2000,
						});	
						window.location.href = data.redirect;				
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