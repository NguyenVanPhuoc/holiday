@extends('backend.layout.index')
@section('title','Country')
@section('content')

@php
	$cats = get_categories_tour(); 
@endphp

<div id="country-cat" class="page countries-page  container">
	<div class="head">
		<h1 class="title">Country haven't Tour Style</h1>		
	</div>	
	<div class="main">
		<form action="#" method="POST" name="blog" class="dev-form">
			{!!csrf_field()!!}
			<div id="frm-country-cat">
				@if($country_cats)
					@foreach($country_cats as $value)
						<div class="edit-item" data-id="{{$value->id}}">
							<div class="row">
								@if($countries)
								<div class="col-md-4">
									<div class="form-group">
										<select class="country form-control">
											<option value="">--Country--</option>
											@foreach($countries as $item)
												<option value="{{$item->id}}" @if($item->id == $value->country_id) selected @endif >
														{{$item->title}}
												</option>
											@endforeach
										</select>
									</div>
								</div>
								@endif
								<div class="col-md-3 text-center">Haven't tour style</div>
								@if($cats)
								<div class="col-md-4">
									<div class="form-group">
										<select class="cat form-control">
											<option value="">--Tour Style--</option>
											@foreach($cats as $item)
												<option value="{{$item->id}}" @if($item->id == $value->cat_id) selected @endif >
													{{$item->title}}
												</option>
											@endforeach
										</select>
									</div>
								</div>
								@endif
								<div class="col-md-1">
									<button type="button" href="{{route('deleteCountryCatAdmin', ['id'=>$value->id])}}" class="btn remove-row">Remove</button>
								</div>
							</div>
						</div>
					@endforeach
				@endif
			</div>
			<a href="#" class="btn btn-default add-row">Add</a>
			
			<div class="group-action">
				<button type="submit" class="submit btn @if(!$country_cats) hide @endif">Save</button>
				<a href="{{route('storeCountryAdmin')}}" class="btn btn-cancel">Cancel</a>
			</div>
		</form>
		<div id="frm-add">
			<div class="add-item hide">
				<div class="row">
					@if($countries)
					<div class="col-md-4">
						<div class="form-group">
							<select class="country form-control">
								<option value="">--Country--</option>
								@foreach($countries as $item)
									<option value="{{$item->id}}">{{$item->title}}</option>
								@endforeach
							</select>
						</div>
					</div>
					@endif
					<div class="col-md-3 text-center">Haven't tour style</div>
					@if($cats)
					<div class="col-md-4">
						<div class="form-group">
							<select class="cat form-control">
								<option value="">--Tour Style--</option>
								@foreach($cats as $item)
									<option value="{{$item->id}}">{{$item->title}}</option>
								@endforeach
							</select>
						</div>
					</div>
					@endif
					<div class="col-md-1">
						<button type="button" href="#" class="btn remove-row">Remove</button>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>

@if(session('deleted'))
<script type="text/javascript">
	$(function(){
		new PNotify({
		    title: 'Successfully',
		    text: '{{session('deleted')}}',
		    type: 'success',
		    hide: true,
		    delay: 2000,
		});
	})
</script>
@endif

<script type="text/javascript">
	$(function(){
		//save
		$('#country-cat button.submit').click(function(e){
			e.preventDefault();
				
			var _token = $("form input[name='_token']").val();
			var array_add = new Array();
			var array_edit = new Array();
			var check_error = 0;
			//add array add
			$('#country-cat #frm-country-cat .add-item').each(function(){
				var country = $(this).find('select.country').val();
				var cat = $(this).find('select.cat').val(); 
				if(country == '' || cat == ''){
					new PNotify({
						title: 'Error',
						text: 'Please select a value.',						    
						hide: true,
						delay: 2000,
					});
				 	check_error = 1;
				} 
				else{
					check_error = 0;
					var temp = {};
					temp.country = country
					temp.cat = cat
					array_add.push(temp);
				}
				
			});
			//add array edit
			$('#country-cat #frm-country-cat .edit-item').each(function(){
				var temp = {};
				temp.id = $(this).attr('data-id');
				temp.country = $(this).find('select.country').val();
				temp.cat = $(this).find('select.cat').val();
				array_edit.push(temp);
			});
			if(check_error == 0){
				$.ajax({
					type:'POST',            
					url:'{{ route("postCountryCatAdmin") }}',
					cache: false,
					data:{
						'_token': _token,
						'array_add': array_add,
						'array_edit': array_edit
					},
				}).done(function(data) {
					if(data=="success"){			       					       	
						new PNotify({
							title: 'Successfully.',
							text: 'Successfully saved.',
							type: 'success',
							hide: true,
							delay: 2000,
						});	
						location.reload();					
					}else{
						new PNotify({
							title: 'Error.',
							text: 'Browser not support javascript.',						    
							hide: true,
							delay: 2000,
						});
					}	           		
				});
			}
		});

		//delete
		$('#country-cat .edit-item .remove-row').click(function(e){

		});
	});
</script>

@stop