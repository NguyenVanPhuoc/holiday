@extends('backend.layout.index')
@section('title','Add tour style')
@section('content')
<div id="create-category" class="container page route">
	<div class="head">
		<a href="{{route('catTourAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Tour style</a>
		<h1 class="title">Add tour style</h1>		
	</div>
	<div class="main">
		<div class="row">
			
			<form action="{{route('createCatTourAdmin')}}" class="frm-menu dev-form activity-form" method="POST" name="create_category" role="form">
				{!!csrf_field()!!}
				<div class="col-md-9">
					<div id="frm-title" class="form-group">
						<label for="title">Input title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" class="frm-input">
					</div>
					<div id="frm-content" class="form-group">
						<label for="content">Description</label>
						<textarea name="desc" id="editor"></textarea>
					</div>	
					<div class="row">
						<div class="col-md-3">
							<div id="frm-white-icon" class="form-group img-upload">
								<label>White Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'White Icon')!!}
									<input type="hidden" name="white_icon" class="thumb-media" value="" />
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div id="frm-pink-icon" class="form-group img-upload">
								<label>Pink Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Pink Icon')!!}
									<input type="hidden" name="pink_icon" class="thumb-media" value="" />
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div id="frm-gray-icon" class="form-group img-upload">
								<label>Gray Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Gray Icon')!!}
									<input type="hidden" name="gray_icon" class="thumb-media" value="" />
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div id="frm-green-icon" class="form-group img-upload">
								<label>Green Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Green Icon')!!}
									<input type="hidden" name="green_icon" class="thumb-media" value="" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 sidebar">
					<div class="gr-not-fixed">
						<div class="box-wrap">
							<div id="frm-image" class="form-group img-upload">
								<label>Image</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Ảnh đại diện')!!}
									<input type="hidden" name="image" class="thumb-media" value="" />
								</div>
							</div>
						</div>
					</div>
					<div class="group-fixed">
						<div class="group-action">
							<button type="submit" name="submit" class="btn">Lưu</button>
							<a href="{{route('catTourAdmin')}}" class="btn btn-cancel">Hủy</a>							
						</div>
					</div>
				</div>
				<!-- <div class="col-md-9">
					<div class="group-action">
						<button type="submit" name="submit" class="btn">Lưu</button>
						<a href="{{route('catTourAdmin')}}" class="btn btn-cancel">Hủy</a>							
					</div>
				</div> -->
			</form>

		</div>				
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">
	ckeditor("editor");
</script>
@stop