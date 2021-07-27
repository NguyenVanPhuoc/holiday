@extends('backend.layout.index')
@section('title','Admin')
@section('content')
<div id="users" class="container page">
	<div class="head">
		<a href="{{route('users')}}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> Tất cả</a>
		<h1 class="title">Thành viên</h1>		
	</div>
	<ul class="nav-filter">
		<li{{ Request::is('admin/users') ? ' class=active' : '' }}><a href="{{route('users')}}">Tất cả</a></li>
		<li{{ Request::is('admin/users/role/admin') ? ' class=active' : '' }}><a href="{{route('levelAdmin',['level'=>'admin'])}}">Ban quản trị</a></li>
		<li{{ Request::is('admin/users/role/memeber') ? ' class=active' : '' }}><a href="{{route('levelAdmin',['level'=>'member'])}}">Thành viên</a></li>
	</ul>
	<form id="customers" action="#" method="post" name="addUser" class="dev-form list-user">
		{!!csrf_field()!!}
		<div class="tb-results">
			<table id="list-members" class="table table-striped">
				<thead class="thead-dark">
					<tr>
						<th scope="col" class="stt">STT</th>
						<th scope="col" class="avatar">Avatar</th>
						<th scope="col" class="title">Họ & tên</th>
						<th scope="col" class="phone">Phone</th>
						<th scope="col" class="email">Email</th>						
						<th scope="col" class="date">Ngày tạo</th>
						<th scope="col" class="role">Vai trò</th>
						<th scope="col" class="action">Tác vụ</th>
					</tr>
				</thead>
				<tbody>
					<?php $count = 0;?>
					@foreach($users as $u) <?php $count++;?>
					<tr>
						<th scope="row">{{$count}}</th>
						<td class="avatar"><a href="{{route('updateAdmin',['id'=>$u->id])}}">{!!image($u->image, 50,50, $u->name)!!}</a></td>
						<td class="title"><a href="{{route('updateAdmin',['id'=>$u->id])}}">{{$u->name}}</a></td>
						<td class="phone">{{$u->phone}}</td>
						<td class="email">{{$u->email}}</td>
						<td class="date">{{$u->updated_at}}</td>
						<td class="email">{{$u->level}}</td>
						<td class="action">
							@handheld<a href="#" data-value="{{$u->id}}" class="view"><i class="fa fa-eye" aria-hidden="true"></i></a>@endhandheld
							<a href="{{route('updateAdmin',['id'=>$u->id])}}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
							<a href="{{route('deleteAdmin',['id'=>$u->id])}}" class="delete"><i class="fa fa-close" aria-hidden="true"></i></a>					
						</td>
					</tr>
					@handheld
					<tr class="item-{{$u->id}} detail">
						<td colspan="7">					
							<ul class="info">
								<li>Họ tên: <a href="{{route('updateAdmin',['slug'=>$u->slug])}}">{{$u->name}}</a></li>
								<li>Phone: <strong>{{$u->phone}}</strong></li>
								<li>Email: <strong>{{$u->email}}</strong></li>
							</ul>
							<a href="{{route('updateAdmin',['slug'=>$u->slug])}}" class="read-more"><i class="fa fa-angle-right" aria-hidden="true"></i>Chi tiết</a>
						</td>
					</tr>
					@endhandheld
					@endforeach				
				</tbody>
			</table>
		</div>
	</form>
</div>
{!! $users->links() !!}
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
	$("#users .delete").click(function(){
		var href = $(this).attr("href");
		(new PNotify({
			title: 'Xóa',
			text: 'Bạn muốn xóa thành viên này?',
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