@extends('backend.layout.index')
@section('title','Attraction')
@section('content')
@php
	$countries = getCountryLevel1();
	$country_id = isset($country_id)? $country_id : '';	
	if(isset($country_id) && $country_id!=""){
		$countryId = $country_id;
		$countryTitle = get_countries($country_id)->title;
	}else{
		$countryId = "";
		$countryTitle = "---All country---";
	}
	$key = isset($s)? $s:'';
@endphp
<div id="attractions" class="page">
	<div class="head">
		<h1 class="title">Attracrion</h1>		
	</div>
	<div class="main">
		<div class="search-form">
			<form name="s" action="{{route('searchAttractionAdmin')}}" method="GET">
				<div class="row">
					<div id="frm-parent" class="col-md-6">
						<div class="s-country">
							<select name="country_id">
								<option value="{{$countryId}}">{{$countryTitle}}</option>
								@foreach($countries as $country)
									<option value="{{ $country->id }}">{{ $country->title }}</option>
								@endforeach
							</select>
						</div>			
					</div>
					<div id="frm-keyword" class="col-md-6"><input type="text" name="s" class="form-control" placeholder="Input key word..." value="{{$key}}"></div>
				</div>
				<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
			</form>
		</div>
		<form action="#" method="post" class="dev-form list-guides" data-delete="{{route('deleteAllAttractionAdmin')}}">
			{!!csrf_field()!!}
			<div class="tb-results">
				<table class="table table-striped">
					<thead class="thead-dark">
						<tr>
							<th id="check-all" scope="col" class="check">
								<div class="checkbox checkbox-success">
									<input id="check" type="checkbox" name="checkAll[]" value="">
									<label for="check"></label>
								</div>
							</th>
							<th scope="col" class="stt">#</th>
							<th scope="col" class="image">Image</th>
							<th scope="col" class="title">Title</th>
							<th scope="col" class="desc">Description</th>
							<th scope="col" class="country">Country</th>
							<th scope="col" class="action"></th>
						</tr>
					</thead>
					<tbody>
						@foreach($attractions as $keys => $item)
							@php
								$country = getCountryById($item->country_id);
							@endphp
							<tr id="item-{{$item->id}}">
								<td class="check">
									<div class="checkbox checkbox-success">
										<input id="item-{{$item->id}}" type="checkbox" name="items[]" value="{{$item->id}}">
										<label for="item-{{$item->id}}"></label>
									</div>
								</td>
								<th scope="row">{{$keys+1}}</th>
								<td class="image">
									<a href="{{ route('editAttractionAdmin', ['slug'=>$item->slug]) }}">{!!image($item->image, 50,50, $item->title)!!}</a>
								</td>
								<td class="title"><a href="{{ route('editAttractionAdmin', ['slug'=>$item->slug]) }}">{{$item->title}}</a></td>
								<td class="desc"><div class="text">{!! $item->desc !!}</div></td>
								<td class="country">
									{{ $country->title }}
								</td>
								<td class="action">
									@handheld<a href="#" data-value="{{$item->id}}" class="view"><i class="fa fa-eye" aria-hidden="true"></i></a>@endhandheld
									<a href="{{ route('editAttractionAdmin', ['slug'=>$item->slug]) }}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
									<a href="{{ route('deleteAttractionAdmin', ['id'=>$item->id]) }}" class="delete delete-item"><i class="fa fa-close" aria-hidden="true"></i></a>					
								</td>
							</tr>
						@endforeach				
					</tbody>
				</table>
			</div>
		</form>
	</div>
</div>
@if($country_id=="" && $key=="")
		{!! $attractions->links() !!}
@else
	{!! $attractions->appends(['country_id'=>$country_id,'s'=>$key])->links() !!}		
@endif
@if(session('success'))
<script type="text/javascript">
	$(function(){
		new PNotify({
			title: 'Successfully',
			text: '{{session('success')}}',
			type: 'success',
			hide: true,
			delay: 2000,
		});
	})
</script>
@endif
<script type="text/javascript">
	$(function() {
	//delete location
	
});	
</script>
@stop