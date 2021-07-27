@extends('backend.layout.index')
@section('title','Edit location hotel')
@section('content')
<div id="edit-location" class="container page route">
	<div class="head">
		<a href="{{route('locationHotelsAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All location hotel</a>
		<h1 class="title">Edit location hotel</h1>		
		<a href="{{ route('storeLocationHotelAdmin') }}" class="btn btn-add">Add</a>
	</div>
	<div class="main">
		<div class="row">
			
			<form action="#" class="frm-menu dev-form" method="POST" name="create_star" role="form">
				{!!csrf_field()!!}
				<div id="frm-title" class="form-group">
					<label for="title">Title<small class="required">(*)</small></label>
					<input type="text" name="title" class="form-control" placeholder="Input title" class="frm-input" value="{{$location->title}}">
				</div>
				<div class="group-action">
					<a href="{{route('deleteLocationHotelAdmin', ['id'=>$location->id])}}" class="btn btn-delete">Delete</a>
					<button type="submit" name="submit" class="btn">Save</button>
					<a href="{{route('locationHotelsAdmin')}}" class="btn btn-cancel">Cancel</a>							
				</div>
			</form>

		</div>				
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">
	$(function() {
		$("#edit-location").on('click','form .group-action button',function(){
			var _token = $("form input[name='_token']").val();
			var title = $("#frm-title input").val();
			if(title==""){
				new PNotify({
					title: 'Error',
					text: 'Please input title.',
					hide: true,
					delay: 2000,
				});
			}else{
				$('#overlay').show();
				$('.loading').show();
				$.ajax({
					type:'POST',            
					url:'{{ route("updateLocationHotelAdmin", ["slug"=>$location->slug]) }}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
					},
				}).done(function(data) { 
					$('#overlay').hide();
					$('.loading').hide();
					if(data.msg=="success"){
						new PNotify({
							title: 'Successfully',
							text: 'Update to success.',
							type: 'success',
							hide: true,
							delay: 2000,
						});		
						window.location.href = data.redirect;				
					}else{
						new PNotify({
							title: 'Error',
							text: 'The system is busy. Please try again. ',					    
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