@extends('backend.layout.index')
@section('title','Medias')
@section('content')
<?php $mediaCats = getMediaCats();	
	$category = isset($category)? $category : '';	
	if(isset($category) && $category!=""){
		$catId = $category;
		$catTitle = get_category_media($category)->title;
	}else{
		$catId = "";
		$catTitle = "---Category---";
	}
	$list_author = getAuthor();	
	$author = isset($author) ? $author : '';	
	if(isset($author) && $author!=""){
		$authorId = $author;
		$authorName = getUser($author)->name;
	}else{
		$authorId = "";
		$authorName = "---Author---";
	}
	$key = isset($s)? $s:'';

?>
<div id="media" class="page">
	<div class="head"><h1 class="title">Medias</h1></div>
	<div class="search-form">
		<form name="s" action="{{route('search')}}" method="GET">
			<div class="row">
				<div id="frm-author" class="col-md-4">
					@if(isset($list_author))
						<select name="author" class="select2">
							<option value="{{$authorId}}">{{$authorName}}</option>
							@foreach($list_author as $item)
							<option value="{{$item->id}}">{{$item->name}}</option>
							@endforeach
						</select>
					@endif
				</div>
				<div id="frm-category" class="col-md-4">
					@if(isset($mediaCats))
						<select name="category" class="select2">
							<option value="{{$catId}}">{{$catTitle}}</option>
							@foreach($mediaCats as $item)
							<option value="{{$item->id}}">{{$item->title}}</option>
							@endforeach
						</select>
						@endif
				</div>
				<div id="frm-title" class="col-md-4"><input type="text" name="s" class="form-control" placeholder="Input keyword..." value="{{$key}}"></div>
			</div>
			<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
		</form>
	</div>
	<form id="media-frm" action="#" method="post" name="media" class="dev-form">
		{!! csrf_field() !!}	
		<table class="table table-striped">
			<thead>
				<tr>
					<th id="check-all" scope="col" class="check">
						<div class="checkbox checkbox-success">
							<input id="check" type="checkbox" name="checkAll[]" value="">
							<label for="check"></label>
						</div>
					</th>
					<th scope="col" class="stt">#</th>
					<th scope="col" class="image">Image</th>
					<th scope="col" class="title">Title</th>
					<th scope="col" class="category">Category</th>
					<th scope="col" class="author">Author</th>				
					<th scope="col" class="size">Size</th>				
					<th scope="col" class="action"></th>
				</tr>
			</thead>
			<tbody>
				@if(isset($media))
					<?php $count = 0;?>
					@foreach($media as $item) <?php $count++; $user = getUser($item->user_id);?>
					<tr id="image-{{ $item->id }}">
						<td class="check">
							<div class="checkbox checkbox-success">
								<input id="media-{{$item->id}}" type="checkbox" name="medias[]" value="{{$item->id}}">
								<label for="media-{{$item->id}}"></label>
							</div>
						</td>
						<td scope="row" class="stt">{{ $count }}</td>
						<td class="image">
							@if($item->type == 'pdf')
								<img src="{{asset('/public/admin/images/pdf_icon.png')}}" alt="pdf-icon" />
							@else
								{!!image($item->id, 100,60, $item->title)!!}
							@endif
						</td>
						<td class="title">{{ $item->title }}</td>								
						<td class="category">
							@if($item->cat_ids)
								<?php $number = 0;
								$cats = explode(',',$item->cat_ids);
								foreach ($cats as $value) {
									$number ++;
									$cat = getMediaCat($value);
									if($cat) echo $cat->title;									
									if($number < count($cats)) echo ', ';
								}?>
							@endif
						</td>
						<td class="author">@if($user->name != NULL){{ $user->name }}@endif</td>
						<td class="size">
							<span>W: {{ $item->width }}</span>,
							<span>H: {{ $item->height }}</span>,
							<span>S: {{formatSizeUnits($item->size)}}</span>
						</td>
						<td class="action">
							<a href="{{route('editMedia',['id'=>$item->id])}}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
							<a href="{{route('deleteMedia',['id'=>$item->id])}}" class="delete"><i class="fa fa-close" aria-hidden="true"></i></a>
						</td>
					</tr>
					@endforeach
				@else
					<tr><td colspan="6">Chưa có file nào...</td></tr>
				@endif			
			</tbody>
		</table>
	</form>
</div>
@if($authorId=="" && $catId=="" && $key=="")
	{!! $media->links() !!}
@else
	{!! $media->appends(['author'=>$authorId,'category'=>$catId,'s'=>$key])->links() !!}		
@endif
@if(session('success'))
<script type="text/javascript">
	$(function(){
		new PNotify({
		    title: 'Thành công',
		    text: 'Xóa Thành công.',
		    type: 'success',
		    hide: true,
		    delay: 2000,
		});
	})
</script>
@endif
<script type="text/javascript">
	$(function() {
		//delete media
      	$("#media .delete").click(function(){
      		var href = $(this).attr("href");
      		(new PNotify({
			    title: 'Xóa',
			    text: 'Bạn muốn xóa ảnh này?',
			    icon: 'glyphicon glyphicon-question-sign',
			    type: 'error',
			    hide: false,
			    confirm: {
			        confirm: true
			    },
			    buttons: {
			        closer: false,
			        sticker: false
			    },
			    history: {
			        history: false
			    }
			})).get().on('pnotify.confirm', function() {			    
			    window.location.href = href;
			});
			return false;
      	});
      	$(".dev-form").on('click','.dell-all',function(){
      		var _token = $("form input[name='_token']").val();
			var items = new Array();
			$(".dev-form tbody tr").each(function(){
				if($(this).find(".check input").is(":checked")){
					items.push($(this).find("input").val());
				}
			});
			if(items<0){		       	
		       	new PNotify({
					title: 'Lỗi dữ liệu',
					text: 'Vui lòng chọn ít nhất 1 hàng cần xóa.!',						    
					hide: true,
					delay: 6000,
				});
	       	}else{
	       		$(".dev-form").append("<div class='loading'><img src='{{route('home')}}/public/images/loading_red.gif' alt='loading..'/></div>");
				$.ajax({
					type:'POST',            
					url:'{{ route("deleteAllMedia") }}',
					cache: false,
					data:{
						'_token': _token,
						'items': JSON.stringify(items)
					},
				}).done(function(data) {
					if(data=="success"){
						$(".dev-form .loading").remove();
						$(".dev-form tbody .check input").prop('checked', false);
						$.each(items, function(index, value){
							console.log(value);
							$(".dev-form #image-"+value).remove();
						});
						items = new Array();				       					       	
						new PNotify({
							title: 'Thành công',
							text: 'Xóa thành công.',
							type: 'success',
							hide: true,
							delay: 2000,
						});						
					}else{
						new PNotify({
							title: 'Lỗi',
							text: 'Trình duyệt không hỗ trợ javascript.',						    
							hide: true,
							delay: 2000,
						});
					}	           		
				});
			}
			return false;
		});
	});
</script>
@stop