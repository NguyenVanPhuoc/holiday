@extends('backend.layout.index')
@section('title','Edit tour')
@section('content')
@php 
	if($seo){ 
		$meta_key = $seo->key; 
		$meta_value = $seo->value;
	}else{
		$meta_key = "";
		$meta_value = "";
	}
	$slug_country = get_slug_country_of_tour($tour->id);
	$catIconSchedules = getListCatIconSchedule(); 
	//var_dump(toStringCountryTour($tour->id));
@endphp
<div id="edit-tour" class="page tour-page route ">
	<div class="head">
		<a href="{{route('tourAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All</a>
		<h1 class="title">Edit tour</h1>	
		<a href="{{route('tour', ['slug_country'=>$slug_country,'slug'=>$tour->slug])}}" target="_blank" class="view-fast"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View tour</a>		
	</div>	
	<div class="main">
		<form action="{{route('updateTourAdmin', ['slug'=>$tour->slug])}}" class="frm-menu dev-form frm-nvp" method="POST" name="create_tour" role="form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div id="frm-title" class="form-group">
						<label for="title">Tour title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" value="{{$tour->title}}" placeholder="Input tour title" class="frm-input">
					</div>
					<div id="frm-slug" class="form-group">
						<label for="slug">Slug<small class="required">(*)</small></label>
						<div class="wrap">
							<span>{{$tour->slug}}</span>
							<input type="text" name="edit_slug" value="{{$tour->slug}}" class="form-control hide" />
							<a href="#" class="edit-slug">Edit</a>
							<a href="#" class="btn save-slug hide">OK</a>
							<a href="#" class="cancel hide">Cancel</a>
						</div>
					</div>
					<div id="frm-title-tag" class="form-group">
						<label for="title_tag">Title tag (SEO title)</label>
						<span class="count-characters">( {{strlen($tour->title_tag)}} characters )</span>
						<input type="text" name="title_tag" class="form-control"  value="{{$tour->title_tag}}" placeholder="Title tag (SEO title)" class="frm-input">
					</div>

					<div id="frm-metaKey" class="form-group">
						<label for="metakey">Keyword (SEO)</label>
						<input type="text" name="metakey" class="form-control" value="{{$meta_key}}" placeholder="Input keyword (SEO)" class="frm-input">
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="metaValue">Meta Description (SEO)</label>
						<span class="count-characters">( {{strlen($meta_value)}} characters )</span>
						<textarea name="metaValue" placeholder="Input meta description (SEO) 150-160 characters" class="form-control">{{$meta_value}}</textarea>
					</div>	
					<div id="frm-content" class="form-group">
						<label for="content">Content</label>
						<textarea name="content" id="editor">{{$tour->content}}</textarea>
					</div>
					<div id="frm-desc-price" class="form-group">
						<label for="desc_price">Description Price</label>
						<textarea name="desc_price" id="desc_price">{{$tour->desc_price}}</textarea>
					</div>
					<div id="frm-must-see-2" class="form-group frm-must-see">
						<label for="must_see_2">VARIOUS ACTIVITIES ON SITES</label>
						<textarea name="must_see_2" id="must_see_2">{{$tour->must_see_2}}</textarea>
					</div>
					<div id="frm-must-see-1" class="form-group frm-must-see">
						<label for="must_see_1">UNFORGETTABLE MOMENT</label>
						<textarea name="must_see_1" id="must_see_1">{{$tour->must_see_1}}</textarea>
					</div>
					<div id="frm-must-see-3" class="form-group frm-must-see">
						<label for="must_see_3">NATURE EXPLORATION</label>
						<textarea name="must_see_3" id="must_see_3">{{$tour->must_see_3}}</textarea>
					</div>
					<div id="frm-must-see-4" class="form-group frm-must-see">
						<label for="must_see_4">CULTURE EXPERIENCE</label>
						<textarea name="must_see_4" id="must_see_4">{{$tour->must_see_4}}</textarea>
					</div>
					<div id="frm-map" class="form-group">
						<label for="map">Map</label>
						<textarea name="map" id="map" class="form-control" rows="5">{{$tour->map}}</textarea>
					</div>
					<div id="frm-itinerary" class="form-group">
						<label for="itinerary">Itinerary</label>
						<select multiple="multiple" class="select2" class="form-control" data-order="{{ $tour->itinerary }}">
							@foreach($list_highlight as $item)
								<option value="{{ $item->id }}" @if(in_array($item->id, $array_highlightID)) selected @endif>{{ $item->country->title }}</option>
							@endforeach
						</select>
					</div>
					<div id="frm-gallery" class="form-group img-upload">
						<label for="itinerary">Gallery</label>
						<div class="wrap-gallery">
							@php $gallery = json_decode($tour->gallery); @endphp
							@if($gallery)
								@foreach($gallery as $item)
									@php $image = getMedia($item); @endphp
									<div class="gallery-item item-{{$item}}" data-id="{{$item}}" >
										<div class="wrap-item">
											{!! imageAuto($item, $tour->title) !!}
											<span class="remove-gallery">x</span>
										</div>
									</div>
								@endforeach
							@endif
						</div>
						<div class="bot-wrap">
							<a href="{{ route('loadMedia') }}" class="btn btn-default library-gallery">Add to gallery</a>
							<input type="hidden" name="gallery" class="thumb-media" value="{{$tour->gallery}}">
						</div>
					</div>
					
					<div id="frm-things-to-do" class="form-group">
						<label>Things to do</label>
						<select multiple="multiple" class="select2 form-control" data-order="{{ implode(",", $array_thingToDoId) }}">
							@foreach($list_thingToDo as $item)
								<option value="{{ $item->id }}" @if(in_array($item->id, $array_thingToDoId)) selected @endif>{{ $item->title }}</option>
							@endforeach
						</select>
					</div>	
					<div id="frm-schedule" class="form-group">
						<label for="itinerary">Schedule</label>
						@include('backend.tours.table')
						<a href="#" class="btn btn-default add-chedule" data-link="{{ route('loadMedia') }}">Add row</a>
					</div>						
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<section id="frm-code" class="box-wrap">
							<h2 class="title">Code tour</h2>
							<input type="text" name="code" class="form-control" value="{{$tour->code}}" placeholder="Input code" class="frm-input">
						</section>
						<section id="frm-price" class="box-wrap">
							<h2 class="title">Price ($)</h2>
							<input type="number" name="price" class="form-control" value="{{$tour->price}}" placeholder="Input price" class="frm-input">
						</section>
						<section id="sb-country" class="box-wrap">
							<input type="hidden" name="countries_active" value="{{ implode(',', $list_countryid) }}" />
							<h2 class="title">Country</h2>
							<div class="desc list">
	                            <ul class="no-list-style list-item scrollbar-inner">
	                                {!! getListCheckCountry(0, 0) !!}
	                            </ul>						
							</div>		
						</section>
						<?php $categories = get_categories_tour();?>
						@if(!$categories->isEmpty())
						<section id="sb-categories" class="box-wrap">
							<h2 class="title">Tour Style</h2>
							<div class="desc list">
								@php 
									$cat_active = explode(',',$tour->cat_id);
								@endphp
	                            @if($categories)
	                                <ul class="no-list-style list-item">
	                                    @foreach($categories as $item)
											@if($cat_active)
	                                    		@php if(in_array($item->id, $cat_active)) $check = 'checked'; else $check = '';  @endphp
	                                    	@endif
		                                    <li class="radio radio-success">
		                                    	<input value="{{$item->id}}" type="radio" name="categories[]" id="cat-{{$item->id}}" {{$check}} />
		                                    	<label for="cat-{{$item->id}}">{{$item->title}}</label>
		                                    </li>
	                                    @endforeach
	                                </ul>
	                            @endif			
							</div>						
						</section>
						@endif

						{{-- @php $durations = get_list_duration(); @endphp
						@if(!$durations->isEmpty())
						<section id="sb-duration" class="box-wrap">
							<h2 class="title">Duration</h2>
							<div class="desc list">
								<div class="dropdown vs-drop">
									@if($tour->number)
										@php $duration = getDurationById($tour->number); @endphp
										<a class="dropdown-toggle" href="#{{$duration->slug}}" role="button" id="dropdown-duration" data-toggle="dropdown" data-value="{{$duration->id}}">
											{{$duration->title}}
										</a>
									@else
		                            	<a class="dropdown-toggle" href="#" role="button" id="dropdown-duration" data-toggle="dropdown">Duration</a>
		                            @endif
		                            @if($durations)
		                            <div class="dropdown-menu" aria-labelledby="dropdown-duration">
		                                <ul class="list-item">
		                                    @foreach($durations as $item)
		                                    <li><a href="#{{$item->slug}}" data-value="{{$item->id}}">{{$item->title}}</a></li>
		                                    @endforeach
		                                </ul>
		                            </div>
		                            @endif
		                        </div>							
							</div>						
						</section>
						@endif --}}

						<section id="sb-duration" class="box-wrap">
							<h2 class="title">Duration</h2>
							<input type="number" name="number" class="form-control" class="sb-duration" placeholder="Enter the duration" value="{{$tour->number}}">
						</section>

						<section id="sb-image" class="box-wrap">
							<h2 class="title">Featured Image</h2>
							<div id="frm-image" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($tour->image , 211, 139, $tour->title)!!}
									<input type="hidden" name="image" class="thumb-media" value="{{$tour->image}}" />
								</div>
							</div>
						</section>
						<section id="sb-image-pdf" class="box-wrap">
							<h2 class="title">Image PDF</h2>
							<div id="frm-image-pdf" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($tour->image_pdf , 211, 139, $tour->title)!!}
									<input type="hidden" name="image_pdf" class="thumb-media" value="{{$tour->image_pdf}}" />
								</div>
							</div>
						</section>
						<!-- <section id="sb-pdf" class="box-wrap">
							<h2 class="title">PDF</h2>
							<div id="frm-pdf" class="img-upload">
								@php
									$pdf = getMedia($tour->pdf);
									$value_pdf = '';
									$class = '';
								@endphp
								@if($pdf)
									@php
										$value_pdf = $tour->pdf;
										$class = 'hide';
									@endphp
									<div class="wrap-pdf add">
										<img src="{{asset('/public/admin/images/pdf_icon.png')}}" alt="pdf-icon"/>
										<h5>{{$pdf->image_path}}</h5>
										<span class="remove-file">x</span>
									</div>
								@endif
								<a href="{{ route('loadMedia') }}" class="btn library {{$class}}">Add file</a>
								<input type="hidden" name="pdf" class="thumb-media" value="{{$value_pdf}}" />
							</div>
						</section> -->
						<section id="sb-image-personalize" class="box-wrap">
							<h2 class="title">Background Personalize</h2>
							<div id="frm-image-personalize" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($tour->image_personalize , 211, 139, $tour->title)!!}
									<input type="hidden" name="image_personalize" class="thumb-media" value="{{$tour->image_personalize}}" />
								</div>
							</div>
						</section>
						<section id="sb-image-request" class="box-wrap">
							<h2 class="title">Background Request</h2>
							<div id="frm-image-request" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($tour->image_request , 211, 139, $tour->title)!!}
									<input type="hidden" name="image_request" class="thumb-media" value="{{$tour->image_request}}" />
								</div>
							</div>
						</section>
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($tour->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($tour->updated_at)) }}</li>
							</ul>
						</section>
					</div>
					<div class="group-fixed">
						<div class="group-action">
							<a href="{{ route('deleteTourAdmin',['slug'=>$tour->id]) }}" class="btn btn-delete">Delete</a>
							<button type="submit" name="submit" class="btn">Save</button>
							<a href="{{route('tourAdmin')}}" class="btn btn-cancel">Cancel</a>									
						</div>
					</div>
				</div>
				<div class="col-md-10">
					
				</div>
			</div>			
		</form>				
	</div>
	<div id="wp-data-icon-schedule" class="hidden">
		<div class="sch-icon field-row">
			<div class="row-left"><label>Icons details</label></div>
			<div class="row-right">
				{!! getIconScheduleAdmin() !!}
			</div>
		</div>
	</div>
	@include('backend.media.library')
</div>

<script type="text/javascript">
	ckeditor("editor");
	ckeditor("desc_price");
	ckeditor("must_see_1");
	ckeditor("must_see_2");
	ckeditor("must_see_3");
	ckeditor("must_see_4");

	$('#frm-schedule table tr.edit').each(function(){
		var data_id = $(this).attr('data-id');
		//ckeditor("edit-sch-brief-"+data_id);
		ckeditor("edit-sch-content-"+data_id);
		ckeditor("edit-sch-notes-"+data_id);
	});

	$(function(){
		$("#edit-tour").on('click','form .group-action button[type=submit]',function(e){
			e.preventDefault();
			var _token = $("form input[name='_token']").val();
	       	var title = $("form #frm-title input").val();
	       	var slug = $("form #frm-slug input").val();
	       	var title_tag = $("form #frm-title-tag input").val();
	       	var image = $("#frm-image input").val();
	       	var image_pdf = $("#frm-image-pdf input").val();
	       	var pdf = $("#frm-pdf input").val();
	       	var image_request = $("#frm-image-request input").val();
	       	var image_personalize = $("#frm-image-personalize input").val();
       		var content = CKEDITOR.instances['editor'].getData();
       		var desc_price = CKEDITOR.instances['desc_price'].getData();
       		var metaKey = $("#frm-metaKey input").val();
	       	var metaValue = $("#frm-metaValue textarea").val();
       		var must_see_1 = CKEDITOR.instances['must_see_1'].getData();
       		var must_see_2 = CKEDITOR.instances['must_see_2'].getData();
       		var must_see_3 = CKEDITOR.instances['must_see_3'].getData();
       		var must_see_4 = CKEDITOR.instances['must_see_4'].getData(); 
       		var map = $('#frm-map textarea').val();
       		//var number = $("#sb-duration .dropdown-toggle").attr("data-value");
       		var itinerary = $('#frm-itinerary textarea').val();
       		var price = $('#frm-price input').val();
       		var array_gallery = $('#frm-gallery .thumb-media').val(); 

       		//get schedule (add new)
       		var array_schedule = new Array();
       		$('#frm-schedule table tr.add').each(function(){
       			var array_temp = {};
       			var array_meal = new Array();
       			var array_sch_gallery = $(this).find('.bot-wrap .thumb-media').val(); 
       			//var name_brief = $(this).find('.sch-brief textarea').attr('name');
       			var name_content = $(this).find('.sch-content textarea').attr('id');
       			var name_notes = $(this).find('.sch-notes textarea').attr('id');
       			var position = $(this).attr('data-position');   
       			var array_icon = new Array();
       			console.log(name_content + '    ' + name_notes);
       			array_temp.title = $(this).find('.sch-title input').val();
       			array_temp.position = position;
       			array_temp.gallery = array_sch_gallery;
       			//array_temp.brief = CKEDITOR.instances[name_brief].getData(); 
       			array_temp.content = CKEDITOR.instances[name_content].getData(); 
       			array_temp.notes = CKEDITOR.instances[name_notes].getData(); 
	       		$(this).find('.sch-meal input[name="meal[]"]:checked').each(function(){
	       			array_meal.push($(this).val());
	       		});
	       		array_temp.meal = array_meal;
	       		$(this).find('.sch-icon input[name="icon[]"]:checked').each(function(){
       				array_icon.push($(this).val());
       			});

	       		array_temp.icon = array_icon; 
       			array_schedule.push(array_temp); console.log(array_schedule);
       		});

       		//list edit schedule
       		var array_schedule_edit = new Array();
       		$('#frm-schedule table tr.edit').each(function(){
       			var data_id = $(this).attr('data-id');
       			var array_temp = {};
       			var array_meal = new Array();
       			var array_sch_gallery = $(this).find('.bot-wrap .thumb-media').val(); 
       			//var name_brief = $(this).find('.sch-brief textarea').attr('name');
       			var name_content = $(this).find('.sch-content textarea').attr('id'); 
       			var name_notes = $(this).find('.sch-notes textarea').attr('id'); 
       			var position = $(this).attr('data-position'); 
       			var array_icon = new Array();       		
       			array_temp.id = data_id;
       			array_temp.title = $(this).find('.sch-title input').val();
       			array_temp.position = position;
       			array_temp.gallery = array_sch_gallery;
       			//array_temp.brief = CKEDITOR.instances[name_brief].getData(); 
       			array_temp.notes = CKEDITOR.instances[name_notes].getData();
       			array_temp.content = CKEDITOR.instances[name_content].getData(); 
	       		$(this).find('.sch-meal input[name="meal[]"]:checked').each(function(){
	       			array_meal.push($(this).val());
	       		});
	       		array_temp.meal = array_meal;
	       		//icon
	       		$(this).find('.sch-icon input[name="icon[]"]:checked').each(function(){
       				array_icon.push($(this).val());
       			});

	       		array_temp.icon = array_icon; 
       			array_schedule_edit.push(array_temp);
       		});

       		var code = $('form #frm-code input').val();
       		var number = $('form #sb-duration input').val();
       		var array_country = new Array();
       		$('form #sb-country .list-item li input:checked').each(function(){
       			array_country.push($(this).val());
       		});
       		var array_cat = new Array();
       		$('form #sb-categories .list-item li input:checked').each(function(){
       			array_cat.push($(this).val());
       		});
       		var array_thingsToDo = $('#frm-things-to-do select').val();
       		var array_highlightID = $('#frm-itinerary select').val();

       		var errors = new Array();
	       	var error_count = 0;
	       	if(title==""){
	       		errors[0] = "Please input title";
	       	}
       		var i;
	   		var html = "<ul>";
	       	for(i = 0; i < errors.length; i++){
	       		if(errors[i] != ""){
	       			html +='<li>'+errors[i]+'</li>';
	       			error_count += 1;
	       		}
	       	}   
	       	if(error_count>0){
		       	html += "</ul>";	       	
		       	new PNotify({
					title: 'Error data ('+error_count+')',
					text: html,						    
					hide: true,
					delay: 6000,
				});
	       	}
	       	else{
	       		$('#overlay').show();
	       		$('.loading').show();
	       		$.ajax({
					type:'POST',            
					url:'{{route('updateTourAdmin', ['slug'=>$tour->slug])}}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
						'slug' : slug,
						'title_tag': title_tag,
						'image': image,
						'metaKey': metaKey,
						'metaValue': metaValue,
						'image_pdf': image_pdf,
						'pdf': pdf,
						'image_request': image_request,
						'image_personalize': image_personalize,
						'content': content,
						'desc_price': desc_price,
						'metaKey': metaKey,
						'metaValue': metaValue,
						'must_see_1': must_see_1,
						'must_see_2': must_see_2,
						'must_see_3': must_see_3,
						'must_see_4': must_see_4,
						'map': map,
						'number': number,
						'itinerary': itinerary,
						'price': price,
						'array_gallery': array_gallery,
						'array_schedule': array_schedule,
						'array_schedule_edit' : array_schedule_edit,
						'code': code,
						'array_country': array_country,
						'array_cat': array_cat,
						'array_thingsToDo': array_thingsToDo,
						'array_highlightID' : array_highlightID,
					},
				}).done(function(data) {
					$('#overlay').hide();
	       			$('.loading').hide();
					if(data.status=="success"){
						categories = [];
				       	errors = [];
				       	error_count = 0;				       					       	
						new PNotify({
							title: 'Successfully',
							text: 'Update success.',
							type: 'success',
							hide: true,
							delay: 2000,
						});
						window.location.replace(data.url);							
					}else{
						new PNotify({
							title: 'Error',
							text: 'Browser not support javascript.',						    
							hide: true,
							delay: 2000,
						});
					}	           		
				});
	       	}

		});

		//delete location
      	$(".dev-form .btn-delete").click(function(){
      		var href = $(this).attr("href");
      		(new PNotify({
			    title: 'Delete',
			    text: 'Do you delete?',
			    icon: 'glyphicon glyphicon-question-sign',
			    type: 'error',
			    hide: false,
			    confirm: {
			        confirm: true
			    },
			    buttons: {
			        closer: false,
			        sticker: false
			    },
			    history: {
			        history: false
			    }
			})).get().on('pnotify.confirm', function() {			    
			    window.location.href = href;
			});
			return false;
      	});

      	//delete row shcedule
      	$('table').on('click', 'tr.edit a.remove-row', function(){
      		var id = $(this).parents('tr').attr('data-id');
	   		$(this).addClass('active');
			$(this).parents('td.delete').find('.tooltip').addClass('active');
			$(this).parents('td.delete').find('#d-no').on('click', $(this).parents('.del-tooltip .tooltip.active').find('.no'), function(){
				$(this).parents('.tooltip').removeClass('active');
				$(this).find('a.remove-row').removeClass('active');
				return false;
			});
			$(this).closest('td.delete').find('.yes').click(function(e){
			e.preventDefault();
				var _token = $("form input[name='_token']").val();
				$(this).parents('tr').fadeOut();
				$(this).parents('tr').remove();	
				$.ajax({
					type:'POST',            
					url:'{{route('deleteScheduleTour')}}',
					cache: false,
					data:{
						'_token': _token,
						'id': id,
					},
				}).done(function(data) {
					if(data=="success"){				       					       	
						new PNotify({
							title: 'Successfully',
							text: 'Successfully deleted.',
							type: 'success',
							hide: true,
							delay: 2000,
						});		
						
						$('#frm-schedule table tbody tr').each(function(){
							var number = $(this).index() + 1;
							$(this).find('td.stt').text(number);
						});				
					}else{
						new PNotify({
							title: 'Lỗi',
							text: 'Trình duyệt không hỗ trợ javascript.',						    
							hide: true,
							delay: 2000,
						});
					}	           		
				});
				
				return false;
			});	
			return false;
	    });
	});
		
</script>
@stop