@extends('backend.layout.index')
@section('title','Edit Place to visit')
@section('content')

@php
	$arrayEditor = array();
	$list_fact = json_decode($highlight->fact);
	$gallery = json_decode($highlight->gallery);
	$how_to_get = json_decode($highlight->how_to_get);
	$where_eat = json_decode($highlight->where_eat);
	$things_to_do = explode(",", $highlight->things_to_do);
@endphp

<div id="create-highlight" class="page route">
	<div class="head">
		<a href="{{ route('highlightsAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All Places to visit</a>
		<h1 class="title">Edit Place to visit</h1>		
	</div>
	<div class="main">
		<form action="{{ route('updateHighlightAdmin', $city->slug) }}" method="post" class="dev-form create-guide activity-form form-add ">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="title">City</label>
								<input type="hidden" name="country_id" value="{{ $city->id }}">
								<input type="text" class="form-control" value="{{ $city->title }}" readonly>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="title">Text map</label>
						<textarea class="form-control" name="text_map">{{ $highlight->text_map }}</textarea>
					</div>
					<div id="frm-gallery" class="form-group img-upload">
						<label for="content">Gallery</label>
						<div class="wrap-gallery">
							@if($gallery)
								@foreach($gallery as $value)
									@php $image = getMedia($value); @endphp
									<div class="gallery-item item-{{$value}}" data-id="{{$value}}" >
										<div class="wrap-item">
											{!! imageAuto($value, $highlight->title) !!}
											<span class="remove-gallery">x</span>
										</div>
									</div>
								@endforeach
							@endif
						</div>
						<div class="bot-wrap">
							<a href="{{ route('loadMedia') }}" class="btn btn-default library-gallery">Add to gallery</a>
							<input type="hidden" name="gallery" class="thumb-media" value="{{ $highlight->gallery }}">
						</div>
					</div>
					<div class="form-group">
						<label for="title">Text attraction section</label>
						<textarea class="form-control" name="text_attraction_sec">{{ $highlight->text_attraction_sec }}</textarea>
					</div>
					<div class="form-group">
						<label for="title">Text accommodation section</label>
						<textarea class="form-control" name="text_hotel_sec">{{ $highlight->text_hotel_sec }}</textarea>
					</div>
					<div class="form-group">
						<label for="title">Select things to do</label>
						<select multiple="multiple" name="list_thingToDo[]" class="form-control select2">
                            @foreach ($list_thingToDo as $item)
                                <option value="{{ $item->id }}" @if(in_array($item->id, $things_to_do)) selected @endif> {{ $item->title }} </option>
                            @endforeach
                        </select>
					</div>
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($highlight->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($highlight->updated_at)) }}</li>
							</ul>
						</section>
					</div>
					<div class="group-fixed">
						<section id="sb-action">
							<div class="group-action">
								<button type="submit" name="submit" class="btn">Save</button>
								<a href="#" class="btn btn-cancel">Cancel</a>									
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
	
	@php
		foreach ($arrayEditor as $key => $value) {
			@endphp
				ckeditor('{{$value}}');
			@php
		}
	@endphp
</script>
@stop