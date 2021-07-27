@extends('templates.master')
@section('title','Thư viện')
@section('content')
<div id="media" class="page profile">
	<div class="container">
		<div class="pro-wrap">
			@include('members.profile_header')			
			<div id="pro-main" class="row">				
				<div class="main col-md-10">					
					<ul class="nav">
						<li class="active"><a href="{{route('mediaProfile')}}">Tất cả</a></li>
						<li ><a href="{{route('storeMediaProfile')}}">Thêm mới</a></li>
					</ul>
					<form id="media-frm" action="{{route('deleteMediasProfile')}}" method="post" name="media" class="dev-form">
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
									<th scope="col" class="stt">STT</th>
									<th scope="col" class="image">Hình ảnh</th>
									<th scope="col" class="title">Tên file</th>
									<th scope="col" class="date">Ngày</th>				
									<th scope="col" class="action">Tác vụ</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($media))
									<?php $count = 0;?>
									@foreach($media as $item)<?php $count++; $title = empty($item->title)? $item->image_path : $item->title;?>
									<tr id="image-{{ $item->id }}">
										<td class="check">
											<div class="checkbox checkbox-success">
												<input id="media-{{$item->id}}" type="checkbox" name="medias[]" value="{{$item->id}}">
												<label for="media-{{$item->id}}"></label>
											</div>
										</td>
										<td scope="row" class="stt">{{ $count }}</td>
										<td class="image">{!!image($item->id, 100,60, $item->title)!!}</td>
										<td class="title">{{ $title }}</td>
										<td class="date">{{$item->created_at}}</td>
										<td class="action">
											<a href="{{route('editMediaProfile',['id'=>$item->id])}}" class="edit"><i class="fas fa-edit" aria-hidden="true"></i></a>
											<a href="{{route('deleteMediaProfile',['id'=>$item->id])}}" class="delete"><i class="fas fa-times"></i></a>
										</td>
									</tr>
									@endforeach
								@else
									<tr><td colspan="6">Chưa có file nào...</td></tr>
								@endif			
							</tbody>
						</table>
					</form>
					{!! $media->links() !!}
				</div>
				<div class="sidebar col-md-2">@include('sidebars.member')</div>
			</div>
		</div>
	</div>
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
@endsection