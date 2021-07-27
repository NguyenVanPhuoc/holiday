@php
	$meta_key = ($seo) ? $seo->key : '';
	$meta_value = ($seo) ? $seo->value : '';
	$array_tour_id = ($tour_guide->favourite_tour) ? explode(",", $tour_guide->favourite_tour) : [];
	$array_highlight_id = ($tour_guide->favourite_highlight) ? explode(",", $tour_guide->favourite_highlight) : [];
	$array_hotel_id = ($tour_guide->favourite_hotel) ? explode(",", $tour_guide->favourite_hotel) : [];
@endphp

@extends('backend.layout.index')
@section('title','Edit tour guide')
@section('content')

<div id="edit-tour-guide" class="container page route padding-bottom-200">
	<div class="head">
		<a href="{{route('tourGuidesAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All tour guide</a>
		<h1 class="title">Edit tour guide</h1>		
	</div>
	<div class="main">
		<form action="{{ route('updateTourGuideAdmin', $tour_guide->id) }}" method="post" class="dev-form activity-form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-9 content">
					<div class="form-group" id="frm-title">
						<label for="title">Name<small>(*)</small></label>
						<input type="text" name="title" class="form-control" value="{{$tour_guide->title}}" />
					</div>
					<div id="frm-slug" class="form-group">
						<label for="slug">Slug<small class="required">(*)</small></label>
						<div class="wrap">
							<span>{{$tour_guide->slug}}</span>
							<input type="text" name="slug" value="{{$tour_guide->slug}}" class="form-control hide" />
							<a href="#" class="edit-slug">Edit</a>
							<a href="#" class="btn save-slug hide">OK</a>
							<a href="#" class="cancel hide">Cancel</a>
						</div>
					</div>
					<div id="frm-metaKey" class="form-group">
						<label for="meta_key">Keyword (SEO)</label>
						<input type="text" name="meta_key" class="form-control" placeholder="Input keyword (SEO)" value="{{ $meta_key }}">
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="meta_value">Meta Description (SEO) 150-160 characters</label>
						<span class="count-characters"></span>
						<textarea name="meta_value" placeholder="Input meta description (SEO) 150-160 characters" class="form-control">{{ $meta_value }}</textarea>
					</div>
					<div id="frm-desc" class="form-group">
						<label for="desc">Description</label>
						<textarea name="desc" id="editor">{{ $tour_guide->desc }}</textarea>
					</div>
					<div id="frm-short-desc" class="form-group">
						<label for="short-desc">Short Description</label>
						<textarea name="short-desc" class="form-control">{{ $tour_guide->short_desc }}</textarea>
					</div>
					<div id="frm-text-tour" class="form-group">
						<label for="favourite-tour">Text Favourite Tours</label>
						<textarea name="favourite-tour" class="form-control">{{$tour_guide->text_tour}}</textarea>
					</div>
					<div id="frm-text-hotel" class="form-group">
						<label for="favourite-tour">Text Favourite Accommodation</label>
						<textarea name="favourite-hotel" class="form-control">{{$tour_guide->text_hotel}}</textarea>
					</div>
					<div id="frm-text-country" class="form-group">
						<label for="favourite-destination">Text Favourite Places to visit</label>
						<textarea name="favourite-destination" class="form-control">{{$tour_guide->text_highlight}}</textarea>
					</div>
					<div id="frm-favourite-tour" class="form-group">
						<label for="favourite-tour">Favourite Tours</label>
						<select multiple class="select2" name="array_favourite_tour[]" data-order="{{ $tour_guide->favourite_tour }}">
							@foreach($list_tour as $item)
								<option value="{{ $item->id }}" @if(in_array($item->id, $array_tour_id)) selected @endif>
									{{ $item->title }}
								</option>
							@endforeach
						</select>
					</div>

					<div id="frm-favourite-country" class="form-group">
						<label for="favourite-country">Favourite places to visit</label>
						<select multiple class="select2" name="array_favourite_highlight[]" data-order="{{ $tour_guide->favourite_highlight }}">
							@foreach($list_highlight as $item)
								<option value="{{ $item->id }}"  @if(in_array($item->id, $array_highlight_id)) selected @endif>
									{{ $item->country->title }}
								</option>
							@endforeach
						</select>
					</div>

					<div id="frm-favourite-hotel" class="form-group">
						<label for="favourite-tour">Favourite Accommodation</label>
						<select multiple class="select2" name="array_favourite_hotel[]" data-order="{{ $tour_guide->favourite_hotel }}">
							@foreach($list_hotel as $item)
								<option value="{{ $item->id }}"  @if(in_array($item->id, $array_hotel_id)) selected @endif>
									{{ $item->title }}
								</option>
							@endforeach
						</select>
					</div>

				</div>
				<div class="col-md-3 sidebar">
					<div class="gr-not-fixed">
						@if($list_country)
						<section id="sb-country" class="box-wrap">
							<h2 class="title">Country</h2>
							<select name="country_id">
								@foreach($list_country as $item)
									<option value="{{ $item->id }}" @if($item->id == $tour_guide->country_id) selected @endif>{{ $item->title }}</option>
								@endforeach
							</select>
						</section>
						@endif

						<section id="sb-image" class="box-wrap">
							<h2 class="title">Image</h2>
							<div id="frm-image" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image( $tour_guide->image , 150,150, $tour_guide->title)!!}
									<input type="hidden" name="image" class="thumb-media" value="{{$tour_guide->image}}" />
								</div>
							</div>
						</section>
						<section id="sb-banner" class="box-wrap">
							<h2 class="title">Banner</h2>
							<div id="frm-banner" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($tour_guide->banner, 150,150, 'Image')!!}
									<input type="hidden" name="banner" class="thumb-media" value="{{ $tour_guide->banner }}" />
								</div>
							</div>
						</section>
						
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($tour_guide->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($tour_guide->updated_at)) }}</li>
							</ul>
						</section>
					</div>
					<div class="group-fixed">
						<section id="sb-action">
							<div class="group-action">
								<a href="{{ route('deleteConsultantAdmin', ['id'=>$tour_guide->id]) }}" class="btn btn-delete">Delete</a>
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
	ckeditor("editor");
</script>
@stop