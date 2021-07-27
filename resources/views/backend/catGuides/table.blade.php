@php
/*
* table content of category guide
*/
@endphp
<table class="table table-striped list">
	<thead class="thead-dark">
		<tr>
			<th id="check-all" class="check">
				<div class="checkbox checkbox-success">
					<input id="check" type="checkbox" name="checkAll[]" value="">
					<label for="check"></label>
				</div>
			</th>
			<th class="stt">#</th>
			<th class="title">Title</th>
			<th class="action">Action</th>
		</tr>
	</thead>
	<tbody class="sortable" data-action="{{ route('positionCatGuideAdmin') }}">
		@if ($list_catGuide->isNotEmpty())
			@foreach($list_catGuide as $key => $item)
				<tr id="item-{{ $item->id }}" data-id="{{ $item->id }}" data-position="{{ $key + 1 }}">
					<td class="check">
						<div class="checkbox checkbox-success">
							<input id="proCat-{{ $item->id }}" type="checkbox" name="productCats[]" value="{{ $item->id }}">
							<label for="proCat-{{ $item->id }}"></label>
						</div>
					</td>
					<td class="stt">{{ $key + 1 }}</td>
					<td class="title"><a href="{{ route('editCatGuideAdmin', $item->slug) }}">{{ $item->title }}</a></td>
					<td class="action">
						<a href="{{ route('editCatGuideAdmin', $item->slug) }}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
						<a href="{{ route('deleteCatGuideAdmin', $item->id) }}" class="btn-delete delete"><i class="fa fa-close" aria-hidden="true"></i></a>
					</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>
