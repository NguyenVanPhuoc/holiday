@extends('backend.layout.index')
@section('title','Add country')
@section('content')
<div id="create-country" class=" page country-page route">
	<div class="head">
		<a href="{{ route('countryAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All country</a>
		<h1 class="title">Add country</h1>		
	</div>	
	<div class="main">
		<form action="{{route('createCountryAdmin')}}" class="frm-menu dev-form activity-form" method="POST" name="create_country" role="form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div id="frm-title" class="form-group">
						<label for="title">Title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" class="frm-input">
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
					<div id="frm-shortContent" class="form-group">
						<label class="short-content">Description</label>
						<textarea name="desc" placeholder="Input description" class="form-control" id="editor"></textarea>
					</div>
					<div class="form-group">
						<label class="short-content">Short Description</label>
						<textarea name="short_desc" placeholder="Input description" class="form-control"></textarea>
					</div>
					<div id="frm-color" class="form-group">
						<label>Color</label>
						<div id="color" class="input-group colorpicker-component">
						    <input type="text" name="color" value="" class="form-control" />
						    <span class="input-group-addon"><i></i></span>
						</div>	
					</div>	
					<div id="frm-map" class="form-group">
						<label>Map</label>
					    <textarea name="map" placeholder="" class="form-control"></textarea>	
					</div>

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
					<div class="row form-group">
						<div class="col-md-3">
							<label class="title">Icon</label>
							<div id="frm-icon" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="icon" class="thumb-media" value="" />
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<label class="title">Flag</label>
							<div id="frm-flag" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="flag" class="thumb-media" value="" />
								</div>
							</div>
						</div>
					</div>
					

					<div id="frm-tb-content" class="form-group just-level-1 has-thumb" data-load-media={{ route('loadMedia') }}>
						<input type="hidden" class="string-value" name="best_time_to_visit" value="">
						<label for="title">City guide detail</label>
						<table class="field block-style">
							<tbody class="sortable"></tbody>
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
								{!! getListOptionParentCountry(0, 0, false) !!}
							</select>
						</section>
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Image</h2>
							<div id="frm-image" class="desc img-upload">	
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="image" class="thumb-media" value="" />
								</div>
							</div>
						</section>
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
						<section id="status">
							<select name="status" class="status_nvp">
								<option>Status</option>
								<option value="active">Active</option>
								<option value="deactive">Deactive </option>
							</select>
						</section>
					</div>
					<div class="group-fixed">
						<div class="group-action">
							<button type="submit" name="submit" class="btn">Save</button>
							<a href="{{route('countryAdmin')}}" class="btn btn-cancel">Cancel</a>									
						</div>
					</div>
				</div>
			</div>			
		</form>	
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">
	$('#color').colorpicker();
	ckeditor("editor");
	//action
	/*$(function(){
		$('#create-country').on('submit', 'form', function(e){
			e.preventDefault();
			var _token = $("form input[name='_token']").val();
			var title = $("#frm-title input").val();
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
					url:'{{ route("createCountryAdmin") }}',
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
					if(data=="success"){
						$("#frm-title input").val("");
						$("#frm-shortContent textarea").val("");
						$("#frm-content textarea").val("");
						$("#frm-color input").val("");
						var img_url = location.protocol + "//" + location.host+'/image/noimage.png/150/150';
						$("#frm-image img").attr("src",img_url);
						$("#frm-icon img").attr("src",img_url);
						$("#frm-flag img").attr("src",img_url);
						CKEDITOR.instances['best_time_to_visit'].setData("");
				       	errors = [];
				       	error_count = 0;				       					       	
						new PNotify({
							title: 'Successfully',
							text: 'Add to success.',
							type: 'success',
							hide: true,
							delay: 2000,
						});					
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
	});*/

</script>
@stop