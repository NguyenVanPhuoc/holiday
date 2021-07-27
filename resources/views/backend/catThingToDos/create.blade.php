@extends('backend.layout.index')
@section('title','Add category thing to do')
@section('content')
<div id="create-cat-guide" class="container page country-page route">
	<div class="head">
		<a href="{{ route('catThingsToDoAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All category thing to do</a>
		<h1 class="title">Add category thing to do</h1>		
	</div>	
	<div class="main">
		<form action="{{route('createCatThingToDoAdmin')}}" class="frm-menu dev-form activity-form" method="POST" role="form">
			{!!csrf_field()!!}
			<input type="hidden" name="post_type" value="thing_to_do">
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
							<label class="title">Yellow icon</label>
							<div id="frm-green-icon" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="yellow_icon" class="thumb-media" value="" />
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
					</div>
					
				</div>
				<div class="col-md-3 sidebar">
					<div class="gr-not-fixed"></div>
					<div class="group-fixed">
						<div class="group-action">
							<button type="submit" name="submit" class="btn">Save</button>
							<a href="{{route('catThingsToDoAdmin')}}" class="btn btn-cancel">Cancel</a>									
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