@extends('backend.layout.index')
@section('title','Edit Overview')
@section('content')
@php
	$arrayEditor = []; 
	$country_id = isset($_GET['country_id']) ? $_GET['country_id'] : '';

	$array_main_cityID = ($overview->list_main_city != '') ? explode(",", $overview->list_main_city) : []; 
	$best_things_to_doID = ($overview->best_things_to_do != '') ? explode(",", $overview->best_things_to_do) : [];
	$list_quick_info = json_decode($overview->list_quick_info);
	$list_trip_planning = json_decode($overview->list_trip_planning);
	$list_what_to_eat = json_decode($overview->list_what_to_eat); 	
	
@endphp
<div id="create-highlight" class="page route">
	<div class="head">
		<a href="{{ route('overviewsAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All Overview</a>
		<h1 class="title">Edit Overview</h1>		
	</div>
	<div class="main">
		<form action="{{ route('updateOverviewAdmin', $country->slug) }}" method="post" class="dev-form create-guide activity-form form-add ">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="title">Choose overview<small>(*)</small></label>
								<input type="text" value="{{ $country->title }}" class="form-control" readonly />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="title">List main city</label>
						<select multiple="multiple" name="list_main_city[]" class="form-control select2 test" data-order="{{ $overview->list_main_city }}">
                            @foreach ($list_city as $item)
                                <option value="{{ $item->id }}" @if(in_array($item->id, $array_main_cityID)) selected @endif> {{ $item->title }} </option>
                            @endforeach
                        </select>
					</div>
					
					<div class="form-group">
						<label for="title">Text where to go</label>
						<textarea class="form-control" name="text_where_to_go">{{ $overview->text_where_to_go }}</textarea>
					</div>
					<div class="form-group">
						<label for="title">Text What to do & see</label>
						<textarea class="form-control" name="text_what_to_do">{{ $overview->text_what_to_do }}</textarea>
					</div>
					
					<div class="form-group">
						<label for="title">Text more inspiration?</label>
						<textarea class="form-control" name="text_more_inspiration">{{ $overview->text_more_inspiration }}</textarea>
					</div>
					<div class="form-group">
						<label for="title">Text exclusive experience</label>
						<textarea class="form-control" name="text_exclusive">{{ $overview->text_exclusive }}</textarea>
					</div>
					<div class="form-group" id="frm-hand">
						<label for="title">Text hand crafted</label>
						<textarea class="form-control" name="text_hand_crafted" id="editor">{!! $overview->text_hand_crafted !!}</textarea>
					</div>
					<div class="form-group" id="frm-preparing">
						<label for="title">Text preparing</label>
						<textarea class="form-control" name="text_preparing" id="preparing">{!! $overview->text_preparing !!}</textarea>
					</div>
				<!-- 	<div id="frm-tb-content" class="form-group just-level-1 has-thumb" data-load-media={{ route('loadMedia') }}>
					<input type="hidden" class="string-value" name="list_quick_info" value="">
					<label for="title">List quick information</label>
					<table class="field block-style">
						<tbody class="sortable">
							@if($list_quick_info != '')
								@foreach($list_quick_info as $key => $item)
									@php
										$arrayEditor[] = 'list_quick_info_'. ($key+1);
										$num_row = $key + 1;
										$row_image = $item->image;
										$row_title = $item->title;
										$row_content = $item->content;
										$row_idEditor = 'list_quick_info_'. ($key+1);
									@endphp
									@include('backend.templates.item-overviews-tb-content')
								@endforeach
							@endif
						</tbody>
					</table>
					<a href="javascript:void(0)" class="btn add-row m-t-10">Add content</a>
				</div>
				<div id="frm-tb-content" class="form-group just-level-1 has-thumb" data-load-media={{ route('loadMedia') }}>
					<input type="hidden" class="string-value" name="list_trip_planning" value="">
					<label for="title">List trip planning</label>
					<table class="field block-style">
						<tbody class="sortable">
							@if($list_trip_planning != '')
								@foreach($list_trip_planning as $key => $item)
									@php
										$arrayEditor[] = 'list_trip_planning_'. ($key+1);
										$num_row = $key + 1;
										$row_image = $item->image;
										$row_title = $item->title;
										$row_content = $item->content;
										$row_idEditor = 'list_trip_planning_'. ($key+1);
									@endphp
									@include('backend.templates.item-overviews-tb-content')
								@endforeach
							@endif
						</tbody>
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
									{!!image($overview->icon_flag_gray, 150,150, 'Image')!!}
									<input type="hidden" name="icon_flag_gray" class="thumb-media" value="{{ $overview->icon_flag_gray }}" />
								</div>
							</div>
						</section>
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Icon flag active</h2>
							<div id="frm-icon-flag" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($overview->icon_flag, 150,150, 'Image')!!}
									<input type="hidden" name="icon_flag" class="thumb-media" value="{{ $overview->icon_flag }}" />
								</div>
							</div>
						</section>
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($overview->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($overview->updated_at)) }}</li>
							</ul>
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
	@php
		foreach ($arrayEditor as $key => $value) {
			@endphp
				ckeditor('{{$value}}');
			@php
		}
	@endphp
</script>
@stop