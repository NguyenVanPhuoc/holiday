@extends('backend.layout.index')
@section('title','Thêm Trang')
@section('content')
<div id="create-page" class="page route">
	<div class="head">
		<a href="{{route('pagesAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All pages</a>
		<h1 class="title">Add page</h1>		
	</div>
	<form id="add-page" action="{{route('createPageAdmin')}}" method="post" name="addPage" class="dev-form add-form">
		<input type="hidden" name="_token" value="{{csrf_token()}}"/>
		<div class="row">
			<div class="col-md-10 content">
				<div id="frm-title" class="form-group section">
					<label for="title">Title<small>(*)</small></label>
					<input type="text" name="title" class="form-control" value="{{old('title')}}" placeholder="Input title" />			
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
				<div id="frm-editor" class="form-group section">
					<label for="name">Content<small>(*)</small></label>
					<textarea name="content" id="editor"></textarea>
				</div>
			</div>
			<div class="col-md-2 sidebar">
				<div class="gr-not-fixed">
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
							<a href="{{route('pagesAdmin')}}" class="btn btn-cancel">Cancel</a>		
						</div>
					</section>
				</div>
			</div>
		</div>
		
	</form>
</div>
@include('backend.media.library')
<script type="text/javascript">
	ckeditor("editor");
	$(document).ready(function(){
		$("#create-page .group-action button").click(function(){
			var _token = $("input[name='_token']").val();
			var title = $("#frm-title input").val();
			var content = CKEDITOR.instances['editor'].getData();								
			var metaKey = $("#frm-metaKey input").val();
			var metaValue = $("#frm-metaValue textarea").val();	
			var image = $('#frm-image input').val();
			var errors = new Array();
       		var error_count = 0;
			if(title==""){
	       		errors[0] = "Please input the title";
	       	}else{
				errors[0] = "";
	       	}
	       	if(content==""){
	       		errors[1] = "Please input the content";
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
	       	if(error_count>0){
		       	html += "</ul>";	       	
		       	new PNotify({
					title: 'Error ('+error_count+')',
					text: html,						    
					hide: true,
					delay: 6000,
				});
	       	}else{
				$.ajax({
					type:'POST',            
					url:'{{ route("createPageAdmin") }}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
						'content': content,							
						'metaKey': metaKey,							
						'metaValue': metaValue,
						'image': image
					},
					success:function(data){
						if(data=="success"){
							CKEDITOR.instances['editor'].setData("");
							$("#frm-title input").val("");
							$("#frm-metaKey input").val("");
							$("#frm-metaValue textarea").val("");
							new PNotify({
								title: 'Success',
								text: 'Add to successful.',
								type: 'success',
								hide: true,
								delay: 2000,
							});						
						}else{
							new PNotify({
								title: 'Error',
								text: 'Trình duyệt không hỗ trợ javascript.',						    
								hide: true,
								delay: 2000,
							});
						}
					}
				});
			}
			return false;
		});
	})
</script>
@stop