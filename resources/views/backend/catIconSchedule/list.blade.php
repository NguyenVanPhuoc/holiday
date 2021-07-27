@extends('backend.layout.index')
@section('title','Categories Icons Schedule')
@section('content')
<div id="route-cats" class="container page routeCat-page">
	<div class="head">
		<h1 class="title">Categories Icons Schedule</h1>
		<a href="{{route('storeCatIconSchedules')}}" class="btn btn-add">Add</a>
	</div>
	<div class="main row">		
		<div class="col-md-4 left-box sidebar-desc">
			<h2>Categories Icons Schedule</h2>
			<!-- <div class="desc">
				<p>Danh sách blog sẽ giúp bạn duyệt web của bạn dễ dàng hơn.</p>
			</div> -->
		</div>
		<div class="col-md-8 right-box">
			<form id="form-routes" action="#" class="frm-menu" method="POST" name="route">
				{!!csrf_field()!!}			
				@if($catIcon)
				<section class="box-wrap">
					<h2 class="title">Categories Icons Schedule</h2>
					<ul class="sortable list-item">
						<?php $count = 0;?>
						@foreach($catIcon as $item) <?php $count++;?>						
							<li class="ui-state-default" data-value="{{$item->id}}" data-position="{{$count}}">{{$item->title}}
								<a href="{{route('editCatIconSchedules', ['id'=>$item->id])}}">Edit<i class="fa fa-angle-down" aria-hidden="true"></i></a></li>
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
		    text: 'Successfully deleted',
		    type: 'success',
		    hide: true,
		    delay: 2000,
		});
	})
</script>
@endif
<script type="text/javascript">
	$(function() {		
		
	})
</script>
@stop