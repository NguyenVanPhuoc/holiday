@extends('backend.layout.index')
@section('title','Accommodation')
@section('content')
<div id="hotels" class="page">
	<div class="head">
		<h1 class="title">Accommodation</h1>		
	</div>
	<div class="main">
		<form action="{{ route('hotelsAdmin') }}" method="GET" class="dev-form activity-s-form" data-delete="{{ route('deleteAllHotelAdmin') }}">
			{!!csrf_field()!!}
			<div class="search-filter">
				<div class="row">
					<div class="col-md-6 col-md-offset-6">
						<div class="search-form">
							<div class="row">
								<div class="col-md-6">
									<select name="country_id" class="select2 form-control">
										<option value="">-- City --</option>
										@foreach($list_city as $city)
											<option value="{{ $city->id }}">{{ $city->title }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-6">
									<input type="text" name="s" class="form-control s-key" placeholder="Input keyword..." value="">
								</div>
							</div>
							<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div id="tb-result">
				@include('backend.hotels.table')
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