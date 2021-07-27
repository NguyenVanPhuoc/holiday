@extends('backend.layout.index')
@section('title','Add tour')
@section('content')
<div id="create-tour" class="page tour-page route">
	<div class="head">
		<a href="{{route('tourAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All tours</a>
		<h1 class="title">Add tour</h1>		
	</div>	
	<div class="main">
		<form action="{{route('createTourAdmin')}}" class="frm-menu dev-form frm-nvp" method="POST" name="create_tour" role="form">
			{!!csrf_field()!!}
			
			<div class="row">
				<div class="col-md-10 content">
					<div id="frm-title" class="form-group">
						<label for="title">Tour title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input tour title" class="frm-input">
					</div>
					<div id="frm-title-tag" class="form-group">
						<label for="title_tag">Title tag (SEO title) 65-70 characters</label>
						<span class="count-characters"></span>
						<input type="text" name="title_tag" class="form-control" placeholder="Title tag (SEO title) 65-70 characters" class="frm-input">
					</div>
					<div id="frm-metaKey" class="form-group">
						<label for="metakey">Keyword (SEO)</label>
						<input type="text" name="metakey" class="form-control" placeholder="Input keyword (SEO)" class="frm-input">
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="metaValue">Meta Description (SEO) 150-160 characters</label>
						<span class="count-characters"></span>
						<textarea name="metaValue" placeholder="Input meta description (SEO) 150-160 characters" class="form-control"></textarea>
					</div>
					<div id="frm-content" class="form-group">
						<label for="content">Content</label>
						<textarea name="content" id="editor"></textarea>
					</div>
					<div id="frm-desc-price" class="form-group">
						<label for="desc_price">Description Price</label>
						<textarea name="desc_price" id="desc_price"></textarea>
					</div>
					<div id="frm-must-see-2" class="form-group frm-must-see">
						<label for="must_see_2">VARIOUS ACTIVITIES ON SITES</label>
						<textarea name="must_see_2" id="must_see_2"></textarea>
					</div>
					<div id="frm-must-see-1" class="form-group frm-must-see">
						<label for="must_see_1">UNFORGETTABLE MOMENT</label>
						<textarea name="must_see_1" id="must_see_1"></textarea>
					</div>
					<div id="frm-must-see-3" class="form-group frm-must-see">
						<label for="must_see_3">NATURE EXPLORATION</label>
						<textarea name="must_see_3" id="must_see_3"></textarea>
					</div>
					<div id="frm-must-see-4" class="form-group frm-must-see">
						<label for="must_see_4">CULTURE EXPERIENCE</label>
						<textarea name="must_see_4" id="must_see_4"></textarea>
					</div>
					<div id="frm-map" class="form-group">
						<label for="map">Map</label>
						<textarea name="map" id="map" class="form-control" rows="5"></textarea>
					</div>
					<!-- <div id="frm-itinerary" class="form-group">
						<label for="itinerary">Itinerary</label>
						<textarea name="itinerary" id="itinerary" class="form-control" rows="5"></textarea>
					</div> -->
					<div id="frm-itinerary" class="form-group">
						<label for="itinerary">Itinerary</label>
						<select multiple="multiple" class="select2" class="form-control">
							@foreach($list_highlight as $item)
								<option value="{{ $item->id }}">{{ $item->country->title }}</option>
							@endforeach
						</select>
					</div>
					<div id="frm-gallery" class="form-group img-upload">
						<label for="itinerary">Gallery</label>
						<div class="wrap-gallery">
							
						</div>
						<div class="bot-wrap">
							<a href="{{ route('loadMedia') }}" class="btn btn-default library-gallery">Add to gallery</a>
							<input type="hidden" name="gallery" class="thumb-media" value="">
						</div>
					</div>
					<div id="frm-things-to-do" class="form-group">
						<label>Things to do</label>
						<select multiple="multiple" class="select2" class="form-control">
							@foreach($list_thingToDo as $item)
								<option value="{{ $item->id }}">{{ $item->title }}</option>
							@endforeach
						</select>
					</div>
					<div id="frm-schedule" class="form-group">
						<label for="itinerary">Schedule</label>
						<table class="table-days field row-style">
							<tbody class="sortable" data-action="{{ route('positionDaysTour') }}"></tbody>
						</table>
						<a href="#" class="btn btn-default add-chedule">Add row</a>
					</div>	

					
									
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<section id="frm-code" class="box-wrap">
							<h2 class="title">Code tour</h2>
							<input type="text" name="code" class="form-control" placeholder="Input code" class="frm-input">
						</section>
						<section id="frm-price" class="box-wrap">
							<h2 class="title">Price ($)</h2>
							<input type="number" name="price" class="form-control" placeholder="Input price" class="frm-input">
						</section>
						<section id="sb-country" class="box-wrap">
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
	                            @if($categories)
	                                <ul class="no-list-style list-item">
	                                    @foreach($categories as $item)
	                                    <li class="radio radio-success">
	                                    	<input value="{{$item->id}}" type="radio" name="categories[]" id="cat-{{$item->id}}">
	                                    	<label for="cat-{{$item->id}}">{{$item->title}}</label>
	                                    </li>
	                                    @endforeach
	                                </ul>
	                            @endif
							</div>
						</section>
						@endif

						<!-- @php $durations = get_list_duration(); @endphp
						@if(!$durations->isEmpty())
						<section id="sb-duration" class="box-wrap">
							<h2 class="title">Duration</h2>
							<div class="desc list">
								<div class="dropdown vs-drop">
	                            <a class="dropdown-toggle" href="#" role="button" id="dropdown-duration" data-toggle="dropdown">Duration</a>
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
						@endif -->
						<section id="sb-duration" class="box-wrap">
							<h2 class="title">Duration</h2>
							<input type="number" name="number" class="form-control" class="sb-duration" placeholder="Enter the duration">
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
						<section id="sb-image-pdf" class="box-wrap">
							<h2 class="title">Image PDF</h2>
							<div id="frm-image-pdf" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Ảnh đại diện')!!}
									<input type="hidden" name="image_pdf" class="thumb-media" value="" />
								</div>
							</div>
						</section>
						<!-- <section id="sb-pdf" class="box-wrap">
							<h2 class="title">PDF</h2>
							<div id="frm-pdf" class="img-upload">
								<a href="{{ route('loadMedia') }}" class="btn library">Add file</a>
								<input type="hidden" name="pdf" class="thumb-media" value="" />
							</div>
						</section> -->
						<section id="sb-image-personalize" class="box-wrap">
							<h2 class="title">Background Personalize</h2>
							<div id="frm-image-personalize" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Ảnh đại diện')!!}
									<input type="hidden" name="image_personalize" class="thumb-media" value="" />
								</div>
							</div>
						</section>
						<section id="sb-image-request" class="box-wrap">
							<h2 class="title">Background Request</h2>
							<div id="frm-image-request" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Ảnh đại diện')!!}
									<input type="hidden" name="image_request" class="thumb-media" value="" />
								</div>
							</div>
						</section>
					</div>
					<div class="group-fixed">
						<section id="sb-action">
							<div class="group-action">
								<button type="submit" name="submit" class="btn">Save</button>
								<a href="{{route('tourAdmin')}}" class="btn btn-cancel">Cancel</a>									
							</div>
						</section>
					</div>
				</div>
				<!-- <div class="col-md-10">
					<div class="group-action">
						<button type="submit" name="submit" class="btn">Lưu</button>
						<a href="{{route('tourAdmin')}}" class="btn btn-cancel">Hủy</a>									
					</div>
				</div> -->
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

	jQuery(document).ready(function($){
		$("#create-tour").on('click','form .group-action button[type=submit]',function(e){
			e.preventDefault();
			var _token = $("form input[name='_token']").val();
	       	var title = $("form #frm-title input").val();
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
       		//get schedule
       		var array_schedule = new Array();
       		$count = 1;
       		$('#frm-schedule table tr.add').each(function(){
       			var array_temp = {};
       			var array_meal = new Array();
       			var array_sch_gallery = $(this).find('.bot-wrap .thumb-media').val(); 
       			//var name_brief = $(this).find('.sch-brief textarea').attr('name');
       			var name_content = $(this).find('.sch-content textarea').attr('id');
       			var name_notes = $(this).find('.sch-notes textarea').attr('id'); 
       			var array_icon = new Array(); 
       			array_temp.gallery = array_sch_gallery;
       			array_temp.position = $count;
       			//array_temp.brief = CKEDITOR.instances[name_brief].getData(); 
       			array_temp.notes = CKEDITOR.instances[name_notes].getData();
       			array_temp.content = CKEDITOR.instances[name_content].getData(); 
	       		$(this).find('.sch-meal input[name="meal[]"]:checked').each(function(){
	       			array_meal.push($(this).val());
	       		});
	       		array_temp.meal = array_meal; 

	       		//array icon
	       		/*$(this).find('.sch-icon .cat-icons').each(function(){
	       			var ob_icon = {};
	       			var array_icon_cat = new Array();
	       			ob_icon.cat_id = $(this).attr('data-id');
	       			$(this).find('ul input:checked').each(function(){
	       				array_icon_cat.push($(this).val());
	       			});
	       			ob_icon.list_icon = array_icon_cat;
	       			array_icon.push(ob_icon);
	       		});*/
	       		$(this).find('.sch-icon input[name="icon[]"]:checked').each(function(){
       				array_icon.push($(this).val());
       			});

	       		array_temp.icon = array_icon; 

       			array_schedule.push(array_temp);
       			$count++;
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
	       	if(title=="")
	       		errors.push("Please input title");
	       	if(array_country.length == 0)
	       		errors.push("Please select country");
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
					url:'{{ route("createTourAdmin") }}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
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
						'code': code,
						'array_country': array_country,
						'array_cat': array_cat,
						'array_thingsToDo' : array_thingsToDo,
						'array_highlightID' : array_highlightID,
					},
				}).done(function(data) {
					$('#overlay').hide();
	       			$('.loading').hide();
					if(data=="success"){
						categories = [];
				       	errors = [];
				       	error_count = 0;				       					       	
						new PNotify({
							title: 'Successfully',
							text: 'Add to success.',
							type: 'success',
							hide: true,
							delay: 2000,
						});
						location.reload();						
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
	});
		
</script>
@stop