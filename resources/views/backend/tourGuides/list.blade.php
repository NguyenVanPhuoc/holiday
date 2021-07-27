@extends('backend.layout.index')
@section('title','Tour Guide')
@section('content')

<div id="tour-guides" class="page">
	<div class="head">
		<h1 class="title">Tour Guide</h1>	
		<a href="{{ route('storeTourGuideAdmin') }}" class="btn btn-add">Add</a>	
	</div>
	<div class="main">
		<form action="{{ route('tourGuidesAdmin') }}" method="GET" class="dev-form activity-s-form" data-delete="{{ route('deleteAllTourGuideAdmin') }}">
			{!! csrf_field() !!}
			<div class="search-filter">
				<div class="row">
					<div class="col-md-8 col-md-offset-4">
						<div class="search-form">
							<div class="row">
								<div class="col-md-6">
									<select name="country_id">
										<option value="">All country</option>
										@foreach($list_country as $item)
											<option value="{{ $item->id }}">{{ $item->title }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-6">
									<input type="text" name="s" class="form-control" placeholder="Input keyword...">
								</div>
							</div>
							<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div id="tb-result">
				@include('backend.tourGuides.table')
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

@stop