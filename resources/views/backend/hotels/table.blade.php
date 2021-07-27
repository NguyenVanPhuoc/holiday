@php
/**
 * template table accommodation
 * @param $list_hotel
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
			<th scope="col" class="desc">Description</th>
			<th scope="col" class="country">Country</th>
			<th scope="col" class="action"></th>
		</tr>
	</thead>
	<tbody>
		@foreach($list_hotel as $key => $item)
			@php
				
			@endphp
			<tr id="item-{{$item->id}}">
				<td class="check">
					<div class="checkbox checkbox-success">
						<input id="item-{{$item->id}}" type="checkbox" name="items[]" value="{{$item->id}}">
						<label for="item-{{$item->id}}"></label>
					</div>
				</td>
				<th scope="row">{{$key+1}}</th>
				<td class="image">
					<a href="{{ route('editHotelAdmin', $item->slug) }}">{!!image($item->image, 50,50, $item->title)!!}</a>
				</td>
				<td class="title">
					<a href="{{ route('editHotelAdmin', $item->slug) }}">{{$item->title}}</a>
				</td>
				<td class="desc"><div class="text">{!! $item->desc !!}</div></td>
				<td class="country">
					{!! getCountryHotel($item->id) !!}
				</td>
				<td class="action">
					@handheld<a href="#" data-value="{{$item->id}}" class="view"><i class="fa fa-eye" aria-hidden="true"></i></a>@endhandheld
					<a href="{{ route('editHotelAdmin', $item->slug) }}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
					<a href="{{ route('deleteHotelAdmin', $item->id) }}" class="delete delete-item"><i class="fa fa-close" aria-hidden="true"></i></a>					
				</td>
			</tr>
		@endforeach				
	</tbody>
</table>
{!! $list_hotel->links() !!}