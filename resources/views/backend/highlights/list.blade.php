@extends('backend.layout.index')
@section('title','Places to visit')
@section('content')
@php
	$keyword = isset($_GET['s']) ? $_GET['s'] : '';
@endphp
<div id="highlights" class="page highlights-page container">
	<div class="head">
		<h1 class="title">Places to visit</h1>		
	</div>	
	<div class="main">
		<form action="{{ route('highlightsAdmin') }}" method="GET" class="dev-form activity-s-form" data-delete="{{ route('deleteAllHighlightAdmin') }}">
			{!!csrf_field()!!}
			<div class="search-filter">
				<div class="row">
					<div class="col-md-6 col-md-offset-6">
						<div class="search-form">
							<div class="s-key">
								<input type="text" name="s" class="form-control s-key" placeholder="Input keyword..." value="">
							</div>
							<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div id="tb-result">
				@include('backend.highlights.table')
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