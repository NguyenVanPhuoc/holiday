@section('js')
	<script src="{{asset('public/admin/js/form-pickers.js')}}" type="text/javascript"></script>
@endsection
@extends('backend.layout.index')
@section('title','Add review')
@section('content')
<div id="create-review" class="container page route">
	<div class="head">
		<a href="{{route('reviewsAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All reviews</a>
		<h1 class="title">Add review</h1>		
	</div>
	<form id="add-review" action="{{ route('createReviewAdmin') }}" method="post" class="dev-form add-form activity-form" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{csrf_token()}}"/>
		<div class="row">
			<div class="col-md-9 content">
				<div id="frm-title" class="form-group">
					<label for="name">Name<small>(*)</small></label>
					<input type="text" name="name" class="form-control title" value="{{old('name')}}" />		
				</div>
				<div id="frm-title" class="form-group">
					<label for="title">Title<small>(*)</small></label>
					<input type="text" name="title" class="form-control title" value="{{old('title')}}" />		
				</div>
				<div id="frm-title-tag" class="form-group">
					<label for="title_tag">Title tag (SEO title) 65-70 characters</label>
					<span class="count-characters"></span>
					<input type="text" name="title_tag" class="form-control" placeholder="Title tag (SEO title) 65-70 characters" class="frm-input">
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
				<div class="row">
					<div class="col-md-6">
						<div class="form-group date-picker">
							<label>From date</label>
							<input type="text" name="from_date">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group date-picker">
							<label>To date</label>
							<input type="text" name="to_date">
						</div>
					</div>
				</div>
				<div id="frm-editor" class="form-group">
					<label for="name">Content</label>
					<textarea name="content" id="editor"></textarea>
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
					<label>List city</label>
					@if($list_city)
					<select multiple="multiple" name="list_city[]" class="select2">
						@foreach($list_city as $item)
							<option value="{{ $item->id }}">{{ $item->title }}</option>
						@endforeach
					</select>
					@endif
				</div>
				
			</div>
			<div class="col-md-3 sidebar">
				<div class="gr-not-fixed">
					<section id="sb-group-type" class="box-wrap">
						<h2 class="title">Group type</h2>
						<div class="desc list">
                            @if($list_groupType)
                                <select name="group_type_id">
                                	<option value="">Chose group type</option>
                                    @foreach($list_groupType as $item)
                                    	<option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            @endif
						</div>
					</section>
					<section id="sb-destionation" class="box-wrap">
						<h2 class="title">Destination</h2>
						<div class="desc list">
                            @if($list_destination)
                                <ul class="no-list-style list-item">
                                    @foreach($list_destination as $item)
                                    <li class="checkbox checkbox-success">
                                    	<input value="{{$item->id}}" type="checkbox" name="list_destination[]" id="cat-{{$item->id}}">
                                    	<label for="cat-{{$item->id}}">{{$item->title}}</label>
                                    </li>
                                    @endforeach
                                </ul>
                            @endif
						</div>
					</section>

					<section id="sb-destionation" class="box-wrap">
						<h2 class="title">Tour Style</h2>
						<div class="desc list">
                            @if($list_tourStyle)
                                <ul class="no-list-style list-item">
                                    @foreach($list_tourStyle as $item)
                                    <li class="checkbox checkbox-success">
                                    	<input value="{{$item->id}}" type="checkbox" name="list_tour_style[]" id="cat-{{$item->id}}">
                                    	<label for="cat-{{$item->id}}">{{$item->title}}</label>
                                    </li>
                                    @endforeach
                                </ul>
                            @endif
						</div>
					</section>

					<section id="sb-image" class="box-wrap">
						<h2 class="title">Image</h2>
						<div id="frm-image" class="desc img-upload">
							<div class="image">
								<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
								{!!image('', 150,150, 'cmnd mat truoc')!!}
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
					<section id="sb-image-looking" class="box-wrap">
						<h2 class="title">Image Looking</h2>
						<div id="frm-image-looking" class="desc img-upload">							
							<div class="image">
								<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
								{!!image('', 150,150, 'Image')!!}
								<input type="hidden" name="image_looking" class="thumb-media" value="" />
							</div>
						</div>
					</section>
					<section id="sb-image-request" class="box-wrap">
						<h2 class="title">Image Request</h2>
						<div id="frm-image-request" class="desc img-upload">							
							<div class="image">
								<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
								{!!image('', 150,150, 'Image')!!}
								<input type="hidden" name="image_request" class="thumb-media" value="" />
							</div>
						</div>
					</section>
				</div>
				<div class="group-fixed">
					<div class="group-action">
						<button type="submit" name="submit" class="btn">Save</button>
						<a href="{{route('reviewsAdmin')}}" class="btn btn-cancel">Cancel</a>									
					</div>
				</div>
			</div>
		</div>
		<div class="group-action">
		</div>
	</form>
</div>
@include('backend.media.library')
<script type="text/javascript">
	ckeditor("editor");
</script>
@stop