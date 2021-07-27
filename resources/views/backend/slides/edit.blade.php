@extends('backend.layout.index')
@section('title','Sửa slide')
@section('content')
<div id="edit-slide" class="container page menu-page slides">
	<div class="head">
		<a href="{{route('slidesAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Slides</a>
		<h1 class="title">{{$slide->title}}</h1>		
	</div>
	<div class="main">
		<form id="create-slide" action="{{route('updateSlideAdmin',['id'=>$slide->id])}}" class="frm-menu dev-form" method="POST" name="editSlide" role="form"/>
			{!!csrf_field()!!}
			<div class="row">				
				<div class="col-md-12 left-box">			
					<section class="box-wrap box-title">
						<h2 class="title">Tên</h2>
						<input type="text" name="title" placeholder="Nhập tên slide..." value="{{$slide->title}}" class="mn-title frm-input">
					</section>
					<section class="box-wrap mn-link">
						<h2 class="title">Hàng</h2>
						<div class="list">
							@if(empty(getSlideDetail($slide->id))))
								<p class="empty">Slide này chưa có hàng nào.</p>	
							@else
								<?php $count = 0;?>
								<?php $metas = getSlideDetail($slide->id);?>
								<ul class="sortable" data-recores="{{count($metas)}}">
								@foreach($metas as $item)<?php $count++;?>
								<li id="{{$item->id}}" class="ui-state-default item-{{$count}} old" data-position="{{$count}}">
									<div class="link-title row">
										<div class="col-md-10 frm-text">
											<textarea rows="3" type="text" name="contents[]" placeholder="Nhập nội dung" class="frm-input">{!!$item->content!!}</textarea>
										</div>
										<div id="image-{{$item->id}}" class="col-md-2 img-upload">
											<div class="image">
												<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>{!!image($item->image,150,150,"image")!!}
												<input type="hidden" name="image" class="thumb-media" value="{{$item->image}}" />
											</div>
										</div>
									</div>
									<i class="fa fa-trash" aria-hidden="true"></i>
								</li>
								@endforeach							
								</ul>
							@endif
						</div>
						<button class="btn-add"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm hàng</button>
					</section>
				</div>
			</div>
			<div class="group-action">
				<a href="{{route('deleteSlideAdmin',['id'=>$slide->id])}}" class="btn btn-delete">Xóa</a>
				<a href="{{route('slidesAdmin')}}" class="btn btn-cancel">Hủy</a>
				<button type="submit" name="submit" class="btn">Lưu</button>			
			</div>
		</form>			
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">
	$(function() {		
		$(".sortable" ).sortable({			
		    update: function(e, ui) {
		        var count = 0;
		        $(".sortable .ui-state-default").each(function(){
		        	count = count + 1;
		        	$(this).attr("data-position",count);
		        });
		    }
		});	
		//add recore		
		$(".menu-page").on('click','.btn-add',function(){
			$("#add-slide-page .left-box .list .empty").remove();
			var recores = $(".mn-link .list .sortable").attr("data-recores");
			number = parseInt(recores) + 1;
			$(this).parents(".box-wrap").find(".sortable").attr("data-recores",number);
			var html = '<li class="ui-state-default item-'+number+' new" data-position="'+number+'">';
					html = html + '<div class="link-title row">';
					html = html + '<div class="col-md-10 frm-text"><textarea rows=3 type="text" name="contents[]" placeholder="Nhập nội dung" class="frm-input" /></div>';
					html = html + '<div id="image-'+number+'" class="col-md-2 img-upload""><div class="image"><a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>{!!image("",150,150,"image")!!}<input type="hidden" name="image" class="thumb-media" value="" /></div></div>';
					html = html + '</div>';
					html = html + '<i class="fa fa-trash" aria-hidden="true"></i>';
				html = html + '</li>';
				$(".list .sortable").append(html);
			return false;
		});
		var delItems = new Array();
		$(".sortable").on('click','i.fa-trash',function(){
			var item_id = $(this).parents(".ui-state-default").attr("id");
			delItems.push(item_id);
			$(this).parents(".ui-state-default").remove();
		 	var count = 0;
	        $(".sortable .ui-state-default").each(function(){
	        	count = count + 1;
	        	$(this).attr("data-position",count);
	        });
		});
       //create menu
       $(".menu-page").on('click','.frm-menu .group-action button',function(){
			var _token = $(".frm-menu input[name='_token']").val();
			var title = $(".frm-menu .box-title input").val();
           	var new_metas = new Array();
			var new_count = 0;
			var old_metas = new Array();
			var old_count = 0;
			var errors = new Array();
			var error_count = 0;
			var error_record = 0;
			$(".menu-page .list .sortable .ui-state-default").each(function(){
				var text = $(this).find(".frm-text textarea").val();
				var image = $(this).find(".img-upload .thumb-media").val();
				if(image != ""){
					if($(this).hasClass('old')){
						old_metas[old_count] = {
							'meta_id' : $(this).attr("id"),
							'text' : text,
							'image' : image,
							'position' : $(this).attr("data-position")
						}
						old_count = old_count + 1;
					}else{
						new_metas[new_count] = {
							'text' : text,
							'image' : image,
							'position' : $(this).attr("data-position")
						}
						new_count = new_count + 1;
					}
				}else{
					error_record = 1;
				}				
			});
			if(title==""){
	       		errors[0] = "Vui lòng nhập tiêu đề";
	       	}else{
				errors[0] = "";
	       	}
	       	if(error_record==1){
	       		errors[1] = "Một hoặc nhiều hàng chưa chọn hình ảnh!";
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
					title: 'Lỗi dữ liệu ('+error_count+')',
					text: html,						    
					hide: true,
					delay: 6000,
				});
	       	}else{
	           $.ajax({
	               	type:'POST',            
				    url:'{{ route("updateSlideAdmin",["id"=>$slide->id]) }}',
				    cache: false,
		            data:{
		                '_token': _token,
						'title':title,
						'new_metas': JSON.stringify(new_metas),
						'old_metas': JSON.stringify(old_metas),
						'delItems': JSON.stringify(delItems)
		            },
	           }).done(function(data) {           			
	           		new PNotify({
					    title: 'Thành công',
					    text: 'Sửa slide thành công.',
					    type: 'success',
					    hide: true,
					    delay: 2000,
					});
	           });
	       }
           return false;
		});
       //delete location
      	$(".frm-menu .btn-delete").click(function(){
      		var href = $(this).attr("href");
      		(new PNotify({
			    title: 'Xóa',
			    text: 'Bạn muốn slide này?',
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
	});	
</script>
@stop