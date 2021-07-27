@extends('backend.layout.index')
@section('title','Categories guide')
@section('content')
	<div id="catGuides" class="page productCats-page product-page">
		<div class="head container">
			<h1 class="title">Categories travel tip</h1>
			<a href="{{ route('storeCatGuideAdmin') }}" class="btn btn-add">Add new</a>
		</div>	
		<div class="main container">
			<form action="{{ route('catThingsToDoAdmin') }}" method="GET" class="dev-form activity-s-form" data-delete="{{ route('deleteAllCatGuideAdmin') }}">
				{{ csrf_field() }}
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
					@include('backend.catGuides.table')
				</div>
			</form>
		</div>
	</div>
	

	@if(session('success'))
		<script type="text/javascript">
			$(function(){
				new PNotify({
					title: 'Successfully',
					text: '{{ session('success') }}',
					type: 'success',
					hide: true,
					delay: 2000,
				});
			})
		</script>
	@endif
@endsection
