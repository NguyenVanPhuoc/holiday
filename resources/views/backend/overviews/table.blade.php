@php
/*
* template table overview
* @param $list_overview
*/
@endphp
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
			<th scope="col" class="title">Title</th>			
			<th scope="col" class="action"></th>
		</tr>
	</thead>
	<tbody>
		@foreach($list_overview as $key => $item)
			<tr id="item-{{$item->id}}">
				<td class="check">
					<div class="checkbox checkbox-success">
						<input id="item-{{$item->id}}" type="checkbox" name="items[]" value="{{$item->id}}">
						<label for="item-{{$item->id}}"></label>
					</div>
				</td>
				<td scope="row" class="stt">{{$key + 1}}</td>
				<td class="title"><a href="{{route('editOverviewAdmin', ['slug'=>$item->slug])}}">{{$item->title}}</a></td>
				<td class="action">						
					<a href="{{route('editOverviewAdmin', ['slug'=>$item->slug])}}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
					<a href="{{ route('deleteOverviewAdmin', $item->id) }}" class="delete delete-item"><i class="fa fa-close" aria-hidden="true"></i></a>
				</td>
			</tr>				
		@endforeach				
	</tbody>
</table>
{!! $list_overview->links() !!}