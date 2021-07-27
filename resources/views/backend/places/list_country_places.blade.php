@extends('backend.layout.index')
@section('title','Countries Places to visit')
@section('content')
<div id="route-country-blog" class="container page">
	<div class="head">
		<h1 class="title">Countries Places to visit</h1>
		<a href="{{route('storeCountryPlacesAdmin')}}" class="btn btn-add">Add new</a>
	</div>
	<div class="main row">		
		<div class="col-md-4 left-box sidebar-desc">
			<h2>Countries Places to visit</h2>
		</div>
		<div class="col-md-8 right-box content">
			<form id="form-routes" action="{{route('storeCountryPlacesAdmin')}}" class="frm-menu dev-form" method="POST" name="route">
				{!!csrf_field()!!}			
				@if($countries)
				<section class="box-wrap">
					<h2 class="title">Countries Places to visit</h2>
					<ul class="sortable list-item">
						<?php $count = 0;?>
						@foreach($countries as $item)						
							<li class="ui-state-default" data-value="{{$item->id}}" data-position="{{ $item->position }}">
								{{$item->title}}
								<small>({{countRecoredCat($item->id)}})</small>
								<a href="{{route('deleteCountryPlacesAdmin',$item->id)}}" class="btn-delete">
									<i class="fa fa-trash" aria-hidden="true"></i>
								</a>
								<a href="{{route('editCountryPlacesAdmin',$item->id)}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
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
@stop