@extends('backend.layout.index')
@section('title','Country')
@section('content')

@php
	$parent_id = isset($parent_id)? $parent_id : '';
	$parentTitle  = '-- Choose Parent --';
	if($parent_id != ''){
		if($parent_id == 0) 
			$parentTitle = 'None';
		else
			$parentTitle = getCountryById($parent_id)->title;
	}
	$keyword = isset($s)? $s:'';
@endphp

<div id="countries" class="page countries-page">
	<div class="head container">
		<h1 class="title">Country</h1>		
	</div>	
	<div class="main">
		<!-- <div class="search-form">
			<form name="s" action="{{route('searchCountryAdmin')}}" method="GET">
			<div class="row">
				<div id="frm-parent" class="col-md-6">
					<fieldset>
						<select class="form-control select2" name="parent_id">
							<option value="">Choose parent</option>
							{!! getListOptionParentCountry(0, 0, true) !!}
						</select>
					</fieldset>	
				</div>
				<div id="frm-keyword" class="col-md-6"><input type="text" name="s" class="form-control" placeholder="Input key word..." value="{{$keyword}}"></div>
			</div>
			<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
		</form>
				</div>  -->
		<form action="{{ route('countryAdmin') }}" method="GET" class="dev-form activity-s-form" data-delete="{{ route('deleteAllCountry') }}">
			{!!csrf_field()!!}
			<div class="search-filter">
				<div class="row">
					<div class="col-md-6 col-md-offset-6">
						<div class="search-form">
							<div class="row">
								<div class="col-md-6">
									<div class="s-country">
										<select class="form-control select2" name="parent_id">
											<option value="">All parent</option>
											{!! getListOptionParentCountry(0, 0, true) !!}
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
				@include('backend.countries.table')
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

<script type="text/javascript">
</script>

@stop