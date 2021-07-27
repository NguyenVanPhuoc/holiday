@php
	/**
	 * template table faq
	 * @param $list_faq
	 */
@endphp

<table  class="table table-striped">
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
			<th scope="col" class="cat">Category</th>
			<th scope="col" class="action"></th>
		</tr>
	</thead>
	<tbody>
		@foreach($list_faq as $key => $c)
		<tr id="item-{{$c->id}}">
			<td class="check">
				<div class="checkbox checkbox-success">
					<input id="item-{{$c->id}}" type="checkbox" name="items[]" value="{{$c->id}}">
					<label for="item-{{$c->id}}"></label>
				</div>
			</td>
			<th scope="row">{{$key+1}}</th>
			<td class="title"><a href="{{ route('editFaqAdmin', $c->id) }}">{{$c->title}}</a></td>
			<td class="cat">
				@if($c->category)
				{{ $c->category->title }}
				@endif
			</td>
			<td class="action">
				<a href="{{ route('editFaqAdmin', $c->id) }}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
				<a href="{{ route('deleteFaqAdmin', $c->id) }}" class="btn-delete delete-item"><i class="fa fa-close" aria-hidden="true"></i></a>					
			</td>
		</tr>
		@endforeach				
	</tbody>
</table>

{!! $list_faq->links() !!}