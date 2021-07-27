@extends('backend.layout.index')
@section('title','Guides')
@section('content')
@php
	$countries = getCountryLevel1();
@endphp
<div id="guides" class="page">
	<div class="head">
		<h1 class="title">Guides</h1>		
	</div>
	<div class="main">
		<form action="{{ route('guidesAdmin') }}" method="GET" class="dev-form activity-s-form" data-delete="{{ route('deleteAllGuideAdmin') }}">
			{!!csrf_field()!!}
			<div class="search-filter">
				<div class="row">
					<div class="col-md-6 col-md-offset-6">
						<div class="search-form">
							<div class="row">
								<div class="col-md-6">
									<div class="s-country">
										<select name="country_id">
											<option value="">All country</option>
											@foreach($countries as $country)
												<option value="{{ $country->id }}">{{ $country->title }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="s-key">
										<input type="text" name="s" class="form-control s-key" placeholder="Input keyword..." value="">
									</div>
								</div>
							</div>
							<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div id="tb-result">
				@include('backend.guides.table')
			</div>
		</form>
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
	//delete location
	
});	
</script>
@stop