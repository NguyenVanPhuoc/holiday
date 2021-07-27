@extends('backend.layout.index')
@section('title','Add tour guide')
@section('content')

<div id="create-tour-guide" class="container page route padding-bottom-200">
	<div class="head">
		<a href="{{route('tourGuidesAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All tour guide</a>
		<h1 class="title">Add  tour guide</h1>		
	</div>
	<div class="main">
		<form action="{{ route('createTourGuideAdmin') }}" method="post" class="dev-form activity-form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-9 content">
					<div class="form-group" id="frm-title">
						<label for="title">Name<small>(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input name" />
					</div>
					<div id="frm-metaKey" class="form-group">
						<label for="meta_key">Keyword (SEO)</label>
						<input type="text" name="meta_key" class="form-control" placeholder="Input keyword (SEO)" class="frm-input">
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="meta_value">Meta Description (SEO) 150-160 characters</label>
						<span class="count-characters"></span>
						<textarea name="meta_value" placeholder="Input meta description (SEO) 150-160 characters" class="form-control"></textarea>
					</div>
					<div id="frm-desc" class="form-group">
						<label for="desc">Description</label>
						<textarea name="desc" id="editor"></textarea>
					</div>
					<div id="frm-short-desc" class="form-group">
						<label for="short-desc">Short Description</label>
						<textarea name="short_desc" class="form-control"></textarea>
					</div>
					<div id="frm-text-tour" class="form-group">
						<label for="favourite-tour">Text Favourite Tours</label>
						<textarea name="text_tour" class="form-control"></textarea>
					</div>
					<div id="frm-text-country" class="form-group">
						<label for="favourite-destination">Text Favourite Places to visit</label>
						<textarea name="text_highlight" class="form-control"></textarea>
					</div>
					<div id="frm-text-hotel" class="form-group">
						<label for="favourite-tour">Text Favourite Accommodation</label>
						<textarea name="text_hotel" class="form-control"></textarea>
					</div>
					
					<div id="frm-favourite-tour" class="form-group">
						<label for="favourite-tour">Favourite Tours</label>
						<select multiple class="select2" name="array_favourite_tour[]">
							@foreach($list_tour as $item)
								<option value="{{ $item->id }}">{{ $item->title }}</option>
							@endforeach
						</select>
					</div>

					<div id="frm-favourite-country" class="form-group">
						<label for="favourite-country">Favourite places to visit</label>
						<select multiple class="select2" name="array_favourite_highlight[]">
							@foreach($list_highlight as $item)
								<option value="{{ $item->id }}">{{ $item->country->title }}</option>
							@endforeach
						</select>
					</div>

					<div id="frm-favourite-hotel" class="form-group">
						<label for="favourite-tour">Favourite Accommodation</label>
						<select multiple class="select2" name="array_favourite_hotel[]">
							@foreach($list_hotel as $item)
								<option value="{{ $item->id }}">{{ $item->title }}</option>
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
									<option value="{{ $item->id }}">{{ $item->title }}</option>
								@endforeach
							</select>
						</section>
						@endif

						<section id="sb-image" class="box-wrap">
							<h2 class="title">Image</h2>
							<div id="frm-image" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="image" class="thumb-media" value="" />
								</div>
							</div>
						</section>

						<section id="sb-banner" class="box-wrap">
							<h2 class="title">Banner</h2>
							<div id="frm-banner" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="banner" class="thumb-media" value="" />
								</div>
							</div>
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
	ckeditor("editor");
</script>
@stop