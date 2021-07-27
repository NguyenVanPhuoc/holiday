@extends('backend.layout.index')
@section('title','Add categories icon schedule')
@section('content')
<div id="add-catIcon-page" class="container page menu-page slides">
	<div class="head">
		<a href="{{route('catIconSchedules')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> List categories icon schedule</a>
		<h1 class="title">Add categories icon schedule</h1>		
	</div>
	<div class="main">
		<form id="create-catIcon" action="{{route('createCatIconSchedules')}}" class="frm-menu dev-form" method="POST" role="form"/>
			{!!csrf_field()!!}
			<div class="row">				
				<div class="col-md-12 left-box">			
					<section class="box-wrap box-title">
						<h2 class="title">Title</h2>
						<input type="text" name="title" placeholder="Input title" class="mn-title frm-input">
					</section>
				</div>
			</div>
			<div class="group-action">
				<a href="{{route('catIconSchedules')}}" class="btn btn-cancel">Cancel</a>
				<button type="submit" name="submit" class="btn">Save</button>			
			</div>
		</form>			
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">
	$(function() {		
		$('form#create-catIcon').submit(function(e){
			e.preventDefault();
			var _token = $("input[name='_token']").val();
			var title = $("form#create-catIcon input[name='title']").val();
			var errors = new Array();
			var error_count = 0;
			if(title==""){
	       		errors.push("Please input title");
	       	}
	       	var html = "<ul>";
	       	for(var i = 0; i < errors.length; i++){
	       		if(errors[i] != ""){
	       			html +='<li>'+errors[i]+'</li>';
	       			error_count += 1;
	       		}
	       	}       
       		html += "</ul>";		
	       	if(error_count>0){
		              	
		       	new PNotify({
					title: 'Error data ('+error_count+')',
					text: html,						    
					hide: true,
					delay: 6000,
				});
	       	}else{
				$.ajax({
	               	type:'POST',            
				    url:'{{ route("createCatIconSchedules") }}',
				    cache: false,
		            data:{
		                '_token': _token,
						'title':title
		            },
	           }).done(function(data) {
	           		if(data.msg == 'success'){
	           			new PNotify({
						    title: 'Successfully',
						    text: 'Add to success.',
						    type: 'success',
						    hide: true,
						    delay: 2000,
						});
						$('form#create-catIcon').trigger("reset");
	           		}
	           		else{
	           			new PNotify({
							title: 'Error',
							text: 'The system is busy. Please try again. ',						    
							hide: true,
							delay: 2000,
						});
	           		}
	           });
	       }
		});
	});	
</script>
@stop