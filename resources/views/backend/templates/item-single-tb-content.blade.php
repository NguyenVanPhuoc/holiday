@php
/*
* Template single content item
*/
@endphp
<tr class="add current">
	<td>{{ $num_row }}</td>
	<td>
		<div class="tb-title field-row">
			<div class="row-left"><label>Title</label></div>
			<div class="row-right">
				<input  class="form-control" value="{{ $row_title }}">
			</div>
		</div>
		@if(isset($row_image))
			<div class="tb-image field-row content_days">
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
		@if(isset($list_city))
			<div id="frm-list-city" class="field-row content_days">
				<div class="row-left">
					<label>Route</label>
				</div>
				<div class="row-right">
					<select multiple="multiple" name="list_city[]" class="form-control select2">
				        @foreach ($list_city as $item)
				            <option value="{{ $item->id }}" @if($row_city != '' && in_array($item->id, $row_city)) selected @endif> {{ $item->title }} </option>
				        @endforeach
				    </select>
				</div>
			</div>
		@endif
		@if(isset($list_style))
			<div id="frm-list-style" class="field-row content_days">
				<div class="row-left">
					<label>Experience</label>
				</div>
				<div class="row-right">
					<select multiple="multiple" name="list_style[]" class="form-control select2">
				        @foreach ($list_style as $item)
				            <option value="{{ $item->id }}" @if($row_style != '' && in_array($item->id, $row_style)) selected @endif> {{ $item->title }} </option>
				        @endforeach
				    </select>
				</div>
			</div>
		@endif
		@if(isset($list_tour))
			<div id="frm-list-tour" class="field-row content_days">
				<div class="row-left">
					<label>Sample tour packages</label>
				</div>
				<div class="row-right">
					<select multiple="multiple" name="list_tour[]" class="form-control select2">
				        @foreach ($list_tour as $item)
				            <option value="{{ $item->id }}" @if($row_tour != '' && in_array($item->id, $row_tour)) selected @endif> {{ $item->title }} </option>
				        @endforeach
				    </select>
				</div>
			</div>
		@endif
		@if(isset($row_map))
			<div class="tb-map field-row content_days">
				<div class="row-left">
					<label>Map</label>
					<p>Note: Add Zoom Value</p>
				</div>
				<div class="row-right">
					<textarea class="tb-map form-control">{{ $row_map }}</textarea>
				</div>
			</div>
		@endif
		<div class="tb-content field-row content_days ">
			<div class="row-left"><label>Content</label></div>
			<div class="row-right">
				<textarea id="{{ $row_idEditor}}">{!! $row_content !!}</textarea>
			</div>
		</div>
	</td>
	<td class="delete text-center drop_nvp">
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
		<span class="toggle_up"><i class="fa fa-chevron-up" aria-hidden="true"></i></span>
		<span class="toggle_down"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
	</td>
</tr>