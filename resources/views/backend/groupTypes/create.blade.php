@extends('backend.layout.index')
@section('title','Add Group type')
@section('content')
<div id="create-group-type" class="container page country-page route">
	<div class="head">
		<a href="{{ route('groupTypesAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All group types</a>
		<h1 class="title">Add Group type</h1>		
	</div>	
	<div class="main">
		<form action="{{route('createGroupTypeAdmin')}}" class="frm-menu dev-form activity-form" method="POST" role="form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-9 content">
					<div id="frm-title" class="form-group">
						<label for="title">Title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" class="frm-input">
					</div>
				</div>
				<div class="col-md-3 sidebar">
					<div class="gr-not-fixed"></div>
					<div class="group-fixed">
						<div class="group-action">
							<button type="submit" name="submit" class="btn">Save</button>
							<a href="{{route('groupTypesAdmin')}}" class="btn btn-cancel">Cancel</a>									
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
@stop