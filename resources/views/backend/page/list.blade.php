@extends('backend.layout.index')
@section('title','Dashboard')
@section('content')
<div id="pages" class="page">
	<div class="head container"><h1 class="title">Tất cả</h1></div>
	<form id="page-frm" action="#" method="post" name="page" class="dev-form">
		{!!csrf_field()!!}
		<table class="table table-striped list-page">
			<thead>
				<tr>
					<th scope="col" class="stt">STT</th>
					<th scope="col" class="title">Tên page</th>
					<th scope="col" class="slug">Slug</th>
					<th scope="col" class="author">Tác giả</th>
					<th scope="col" class="date">Date</th>
					<th scope="col" class="action">Tác vụ</th>
				</tr>
			</thead>
			<tbody>
				<?php $count = 0;?>
				@foreach($pages as $page) <?php $count++; $user = getUser($page->user_id);?>
				<tr>
					<th class="stt">{{$count}}</th>
					<td class="title">{{$page->title}}</td>
					<td class="slug">{{$page->slug}}</td>
					<td class="author">@if($user != null){{$user->name}}@endif</td>
					<td class="date">{{$page->updated_at}}</td>
					<td class="action">
						<a href="{{route('editPageAdmin',['id'=>$page->id])}}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
						<a href="{{route('deletePageAdmin',['id'=>$page->id])}}" class="delete"><i class="fa fa-close" aria-hidden="true"></i></a>
					</td>
				</tr>
				@endforeach				
			</tbody>
		</table>
	</form>
</div>
{!! $pages->links() !!}
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
		//delete location
      	$("#pages .delete").click(function(){
      		var href = $(this).attr("href");
      		(new PNotify({
			    title: 'Xóa',
			    text: 'Bạn muốn xóa trang này?',
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
	});	
</script>
@stop