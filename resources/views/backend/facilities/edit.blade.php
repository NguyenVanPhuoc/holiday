@extends('backend.layout.index')
@section('title','Edit Facilities')
@section('content')

<div id="edit-facility" class="page route container">
	<div class="head">
		<a href="{{route('facilitiesAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All facilities</a>
		<h1 class="title">Edit Facilities</h1>		
	</div>
	<div class="main">
		<form action="#" method="post" class="dev-form create-attraction">
			{!!csrf_field()!!}
			<div class="form-group" id="frm-title">
				<label for="title">Title<small>(*)</small></label>
				<input type="text" name="title" class="form-control" placeholder="Input title" value="{{$facility->title}}" />
			</div>
			<div class="row">
				<div class="col-md-2">
					<div id="frm-white-icon" class="form-group img-upload">
						<label>White Icon</label>
						<div class="image">
							<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
							{!!image($facility->white_icon, 150,150, 'Gray Icon')!!}
							<input type="hidden" name="white_icon" class="thumb-media" value="{{$facility->white_icon}}" />
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<div id="frm-gray-icon" class="form-group img-upload">
						<label>Gray Icon</label>
						<div class="image">
							<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
							{!!image($facility->gray_icon, 150,150, 'Gray Icon')!!}
							<input type="hidden" name="gray_icon" class="thumb-media" value="{{$facility->gray_icon}}" />
						</div>
					</div>
				</div>
			</div>
			<div class="group-action">
				<a href="{{ route('deleteFacilityAdmin',['id'=>$facility->id]) }}" class="btn btn-delete">Delete</a>
				<button type="submit" name="submit" class="btn">Save</button>
				<a href="{{route('facilitiesAdmin')}}" class="btn btn-cancel">Cancel</a>							
			</div>
		</form>
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">
	$(function() {
       $("#edit-facility").on('click','form .group-action button',function(){
	       	var _token = $("form input[name='_token']").val();
	       	var title = $("#frm-title input").val();
	       	var white_icon = $("#frm-white-icon input").val();
	       	var gray_icon = $("#frm-gray-icon input").val();
	       	var errors = new Array();
	       	var error_count = 0;

	       	if(title==""){
	       		errors.push("Please input title");
	       	}
	       	var i;
	   		var html = "<ul>";
	       	for(i = 0; i < errors.length; i++){
	       		if(errors[i] != ""){
	       			html +='<li>'+errors[i]+'</li>';
	       			error_count += 1;
	       		}
	       	}   
	       	html += "</ul>";
	       	if(error_count>0){
		       	new PNotify({
					title: 'Error ('+error_count+')',
					text: html,						    
					hide: true,
					delay: 6000,
				});
	       	}else{
	       		$('#overlay').show();
	       		$('.loading').show();
				$.ajax({
					type:'POST',            
					url:'{{ route("updateFacilityAdmin", ["slug"=>$facility->slug]) }}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
						'white_icon':white_icon,
						'gray_icon': gray_icon
					},
				}).done(function(data) {
					$('#overlay').hide();
	       			$('.loading').hide();
					if(data.msg=="success"){				       					       	
						new PNotify({
							title: 'Successfully',
							text: 'Add to success.',
							type: 'success',
							hide: true,
							delay: 2000,
						});	
						window.location.href = data.redirect			
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