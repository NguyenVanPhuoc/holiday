@extends('backend.layout.index')
@section('title','Edit FAQs')
@section('content')

<div id="create-guide" class="page route">
	<div class="head">
		<a href="{{route('faqsAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All FAQs</a>
		<h1 class="title">Edit FAQs</h1>		
	</div>
	<div class="main">
		<form action="{{ route('updateFaqAdmin', $faq->id) }}" method="post" class="dev-form create-guide activity-form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-10 content">
					<div class="form-group" id="frm-long-title">
						<label for="title">Title<small>(*)</small></label>
						<input type="text" name="title" class="form-control" placeholder="Input title" value="{{ $faq->title }}" />
					</div>
					<div id="frm-desc" class="form-group">
						<label for="content">Content</label>
						<textarea name="content" id="editor">{!! $faq->content !!}</textarea>
					</div>
				</div>
				<div class="col-md-2 sidebar">
					<div class="gr-not-fixed">
						<section id="sb-category" class="box-wrap">
							<h2 class="title">Category</h2>
							<select name="cat_id" class="select2">
								<option value="">Chose category</option>
								@if($list_cat)
									@foreach($list_cat as $cat)
										<option value="{{ $cat->id }}" @if($cat->id == $faq->cat_id) selected @endif>{{ $cat->title }}</option>
									@endforeach
								@endif
							</select>
							
						</section>
						<section id="sb-asked" class="box-wrap">
							<h2 class="title">Most asked</h2>
							<ul class="no-list-style list-item ">
	                           <li class="checkbox checkbox-success {{ $faq->most_asked }}">
								<input value="1" type="checkbox" name="most_asked" id="cat_asked" {{ ($faq->most_asked != 1) ? '' : 'checked' }}>
								<label for="cat_asked">Most asked</label>
							</li>
	                       </ul>
						</section>
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($faq->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($faq->updated_at)) }}</li>
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
	$(function() {
       
   	});	
</script>
@stop