@extends('backend.layout.index')
@section('title','Star rating')
@section('content')
<div id="route-cats" class="container page routeCat-page">
	<div class="head">
		<h1 class="title">Star rating</h1>
		<a href="{{ route('storeStarRatingAdmin') }}" class="btn btn-add">Add</a>
	</div>
	<div class="main row">		
		<div class="col-md-4 left-box sidebar-desc">
			<h2>Star rating</h2>
		</div>
		<div class="col-md-8 right-box">
			<form id="form-routes" action="#" class="frm-menu" method="POST" name="route">
				{!!csrf_field()!!}			
				@if($stars)
				<section class="box-wrap">
					<h2 class="title">Star rating</h2>
					<ul class="sortable list-item">
						<?php $count = 0;?>
						@foreach($stars as $item) <?php $count++;?>						
							<li class="ui-state-default" data-value="{{$item->id}}" data-position="{{$count}}">{{$item->title}}
								<small>({{countTourInCat($item->id)}})</small>
								<a href="{{ route('editStarRatingAdmin', ['slug'=>$item->slug]) }}">Edit<i class="fa fa-angle-down" aria-hidden="true"></i></a>
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
		    title: 'Successfully',
		    text: '{{session('success')}}',
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
				    url:'{{route("positionStarRatingAdmin")}}',
				    cache: false,
		            data:{
		                '_token': _token,
						'routes': routes
		            },
	           }).done(function(data) {
	           		if(data=="success"){
	           			new PNotify({
						    title: 'Successfully',
						    text: 'Change position success',
						    type: 'success',
						    hide: true,
						    delay: 2000,
						});						
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
		});	
	})
</script>
@stop