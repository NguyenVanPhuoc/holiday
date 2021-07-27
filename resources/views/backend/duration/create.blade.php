@extends('backend.layout.index')
@section('title','Add duration')
@section('content')
<div id="create-duration" class="container page route">
	<div class="head">
		<a href="{{route('durationAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i>All Duration</a>
		<h1 class="title">Add duration</h1>		
	</div>
	<div class="main">			
		<form action="{{route('storeDurationAdmin')}}" class="frm-menu dev-form" method="POST" name="create_duration" role="form">
			{!!csrf_field()!!}
			<div id="frm-title" class="form-group">
				<label for="title">Title<small class="required">(*)</small></label>
				<input type="text" name="title" class="form-control" placeholder="Input title" class="frm-input">
			</div>
			<div class="row">
				<div class="col-md-6">
					<div id="frm-min" class="form-group">
						<label>Min</label>
						<input type="text" name="min" class="form-control" placeholder="Input min" class="frm-input">
					</div>
				</div>
				<div class="col-md-6">
					<div id="frm-max" class="form-group">
						<label>Max</label>
						<input type="text" name="max" class="form-control" placeholder="Input max" class="frm-input">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div id="frm-white-icon" class="form-group img-upload">
						<label>White Icon</label>
						<div class="image">
							<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
							{!!image('', 150,150, 'White Icon')!!}
							<input type="hidden" name="white_icon" class="thumb-media" value="" />
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div id="frm-yellow-icon" class="form-group img-upload">
						<label>Yellow Icon</label>
						<div class="image">
							<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
							{!!image('', 150,150, 'Yellow Icon')!!}
							<input type="hidden" name="yellow_icon" class="thumb-media" value="" />
						</div>
					</div>
				</div>
			</div>
			<div class="group-action">
				<button type="submit" name="submit" class="btn">Save</button>
				<a href="{{route('durationAdmin')}}" class="btn btn-cancel">Cancel</a>							
			</div>
		</form>			
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">
	$(function() {
		$("#create-duration").on('click','form .group-action button',function(){
			var _token = $("form input[name='_token']").val();
			var title = $("#frm-title input").val();
			var min = $("#frm-min input").val();
			var max = $("#frm-max input").val();
			var white_icon = $('input[name=white_icon]').val();
			var yellow_icon = $('input[name=yellow_icon]').val();
			if(title==""){
				new PNotify({
					title: 'Lỗi',
					text: 'Please input title!.',
					hide: true,
					delay: 2000,
				});
			}else{
				$.ajax({
					type:'POST',            
					url:'{{ route("createDurationAdmin") }}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
						'min': min,
						'max': max,
						'white_icon': white_icon,
						'yellow_icon': yellow_icon,
					},
				}).done(function(data) {
					if(data=="success"){
						new PNotify({
							title: 'Successfully',
							text: 'Created successful.',
							type: 'success',
							hide: true,
							delay: 2000,
						});		
						location.reload();				
					}else{
						new PNotify({
							title: 'Error',
							text: 'The system is busy. Please try later',						    
							hide: true,
							delay: 2000,
						});
					}	           		
				});
			}       	
			return false;
		});
	});	
</script>
@stop