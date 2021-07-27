@extends('backend.layout.index')
@section('title','Edit Market Guide')
@section('content')

@php
	$countries = getCountryLevel1();
	$seo = get_seo($guide->id,'market');
	if($seo){ 
		$meta_key = $seo->key; 
		$meta_value = $seo->value;
	}else{
		$meta_key = "";
		$meta_value = "";
	}

	$tableContent = getTableContent($guide->id, 'market');
	$arrayEditor = array();
	$list_cat = getListCatNation();
	$array_tourID = ($guide->list_tour != '') ? explode(",", $guide->list_tour) : []; 
	$slug = get_slug_guideMarket($guide->cat_id);
	
@endphp

<div id="edit-cultural" class="page route">
	<div class="head">
		<a href="{{route('marketAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All Market guides</a>
		<a href="{{route('postTypeCountryTravel', ['slug_country'=>$country->slug,'slug'=>$slug->slug])}}" target="_blank" class="view-fast"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View Market</a>	
		<h1 class="title">Edit Market Guide</h1>		
	</div>
	<div class="main">
		<form action="{{ route('updateMarketAdmin', $guide->id) }}" method="post" class="dev-form activity-form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div class="form-group" id="frm-long-title">
						<label for="title">Title<small>(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input long title" value="{{$guide->title}}" />
					</div>
					{{-- <div class="form-group">
						<label for="title">Permalink</label>
						<a href="{{route('postTypeCountryTravel', ['slug_country'=>$country->slug,'slug'=>$cat->slug])}}" class="permalink" target="_blank">
							{{route('postTypeCountryTravel', ['slug_country'=>$country->slug,'slug'=>$cat->slug])}}
						</a>
					</div> --}}
					<!-- <div id="frm-slug" class="form-group">
						<label for="slug">Slug<small class="required">(*)</small></label>
						<div class="wrap">
							<span>{{$guide->slug}}</span>
							<input type="text" name="slug" value="{{$guide->slug}}" class="form-control hide" />
							<a href="#" class="edit-slug">Edit</a>
							<a href="#" class="btn save-slug hide">OK</a>
							<a href="#" class="cancel hide">Cancel</a>
						</div>
					</div> -->
					<div id="frm-title-tag" class="form-group">
						<label for="title_tag">Title tag (SEO title) 65-70 characters</label>
						<span class="count-characters">( {{strlen($guide->title_tag)}} characters )</span>
						<input type="text" name="title_tag" class="form-control" placeholder="Title tag (SEO title) 65-70 characters" class="frm-input" value="{{$guide->title_tag}}">
					</div>
					<div id="frm-metaKey" class="form-group">
						<label for="metakey">Keyword (SEO)</label>
						<input type="text" name="meta_key" class="form-control" placeholder="Input keyword (SEO)" class="frm-input" value="{{$meta_key}}">
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="metaValue">Meta Description (SEO) 150-160 characters</label>
						<span class="count-characters">( {{strlen($meta_value)}} characters )</span>
						<textarea name="meta_value" placeholder="Input meta description (SEO) 150-160 characters" class="form-control">{{$meta_value}}</textarea>
					</div>
					<div id="frm-desc" class="form-group">
						<label for="content">Description</label>
						<textarea name="desc" id="editor">{{$guide->desc}}</textarea>
					</div>

					<div id="frm-tb-content" class="form-group edit">
						<input type="hidden" class="string-value" name="table_content" value="">
						<label>Table content</label><br>
						<table class="field block-style">
							<tbody class="sortable">
								@if($tableContent)
									@php
										$tableLevel1s = getTableDetailLevel1($tableContent->id); 
										$tableLists = getTableContentDetails($tableContent->id);
										//add all id in array ckeditor
										if($tableLists):
											foreach ($tableLists as $item):
												$arrayEditor[] = $item->id;
											endforeach;
										endif;
									@endphp
									@if($tableLevel1s) <!--Level 1-->
										@foreach($tableLevel1s as $key => $level1)
											@php
												$number_item = ($key + 1);
												$tableLevel2s = getTableDetailByParent($level1->id);
											@endphp
											{!! tableContent($number_item, $level1->id, $level1->sequence, $level = 1) !!}
										@endforeach
									@endif
								@endif
							</tbody>
						</table>
						<a href="javascript:void(0)" class="btn add-row">Add row</a>
					</div>
					<div id="frm-list-tour" class="form-group">
						<label for="title">Related Posts</label>
						<select multiple="multiple" name="list_tour[]" class="form-control select2 test" data-order="{{ $guide->list_blog }}">
                            @foreach ($list_tour as $item)
                                <option value="{{ $item->id }}" @if(in_array($item->id, $array_tourID)) selected @endif> {{ $item->title }} </option>
                            @endforeach
                        </select>
					</div>
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<section id="sb-country" class="box-wrap">
							<h2 class="title">Country</h2>
							<select name="country_id">
								<option value="">Chose country</option>
								@foreach($countries as $country)
									<option value="{{ $country->id }}" @if($country->id == $guide->country_id) selected @endif>{{ $country->title }}</option>
								@endforeach
							</select>	
						</section>
						<section id="sb-category" class="box-wrap">
							<h2 class="title">Nationality</h2>
							<select name="cat_id" class="select2">
								<option value="">Chose Nationality</option>
								@if($list_cat)
									@foreach($list_cat as $nation)
										<option value="{{ $nation->id }}" @if($nation->id == $guide->cat_id) selected @endif>{{ $nation->title }}</option>
									@endforeach
								@endif
							</select>
						</section>
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Image</h2>
							<div id="frm-image" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($guide->image, 150,150, $guide->title)!!}
									<input type="hidden" name="image" class="thumb-media" value="{{$guide->image}}" />
								</div>
							</div>
						</section>
						<section id="sb-image-looking" class="box-wrap">
							<h2 class="title">Image Looking</h2>
							<div id="frm-image-looking" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($guide->image_looking, 150,150, $guide->title)!!}
									<input type="hidden" name="image_looking" class="thumb-media" value="{{$guide->image_looking}}" />
								</div>
							</div>
						</section>
						<section id="sb-image-request" class="box-wrap">
							<h2 class="title">Image Request</h2>
							<div id="frm-image-request" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($guide->image_request, 150,150, $guide->title)!!}
									<input type="hidden" name="image_request" class="thumb-media" value="{{$guide->image_request}}" />
								</div>
							</div>
						</section>
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($guide->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($guide->updated_at)) }}</li>
							</ul>
						</section>
					</div>
					<div class="group-fixed">
						<section id="sb-action">
							<div class="group-action">
								<a href="{{ route('deleteMarketAdmin', ['id'=>$guide->id]) }}" class="btn btn-delete delete-item">Delete</a>
								<button type="submit" name="submit" class="btn">Save</button>
								<a href="{{route('marketAdmin')}}" class="btn btn-cancel">Cancel</a>									
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
				ckeditor({{'tb_content_' . $value}});
			@php
		}
	@endphp
	/*$(function() {
       $("#edit-cultural").on('click','form .group-action button',function(){
	       	var _token = $("form input[name='_token']").val();
	       	var longTitle = $("#frm-long-title input").val();
	       	var slug = $("form #frm-slug input").val();
	       	var shortTitle = $("#frm-short-title input").val();
	       	var title_tag = $("form #frm-title-tag input").val();
	       	var desc = CKEDITOR.instances['editor'].getData();
	       	var image = $("#frm-image input").val();
	       	var white_icon = $("#frm-white-icon input").val();
	       	var green_icon = $("#frm-green-icon input").val();
	       	var gray_icon = $("#frm-gray-icon input").val();
	       	var metaKey = $("#frm-metaKey input").val();
	       	var metaValue = $("#frm-metaValue textarea").val();
	       	var country = $('#sb-country a.dropdown-toggle').attr('data-value');
	       	var countries = new Array();
	       	var tableContent = new Array();
	       	var errors = new Array();
	       	var error_count = 0;


	       	//get data table content edit
	       	$('#frm-tb-content > table > tbody > tr').each(function(key){ 
	       		var ob_lv1 = {};
	       		var title_lv1 = $(this).find('> td:nth-child(2) > .tb-title input').val();
	       		var id_content_lv1 = $(this).find('> td:nth-child(2) > .tb-content textarea').attr('id');
	       		var content_lv1 = CKEDITOR.instances[id_content_lv1].getData(); 
	       		var position_lv1 = $(this).attr('data-position');
	       		var action_lv1 = 'add'; 
	       		var id_lv1 = $(this).attr('data-id'); 
	       		if($(this).hasClass('edit')) action_lv1 = 'edit';
	       		var arr_child_lv1 = new Array();
	       		//get array child lv 2
	       		if($(this).find('.sortable-lv-2 > tr').length){
	       			$(this).find('.sortable-lv-2 > tr').each(function(){
	       				var ob_lv2 = {};
	       				var title_lv2 = $(this).find('> td:nth-child(2) > .tb-title input').val();
	       				var id_content_lv2 = $(this).find('> td:nth-child(2) > .tb-content textarea').attr('id');
	       				var content_lv2 = CKEDITOR.instances[id_content_lv2].getData();
	       				var position_lv2 = $(this).attr('data-position');
	       				var action_lv2 = 'add'; 
	       				var id_lv2 = $(this).attr('data-id');
	       				if($(this).hasClass('edit')) action_lv2 = 'edit';
	       				var arr_child_lv2 = new Array(); 
	       				//get array child lv 3
			       		if($(this).find('.sortable-lv-3 > tr').length){
			       			$(this).find('.sortable-lv-3 > tr').each(function(){
			       				var ob_lv3 = {};
			       				var title_lv3 = $(this).find('> td:nth-child(2) > .tb-title input').val();
			       				var id_content_lv3 = $(this).find('> td:nth-child(2) > .tb-content textarea').attr('id');
	       						var content_lv3 = CKEDITOR.instances[id_content_lv3].getData();
			       				var position_lv3 = $(this).attr('data-position');
			       				var action_lv3 = 'add'; 
			       				var id_lv3 = $(this).attr('data-id');
	       						if($(this).hasClass('edit')) action_lv3 = 'edit';
	       						if(id_lv3 !== undefined) ob_lv3.id = id_lv3;
			       				ob_lv3.title = title_lv3;
			       				ob_lv3.content = content_lv3;
			       				ob_lv3.position = position_lv3;
			       				ob_lv3.action = action_lv3;
			       				arr_child_lv2.push(ob_lv3);
			       			});
			       		}
			       		if(id_lv2 !== undefined) ob_lv2.id = id_lv2;
			       		ob_lv2.title = title_lv2;
	       				ob_lv2.content = content_lv2;
	       				ob_lv2.position = position_lv2;
	       				ob_lv2.action = action_lv2;
	       				ob_lv2.child = arr_child_lv2;
	       				arr_child_lv1.push(ob_lv2);
	       			});
	       		}
	       		if(id_lv1 !== undefined) ob_lv1.id = id_lv1;
	       		ob_lv1.title = title_lv1;
   				ob_lv1.content = content_lv1;
   				ob_lv1.position = position_lv1;
   				ob_lv1.action = action_lv1;
   				ob_lv1.child = arr_child_lv1;
   				tableContent.push(ob_lv1);
	       	});

	       	if(longTitle==""){
	       		errors.push("Please input long title");
	       	}
	       	if(shortTitle==""){
	       		errors.push("Please input short title");
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
					url:'{{ route("updateCulturalAdmin", ["slug"=>$guide->slug]) }}',
					cache: false,
					data:{
						'_token': _token,
						'longTitle': longTitle,
						'slug': slug,
						'shortTitle': shortTitle,
						'title_tag': title_tag,
						'desc': desc,
						'metaKey': metaKey,
						'metaValue': metaValue,
						'image': image,
						'white_icon': white_icon,
						'green_icon': green_icon,
						'gray_icon': gray_icon,
						'country': country,
						'tableContent': JSON.stringify(tableContent)
					},
				}).done(function(data) {
					$('#overlay').hide();
	       			$('.loading').hide();
					if(data.msg=="success"){				       					       	
						new PNotify({
							title: 'Successfully',
							text: 'Add to success.',
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
   	});*/	
</script>
@stop