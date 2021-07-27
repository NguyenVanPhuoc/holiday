@extends('backend.layout.index')
@section('title','Icons Detail Schedule')
@section('content')
@php 
	$categories = get_icon_schedules();	
	$category = isset($category)? $category : ''; 
	if(isset($category) && $category!=""){
		$category = $category;
		$catTitle = get_category_icon_schedules($category)->title;
	}else{
		$category = "";
		$catTitle = "---Category---";
	}
	$s = isset($s)? $s:'';

@endphp

<div id="iconSchedule-page" class="page">
	<div class="head container">
		<h1 class="title">Icons Detail Schedule</h1>		
	</div>	
	<div class="main">
		<div class="search-form">
			<form name="s" action="{{route('searchIconSchedules')}}" method="GET">
				<div class="row">
					<div id="frm-category" class="col-md-6">
						<select name="category">
							<option value="{{$category}}">{{$catTitle}}</option>
							@if($categories)								
								@foreach($categories as $item)
									<option value="{{$item->id}}">{{$item->title}}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div id="frm-title" class="col-md-6"><input type="text" name="s" class="form-control" placeholder="Input keyword..." value="{{$s}}"></div>
				</div>
				<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
			</form>
		</div>
		<div class="results">
			<form action="#" method="POST" name="blog" class="dev-form">
				{!!csrf_field()!!}
				<table class="table table-striped list">
					<thead class="thead-dark">
						<tr>
							<th id="check-all" scope="col" class="check">
								<div class="checkbox checkbox-success">
									<input id="check" type="checkbox" name="checkAll[]" value="">
									<label for="check"></label>
								</div>
							</th>
							<th scope="col" class="stt">STT</th>
							<th scope="col" class="white-icon">Icon White</th>
							<th scope="col" class="icon">Icon Gray</th>
							<th scope="col" class="yellow-icon">Yellow Icon</th>
							<th scope="col" class="title">Title</th>					
							<th scope="col" class="category">Category</th>					
							<th scope="col" class="action">Action</th>
						</tr>
					</thead>
					<tbody>	
						@foreach($iconSchedules as $key=>$item)
							@php 
								$cat = CatIconScheduleByID($item->cat_id); 
							@endphp
							<tr>
								<td class="check">
									<div class="checkbox checkbox-success">
										<input id="tour-{{$item->id}}" type="checkbox" name="tour[]" value="{{$item->id}}">
										<label for="tour-{{$item->id}}"></label>
									</div>
								</td>
								<td class="stt">{{$key+1}}</td>
								<td class="icon">{!! image($item->white_icon, 50, 50, $item->title)!!}</td>
								<td class="icon">{!! image($item->icon, 50, 50, $item->title)!!}</td>
								<td class="yellow-icon">{!! image($item->yellow_icon, 50, 50, $item->title)!!}</td>
								<td class="title">
									<a href="">{{$item->title}}</a>
								</td>
								<td class="category">{{ $cat ? $cat->title : ''}}</td>		
								<td class="action">
									<a href="{{route('editIconSchedules', ['id'=>$item->id])}}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
									<a href="{{route('deleteIconSchedules', ['id'=>$item->id])}}" class="delete"><i class="fa fa-close" aria-hidden="true"></i></a>
								</td>
							</tr>
						@endforeach	
					</tbody>
				</table>
				@if($category==""  && $s=="")
					{!! $iconSchedules->links() !!}
				@else
					{!!  $iconSchedules->appends(['category'=>$category,'s'=>$s])->links() !!}		
				@endif
			</form>
		</div>	
	</div>
</div>
@if(session('success'))
<script type="text/javascript">
	$(function(){
		new PNotify({
		    title: 'Successfully',
		    text: 'Successfully deleted',
		    type: 'success',
		    hide: true,
		    delay: 2000,
		});
	})
</script>
@endif
<script type="text/javascript">
	$(function() {
		$(".dev-form").on('click','.dell-all',function(){
      		var _token = $("form input[name='_token']").val();
			var items = new Array();
			$(".dev-form tbody tr").each(function(){
				if($(this).find(".check input").is(":checked")){
					items.push($(this).find("input").val());
				}
			});
			if(items<0){		       	
		       	new PNotify({
					title: 'Error data',
					text: 'Please choose row delete.!',						    
					hide: true,
					delay: 6000,
				});
	       	}else{
	       		$(".dev-form").append("<div class='loading'><img src='{{route('home')}}/public/images/loading_red.gif' alt='loading..'/></div>");
				$.ajax({
					type:'POST',            
					url:'{{ route("deleteAllIconSchedules") }}',
					cache: false,
					data:{
						'_token': _token,
						'items': JSON.stringify(items)
					},
				}).done(function(data) {
					if(data=="success"){
						$(".dev-form .loading").remove();
						$(".dev-form tbody .check input").prop('checked', false);
						$.each(items, function(index, value){							
							$(".dev-form #item-"+value).remove();
						});
						items = new Array();				       					       	
						new PNotify({
						    title: 'Successfully',
						    text: 'Successfully deleted',
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
		//delete location
      	$(".dev-form .delete").click(function(){
      		var href = $(this).attr("href");
      		(new PNotify({
			    title: 'Delete',
			    text: 'Are you want delete?',
			    icon: 'glyphicon glyphicon-question-sign',
			    type: 'error',
			    hide: false,
			    confirm: {
			        confirm: true
			    },
			    buttons: {
			        closer: false,
			        sticker: false
			    },
			    history: {
			        history: false
			    }
			})).get().on('pnotify.confirm', function() {			    
			    window.location.href = href;
			});
			return false;
      	});

      	
	});	
</script>
@stop