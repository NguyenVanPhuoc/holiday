@extends('backend.layout.index')
@section('title','Categories FAQs')
@section('content')
<div id="route-cats" class="container page routeCat-page">
	<div class="head">
		<h1 class="title">Categories FAQs</h1>
		<a href="{{route('storeCategoryFaqAdmin')}}" class="btn btn-add">Add new</a>
	</div>
	<div class="main row">		
		<div class="col-md-4 left-box sidebar-desc">
			<h2>Categories FAQs</h2>
		</div>
		<div class="col-md-8 right-box content">
			<form id="form-routes" action="{{route('storeCategoryAdmin')}}" class="frm-menu dev-form activity-s-form" method="POST" name="route">
				{!!csrf_field()!!}			
				@if($list_cat)
				<section class="box-wrap">
					<h2 class="title">Categories FAQs</h2>
					<ul class="sortable list-item">
						<?php $count = 0;?>
						@foreach($list_cat as $item)						
							<li class="ui-state-default" data-value="{{$item->id}}" data-position="{{ $item->position }}">
								{{$item->title}}
								<small></small>
								<a href="{{ route('deleteCategoryFaqAdmin', $item->id) }}" class="btn-delete">
									<i class="fa fa-trash" aria-hidden="true"></i>
								</a>
								<a href="{{route('editCategoryFaqAdmin', $item->id)}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
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
		    title: 'Success',
		    text: '{{ session('success') }}',
		    type: 'success',
		    hide: true,
		    delay: 2000,
		});
	})
</script>
@endif
@stop