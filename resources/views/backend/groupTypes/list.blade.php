@extends('backend.layout.index')
@section('title','Group types')
@section('content')


<div id="group-types" class="page container">
	<div class="head">
		<h1 class="title">Group types</h1>		
	</div>	
	<div class="main">
		<form action="#" method="POST" name="blog" class="dev-form" data-delete="{{ route('deleteAllGroupTypeAdmin') }}">
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
						<th scope="col" class="stt">#</th>
						<th scope="col" class="title">Title</th>			
						<th scope="col" class="action"></th>
					</tr>
				</thead>
				<tbody>
					<?php $count = 0;?>
					@foreach($list_groupType as $key => $item)
						<tr id="item-{{$item->id}}">
							<td class="check">
								<div class="checkbox checkbox-success">
									<input id="article-{{$item->id}}" type="checkbox" name="articles[]" value="{{$item->id}}">
									<label for="article-{{$item->id}}"></label>
								</div>
							</td>
							<td scope="row" class="stt">{{$key + 1}}</td>
							<td class="title"><a href="{{route('editGroupTypeAdmin', $item->slug)}}">{{$item->title}}</a></td>
							<td class="action">						
								<a href="{{route('editGroupTypeAdmin', $item->slug)}}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
								<a href="{{ route('deleteGroupTypeAdmin', $item->id) }}" class="delete"><i class="fa fa-close" aria-hidden="true"></i></a>
							</td>
						</tr>				
					@endforeach				
				</tbody>
			</table>
		</form>
	</div>	
	{!! $list_groupType->links() !!}	

</div>
@if(session('success'))
<script type="text/javascript">
	$(function(){
		new PNotify({
		    title: 'Successfully',
		    text: 'Successfully deleted',
		    type: 'success',
		    hide: true,
		    delay: 2000,
		});
	})
</script>
@endif


@stop