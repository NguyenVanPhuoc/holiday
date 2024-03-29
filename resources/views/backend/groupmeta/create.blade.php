@extends('backend.layout.index')
@section('title','Thêm nhóm')
@section('content')
<div id="create-mediaField" class="container page media-fields">
	<div class="head"><h1 class="title">Thêm nhóm</h1></div>
	@if(count($errors)>0)
	<div class="alert alert-danger">
		<ul>
			@foreach($errors->all() as $error)
			<li>{{$error}}</li>	
			@endforeach
		</ul>
	</div>
	@endif
	<div class="notify"></div>
	<form id="add-groupMeta" action="{{ url()->current() }}" method="post" name="groupMeta" class="dev-form groupMeta add-post">
		<input type="hidden" name="_token" value="{{csrf_token()}}"/>
		<div id="groupMeta-fields" class="row">
			<div class="form-group col-md-8" id="title">
				<label for="title">Tên nhóm<small>(*)</small></label>
				<input type="text" name="title" class="form-control title" value="{{old('title')}}" />				
			</div>
			@if($pages!=null)
			<div class="form-group col-md-4" id="object">
				<label for="object">Áp dụng<small>(*)</small></label>		
				<select class="form-control" name="object">
					@foreach($pages as $page)
					<option value="{{$page->id}}" data-value="{{ $page->slug }}">{{$page->title}}</option>
					@endforeach
				</select>		
			</div>
			@endif
		</div>
		<div id="fields" class="meta"></div>
		<a href="#" class="add-field">Thêm trường</a>
		<div class="group-action">
			<button type="submit" class="btn">Đồng ý</button>
			<a href="{{route('metas')}}" class="btn btn-cancel">Trở lại</a>
		</div>
	</form>
</div>
<script>
	$(document).ready(function(){
		$(".add-field").click(function(){
			var html = '<div class="item row">';
			html = html + '<div class="form-group col-md-6">';
			html = html + '<label for="meta_name">Tên trường<small>(*)</small></label>';
			html = html + '<input type="text" name="meta_name" class="form-control meta-name"/>';
			html = html + '</div>';
			html = html + '<div class="form-group col-md-3">';
			html = html + '<label for="type">Loại<small>(*)</small></label>';
			html = html + '<select class="form-control type" name="type">';
			html = html + '<option value="text">Text</option>';
			html = html + '<option value="textarea">Textarea</option>';
			html = html + '<option value="editor">Editor</option>';
			html = html + '<option value="image">Image</option>';
			html = html + '</select>';
			html = html + '</div>';
			html = html + '<div class="form-group col-md-2">';
			html = html + '<label for="column">Độ rộng<small>(*)</small></label>';
			html = html + '<select class="form-control column" name="column">';
			html = html + '<option value="2">20%</option>';
			html = html + '<option value="3">25%</option>';
			html = html + '<option value="4">33%</option>';
			html = html + '<option value="6">50%</option>';
			html = html + '<option value="12">100%</option>';
			html = html + '</select>';
			html = html + '</div>';
			html = html + '<div class="form-group col-md-1">';
			html = html + '<a href="#" class="btn">Xóa</a>';
			html = html + '</div';
			html = html + '</div';
			$("#fields").append(html);
			return false;
		});

		//remve item
		$( document ).on( "click", "#fields a.btn", function() {
			$(this).parents(".item").remove();
			return false;
		});

		//add group meta
		$("#add-groupMeta .group-action button").click(function(){
			$(".notify").html();
			var _token = $("#add-groupMeta input[name='_token']").val();
			var title = $("#add-groupMeta #title .title").val();			
			var object = $("#add-groupMeta #object select").val();
			var metas = new Array();
			var count = 0;
			var errors = new Array();
	       	var error_count = 0;
			$("#fields .item").each(function(){
				var metaName = $(this).find(".meta-name").val();
				if(metaName!=""){
					metas[count] = {
						'title' : $(this).find(".meta-name").val(),
						'type' : $(this).find(".type").val(),
						'width' : $(this).find(".column").val()
					}
					count = count + 1;
				}else{
					error_count += 1;
				}
				
			});
			if(title==""){
	       		errors[0] = "Vui lòng nhập tiêu đề";
	       	}else{
				errors[0] = "";
	       	}
	       	if(metas.length==0){
	       		errors[1] = "Một/nhiều hàng chưa nhập tên trường";
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
			var metaJson= JSON.stringify(metas);
			if(error_count>0){
		       	html += "</ul>";	       	
		       	new PNotify({
					title: 'Lỗi dữ liệu ('+error_count+')',
					text: html,						    
					hide: true,
					delay: 6000,
				});
	       	}else{
				$.ajax({
					type:'POST',            
					url:'{{route("createMeta")}}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,					
						'object': object,
						'metas': metaJson,
					},
					success:function(data){
						if(data=="success"){
							$("#fields").html("");
							$("#add-groupMeta #title input, #add-groupMeta #value input").val("");							
							new PNotify({
								title: 'Thành công',
								text: 'Thêm thành công.',
								type: 'success',
								hide: true,
								delay: 2000,
							});						
						}else{
							new PNotify({
								title: 'Lỗi',
								text: 'Trình duyệt không hỗ trợ javascript.',						    
								hide: true,
								delay: 2000,
							});
						}
					}
				})
			}
			return false;
		});
	})
</script>
@stop