@php
/*
* Template table things to do
* @param request : $list_guide
*/
@endphp

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
			<th scope="col" class="category">Category</th>
			<th scope="col" class="country">Country</th>
			<th scope="col" class="action">Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($list_guide as $key => $item)
		<tr id="item-{{$item->id}}">
			<td class="check">
				<div class="checkbox checkbox-success">
					<input id="item-{{$item->id}}" type="checkbox" name="items[]" value="{{$item->id}}">
					<label for="item-{{$item->id}}"></label>
				</div>
			</td>
			<th scope="row">{{$key+1}}</th>
			<td class="image"><a href="#">{!!image($item->image, 50,50, $item->title)!!}</a></td>
			<td class="title"><a href="{{ route('editThingToDoAdmin', $item->id) }}">{{$item->title}}</a></td>
			<td class="category">{{ $item->category_title }}</td>
			<td class="country">{{ $item->country_title }}</td>
			<td class="action">
				@handheld<a href="#" data-value="{{$item->id}}" class="view"><i class="fa fa-eye" aria-hidden="true"></i></a>@endhandheld
				<a href="{{ route('editThingToDoAdmin', $item->id) }}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
				<a href="{{ route('deleteThingToDoAdmin', $item->id) }}" class="delete btn-delete delete-item"><i class="fa fa-close" aria-hidden="true"></i></a>					
			</td>
		</tr>
		@handheld
		<tr class="item-{{$item->id}} detail">
			<td colspan="7">					
				<ul class="info">
					<li>Long title: <a href="{{ route('editThingToDoAdmin', ['slug'=>$item->slug]) }}">{{$item->title}}</a></li>
					<li>
						Country: 
						@if(isset($countries))
							@foreach($countries as $key=>$country_id)
								@php $country = getCountryById($country_id); @endphp
								@if(isset($country))
									@if($key == 0)
										{{$country->title}}
									@else
										, {{$country->title}}
									@endif
								@endif
							@endforeach
						@endif
					</li>
				</ul>
				<a href="#" class="read-more"><i class="fa fa-angle-right" aria-hidden="true"></i>View</a>
			</td>
		</tr>
		@endhandheld
		@endforeach				
	</tbody>
</table>
{!! $list_guide->links() !!}
