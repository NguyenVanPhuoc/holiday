@php
	$meta_key = $meta_value = '';
	$seo = $seo = get_seo($countryTourDuration->id,'country_tour_duration');
	if($seo){
		$meta_key = $seo->key;
		$meta_value = $seo->value;
	}
	$list_content = json_decode($countryTourDuration->list_content);
	//dd($list_content);
	$arrayEditor = [];
	$list_city = getAllCountryByLevel(3, true);
	$list_style = getAllCountryTourStyle();
	$list_tour = getAllToursV1();
	$slug_duration= getSlugDurationById($countryTourDuration->duration_id);
	$slug_country= getSlugCountryById($countryTourDuration->country_id);
@endphp

@extends('backend.layout.index')
@section('title','Edit country tour duration')
@section('content')
<div id="frm-list-city" class="hidden">
	<div class="row-left">
		<label>Route</label>
	</div>
	<div class="row-right">
		<select multiple="multiple" name="list_city[]" class="form-control">
	        @foreach ($list_city as $item)
	            <option value="{{ $item->id }}"> {{ $item->title }} </option>
	        @endforeach
	    </select>
	</div>
</div>
<div id="frm-list-style" class="hidden">
	<div class="row-left">
		<label>Experience</label>
	</div>
	<div class="row-right">
		<select multiple="multiple" name="list_style[]" class="form-control">
	        @foreach ($list_style as $item)
	            <option value="{{ $item->id }}"> {{ $item->title }} </option>
	        @endforeach
	    </select>
	</div>
</div>
<div id="frm-list-tour" class="hidden">
	<div class="row-left">
		<label>Sample tour packages</label>
	</div>
	<div class="row-right">
		<select multiple="multiple" name="list_tour[]" class="form-control">
	        @foreach ($list_tour as $item)
	            <option value="{{ $item->id }}"> {{ $item->title }} </option>
	        @endforeach
	    </select>
	</div>
</div>
<div id="create-country-tour-duration" class="page route">
	<div class="head">
		<a href="{{route('countryTourDurationsAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All country tour duration</a>
		<a href="{{route('tour', ['slug_country'=>$slug_country->slug,'slug'=>$slug_duration->slug])}}" target="_blank" class="view-fast"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View duration</a>	
		<h1 class="title">Edit country tour duration</h1>		
	</div>
	<div class="main">
		<form action="{{ route('updateCountryTourDurationAdmin', $countryTourDuration->id) }}" method="post" class="dev-form create-guide activity-form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div class="form-group" id="frm-long-title">
						<label for="title">Title<small>(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" value="{{ $countryTourDuration->title }}" />
					</div>
					<!-- <div id="frm-slug" class="form-group">
						<label for="slug">Slug<small class="required">(*)</small></label>
						<div class="wrap">
							<span>{{$countryTourDuration->slug}}</span>
							<input type="text" name="slug" value="{{$countryTourDuration->slug}}" class="form-control hide" />
							<a href="#" class="edit-slug">Edit</a>
							<a href="#" class="btn save-slug hide">OK</a>
							<a href="#" class="cancel hide">Cancel</a>
						</div>
					</div> -->
					<div id="frm-title-tag" class="form-group">
						<label for="title_tag">Title tag (SEO title) 65-70 characters</label>
						<span class="count-characters"></span>
						<input type="text" name="title_tag" class="form-control" placeholder="Title tag (SEO title) 65-70 characters" class="frm-input" value="{{ $countryTourDuration->title_tag }}">
					</div>
					<div id="frm-metaKey" class="form-group">
						<label for="metakey">Keyword (SEO)</label>
						<input type="text" name="meta_key" class="form-control" placeholder="Input keyword (SEO)" class="frm-input" value="{{ $meta_key }}">
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="metaValue">Meta Description (SEO) 150-160 characters</label>
						<span class="count-characters"></span>
						<textarea name="meta_value" placeholder="Input meta description (SEO) 150-160 characters" class="form-control">{{ $meta_value }}</textarea>
					</div>
					<div id="frm-desc" class="form-group">
						<label for="content">Description</label>
						<textarea name="desc" id="editor">{{ $countryTourDuration->desc }}</textarea>
					</div>
					<div class="form-group">
						<label>Text list content</label>
						<textarea name="text_list_content" class="form-control">{{ $countryTourDuration->text_list_content }}</textarea>
					</div>
					<div id="frm-tb-content" class="form-group has-map just-level-1 has-duration has-thumb" data-load-media="{{ route('loadMedia') }}">
						<input type="hidden" class="string-value" name="list_content" value="">
						<label>Table content</label><br>
						<table class="field block-style row-style">
							<tbody class="sortable">
								@if($list_content)
								@foreach($list_content as $key => $item)
									@php
										$arrayEditor[] = 'list-content-'. ($key+1);
										$num_row = $key+1;
										$row_title = $item->title;
										$row_image = $item->image;
										$row_city = isset($item->list_city) ? $item->list_city : '';
										$row_style = isset($item->list_style) ? $item->list_style : '';
										$row_tour = isset($item->list_tour) ? $item->list_tour : '';
										//dd($row_style);
										$row_map = isset($item->map) ? $item->map : '';
										$row_idEditor = 'list-content-'. ($key+1);
										$row_content = $item->content;
									@endphp
									@include('backend.templates.item-single-tb-content')
								@endforeach
								@endif
							</tbody>
						</table>
						<a href="javascript:void(0)" class="btn add-row m-t-10">Add row</a>
					</div>		
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<section id="sb-country" class="box-wrap">
							<h2 class="title">Country</h2>
							<select name="country_id">
								<option value="">Chose country</option>
								@foreach($list_country as $country)
									<option value="{{ $country->id }}" @if($country->id == $countryTourDuration->country_id) selected @endif >{{ $country->title }}</option>
								@endforeach
							</select>	
						</section>
						<section id="sb-category" class="box-wrap">
							<h2 class="title">Category</h2>
							<select name="duration_id" class="select2">
								<option value="">Chose duration</option>
								@if($list_duration)
									@foreach($list_duration as $duration)
										<option value="{{ $duration->id }}" @if($duration->id == $countryTourDuration->duration_id) selected @endif >{{ $duration->title }}</option>
									@endforeach
								@endif
							</select>
						</section>
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Image</h2>
							<div id="frm-image" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image( $countryTourDuration->image, 150,150, 'Image')!!}
									<input type="hidden" name="image" class="thumb-media" value="{{ $countryTourDuration->image }}" />
								</div>
							</div>
						</section>
						<section id="sb-image-looking" class="box-wrap">
							<h2 class="title">Image Looking</h2>
							<div id="frm-image-looking" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($countryTourDuration->image_looking, 150,150, $countryTourDuration->title)!!}
									<input type="hidden" name="image_looking" class="thumb-media" value="{{$countryTourDuration->image_looking}}" />
								</div>
							</div>
						</section>
						<section id="sb-image-request" class="box-wrap">
							<h2 class="title">Image Request</h2>
							<div id="frm-image-request" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($countryTourDuration->image_request, 150,150, $countryTourDuration->title)!!}
									<input type="hidden" name="image_request" class="thumb-media" value="{{$countryTourDuration->image_request}}" />
								</div>
							</div>
						</section>
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($countryTourDuration->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($countryTourDuration->updated_at)) }}</li>
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
	@php
		if($arrayEditor){
			foreach ($arrayEditor as $key => $value) {
				@endphp
					ckeditor('{{$value}}');
				@php
			}
		}
	@endphp	
</script>
@stop