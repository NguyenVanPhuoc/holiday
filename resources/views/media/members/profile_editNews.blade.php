@extends('templates.master')
@section('title','Sửa tin')
@section('content')
<?php if($seo){
	$key = $seo->key;
	$value = $seo->value;
}else{
	$key = "";
	$value = "";
}?>
<div id="profile" class="page profile">
	<div class="container">
		<div class="pro-wrap">
			@include('members.profile_header')
			<div id="pro-main" class="row">			
				<div class="main col-md-10">
					<form action="{{route('createBlogAdmin')}}" class="frm-menu dev-form" method="POST" name="create_tour" role="form">
						{!!csrf_field()!!}
						<div class="row">
							<div class="col-md-9 content">
								<div id="frm-title" class="form-group">
									<label for="title">Tiêu đề<small class="required">(*)</small></label>
									<input type="text" name="title" class="form-control" placeholder="Nhập tiêu đề" class="frm-input" value="{{$article->title}}">
								</div>
								<div id="frm-content" class="form-group">
									<label for="content">Nội dung</label>
									<textarea name="content" id="editor">{!!$article->content!!}</textarea>
								</div>
								<div id="frm-shortContent" class="form-group">
									<label class="short-content">Mô tả ngắn</label>
									<textarea name="shortContent" placeholder="Nhập nội mô tả" class="form-control" rows="5">{!!$article->desc!!}</textarea>
								</div>
								<div id="frm-metaKey" class="form-group">
									<label for="metakey">Từ khóa</label>
									<input type="text" name="metakey" class="form-control" placeholder="Nhập từ khóa SEO" class="frm-input" value="{{$key}}">
								</div>
								<div id="frm-metaValue" class="form-group">
									<label class="metaValue">Nội dung SEO</label>
									<textarea name="metaValue" placeholder="Nhập nội dung SEO" class="form-control" rows="5">{{$value}}</textarea>
								</div>					
							</div>
							<div class="col-md-3 sidebar">
								<?php $categories = get_categories();?>
								@if(!$categories->isEmpty())
								<section id="sb-categories" class="box-wrap">
									<h2 class="title">Danh mục</h2>
									<div class="desc list">
										@foreach($categories as $item)
										<div class="checkbox checkbox-success item">
											<input id="category-{{$item->id}}" type="checkbox" name="routes[]" value="{{$item->id}}">
											<label for="category-{{$item->id}}">{{$item->title}}</label>
										</div>
										@endforeach
									</div>						
								</section>
								@endif
								<section id="sb-image" class="box-wrap">
									<h2 class="title">Ảnh đại diện</h2>
									<div id="frm-image" class="desc img-upload">							
										<div class="image">
											<a href="{{ route('loadMedia') }}" class="library"><i class="fa fa-edit" aria-hidden="true"></i></a>
											{!!image('', 150,150, 'Ảnh đại diện')!!}
											<input type="hidden" name="image" class="thumb-media" value="" />
										</div>
									</div>
								</section>
								<section id="sb-status" class="box-wrap">
									<h2 class="title">Trạng thái</h2>
									<div class="desc list dropdown local-dropdown">{!!getStatusHtml('b-status','')!!}</div>
								</section>
							</div>
							<div class="col-md-9">
								<div class="group-action">
									<button type="submit" name="submit" class="btn">Lưu</button>
									<a href="{{route('blogAdmin')}}" class="btn btn-cancel">Hủy</a>									
								</div>
							</div>
						</div>			
					</form>
				</div>
				<div class="sidebar col-md-2">@include('sidebars.member')</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	CKEDITOR.replace( 'editor' );
</script>
@endsection