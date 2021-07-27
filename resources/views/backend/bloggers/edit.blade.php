@php
	$listBlogs = getAticlesOrderByTitle();
	$listHotels = getHotelsOrderByTitle();
	$meta_key = ($seo) ? $seo->key : '';
	$meta_value = ($seo) ? $seo->value : '';
	$array_articleID = ($blogger->favourite_article != '') ? explode(",", $blogger->favourite_article) : [];
	$array_highlightID = ($blogger->favourite_highlight != '') ? explode(",", $blogger->favourite_highlight) : [];
	$list_favouriteBooks = json_decode($blogger->favourite_books);
	$list_social = json_decode($blogger->social_icon);
@endphp
@extends('backend.layout.index')
@section('title','Edit Blogger')
@section('content')


<div id="edit-blogger" class="container page route padding-bottom-200">
	<div class="head">
		<a href="{{route('bloggersAdmin')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> All bloggers</a>
		<h1 class="title">Edit Blogger</h1>		

	</div>
	<div class="main">
		<form action="{{ route('updateBloggerAdmin', $blogger->id) }}" method="post" class="dev-form activity-form">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-9 content">
					<div class="form-group" id="frm-title">
						<label for="title">Name<small>(*)</small></label>
						<input type="text" name="title" class="form-control" value="{{ $blogger->title }}" />
					</div>
					<div id="frm-slug" class="form-group">
						<label for="slug">Slug<small class="required">(*)</small></label>
						<div class="wrap">
							<span>{{$blogger->slug}}</span>
							<input type="text" name="slug" value="{{$blogger->slug}}" class="form-control hide" />
							<a href="#" class="edit-slug">Edit</a>
							<a href="#" class="btn save-slug hide">OK</a>
							<a href="#" class="cancel hide">Cancel</a>
						</div>
					</div>
					<div id="frm-title-tag" class="form-group">
						<label for="title_tag">Title tag (SEO title) 65-70 characters</label>
						<span class="count-characters">({{ strlen($blogger->title_tag) }} characters)</span>
						<input type="text" name="title_tag" class="form-control" placeholder="Title tag (SEO title) 65-70 characters" value="{{ $blogger->title_tag }}">
					</div>
					<div id="frm-metaKey" class="form-group">
						<label for="metakey">Keyword (SEO)</label>
						<input type="text" name="meta_key" class="form-control" placeholder="Input keyword (SEO)" value="{{ $meta_key }}">
					</div>
					<div id="frm-metaValue" class="form-group">
						<label class="metaValue">Meta Description (SEO) 150-160 characters</label>
						<span class="count-characters">({{ strlen($meta_value) }} characters)</span>
						<textarea name="meta_value" placeholder="Input meta description (SEO) 150-160 characters" class="form-control">{{ $meta_value }}</textarea>
					</div>
					<div id="frm-desc" class="form-group">
						<label for="desc">Description</label>
						<textarea name="desc" id="editor">{{ $blogger->desc }}</textarea>
					</div>
					<!-- <div id="frm-short-desc" class="form-group">
						<label for="short-desc">Slogan</label>
						<textarea name="short_desc" class="form-control">{{ $blogger->short_desc }}</textarea>
					</div> -->
					<div id="frm-social" class="form-group frm-add-row">
						<label for="metakey">Social</label>
						<input type="hidden" class="json-value json-add" name="social_icon">
						<table class="field block-style">
							<tbody class="sortable">
							@if($list_social)
								@foreach($list_social as $key => $item)
									<tr class="add">
										<td>{{ $key + 1 }}</td>
										<td>
											<div class="field-row">
												<div class="row-left">
													<label>Image</label>
												</div>
												<div class="row-right">
													<div id="image-book-{{ $key + 1 }}" class="desc img-upload" data-id-name="image-book">
														<div class="image">
															<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
															{!!image($item->image, 150,150, 'Image')!!}
															<input type="hidden" class="thumb-media field-item" data-name="image" value="{{ $item->image }}" />
														</div>
													</div>
												</div>
											</div>
											<div class="field-row">
												<div class="row-left">
													<label>Title</label>
												</div>
												<div class="row-right"><input type="text" class="form-control field-item" data-name="title" value="{{ $item->title }}" /></div>
											</div>
											<div class="field-row">
												<div class="row-left">
													<label>Link</label>
												</div>
												<div class="row-right"><input type="text" class="form-control field-item" data-name="link" value="{{ $item->link }}" /></div>
											</div>
										</td>
										<td class="delete text-center">
											<div class="del-tooltip">
												<a href="#" class="remove-row"><span>─</span></a>
												<div class="tooltip">
													<div class="wrap">Are you sure?
														<div id="d-yes"><a href="#" class="yes">Yes</a></div>
														<div id="d-no"><a href="#" class="no">Cancle</a></div>
													</div>
												</div>
											</div>
										</td>
									</tr>
								@endforeach
							@endif
							</tbody>
						</table>
						<a href="#" class="btn btn-default add-row">Add row</a>
						@if($list_social != NULL)
							<div class="group-row-add hidden">
								<div class="field-row">
									<div class="row-left">
										<label>Title</label>
									</div>
									<div class="row-right"><input type="text" class="form-control field-item" data-name="title" /></div>
								</div>
								<div class="field-row">
									<div class="row-left">
										<label>Image</label>
									</div>
									<div class="row-right">
										<div id="image-book-{{ count($list_social) + 1}}" class="desc img-upload" data-id-name="image-book">
											<div class="image">
												<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
												{!!image('', 150,150, 'Image')!!}
												<input type="hidden" class="thumb-media field-item" data-name="image" />
											</div>
										</div>
									</div>
								</div>
								<div class="field-row">
									<div class="row-left">
										<label>Link</label>
									</div>
									<div class="row-right"><input type="text" class="form-control field-item" data-name="link" /></div>
								</div>
							</div>
						@else
							<div class="group-row-add hidden">
								<div class="field-row">
									<div class="row-left">
										<label>Title</label>
									</div>
									<div class="row-right"><input type="text" class="form-control field-item" data-name="title" /></div>
								</div>
								<div class="field-row">
									<div class="row-left">
										<label>Image</label>
									</div>
									<div class="row-right">
										<div id="image-book-1" class="desc img-upload" data-id-name="image-book">
											<div class="image">
												<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
												{!!image('', 150,150, 'Image')!!}
												<input type="hidden" class="thumb-media field-item" data-name="image" value="" />
											</div>
										</div>
									</div>
								</div>
								<div class="field-row">
									<div class="row-left">
										<label>Link</label>
									</div>
									<div class="row-right"><input type="text" class="form-control field-item" data-name="link" /></div>
								</div>
							</div>
						@endif
					</div>
					<div id="frm-favourite-blog" class="form-group">
						<label for="favourite-tour">Favourite Articles</label>
						<select multiple class="select2" name="article[]"  data-order="{{ $blogger->favourite_article }}">
							@foreach($list_article as $item)
								<option value="{{ $item->id }}" @if(in_array($item->id, $array_articleID)) selected @endif>{{ $item->title }}</option>
							@endforeach
						</select>
					</div>
					<div id="frm-favourite-country" class="form-group">
						<label for="favourite-country">Favourite places to visit</label>
						<select multiple class="select2" name="highlight[]" data-order="{{ $blogger->favourite_highlight }}">
							@foreach($list_highlight as $item)
								<option value="{{ $item->id }}" @if(in_array($item->id, $array_highlightID)) selected @endif>{{ $item->country->title }}</option>
							@endforeach
						</select>
					</div>
					<div id="frm-book" class="form-group frm-add-row">
						<label for="metakey">Favourite Books</label>
						<input type="hidden" class="json-value json-add" name="favourite_books">
						<table class="field block-style">
							<tbody class="sortable">
							@if($list_favouriteBooks)
								@foreach($list_favouriteBooks as $key => $item)
									<tr class="add">
										<td>{{ $key + 1 }}</td>
										<td>
											<div class="field-row">
												<div class="row-left">
													<label>Image</label>
												</div>
												<div class="row-right">
													<div id="image-book-{{ $key + 1 }}" class="desc img-upload" data-id-name="image-book">
														<div class="image">
															<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
															{!!image($item->image, 150,150, 'Image')!!}
															<input type="hidden" class="thumb-media field-item" data-name="image" value="{{ $item->image }}" />
														</div>
													</div>
												</div>
											</div>
											<div class="field-row">
												<div class="row-left">
													<label>Title</label>
												</div>
												<div class="row-right"><input type="text" class="form-control field-item" data-name="title" value="{{ $item->title }}" /></div>
											</div>
											<div class="field-row">
												<div class="row-left">
													<label>Link</label>
												</div>
												<div class="row-right"><input type="text" class="form-control field-item" data-name="link" value="{{ $item->link }}" /></div>
											</div>
										</td>
										<td class="delete text-center">
											<div class="del-tooltip">
												<a href="#" class="remove-row"><span>─</span></a>
												<div class="tooltip">
													<div class="wrap">Are you sure?
														<div id="d-yes"><a href="#" class="yes">Yes</a></div>
														<div id="d-no"><a href="#" class="no">Cancle</a></div>
													</div>
												</div>
											</div>
										</td>
									</tr>
								@endforeach
							@endif
							</tbody>
						</table>
						<a href="#" class="btn btn-default add-row">Add row</a>
						@if($list_favouriteBooks)
							<div class="group-row-add hidden">
								<div class="field-row">
									<div class="row-left">
										<label>Image</label>
									</div>
									<div class="row-right">
										<div id="image-book-{{ count($list_favouriteBooks) + 1}}" class="desc img-upload" data-id-name="image-book">
											<div class="image">
												<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
												{!!image('', 150,150, 'Image')!!}
												<input type="hidden" class="thumb-media field-item" data-name="image" />
											</div>
										</div>
									</div>
								</div>
								<div class="field-row">
									<div class="row-left">
										<label>Title</label>
									</div>
									<div class="row-right"><input type="text" class="form-control field-item" data-name="title" /></div>
								</div>
								<div class="field-row">
									<div class="row-left">
										<label>Link</label>
									</div>
									<div class="row-right"><input type="text" class="form-control field-item" data-name="link" /></div>
								</div>
							</div>
						@else
							<div class="group-row-add hidden">
								<div class="field-row">
									<div class="row-left">
										<label>Title</label>
									</div>
									<div class="row-right"><input type="text" class="form-control field-item" data-name="title" /></div>
								</div>
								<div class="field-row">
									<div class="row-left">
										<label>Image</label>
									</div>
									<div class="row-right">
										<div id="image-book-1" class="desc img-upload" data-id-name="image-book">
											<div class="image">
												<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
												{!!image('', 150,150, 'Image')!!}
												<input type="hidden" class="thumb-media field-item" data-name="image" value="" />
											</div>
										</div>
									</div>
								</div>
								<div class="field-row">
									<div class="row-left">
										<label>Link</label>
									</div>
									<div class="row-right"><input type="text" class="form-control field-item" data-name="link" /></div>
								</div>
							</div>
						@endif
					</div>

				</div>
				<div class="col-md-3 sidebar">
					<div class="gr-not-fixed">
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Image</h2>
							<div id="frm-image" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($blogger->image, 150,150, 'Image')!!}
									<input type="hidden" name="image" class="thumb-media" value="{{ $blogger->image }}" />
								</div>
							</div>
						</section>
						<section id="sb-image" class="box-wrap">
							<h2 class="title">Banner</h2>
							<div id="frm-banner" class="desc img-upload">							
								<div class="image">
									<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
									{!!image($blogger->banner, 150,150, 'Image')!!}
									<input type="hidden" name="banner" class="thumb-media" value="{{ $blogger->banner }}" />
								</div>
							</div>
						</section>
						<section class="sb-time-info">
							<ul class="list-unstyled">
								<li><strong>Created at:</strong> {{ date('d M Y H:i', strtotime($blogger->created_at)) }}</li>
								<li><strong>Updated at:</strong> {{ date('d M Y H:i', strtotime($blogger->updated_at)) }}</li>
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
</script>
@stop