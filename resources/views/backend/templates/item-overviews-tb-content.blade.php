@php
/*
* Template single content item
*/
@endphp
<tr class="add">
	<td>{{ $num_row }}</td>
	<td>
		@if(isset($row_image))
			<div class="tb-image field-row">
				<div class="row-left">
					<label>Image</label>
				</div>
				<div class="row-right">
					<div id="frm-image-{{ $row_idEditor.$num_row }}" class="desc img-upload">							
						<div class="image">
							<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
							{!! image($row_image, 150, 150, 'image') !!}
							<input type="hidden" class="thumb-media" value="{{ $row_image }}" />
						</div>
					</div>
				</div>
			</div>
		@endif
		<div class="tb-title field-row">
			<div class="row-left"><label>Title</label></div>
			<div class="row-right">
				<input  class="form-control" value="{{ $row_title }}">
			</div>
		</div>
		@if(isset($row_map))
			<div class="tb-map field-row">
				<div class="row-left">
					<label>Map</label>
				</div>
				<div class="row-right">
					<textarea class="tb-map form-control">{{ $row_map }}</textarea>
				</div>
			</div>
		@endif
		<div class="tb-content field-row">
			<div class="row-left"><label>Content</label></div>
			<div class="row-right">
				<textarea id="{{ $row_idEditor}}">{!! $row_content !!}</textarea>
			</div>
		</div>
	</td>
	<td class="delete text-center">
		<div class="del-tooltip">
			<a href="#" class="remove-row">
				<span>─</span>
			</a>
			<div class="tooltip">
				<div class="wrap">Are you sure?<div id="d-yes">
					<a href="#" class="yes">Yes</a></div><div id="d-no"><a href="#" class="no">Cancle</a></div>
				</div>
			</div>
		</div>
	</td>
</tr>