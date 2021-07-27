@extends('backend.layout.index')
@section('title','tours')
@section('content')
@php 
	$categories = get_categories_tour();	
	$category = isset($category)? $category : ''; 
	if(isset($category) && $category!=""){
		$catId = $category;
		$catTitle = get_category_tour($category)->title;
	}else{
		$catId = "";
		$catTitle = "---Category---";
	}
	$country_id = isset($country_id)? $country_id : '';
	$countryTitle  = '-- Choose Country --';
	if($country_id != ''){
		$countryTitle = getCountryById($country_id)->title;
	}
	$key = isset($s)? $s:'';

@endphp


<div id="tours" class="page tours-page">
	<div class="head container">
		<h1 class="title">Tour</h1>		
	</div>	
	<div class="main">
		<div class="search-form">
			<form name="s" action="{{route('searchTourAdmin')}}" method="GET">
				<div class="row">
					<div id="s-country" class="col-md-4">
						<!-- <div class="desc list">
							<div class="dropdown vs-drop">
						         @if(isset($country_id))
									<a class="dropdown-toggle" href="#" role="button" id="dropdown-parent" data-value="{{$country_id}}" data-toggle="dropdown">{{ $countryTitle }}</a>
	                        	@else
	                        		<a class="dropdown-toggle" href="#" role="button" id="dropdown-parent" data-value="" data-toggle="dropdown">-- Choose Country --</a>
	                        	@endif
	                            <input type="hidden" name="country_id" class="value" value="{{$country_id}}">
	                            <div class="dropdown-menu" aria-labelledby="dropdown-cat" x-placement="bottom-start">
	                                <ul class="list-item dropdown-country scrollbar-inner">
	                                	{!! getParentCountry(0, 0) !!}
	                                </ul>
	                            </div>
	                        </div>							
						</div> -->
						<div class="s-country">
							<select class="form-control select2" name="country_id">
								<option value="">All parent</option>
								{!! getListOptionParentCountry(0, 0) !!}
							</select>
						</div>
					</div>
					<div id="frm-category" class="col-md-4">
						<select name="category">
							<option value="{{$catId}}">{{$catTitle}}</option>
							@if($categories)								
								@foreach($categories as $item)
									<option value="{{$item->id}}">{{$item->title}}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div id="frm-title" class="col-md-4"><input type="text" name="s" class="form-control" placeholder="Input keyword..." value="{{$key}}"></div>
				</div>
				<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
			</form>
		</div>
		<form action="{{route('blogAdmin')}}" method="POST" name="blog" class="dev-form">
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
						<th scope="col" class="stt">#</th>
						<th scope="col" class="stt">Image</th>
						<th scope="col" class="stt">Code tour</th>
						<th scope="col" class="title">Title</th>
						<th scope="col" class="stt">Category</th>					
						<th scope="col" class="stt">Date tour</th>					
						<th scope="col" class="country">Country</th>					
						<th scope="col" class="action"></th>
					</tr>
				</thead>
				<tbody>	
					@php $count = 0; @endphp
					@foreach($tours as $item)
						@php
							$count++;
						@endphp
						<tr>
							<td class="check">
								<div class="checkbox checkbox-success">
									<input id="tour-{{$item->id}}" type="checkbox" name="tour[]" value="{{$item->id}}">
									<label for="tour-{{$item->id}}"></label>
								</div>
							</td>
							<td class="stt">{{$count}}</td>
							<td class="image">{!! image($item->image, 50, 50, $item->title) !!}</td>
							<td class="stt">{{$item->code}}</td>
							<td class="title">
								<a href="{{route('editTourAdmin', ['slug'=>$item->slug])}}" >
									{{$item->title}}
								</a>
							</td>
							<td class="category">
								@if($item->cat_id)
									@php $cats = explode(',',$item->cat_id);  @endphp
									@foreach($cats as $keys=>$cat_id)
										@php $cat = get_category_tour($cat_id); @endphp
										@if($cat)
											@if($keys == 0)
												{{$cat->title}}
											@else
												{{ ', '.$cat->title }}
											@endif
										@endif
									@endforeach
								@endif
							</td>
							<td class="stt">{{$item->number}}</td>
							<td class="country">
								{{ getListStrTitleCountryOfTour($item->id) }}
							</td>
							<td class="action">						
								<a href="{{route('editTourAdmin', ['slug'=>$item->slug])}}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
								<a href="{{ route('deleteTourAdmin',['slug'=>$item->id]) }}" class="delete"><i class="fa fa-close" aria-hidden="true"></i></a>
							</td>
						</tr>
					@endforeach	
				</tbody>
			</table>
		</form>
	</div>	
	@if($catId=="" && $country_id=="" && $key=="")
		{!! $tours->links() !!}
	@else
		{!!  $tours->appends(['category'=>$catId,'country_id'=>$country_id,'s'=>$key])->links() !!}		
	@endif
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
		$(".search-form").on('click','button',function(){
			var category = $(".search-form #frm-category select").val();
			var key = $(".search-form #frm-title input").val();	
			var country_id = $(".search-form #s-country select").val();		

			if(category=="" && country_id=="" && key==""){
				new PNotify({
					title: 'Error',
					text: 'Please choose a category / input keyword',						    
					hide: true,
					delay: 6000,
				});
			}else{
				return true;
			}
			return false;
		});
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
					title: 'Error',
					text: 'Please choose row delete.!',						    
					hide: true,
					delay: 6000,
				});
	       	}else{
	       		$(".dev-form").append("<div class='loading'><img src='{{route('home')}}/public/images/loading_red.gif' alt='loading..'/></div>");
				$.ajax({
					type:'POST',            
					url:'{{ route("deleteAllTour") }}',
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
      	$("#tours .delete").click(function(){
      		var href = $(this).attr("href");
      		(new PNotify({
			    title: 'Delete',
			    text: 'Do you delete?',
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