@extends('backend.layout.index')
@section('title','Edit country')
@section('content')
@php
	if($seo){ 
		$meta_key = $seo->key; 
		$meta_value = $seo->value;
	}else{
		$meta_key = "";
		$meta_value = "";
	}
	$parent_id = isset($parent_id)? $parent_id : '';
	$parentTitle  = '-- Choose Parent --';
	if($parent_id != ''){
		if($parent_id == 0) 
			$parentTitle = 'None';
		else
			$parentTitle = getCountryById($parent_id)->title;
	}
	$key = isset($s)? $s:'';
	$level = getLevelCountry($country->id); 
	//$level_city = getAllCountryByLevel(3);
	$arrayEditor = [];
	$discover = json_decode($country->discover); 
	$list_best_time_to_visit = json_decode($country->best_time_to_visit); 
	if($highlight) {
		$gallery = json_decode($highlight->gallery);
		//$slug_country = getslugCountry(getFarthestParentCountry($highlight->country_id))->slug;
		$slug_country = getslugCountry(getFarthestParentCountry($highlight->country_id));
	}else {
		$gallery = false;
		$slug_country = false;
	}
@endphp
<div id="edit-country" class=" page country-page route">
	<div class="head">
		<a href="{{ route('countryAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All country</a>
		<h1 class="title">Edit country</h1>	
		@if($slug_country)
			<a href="{{route('postTypeCountryTravel', ['slug_country'=>$slug_country->slug,'slug'=>$country->slug])}}" target="_blank" class="view-fast"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View city</a>
		@endif
	</div>	
	<div class="main">
		<div class="search-form">
			<form name="s" action="{{route('countryAdmin')}}" method="GET">
				<div class="row">
					<div id="frm-parent" class="col-md-6">
						<select class="form-control select2" name="parent_id">
							<option value="">Choose Parent</option>
							{!! getListOptionParentCountry(0, 0, true) !!}
						</select>	
					</div>
					<div id="frm-keyword" class="col-md-6"><input type="text" name="s" class="form-control" placeholder="Input key word..." value="{{$key}}"></div>
				</div>
				<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
			</form>
		</div>
		<form action="{{route('updateCountryAdmin', $country->slug)}}" class="frm-edit-country dev-form activity-form" method="POST" name="create_country" role="form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div id="frm-title" class="form-group">
						<label for="title">Title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" value="{{$country->title}}" class="frm-input">
					</div>
					<div id="frm-title-tag" class="form-group">
						<label for="title_tag">Title tag (SEO title) 65-70 characters</label>
						<span class="count-characters">( {{strlen($country->title_tag)}} characters )</span>
						<input type="text" name="title_tag" class="form-control" placeholder="Title tag (SEO title) 65-70 characters" value="{{ $country->title_tag }}" class="frm-input">
					</div>
					<div id="frm-metaKey" class="form-group">
						<label for="metakey">Keyword (SEO)</label>
						<input type="text" name="metakey" class="form-control" placeholder="Input keyword (SEO)" value="{{ $meta_key }}" class="frm-input">
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="metaValue">Meta Description (SEO)</label>
						<span class="count-characters">( {{strlen($meta_value)}} characters )</span>
						<textarea name="metaValue" placeholder="Input meta description (SEO) 150-160 characters" class="form-control">{{$meta_value}}</textarea>
					</div>	
					<div id="frm-shortContent" class="form-group">
						<label class="short-content">Description</label>
						<textarea name="desc" placeholder="Input description" class="form-control" id="editor">{{$country->desc}}</textarea>
					</div>
					<div class="form-group">
						<label class="short-content">Short Description</label>
						<textarea name="short_desc" placeholder="Input description" class="form-control">{{ $country->short_desc }}</textarea>
					</div>
					<div id="frm-color" class="form-group">
						<label>Color</label>
						<div id="color" class="input-group colorpicker-component">
						    <input type="text" name="color" value="{{$country->color}}" class="form-control" />
						    <span class="input-group-addon"><i></i></span>
						</div>	
					</div>	
					<div id="frm-map" class="form-group">
						<label>Map</label>
					    <textarea name="map" placeholder="" class="form-control">{{ $country->map }}</textarea>	
					</div>	
				@if($highlight)
					<div id="frm-title-video" class="form-group">
						<label for="title">Title Video</label>
						<input type="text" name="title_video" class="form-control" placeholder="Input title video" class="frm-input" value="{{$highlight->title_video}}" >
					</div>
					<div id="frm-desc-video" class="form-group">
						<label class="content_video">Description Video</label>
						<textarea name="desc_video" placeholder="" class="form-control">{{ $highlight->desc_video }}</textarea>
					</div>
					<div id="frm-video" class="form-group">
						<label>Video</label>
					    <textarea name="video" placeholder="" class="form-control">{{ $highlight->video }}</textarea>	
					</div>
					<div id="frm-gallery" class="form-group img-upload">
						<label for="content">Gallery</label>
						<div class="wrap-gallery">
							@if($gallery)
								@foreach($gallery as $value)
									@php $image = getMedia($value); @endphp
									<div class="gallery-item item-{{$value}}" data-id="{{$value}}" >
										<div class="wrap-item">
											{!! imageAuto($value, $highlight->title) !!}
											<span class="remove-gallery">x</span>
										</div>
									</div>
								@endforeach
							@endif
						</div>
						<div class="bot-wrap">
							<a href="{{ route('loadMedia') }}" class="btn btn-default library-gallery">Add to gallery</a>
							<input type="hidden" name="gallery" class="thumb-media" value="{{ $highlight->gallery }}">
						</div>
					</div>
					@else
						<div id="frm-title-video" class="form-group">
							<label for="title">Title Video</label>
							<input type="text" name="title_video" class="form-control" placeholder="Input title video" class="frm-input">
						</div>
						<div id="frm-desc-video" class="form-group">
							<label class="content_video">Description Video</label>
							<textarea name="desc_video" placeholder="" class="form-control"></textarea>
						</div>
						<div id="frm-video" class="form-group">
							<label>Video</label>
						    <textarea name="video" placeholder="" class="form-control"></textarea>	
						</div>
						<div id="frm-gallery" class="form-group img-upload">
							<label for="content">Gallery</label>
							<div class="wrap-gallery"></div>
							<div class="bot-wrap">
								<a href="{{ route('loadMedia') }}" class="btn btn-default library-gallery">Add to gallery</a>
								<input type="hidden" name="gallery" class="thumb-media" value="">
							</div>
						</div>
				@endif
					<div class="row form-group">
						<div class="col-md-3">
							<label class="title">Icon</label>
							<div id="frm-icon" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($country->icon,  211,139, $country->title)!!}
									<input type="hidden" name="icon" value="{{$country->icon}}" class="thumb-media" value="" />
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<label class="title">Flag</label>
							<div id="frm-flag" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($country->flag,  211,139, $country->title)!!}
									<input type="hidden" name="flag" value="{{$country->flag}}" class="thumb-media" value="" />
								</div>
							</div>
						</div>
					</div>	
					<div id="frm-tb-content" class="form-group just-level-1 has-thumb" data-load-media={{ route('loadMedia') }}>
						<input type="hidden" class="string-value" name="best_time_to_visit" value="">
						<label for="title">City guide detail</label>
						<table class="field block-style row-style">
							<tbody class="sortable">
								@if($list_best_time_to_visit != '')
									@foreach($list_best_time_to_visit as $key => $item)
										@php
											$arrayEditor[] = 'best_time_to_visit_'. ($key+1);
											$num_row = $key + 1;
											//$row_image = $item->image;
											$row_title = $item->title;
											$row_content = $item->content;
											$row_idEditor = 'best_time_to_visit_'. ($key+1);
										@endphp
										@include('backend.templates.item-single-tb-content')
									@endforeach
								@endif
							</tbody>
						</table>
						<a href="javascript:void(0)" class="btn add-row m-t-10">Add content</a>
					</div>
					
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<section id="sb-parent" class="box-wrap">
							<h2 class="title">Parent</h2>
							<select class="form-control select2" name="parent_id">
								<option value="">Choose Parent</option>
								{!! getListOptionParentCountry(0, 0, true) !!}
							</select>
						</section>

						<section id="sb-flag" class="box-wrap">
							<h2 class="title">Image</h2>		
							<div id="frm-image" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($country->image,  211,139, $country->title)!!}
									<input type="hidden" name="image" value="{{$country->image}}" class="thumb-media" value="" />
								</div>
							</div>
						</section>
					@if($highlight)
						<section id="sb-request-one" class="box-wrap">
							<h2 class="title">Image Request One</h2>
							<div id="frm-request-one" class="desc img-upload">	
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($highlight->image_request_one, 150,150, 'Image')!!}
									<input type="hidden" name="image_request_one" class="thumb-media" value="{{$highlight->image_request_one}}" />
								</div>
							</div>
						</section>
						<section id="sb-request-two" class="box-wrap">
							<h2 class="title">Image Request Two</h2>
							<div id="frm-request-two" class="desc img-upload">	
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($highlight->image_request_two, 150,150, 'Image')!!}
									<input type="hidden" name="image_request_two" class="thumb-media" value="{{$highlight->image_request_two}}" />
								</div>
							</div>
						</section>
					@else
						<section id="sb-request-one" class="box-wrap">
							<h2 class="title">Image Request One</h2>
							<div id="frm-request-one" class="desc img-upload">	
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="image_request_one" class="thumb-media" value="" />
								</div>
							</div>
						</section>
						<section id="sb-request-two" class="box-wrap">
							<h2 class="title">Image Request Two</h2>
							<div id="frm-request-two" class="desc img-upload">	
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="image_request_two" class="thumb-media" value="" />
								</div>
							</div>
						</section>
					@endif

						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($country->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($country->updated_at)) }}</li>
							</ul>
						</section>

						<section>
							<label>Status</label>
							<select name="status" class="form-control">
								<option value="active" {{ ($country->status != 'deactive') ? 'selected' : '' }}>Active</option>
								<option value="deactive" {{ ($country->status == 'deactive') ? 'selected' : '' }}>Deactive</option>
							</select>
						</section>

					</div>
					<div class="group-fixed">
						<section id="sb-action">
							<div class="group-action">
								<a href="{{ route('deleteCountryAdmin',['id'=>$country->id]) }}" class="btn btn-delete">Delete</a>
								<button type="submit" name="submit" class="btn">Save</button>
								<a href="{{route('countryAdmin')}}" class="btn btn-cancel">Cancel</a>										
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
	@php
		foreach ($arrayEditor as $key => $value) {
			@endphp
				ckeditor('{{$value}}');
			@php
		}
	@endphp

	$('#color').colorpicker();
	$('#sb-parent select option[value="{{$country->parent_id }}"]').prop('selected', true);


	//action
	$(function(){
		/*$('#edit-country').on('submit', 'form.frm-edit-country', function(e){
			e.preventDefault();
			var _token = $("form input[name='_token']").val();
			var title = $("#frm-title input").val(); console.log(title);
			var metaValue = $("#frm-metaValue textarea").val();
			var shortContent = $("#frm-shortContent textarea").val();
			var color = $('#frm-color input').val();
			var map = $('#frm-map textarea').val();
			var image = $('#frm-image input').val();
			var icon = $('#frm-icon input').val();
			var flag = $('#frm-flag input').val(); 
			var best_time_to_visit = CKEDITOR.instances['best_time_to_visit'].getData();
			var parent_id = $("#sb-parent select").val();
			var errors = new Array();
	       	var error_count = 0;
	       	if(title==""){
	       		errors[0] = "Please input title";
	       	}else{
				errors[0] = "";
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
					url:'{{ route("updateCountryAdmin", ["slug"=>$country->slug]) }}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
						'metaValue': metaValue,
						'shortContent': shortContent,
						'color': color,
						'map': map,
						'image': image,
						'icon': icon,
						'flag': flag,
						'parent_id': parent_id,
						'best_time_to_visit': best_time_to_visit,
					},
				}).done(function(data) { 
					$('#overlay').hide();
	       			$('.loading').hide();
					if(data.msg =="success"){				       					       	
						new PNotify({
							title: 'Successfully',
							text: 'Update success.',
							type: 'success',
							hide: true,
							delay: 2000,
						});	
						//location.reload();	
						window.location.href = data.redirect;				
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
		});*/

		//delete location
      	/*$(".dev-form .btn-delete").click(function(){
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
      	});*/
	});



</script>
@stop