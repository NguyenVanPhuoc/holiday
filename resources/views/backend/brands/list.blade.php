@extends('backend.layout.index')
@section('title','Đối tác')
@section('content')
<div id="brands" class="page brands-page">
	<div class="head">
		<h1 class="title">Đối tác</h1>		
	</div>	
	<div class="main">
		<table id="list" class="table table-striped">
			<thead class="thead-dark">
				<tr>
					<th scope="col" class="stt">STT</th>
					<th scope="col" class="avatar">Hình ảnh</th>
					<th scope="col" class="title">Tiêu đề</th>				
					<th scope="col" class="link">Liên kết</th>				
					<th scope="col" class="date">Ngày tạo</th>					
					<th scope="col" class="action">Tác vụ</th>
				</tr>
			</thead>
			<tbody>
				<?php $count = 0;?>
				@foreach($brands as $item)<?php $count++;?>
					<tr>
						<th scope="row">{{$count}}</th>
						<td class="image"><a href="{{ route('editBrandAdmin',['id'=>$item->id]) }}">{!!image($item->image, 50,50, $item->name)!!}</a></td>
						<td class="title"><a href="{{ route('editBrandAdmin',['id'=>$item->id]) }}">{{$item->title}}</a></td>
						<td class="link">{{$item->link}}</td>
						<td class="date">{{$item->created_at}}</td>
						<td class="action">						
							<a href="{{ route('editBrandAdmin',['id'=>$item->id]) }}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
							<a href="{{ route('deleteBrandAdmin',['slug'=>$item->id]) }}" class="delete"><i class="fa fa-close" aria-hidden="true"></i></a>
						</td>
					</tr>				
				@endforeach				
			</tbody>
		</table>
	</div>
	{!! $brands->links() !!}
</div>
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
      	$("#brands .delete").click(function(){
      		var href = $(this).attr("href");
      		(new PNotify({
			    title: 'Xóa',
			    text: 'Bạn muốn đối tác này?',
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
      	})
	});	
</script>
@stop