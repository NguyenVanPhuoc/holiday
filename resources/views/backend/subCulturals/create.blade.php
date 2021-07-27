@extends('backend.layout.index')
@section('title','Add Sub-Cultural Guide')
@section('content')
@php
	$listParent = getListCulturalGuides();
@endphp
<div id="create-sub-cultural" class="page route">
	<div class="head">
		<a href="{{route('subCulturalsAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All sub-cultural guides</a>
		<h1 class="title">Add Sub-Cultural Guide</h1>		
	</div>
	<div class="main">
		<form action="#" method="post" class="dev-form create-sub-cultural">
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
						<input type="text" name="metakey" class="form-control" placeholder="Input keyword (SEO)" class="frm-input">
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="metaValue">Meta Description (SEO) 150-160 characters</label>
						<span class="count-characters"></span>
						<textarea name="metaValue" placeholder="Input meta description (SEO) 150-160 characters" class="form-control"></textarea>
					</div>
					<div id="frm-desc" class="form-group">
						<label for="content">Description</label>
						<textarea name="desc" id="editor"></textarea>
					</div>
					<div id="frm-tb-content" class="form-group">
						<label>Table content</label><br>
						<table class="field block-style">
							<tbody class="sortable"></tbody>
						</table>
						<a href="javascript:void(0)" class="btn add-row">Add row</a>
					</div>	
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<section id="frm-parent" class="box-wrap">
							<h2 class="title">Cultural Parent</h2>
							<div class="desc list">
								<div class="dropdown vs-drop">
		                            <a class="dropdown-toggle" href="#" role="button" id="dropdown-cat"  data-value="" data-toggle="dropdown">Cultural Parent</a>
		                            <div class="dropdown-menu" aria-labelledby="dropdown-cat" x-placement="bottom-start">
		                                <ul class="list-item dropdown-country scrollbar-inner">
		                                	@foreach($listParent as $item)
		                                		<li><a href="#{{$item->slug}}" data-value="{{$item->id}}" >{{$item->long_title}}</a></li>
		                                	@endforeach
		                                </ul>
		                            </div>
		                        </div>							
							</div>		
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
	$(function() {
       $("#create-sub-cultural").on('click','form .group-action button',function(){
	       	var _token = $("form input[name='_token']").val();
	       	var title = $("#frm-title input").val();
	       	var title_tag = $("form #frm-title-tag input").val();
	       	var desc = CKEDITOR.instances['editor'].getData();
	       	var image = $("#frm-image input").val();
	       	var metaKey = $("#frm-metaKey input").val();
	       	var metaValue = $("#frm-metaValue textarea").val();
       		var parent = $('#frm-parent a.dropdown-toggle').attr('data-value');
	       	var tableContent = new Array();
	       	var errors = new Array();
	       	var error_count = 0;

	       	//get data table content
	       	$('#frm-tb-content > table > tbody > tr').each(function(key){ 
	       		var ob_lv1 = {};
	       		var title_lv1 = $(this).find('> td:nth-child(2) > .tb-title input').val();
	       		var id_content_lv1 = $(this).find('> td:nth-child(2) > .tb-content textarea').attr('id');
	       		var content_lv1 = CKEDITOR.instances[id_content_lv1].getData(); 
	       		var position_lv1 = $(this).attr('data-position');
	       		var arr_child_lv1 = new Array();
	       		//get array child lv 2
	       		if($(this).find('.sortable-lv-2 > tr').length){
	       			$(this).find('.sortable-lv-2 > tr').each(function(){
	       				var ob_lv2 = {};
	       				var title_lv2 = $(this).find('> td:nth-child(2) > .tb-title input').val();
	       				var id_content_lv2 = $(this).find('> td:nth-child(2) > .tb-content textarea').attr('id');
	       				var content_lv2 = CKEDITOR.instances[id_content_lv2].getData();
	       				var position_lv2 = $(this).attr('data-position');
	       				var arr_child_lv2 = new Array(); 
	       				//get array child lv 3
			       		if($(this).find('.sortable-lv-3 > tr').length){
			       			$(this).find('.sortable-lv-3 > tr').each(function(){
			       				var ob_lv3 = {};
			       				var title_lv3 = $(this).find('> td:nth-child(2) > .tb-title input').val();
			       				var id_content_lv3 = $(this).find('> td:nth-child(2) > .tb-content textarea').attr('id');
	       						var content_lv3 = CKEDITOR.instances[id_content_lv3].getData();
			       				var position_lv3 = $(this).attr('data-position');
			       				ob_lv3.title = title_lv3;
			       				ob_lv3.content = content_lv3;
			       				ob_lv3.position = position_lv3;
			       				arr_child_lv2.push(ob_lv3);
			       			});
			       		}
			       		ob_lv2.title = title_lv2;
	       				ob_lv2.content = content_lv2;
	       				ob_lv2.position = position_lv2;
	       				ob_lv2.child = arr_child_lv2;
	       				arr_child_lv1.push(ob_lv2);
	       			});
	       		}
	       		ob_lv1.title = title_lv1;
   				ob_lv1.content = content_lv1;
   				ob_lv1.position = position_lv1;
   				ob_lv1.child = arr_child_lv1;
   				tableContent.push(ob_lv1);
	       	});

	       	if(title==""){
	       		errors.push("Please input title");
	       	}
	       	if(parent==""){
	       		errors.push("Please choose parent");
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
					url:'{{ route("createSubCulturalAdmin") }}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
						'title_tag': title_tag,
						'desc':desc,
						'metaKey': metaKey,
						'metaValue': metaValue,
						'image': image,
						'parent': parent,
						'tableContent': JSON.stringify(tableContent)
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
   	});	
</script>
@stop