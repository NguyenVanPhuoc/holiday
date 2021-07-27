@extends('backend.layout.index')
@section('title','Facilities')
@section('content')
<div id="facilities" class="page">
	<div class="head">
		<h1 class="title">Facilities</h1>	
		<a href="{{route('storeFacilityAdmin')}}" class="btn btn-add">Add</a>	
	</div>
	<div class="main">
		<form action="#" method="post" class="dev-form list-guides" data-delete="{{ route('deleteAllFacilityAdmin') }}">
			{!!csrf_field()!!}
			<div class="tb-results">
				<table class="table table-striped">
					<thead class="thead-dark">
						<tr>
							<th id="check-all" scope="col" class="check">
								<div class="checkbox checkbox-success">
									<input id="check" type="checkbox" name="checkAll[]" value="">
									<label for="check"></label>
								</div>
							</th>
							<th scope="col" class="stt">#</th>
							<th scope="col" class="gray-icon">Gray Icon</th>
							<th scope="col" class="title">Title</th>
							<th scope="col" class="action"></th>
						</tr>
					</thead>
					<tbody>
						@foreach($facilities as $key => $item)
							<tr id="item-{{$item->id}}">
								<td class="check">
									<div class="checkbox checkbox-success">
										<input id="item-{{$item->id}}" type="checkbox" name="items[]" value="{{$item->id}}">
										<label for="item-{{$item->id}}"></label>
									</div>
								</td>
								<th scope="row">{{$key+1}}</th>
								<td class="gray-icon">
									<a href="{{ route('editFacilityAdmin', ['slug'=>$item->slug]) }}">{!!image($item->gray_icon, 50,50, $item->title)!!}</a>
								</td>
								<td class="title">
									<a href="{{ route('editFacilityAdmin', ['slug'=>$item->slug]) }}">{{$item->title}}</a>
								</td>
								<td class="action">
									@handheld<a href="#" data-value="{{$item->id}}" class="view"><i class="fa fa-eye" aria-hidden="true"></i></a>@endhandheld
									<a href="{{ route('editFacilityAdmin', ['slug'=>$item->slug]) }}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
									<a href="{{ route('deleteFacilityAdmin', ['id'=>$item->id]) }}" class="delete delete-item"><i class="fa fa-close" aria-hidden="true"></i></a>					
								</td>
							</tr>
						@endforeach				
					</tbody>
				</table>
			</div>
		</form>
	</div>
</div>
{!! $facilities->links() !!}
@if(session('success'))
<script type="text/javascript">
	$(function(){
		new PNotify({
			title: 'Successfully',
			text: '{{session('success')}}',
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
	
});	
</script>
@stop