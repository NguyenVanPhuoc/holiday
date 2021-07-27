@extends('backend.layout.index')
@section('title','Edit duration')
@section('content')
<div id="create-duration" class="container page route">
	<div class="head">
		<a href="{{route('durationAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i>All Duration</a>
		<h1 class="title">Edit duration</h1>		
	</div>
	<div class="main">			
		<form action="#" class="frm-menu dev-form" method="POST" name="create_duration" role="form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-9 content">
					<div id="frm-title" class="form-group">
						<label for="title">Title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" value="{{$duration->title}}" placeholder="Input title" class="frm-input">
					</div>
					<div class="row">
						<div class="col-md-6">
							<div id="frm-min" class="form-group">
								<label>Min</label>
								<input type="text" name="min" class="form-control" value="{{$duration->min}}" placeholder="Input min" class="frm-input">
							</div>
						</div>
						<div class="col-md-6">
							<div id="frm-max" class="form-group">
								<label>Max</label>
								<input type="text" name="max" class="form-control" value="{{$duration->max}}" placeholder="Input max" class="frm-input">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div id="frm-white-icon" class="form-group img-upload">
								<label>White Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($duration->white_icon, 150,150, 'White Icon')!!}
									<input type="hidden" name="white_icon" class="thumb-media" value="{{ $duration->white_icon }}" />
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div id="frm-yellow-icon" class="form-group img-upload">
								<label>Yellow Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($duration->yellow_icon, 150,150, 'Yellow Icon')!!}
									<input type="hidden" name="yellow_icon" class="thumb-media" value="{{ $duration->yellow_icon }}" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 sidebar">
					<div class="gr-not-fixed">
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($duration->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($duration->updated_at)) }}</li>
							</ul>
						</section>
					</div>
					<div class="group-fixed">
						<div class="group-action">
							<a href="{{ route('deleteDurationAdmin', $duration->id) }}" class="btn btn-delete">Delete</a>
							<button type="submit" name="submit" class="btn">Save</button>
							<a href="{{route('durationAdmin')}}" class="btn btn-cancel">Cancel</a>							
						</div>
					</div>
				</div>
				
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
					title: 'Error',
					text: 'Please input title!.',
					hide: true,
					delay: 2000,
				});
			}else{
				$.ajax({
					type:'POST',            
					url:'{{ route("updateDurationAdmin", ["slug"=>$duration->slug]) }}',
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
					if(data.status=="success"){
						new PNotify({
							title: 'Successfully',
							text: 'Updated successful.',
							type: 'success',
							hide: true,
							delay: 2000,
						});		
						window.location.replace(data.url);				
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