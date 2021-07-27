@extends('backend.layout.index')
@section('title','Add Overview')
@section('content')
@php
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';
@endphp
<div id="create-highlight" class="page route">
	<div class="head">
		<a href="{{ route('overviewsAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All Overview</a>
		<h1 class="title">Add Overview</h1>		
	</div>
	<div class="main">
		<form action="{{ route('createOverviewAdmin') }}" method="post" class="dev-form create-guide activity-form form-add ">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="title">Choose overview<small>(*)</small></label>
								<select class="select2" name="country_id">
									<option value="">Choose overview</option>
									@foreach($list_overview as $overview)
										<option value="{{ $overview->id }}" @if($overview->id == $country_id) selected @endif>{{ $overview->title }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="title">List main city</label>
						<select multiple="multiple" name="list_main_city[]" class="form-control select2">
                            @foreach ($list_city as $item)
                                <option value="{{ $item->id }}"> {{ $item->title }} </option>
                            @endforeach
                        </select>
					</div>
					<div class="form-group">
						<label for="title">Text where to go</label>
						<textarea class="form-control" name="text_where_to_go"></textarea>
					</div>
					<div class="form-group">
						<label for="title">Text What to do & see</label>
						<textarea class="form-control" name="text_what_to_do"></textarea>
					</div>
					
					<div class="form-group">
						<label for="title">Text more inspiration?</label>
						<textarea class="form-control" name="text_more_inspiration"></textarea>
					</div>
					<div class="form-group">
						<label for="title">Text exclusive experience</label>
						<textarea class="form-control" name="text_exclusive"></textarea>
					</div>
					<div class="form-group" id="frm-hand">
						<label for="title">Text hand crafted</label>
						<textarea class="form-control" name="text_hand_crafted" id="editor"></textarea>
					</div>
					<div class="form-group" id="frm-preparing">
						<label for="title">Text preparing</label>
						<textarea class="form-control" name="text_preparing" id="preparing"></textarea>
					</div>
					<!-- <div id="frm-tb-content" class="form-group just-level-1 has-thumb" data-load-media={{ route('loadMedia') }}>
						<input type="hidden" class="string-value" name="list_quick_info" value="">
						<label for="title">List quick information</label>
						<table class="field block-style">
							<tbody class="sortable"></tbody>
						</table>
						<a href="javascript:void(0)" class="btn add-row m-t-10">Add content</a>
					</div>
					<div id="frm-tb-content" class="form-group just-level-1 has-thumb" data-load-media={{ route('loadMedia') }}>
						<input type="hidden" class="string-value" name="list_trip_planning" value="">
						<label for="title">List trip planning</label>
						<table class="field block-style">
							<tbody class="sortable"></tbody>
						</table>
						<a href="javascript:void(0)" class="btn add-row m-t-10">Add content</a>
					</div> -->
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Icon flag gray</h2>
							<div id="frm-icon-flag-gray" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="icon_flag_gray" class="thumb-media" value="" />
								</div>
							</div>
						</section>
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Icon flag active</h2>
							<div id="frm-icon-flag" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="icon_flag" class="thumb-media" value="" />
								</div>
							</div>
						</section>
					</div>
					<div class="group-fixed">
						<section id="sb-action">
							<div class="group-action">
								<button type="submit" name="submit" class="btn">Save</button>
								<a href="#" class="btn btn-cancel">Cancel</a>									
							</div>
						</section>
					</div>
				</div>

			</div>
		</form>
	</div>
</div>
@include('backend.media.library')
<script type="text/javascript">
	ckeditor("editor");
	ckeditor("preparing");
</script>
@stop