@extends('backend.layout.index')
@section('title','Icons attraction')
@section('content')

<div id="iconSchedule-page" class="page">
	<div class="head container">
		<h1 class="title">Icons attraction</h1>		
		<a href="{{ route('storeIconAttractionAdmin') }}" class="btn btn-add">Add</a>
	</div>	
	<div class="main">
		<div class="results container">
			<form action="#" method="POST" name="blog" class="dev-form">
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
							<th scope="col" class="yellow-icon">Yellow Icon</th>
							<th scope="col" class="title">Title</th>		
							<th scope="col" class="action">Action</th>
						</tr>
					</thead>
					<tbody>	
						@foreach($list_icon as $key=>$item)
							<tr>
								<td class="check">
									<div class="checkbox checkbox-success">
										<input id="tour-{{$item->id}}" type="checkbox" name="tour[]" value="{{$item->id}}">
										<label for="tour-{{$item->id}}"></label>
									</div>
								</td>
								<td class="stt">{{$key+1}}</td>
								<td class="yellow-icon">{!! image($item->pink_icon, 50, 50, $item->title)!!}</td>
								<td class="title">
									<a href="{{route('editIconAttractionAdmin', $item->id)}}">{{$item->title}}</a>
								</td>									
								<td class="action">
									<a href="{{route('editIconAttractionAdmin', $item->id)}}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
									<a href="{{ route('deleteIconAttractionAdmin', $item->id) }}" class="delete btn-delete"><i class="fa fa-close" aria-hidden="true"></i></a>
								</td>
							</tr>
						@endforeach	
					</tbody>
				</table>
				{!! $list_icon->links() !!}
			</form>
		</div>	
	</div>
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