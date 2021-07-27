@extends('backend.layout.index')
@section('title','Add icon attraction')
@section('content')
<div id="create-iconSchedule" class="container page news-page route">
	<div class="head">
		<a href="{{route('iconsAttractionAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> List icon attraction</a>
		<h1 class="title">Add icon attraction</h1>		
	</div>	
	<div class="main">
		<form action="{{route('createIconAdmin')}}" class="frm-menu dev-form activity-form" method="POST" role="form">
			{!!csrf_field()!!}
			<input type="hidden" name="type" value="attraction">
			<input type="hidden" name="url_return" value="{{ route('storeIconAttractionAdmin') }}">
			<div class="row">
				<div class="col-md-9 content">
					<div id="frm-title" class="form-group">
						<label for="title">Title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" class="frm-input">
					</div>
					<div class="row">	
						<div class="col-md-4">
							<div id="frm-yellow-icon" class="form-group img-upload">
								<label>Pink Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Pink Icon')!!}
									<input type="hidden" name="pink_icon" class="thumb-media" value="" />
								</div>
							</div>
						</div>
					</div>				
				</div>
				<div class="col-md-3 sidebar">
					<div class="gr-not-fixed"></div>
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
@stop