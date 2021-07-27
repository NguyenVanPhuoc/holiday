@extends('backend.layout.index')
@section('title','Edit Nationality')
@section('content')

<div id="create-cat-guide" class="container page country-page route">
	<div class="head">
		<a href="{{ route('Nationality') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All Nationality</a>
		<h1 class="title">Edit Nationality</h1>		
	</div>	
	<div class="main">
		<form action="{{route('updateNationalityAdmin', $cat_guide->slug)}}" class="frm-menu dev-form activity-form" method="POST" role="form">
			{!!csrf_field()!!}
			<input type="hidden" name="post_type" value="market">
			<div class="row">
				<div class="col-md-9 content">
					<div id="frm-title" class="form-group">
						<label for="title">Title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" class="frm-input" value="{{ $cat_guide->title }}">
					</div>
					<div id="frm-slug" class="form-group">
						<label for="slug">Slug<small class="required">(*)</small></label>
						<div class="wrap">
							<span>{{$cat_guide->slug}}</span>
							<input type="text" name="slug" value="{{$cat_guide->slug}}" class="form-control hide" />
							<a href="#" class="edit-slug">Edit</a>
							<a href="#" class="btn save-slug hide">OK</a>
							<a href="#" class="cancel hide">Cancel</a>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label class="title">White icon</label>
							<div id="frm-white-icon" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($cat_guide->white_icon , 150,150, 'Image')!!}
									<input type="hidden" name="white_icon" class="thumb-media" value="{{ $cat_guide->white_icon }}" />
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<label class="title">Green icon</label>
							<div id="frm-green-icon" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($cat_guide->green_icon, 150,150, 'Image')!!}
									<input type="hidden" name="green_icon" class="thumb-media" value="{{ $cat_guide->green_icon }}" />
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<label class="title">Gray icon</label>
							<div id="frm-gray-icon" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($cat_guide->gray_icon, 150,150, 'Image')!!}
									<input type="hidden" name="gray_icon" class="thumb-media" value="{{ $cat_guide->gray_icon }}" />
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<label class="title">Feature Image</label>
							<div id="frm-feature" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($cat_guide->feature_image, 250,150, 'Image')!!}
									<input type="hidden" name="feature_image" class="thumb-media" value="{{ $cat_guide->feature_image }}" />
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<div class="col-md-3 sidebar">
					<div class="gr-not-fixed">
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($cat_guide->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($cat_guide->updated_at)) }}</li>
							</ul>
						</section>
					</div>
					<div class="group-fixed">
						<div class="group-action">
							<button type="submit" name="submit" class="btn">Save</button>
							<a href="{{route('Nationality')}}" class="btn btn-cancel">Cancel</a>									
						</div>
					</div>
				</div>
			</div>			
		</form>	
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">

</script>
@endsection