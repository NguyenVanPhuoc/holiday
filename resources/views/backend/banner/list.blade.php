@extends('backend.layout.index')
@section('title','Manage banners')
@section('content')
@php
	$post_type = $list_postType[0]['type']; 
@endphp
<div id="banners" class="page">
	<div class="head">
		<h1 class="title">Manage banners</h1>		
	</div>
	<div class="main">
		<form action="{{ route('postbannerAdmin') }}" method="post" class="dev-form list-banners">
			{!!csrf_field()!!}
			
			<div class="row">
				<div class="col-md-4">
					<fieldset class="form-group m-b-20">
						<select id="chose-post-type" class="form-control" data-action="{{ route('changePostBannerAdmin') }}">
							@foreach($list_postType as $item)
								<option value="{{ $item['type'] }}">{{ $item['name'] }}</option>
							@endforeach
						</select>
					</fieldset>
				</div>
			</div>
			<div class="group-country">
				@include('backend.banner.group_country_layout')
			</div>
			<button type="submit" class="btn btn-primary waves-effect waves-light m-t-20">Save</button>
		</form>
	</div>
</div>
@include('backend.media.library')
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
	
	});	
</script>
@stop