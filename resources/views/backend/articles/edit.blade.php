@extends('backend.layout.index')
@section('title','Edit blog')
@section('content')
@php 
$slugCountry = getSlugCountryOfBlog($article->id);
if($seo){
	$key = $seo->key;
	$value = $seo->value;
}else{
	$key = "";
	$value = "";
}

$tableContent = getTableContent($article->id, 'article');
$arrayEditor = array();
$array_blogID = ($article->list_blog != '') ? explode(",", $article->list_blog) : []; 
@endphp
<div id="edit-blog" class="page news-page route">
	<div class="head">
		<a href="{{route('blogAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Category</a>
		<h1 class="title">Edit blog</h1>
		<a href="{{ $article->getPermalink() }}" target="_blank" class="view-fast"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view</a>		
	</div>
	<div class="main">
		<form action="{{route('editBlogAdmin',['id'=>$article->id])}}" class="dev-form" method="POST" name="edit_blog" role="form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div id="frm-title" class="form-group">
						<label for="title">Title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" class="frm-input" value="{{$article->title}}">
					</div>
					<div id="frm-slug" class="form-group">
						<label for="slug">Slug<small class="required">(*)</small></label>
						<div class="wrap">
							<span>{{$article->slug}}</span>
							<input type="text" name="edit_slug" value="{{$article->slug}}" class="form-control hide" />
							<a href="#" class="edit-slug">Edit</a>
							<a href="#" class="btn save-slug hide">OK</a>
							<a href="#" class="cancel hide">Cancel</a>
						</div>
					</div>
					<div id="frm-title-tag" class="form-group">
						<label for="title_tag">Title tag (SEO title) 65-70 characters</label>
						<span class="count-characters">( {{strlen($article->title_tag)}} characters )</span>
						<input type="text" name="title_tag" value="{{$article->title_tag}}" class="form-control" placeholder="Title tag (SEO title) 65-70 characters" class="frm-input">
					</div>
					<div id="frm-metaKey" class="form-group">
						<label for="metakey">Keyword (SEO)</label>
						<input type="text" name="metakey" class="form-control" placeholder="Input keyword (SEO)" class="frm-input" value="{{$key}}">
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="metaValue">Meta Description (SEO) 150-160 characters</label>
						<span class="count-characters">( {{strlen($article->title_tag)}} characters )</span>
						<textarea name="metaValue" placeholder="Input meta description (SEO) 150-160 characters" class="form-control">{{$value}}</textarea>
					</div>	

					<div id="frm-content" class="form-group">
						<label for="content">Content</label>
						<textarea name="content" id="editor">{!!$article->content!!}</textarea>
					</div>
					<!-- <div id="frm-shortContent" class="form-group">
						<label class="short-content">Description</label>
						<textarea name="shortContent" placeholder="Nhập nội mô tả" class="form-control">{{$article->desc}}</textarea>
					</div> -->
					<div id="frm-tb-content" class="form-group">
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
					<div id="frm-list-blog" class="form-group">
						<label for="title">Related Posts</label>
						<select multiple="multiple" name="list_blog[]" class="form-control select2 test" data-order="{{ $article->list_blog }}">
                            @foreach ($list_blog as $item)
                                <option value="{{ $item->id }}" @if(in_array($item->id, $array_blogID)) selected @endif> {{ $item->title }} </option>
                            @endforeach
                        </select>
					</div>	
									
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<section id="sb-country" class="box-wrap">
							<input type="hidden" name="countries_active" value="{{ implode(',', $list_countryid) }}" />
							<h2 class="title">Country</h2>
							<div class="desc list">
	                            <ul class="no-list-style list-item scrollbar-inner">
	                                {!! getListCheckParentCountry() !!}
	                            </ul>						
							</div>		
						</section>
						<?php $categories = get_categories();?>
						@if(!$categories->isEmpty())
						<section id="sb-categories" class="box-wrap">
							<h2 class="title">Danh mục</h2>
							<div class="desc list">
								<div class="dropdown vs-drop">
									@if($article->cat_id)<?php $cat = get_category($article->cat_id);?>
		                            	<a class="dropdown-toggle" href="#{{$cat->slug}}" id="dropdown-cat" data-toggle="dropdown" data-value="{{$cat->id}}">{{$cat->title}}</a>
		                            @else
		                            	<a class="dropdown-toggle" href="#" role="button" id="dropdown-cat" data-toggle="dropdown">Category</a>
		                            @endif
		                            @if($categories)
		                            <div class="dropdown-menu" aria-labelledby="dropdown-cat">
		                                <ul class="list-item">
		                                    @foreach($categories as $item)
		                                    <li><a href="#{{$item->slug}}" data-value="{{$item->id}}"<?php if($item->id==$article->cat_id) echo 'class ="active"'?>>{{$item->title}}</a></li>
		                                    @endforeach
		                                </ul>
		                            </div>
		                            @endif
		                        </div>							
							</div>						
						</section>
						@endif	

						@if($list_blogger)
						<section id="sb-blogger" class="box-wrap">
							<h2 class="title">Blogger</h2>
							<select class="select2" name="blogger_id">
								<option value="">Choose blogger</option>
								@foreach($list_blogger as $item)
									<option value="{{ $item->id }}" @if($item->id == $article->blogger_id) selected @endif>{{ $item->title }}</option>
								@endforeach
							</select>				
						</section>
						@endif

						<section id="sb-image" class="box-wrap">
							<h2 class="title">Image</h2>
							<div id="frm-image" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($article->image, 211,139, $article->title)!!}
									<input type="hidden" name="image" class="thumb-media" value="{{$article->image}}" />
								</div>
							</div>
						</section>
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Request one</h2>
							<div id="frm-image-request1" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($article->image_request1, 150,150, 'Image')!!}
									<input type="hidden" name="image_request1" class="thumb-media" value="{{$article->image_request1}}" />
								</div>
							</div>
						</section>
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Looking</h2>
							<div id="frm-image-looking" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($article->image_looking, 150,150, 'Image')!!}
									<input type="hidden" name="image_looking" class="thumb-media" value="{{$article->image_looking}}" />
								</div>
							</div>
						</section>
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Request Two</h2>
							<div id="frm-image-request2" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($article->image_request2, 150,150, 'Image')!!}
									<input type="hidden" name="image_request2" class="thumb-media" value="{{$article->image_request2}}" />
								</div>
							</div>
						</section>
						<section id="sb-status" class="box-wrap">
							<h2 class="title">Status</h2>
							<select name="status">
								<option value="1" @if($article->status == 1) selected @endif>Active</option>
								<option value="0" @if($article->status == 0) selected @endif>Inactive</option>
							</select>
						</section>
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($article->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($article->updated_at)) }}</li>
							</ul>
						</section>
					</div>
					<div class="group-fixed">
						<div class="group-action">
							<a href="{{ route('deleteBlogAdmin',['slug'=>$article->id]) }}" class="btn btn-delete">Delete</a>
							<button type="submit" name="submit" class="btn">Save</button>
							<a href="{{route('blogAdmin')}}" class="btn btn-cancel">Cancel</a>									
						</div>
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
	$(function() {		
       $("#edit-blog").on('click','form .group-action button',function(){
	       	var _token = $("form input[name='_token']").val();
	       	var title = $("#frm-title input").val();
	       	var slug = $("form #frm-slug input").val();
	       	var title_tag = $("form #frm-title-tag input").val();
	       	var content = CKEDITOR.instances['editor'].getData();
	       	var shortContent = $("#frm-shortContent textarea").val();
	       	var metaKey = $("#frm-metaKey input").val();
	       	var metaValue = $("#frm-metaValue textarea").val();
	       	var image = $("#frm-image input").val();
	       	var image_request1 = $("#frm-image-request1 input").val();
	       	var image_looking = $("#frm-image-looking input").val();
	       	var image_request2 = $("#frm-image-request2 input").val();
	       	var status = $("#sb-status select").val();
	       	var catId = $("#sb-categories .dropdown-toggle").attr("data-value");
	       	var blogger_id = $('#sb-blogger select').val();
	       	var countries = new Array();
	       	var tableContent = new Array();
	       	var errors = new Array();
	       	var error_count = 0;
	       	var list_blog = $('#frm-list-blog select').val();
	       	$("#sb-categories .list .item").each(function(){
	       		if($(this).find("input").is(':checked')){
	       			categories.push($(this).find("input").val());
	       		}
	       	});
	       	$("#sb-country .list-item li").each(function(){
	       		if($(this).find("input").is(':checked')){
	       			countries.push($(this).find("input").val());
	       		}
	       	});

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

	       	if(title==""){
	       		errors[0] = "Please input title";
	       	}else{
				errors[0] = "";
	       	}
	       	if(catId==""){
	       		errors[1] = "Please choose a category";
	       	}else{
				errors[1] = "";
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
				$.ajax({
					type:'POST',            
					url:'{{route("editBlogAdmin",["id"=>$article->id])}}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
						'slug': slug,
						'title_tag': title_tag,
						'content': content,
						'shortContent': shortContent,
						'metaKey': metaKey,
						'metaValue': metaValue,
						'image': image,
						'image_request1': image_request1,
						'image_looking': image_looking,
						'image_request2': image_request2,
						'status': status,
						'catId': catId,
						'blogger_id': blogger_id,
						'list_blog': list_blog,
						'countries': countries,
						'tableContent': JSON.stringify(tableContent)
					},
				}).done(function(data) {
					if(data=="success"){										       					       	
						new PNotify({
							title: 'Successfully',
							text: 'Update success.',
							type: 'success',
							hide: true,
							delay: 2000,
						});	
						location.reload();				
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

      	//delete row content
      	$('table').on('click', 'tr.edit a.remove-row', function(){
      		var id = $(this).closest('tr').attr('data-id'); 
	   		$(this).addClass('active');
			$(this).parents('td.delete').find('.tooltip').addClass('active');
			$(this).parents('td.delete').find('#d-no').on('click', $(this).parents('.del-tooltip .tooltip.active').find('.no'), function(){
				$(this).parents('.tooltip').removeClass('active');
				$(this).find('a.remove-row').removeClass('active');
				return false;
			});
			$(this).parents('td.delete').find('#d-yes').on('click', $(this).parents('.del-tooltip .tooltip.active').find('.yes'), function(){
				var _token = $("form input[name='_token']").val();
				var number_item = '';
				var itemTemp = $(this).closest('tbody'); 
				numberParent = $(this).parents('tr').length; 

				if(numberParent === 3){ //if have menu parent (it's lv = 3)
					number_item += ($(this).parents('tr').eq(2).index() + 1) + '.'; 
					number_item += ($(this).parents('tr').eq(1).index() + 1) + '.'; 
				}
				else if(numberParent === 2){ //if have menu parent (it's lv = 2)
					number_item += ($(this).parents('tr').eq(1).index() + 1) + '.';
				}
				
				$(this).parents('tr').eq(0).fadeOut();
				$(this).parents('tr').eq(0).remove(); 
				var recount = 0; 
				itemTemp.find('> tr').each(function(){
					recount++;
					$(this).find('> td:first-child').text(number_item + recount); //replace number for each tr same level

					//replace number items child 
					if($(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').length && $(this).find('> td:nth-child(2) tbody').eq(1).find('> tr').length ){ //if it's lv 1
						$(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').each(function(){ // each item have 3 level
							var child = recount + '.' + parseInt($(this).eq(0).index() + 1) ;
							$(this).find('> td:first-child').text(child);
							$(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').each(function(){
								var grand = child + '.' + parseInt($(this).index() + 1);
								$(this).find('> td:first-child').text(grand);
							});
						}); 
					}
					else if($(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').length  && !$(this).find('> td:nth-child(2) tbody').find('> tr').eq(1).length ){ //if it's lv 2
						$(this).find('> td:nth-child(2) tbody').eq(0).find('> tr').each(function(){ // each item have 2 level
							var child = recount + '.' + parseInt($(this).eq(0).index() + 1) ;
							$(this).find('> td:first-child').text(child);
						}); 
					}
				}); 

				$.ajax({
					type:'POST',            
					url:'{{route('deleteRowContent')}}',
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
						location.reload();		
					}else{
						new PNotify({
							title: 'Error',
							text: 'The system is busy. Please try again. ',					    
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