@extends('backend.layout.index')
@section('title','Add category travel tips')
@section('content')
<div id="create-cat-guide" class="container page country-page route">
	<div class="head">
		<a href="{{ route('catGuidesAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All category travel tips</a>
		<h1 class="title">Add category travel tips</h1>		
	</div>	
	<div class="main">
		<form action="{{route('createCatGuideAdmin')}}" class="frm-menu dev-form activity-form" method="POST" role="form">
			{!!csrf_field()!!}
			<input type="hidden" name="post_type" value="travel_tip">
			<div class="row">
				<div class="col-md-9 content">
					<div id="frm-title" class="form-group">
						<label for="title">Title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" class="frm-input">
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label class="title">White icon</label>
							<div id="frm-white-icon" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="white_icon" class="thumb-media" value="" />
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<label class="title">Green icon</label>
							<div id="frm-green-icon" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="green_icon" class="thumb-media" value="" />
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<label class="title">Gray icon</label>
							<div id="frm-gray-icon" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="gray_icon" class="thumb-media" value="" />
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<label class="title">Feature Image</label>
							<div id="frm-feature" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 250,150, 'Image')!!}
									<input type="hidden" name="feature_image" class="thumb-media" value="" />
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<div class="col-md-3 sidebar">
					<div class="gr-not-fixed"></div>
					<div class="group-fixed">
						<div class="group-action">
							<button type="submit" name="submit" class="btn">Save</button>
							<a href="{{route('catGuidesAdmin')}}" class="btn btn-cancel">Cancel</a>									
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