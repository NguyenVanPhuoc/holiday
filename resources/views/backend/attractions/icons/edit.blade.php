@extends('backend.layout.index')
@section('title','Edit icon attraction')
@section('content')
<div id="create-iconSchedule" class="container page news-page route">
	<div class="head">
		<a href="{{route('iconsAttractionAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> List icon attraction</a>
		<h1 class="title">Edit icon attraction</h1>	
		<a href="{{ route('storeIconAttractionAdmin') }}" class="btn btn-add">Add</a>	
	</div>	
	<div class="main">
		<form action="{{route('updateIconAdmin', $icon->id)}}" class="frm-menu dev-form activity-form" method="POST" role="form">
			{!!csrf_field()!!}
			<input type="hidden" name="url_return" value="{{ route('editIconAttractionAdmin', $icon->id) }}">
			<div class="row">
				<div class="col-md-9 content">
					<div id="frm-title" class="form-group">
						<label for="title">Title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" class="frm-input" value="{{ $icon->title }}">
					</div>
					<div class="row">	
						<div class="col-md-4">
							<div id="frm-yellow-icon" class="form-group img-upload">
								<label>Pink Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($icon->pink_icon, 150,150, 'Pink Icon')!!}
									<input type="hidden" name="pink_icon" class="thumb-media" value="{{ $icon->pink_icon }}" />
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