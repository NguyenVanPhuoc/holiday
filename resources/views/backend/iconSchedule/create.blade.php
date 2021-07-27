@extends('backend.layout.index')
@section('title','Add icon schedule')
@section('content')
<div id="create-iconSchedule" class="container page news-page route">
	<div class="head">
		<a href="{{route('iconSchedules')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> List icon schedule</a>
		<h1 class="title">Add icon schedule</h1>		
	</div>	
	<div class="main">
		<form action="{{route('createIconSchedules')}}" class="frm-menu dev-form" method="POST" name="create_tour" role="form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-9 content">
					<div id="frm-title" class="form-group">
						<label for="title">Title<small class="required">(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" class="frm-input">
					</div>
					<div class="row">
						<div class="col-md-4">
							<div id="frm-white-icon" class="form-group img-upload">
								<label>White Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'White Icon')!!}
									<input type="hidden" name="white_icon" class="thumb-media" value="" />
								</div>
							</div>
						</div>		
						<div class="col-md-4">
							<div id="frm-icon" class="form-group img-upload">
								<label>Gray Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Gray Icon')!!}
									<input type="hidden" name="gray_icon" class="thumb-media" value="" />
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div id="frm-yellow-icon" class="form-group img-upload">
								<label>Yellow Icon</label>
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Yellow Icon')!!}
									<input type="hidden" name="pink_icon" class="thumb-media" value="" />
								</div>
							</div>
						</div>
					</div>				
				</div>
				<div class="col-md-3 sidebar">
					@if(!$categories->isEmpty())
					<section id="sb-categories" class="box-wrap">
						<h2 class="title">Category</h2>
						<div class="desc list">
							<div class="dropdown vs-drop">
	                            <a class="dropdown-toggle" href="#" role="button" id="dropdown-cat" data-toggle="dropdown" data-value="">Category</a>
	                            @if($categories)
	                            <div class="dropdown-menu" aria-labelledby="dropdown-cat">
	                                <ul class="list-item">
	                                    @foreach($categories as $item)
	                                    <li><a href="#{{$item->id}}" data-value="{{$item->id}}">{{$item->title}}</a></li>
	                                    @endforeach
	                                </ul>
	                            </div>
	                            @endif
	                        </div>							
						</div>						
					</section>
					@endif
				</div>
				<div class="col-md-9">
					<div class="group-action">
						<button type="submit" name="submit" class="btn">Save</button>
						<a href="{{route('iconSchedules')}}" class="btn btn-cancel">Cancel</a>				
					</div>
				</div>
			</div>			
		</form>				
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">
	$(function() {
       $("#create-iconSchedule form").on('submit', function(e){
       		e.preventDefault();
	       	var _token = $("form input[name='_token']").val();
	       	var title = $("#frm-title input").val();
	       	var icon = $("#frm-icon input").val();
	       	var white_icon = $("#frm-white-icon input").val();
	       	var yellow_icon = $("#frm-yellow-icon input").val();
	       	var cat_id = $("#sb-categories .dropdown-toggle").attr("data-value"); console.log(cat_id);
	       	var errors = new Array();
	       	var error_count = 0;

	       	if(title==""){
	       		errors.push("Please input title");
	       	}
	       	if(cat_id==""){
	       		errors.push("Please choose category");
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
					title: 'Error data ('+error_count+')',
					text: html,						    
					hide: true,
					delay: 6000,
				});
	       	}else{
				$.ajax({
					type:'POST',            
					url:'{{ route("createIconSchedules") }}',
					cache: false,
					data:{
						'_token': _token,
						'title': title,
						'icon': icon,
						'white_icon': white_icon,
						'yellow_icon': yellow_icon,
						'cat_id': cat_id
					},
				}).done(function(data) {
					if(data.msg=="success"){
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