@extends('templates.master')
@section('title','Tin đăng')
@section('content')
<div id="profile" class="page profile">
	<div class="container">
		<div class="pro-wrap">
			@include('members.profile_header')
			<div id="pro-main" class="row">			
				<div class="main col-md-10">
					@if($blogs)
					<form action="{{route('newsProfile')}}" method="POST" name="blog" class="dev-form">
						{!!csrf_field()!!}
						<table class="table table-striped list">
							<thead class="thead-dark">
								<tr>
									<th id="check-all" scope="col" class="check">
										<div class="checkbox checkbox-success">
											<input id="check" type="checkbox" name="checkAll[]" value="">
											<label for="check"></label>
										</div>
									</th>
									<th scope="col" class="stt">STT</th>
									<th scope="col" class="image">Ảnh bài viết</th>
									<th scope="col" class="title">Tiêu đề</th>
									<th scope="col" class="view-number">Lượt xem</th>		
									<th scope="col" class="status">Trạng thái</th>
									<th scope="col" class="action">Tác vụ</th>
								</tr>
							</thead>
							<tbody>
								<?php $count = 0;?>
								@foreach($blogs as $item)
									<?php $count++;						
										$categories = implode(", ",get_titleByIds($item->categories,'category'));
										$author = getUser($item->user_id);
									?>
									<tr id="item-{{$item->id}}">
										<td class="check">
											<div class="checkbox checkbox-success">
												<input id="article-{{$item->id}}" type="checkbox" name="articles[]" value="{{$item->id}}">
												<label for="article-{{$item->id}}"></label>
											</div>
										</td>
										<th scope="row" class="stt">{{$count}}</th>
										<td class="image"><a href="{{ route('editNewsProfile',['id'=>$item->id]) }}">{!!image($item->image, 50,50, $item->name)!!}</a></td>
										<td class="title"><a href="{{ route('editNewsProfile',['id'=>$item->id]) }}">{{$item->title}}</a></td>
										<td class="view-number">{{$item->view}}</td>
										<td class="status status-{{$item->status}}"><span>{{getStatus($item->status)}}</span></td>
										<td class="action">						
											<a href="{{ route('editNewsProfile',['id'=>$item->id]) }}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
										</td>
									</tr>				
								@endforeach				
							</tbody>
						</table>
					</form>
					{!!$blogs->links()!!}
					@endif
				</div>
				<div class="sidebar col-md-2">@include('sidebars.member')</div>
			</div>
		</div>
	</div>
</div>
@endsection