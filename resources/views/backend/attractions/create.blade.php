@extends('backend.layout.index')
@section('title','Add Attraction')
@section('content')
@php
	$countries = getCountryLevel1();
	//var_dump(getFarthestParentCountry(177));
@endphp
<div id="create-attraction" class="page route">
	<div class="head">
		<a href="{{route('attractionsAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All attraction</a>
		<h1 class="title">Add Attraction</h1>		
	</div>
	<div class="main">
		<form action="{{ route('createAttractionAdmin') }}" method="post" class="dev-form create-attraction activity-form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div class="form-group" id="frm-title">
						<label for="title">Title<small>(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" />
					</div>
					<div id="frm-desc" class="form-group">
						<label for="content">Description</label>
						<textarea name="desc" class="form-control" id="editor"></textarea>
					</div>
					<div id="frm-gallery" class="form-group img-upload">
						<label for="content">Gallery</label>
						<div class="wrap-gallery"></div>
						<div class="bot-wrap">
							<a href="{{ route('loadMedia') }}" class="btn btn-default library-gallery">Add to gallery</a>
							<input type="hidden" name="gallery" class="thumb-media" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="content">Select icon attraction</label>
						<select multiple="multiple" name="list_icon[]" class="form-control select2">
                            @foreach ($list_icon as $item)
                                <option value="{{ $item->id }}"> {{ $item->title }} </option>
                            @endforeach
                        </select>
					</div>
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<!-- <section id="sb-country" class="box-wrap">
							<h2 class="title">City</h2>
							<select name="country_id" class="form-control select2">
								<option value="">Select city</option>
							                            @foreach ($list_highlight as $item)
							                                <option value="{{ $item->id }}"> {{ $item->title }} </option>
							                            @endforeach
							                        </select>					
						</section> -->
						<section id="sb-country" class="box-wrap">
							<h2 class="title">Country</h2>
							<select name="country_id">
								<option value="">Country</option>
								@foreach($countries as $country)
									<option value="{{ $country->id }}">{{ $country->title }}</option>
								@endforeach
							</select>	
						</section>
						<?php $categories = get_categories_tour();?>
						@if(!$categories->isEmpty())
						<section id="sb-categories" class="box-wrap">
							<h2 class="title">Tour Style</h2>
							<div class="desc list">
	                            @if($categories)
	                                <ul class="no-list-style list-item">
	                                    @foreach($categories as $item)
	                                    <li class="checkbox checkbox-success">
	                                    	<input value="{{$item->id}}" type="checkbox" name="categories[]" id="cat-{{$item->id}}">
	                                    	<label for="cat-{{$item->id}}">{{$item->title}}</label>
	                                    </li>
	                                    @endforeach
	                                </ul>
	                            @endif
							</div>
						</section>
						@endif
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Image</h2>
							<div id="frm-image" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image('', 150,150, 'Image')!!}
									<input type="hidden" name="image" class="thumb-media" value="" />
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
	$(function() {
       
   	});	
</script>
@stop