@extends('backend.layout.index')
@section('title','Categories Blog')
@section('content')
<div id="route-cats" class="container page routeCat-page">
	<div class="head">
		<h1 class="title">Categories Blog</h1>
		<a href="{{route('storeCategoryAdmin')}}" class="btn btn-add">Add new</a>
	</div>
	<div class="main row">		
		<div class="col-md-4 left-box sidebar-desc">
			<h2>Categories Blog</h2>
		</div>
		<div class="col-md-8 right-box content">
			<form id="form-routes" action="{{route('storeCategoryAdmin')}}" class="frm-menu dev-form" method="POST" name="route">
				{!!csrf_field()!!}			
				@if($categories)
				<section class="box-wrap">
					<h2 class="title">Categories Blog</h2>
					<ul class="sortable list-item">
						<?php $count = 0;?>
						@foreach($categories as $item)						
							<li class="ui-state-default" data-value="{{$item->id}}" data-position="{{ $item->position }}">
								{{$item->title}}
								<small>({{countRecoredCat($item->id)}})</small>
								<a href="{{ route('deleteCategoryAdmin', $item->id) }}" class="btn-delete">
									<i class="fa fa-trash" aria-hidden="true"></i>
								</a>
								<a href="{{route('editCategoryAdmin',['id'=>$item->id])}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
							</li>
						@endforeach
					</ul>
				</section>
				@endif
			</form>
		</div>
	</div>
</div>
@if(session('success'))
<script type="text/javascript">
	$(function(){
		new PNotify({
		    title: 'Thành công',
		    text: 'Xóa Thành công.',
		    type: 'success',
		    hide: true,
		    delay: 2000,
		});
	})
</script>
@endif
<script type="text/javascript">
	$(function() {		
		$(".sortable" ).sortable({			
		    update: function(e, ui) {
		        var count = 0;
		        var route_count = 0;
		        var routes = new Array();
		        $(".sortable .ui-state-default").each(function(){
		        	count = count + 1;
		        	$(this).attr("data-position",count);
		        	routes[route_count] = {
						'id' : $(this).attr("data-value"),						
						'position' : $(this).attr("data-position")
					}
					route_count = route_count + 1;
		        });		        	
				var routes = JSON.stringify(routes);
				var _token = $("form input[name='_token']").val();
				$.ajax({
	               	type:'POST',            
				    url:'{{route("positionCategoryAdmin")}}',
				    cache: false,
		            data:{
		                '_token': _token,
						'routes': routes
		            },
	           }).done(function(data) {
	           		if(data=="success"){
	           			new PNotify({
						    title: 'Thành công',
						    text: 'Đổi vị trí thành công.',
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
	           });
		    }
		});	
	})
</script>
@stop