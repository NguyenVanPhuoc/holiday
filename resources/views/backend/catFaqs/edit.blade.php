@extends('backend.layout.index')
@section('title','Edit category faqs')
@section('content')
<div id="edit-category" class="container page route">
	<div class="head">
		<a href="{{route('catFaqsAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Category FAQs</a>
		<h1 class="title">Edit category faqs</h1>		
	</div>
	<div class="main">
		<div class="row">
			
			<form action="{{route('editCategoryFaqAdmin', $catFaq->id)}}" class="frm-menu dev-form activity-form" method="POST" name="create_category" role="form">
				{!!csrf_field()!!}
				<div class="col-md-9">
					<div id="frm-title" class="form-group">
						<label for="title">Input title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" value="{{ $catFaq->title }}" class="frm-input">
					</div>
					<div class="row">
						<div class="col-md-3">
							<div id="frm-white-icon" class="form-group img-upload">
								<label>White Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($catFaq->white_icon, 150,150, 'White Icon')!!}
									<input type="hidden" name="white_icon" class="thumb-media" value="{{ $catFaq->white_icon }}" />
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div id="frm-yellow-icon" class="form-group img-upload">
								<label>Yellow Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($catFaq->yellow_icon, 150,150, 'Yellow Icon')!!}
									<input type="hidden" name="yellow_icon" class="thumb-media" value="{{ $catFaq->yellow_icon }}" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 sidebar">
					<div class="group-fixed">
						<div class="group-action">
							<button type="submit" name="submit" class="btn">Save</button>
							<a href="{{route('catFaqsAdmin')}}" class="btn btn-cancel">Cancel</a>							
						</div>
					</div>
				</div>
			</form>

		</div>				
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">
	ckeditor("editor");
</script>
@stop