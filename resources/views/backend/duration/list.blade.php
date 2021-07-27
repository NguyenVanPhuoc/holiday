@extends('backend.layout.index')
@section('title','Duration')
@section('content')
<div id="route-durations" class="container page routeCat-page">
	<div class="head">
		<h1 class="title">Duration</h1>
		<a href="{{route('storeDurationAdmin')}}" class="btn btn-add">Thêm</a>
	</div>
	<div class="main row">		
		<div class="col-md-4 left-box sidebar-desc">
			<h2>Duration</h2>
			<!-- <div class="desc">
				<p>Danh sách blog sẽ giúp bạn duyệt web của bạn dễ dàng hơn.</p>
			</div> -->
		</div>
		<div class="col-md-8 right-box">
			<form id="form-routes" action="{{route('storeDurationAdmin')}}" class="frm-menu" method="POST" name="route">
				{!!csrf_field()!!}			
				@if($durations)
				<section class="box-wrap">
					<h2 class="title">Duration</h2>
					<ul class="sortable list-item">
						<?php $count = 0;?>
						@foreach($durations as $item) <?php $count++;?>						
							<li class="ui-state-default" data-value="{{$item->id}}" data-position="{{$count}}">{{$item->title}}<small>({{countTourInDuration($item->id)}})</small><a href="{{route('editDurationAdmin', ['slug'=>$item->slug])}}">Sửa<i class="fa fa-angle-down" aria-hidden="true"></i></a></li>
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
				    url:'{{route("positionDurationAdmin")}}',
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