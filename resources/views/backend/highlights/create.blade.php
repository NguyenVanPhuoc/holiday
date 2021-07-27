@extends('backend.layout.index')
@section('title','Add Place to visit')
@section('content')
@php
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
@endphp
<div id="create-highlight" class="page route">
	<div class="head">
		<a href="{{ route('highlightsAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All Places to visit</a>
		<h1 class="title">Add Place to visit</h1>		
	</div>
	<div class="main">
		<form action="{{ route('createHighlightAdmin') }}" method="post" class="dev-form create-guide activity-form form-add ">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="title">Choose place to visit<small>(*)</small></label>
								<select class="select2" name="country_id">
									<option value="">Choose place to visit</option>
									@foreach($list_city as $city)
										<option value="{{ $city->id }}" @if($city->id == $country_id) selected @endif>{{ $city->title }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="title">Text map</label>
						<textarea class="form-control" name="text_map"></textarea>
					</div>
					<div id="frm-gallery" class="form-group img-upload">
						<label for="content">Gallery</label>
						<div class="wrap-gallery"></div>
						<div class="bot-wrap">
							<a href="{{ route('loadMedia') }}" class="btn btn-default library-gallery">Add to gallery</a>
							<input type="hidden" name="gallery" class="thumb-media" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="title">Text attraction section</label>
						<textarea class="form-control" name="text_attraction_sec"></textarea>
					</div>
					<div class="form-group">
						<label for="title">Text accommodation section</label>
						<textarea class="form-control" name="text_hotel_sec"></textarea>
					</div>
					<div class="form-group">
						<label for="title">Select things to do</label>
						<select multiple="multiple" name="list_thingToDo[]" class="form-control select2">
                            @foreach ($list_thingToDo as $item)
                                <option value="{{ $item->id }}"> {{ $item->title }} </option>
                            @endforeach
                        </select>
					</div>
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed"></div>
					<div class="group-fixed">
						<section id="sb-action">
							<div class="group-action">
								<button type="submit" name="submit" class="btn">Save</button>
								<a href="{{ route('highlightsAdmin') }}" class="btn btn-cancel">Cancel</a>									
							</div>
						</section>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">
	
</script>
@stop