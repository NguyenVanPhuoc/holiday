@extends('backend.layout.index')
@section('title','FAQs')
@section('content')

<div id="blogger" class="page">
	<div class="head">
		<h1 class="title">FAQs</h1>	
		<a href="{{ route('storeFaqAdmin') }}" class="btn btn-add">Add</a>	
	</div>
	<div class="main">
		<form action="{{ route('faqsAdmin') }}" method="GET" class="dev-form activity-s-form" data-delete="{{ route('deleteAllFaqAdmin') }}">
			{!!csrf_field()!!}
			<div class="search-filter">
				<div class="row">
					<div class="col-md-8 col-md-offset-4">
						<div class="search-form">
							<div class="row">
								<div class="col-md-6">
									<select name="cat_id">
										<option value="">Select category</option>
										@foreach($list_cat as $cat)
											<option value="{{ $cat->id }}">{{ $cat->title }}</option>
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
				@include('backend.faqs.table')
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