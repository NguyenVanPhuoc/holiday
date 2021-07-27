@extends('backend.layout.index')
@section('title','Overviews')
@section('content')
@php
	$keyword = isset($_GET['s']) ? $_GET['s'] : '';
@endphp
<div id="overviews" class="page highlights-page container">
	<div class="head ">
		<h1 class="title">Overviews</h1>		
	</div>	
	<div class="main">
		<form action="{{ route('overviewsAdmin') }}" method="GET" class="dev-form activity-s-form" data-delete="{{ route('deleteAllOverviewAdmin') }}">
			{!!csrf_field()!!}
			<div id="tb-result">
				@include('backend.overviews.table')
			</div>
		</form>
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

@stop