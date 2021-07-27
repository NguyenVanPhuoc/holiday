@extends('backend.layout.index')
@section('title','Add star rating')
@section('content')
<div id="create-star" class="container page route">
	<div class="head">
		<a href="{{route('locationHotelsAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All star rating</a>
		<h1 class="title">Add star rating</h1>		
	</div>
	<div class="main">
		<div class="row">
			
			<form action="#" class="frm-menu dev-form" method="POST" name="create_star" role="form">
				{!!csrf_field()!!}
				<div id="frm-title" class="form-group">
					<label for="title">Title<small class="required">(*)</small></label>
					<input type="text" name="title" class="form-control" placeholder="Input title" class="frm-input">
				</div>
				<div id="frm-number-star" class="form-group">
					<label>Number star</label>
					<select class="form-control">
						<option value="">None</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
				</div>
				<div class="group-action">
					<button type="submit" name="submit" class="btn">Save</button>
					<a href="{{route('starRatingsAdmin')}}" class="btn btn-cancel">Cancel</a>							
				</div>
			</form>

		</div>				
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">
	$(function() {
		$("#create-star").on('click','form .group-action button',function(){
			var _token = $("form input[name='_token']").val();
			var title = $("#frm-title input").val();
			var number_star = $("#frm-number-star select").val();
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
					url:'{{ route("createStarRatingAdmin") }}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
						'number_star': number_star,
					},
				}).done(function(data) { 
					$('#overlay').hide();
					$('.loading').hide();
					if(data=="success"){
						new PNotify({
							title: 'Successfully',
							text: 'Add to success.',
							type: 'success',
							hide: true,
							delay: 2000,
						});		
						location.reload();				
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