@extends('backend.layout.index')
@section('title','Reviews')
@section('content')
<div id="reviews" class="page">
	<div class="head">
		<h1 class="title">Reviews</h1>
	</div>
	<form id="reviews" action="#" method="post" name="reviwer" class="dev-form" data-delete="{{ route('deleteAllReviewAdmin') }}">
		<input type="hidden" name="_token" value="{{csrf_token()}}"/>
		<div class="tb-results">
			<table class="table table-striped">
				<thead>
					<tr>
						<th id="check-all" class="check">
							<div class="checkbox checkbox-success">
								<input id="check" type="checkbox" name="checkAll[]" value="">
								<label for="check"></label>
							</div>
						</th>
						<th scope="col" class="stt">STT</th>
						<th scope="col" class="image">Image</th>
						<th scope="col" class="name">Name</th>
						<th scope="col" class="title">Title</th>
						<th scope="col">Country</th>
						<th scope="col">Tour Style</th>
						<th scope="col" class="action">Tác vụ</th>
					</tr>
				</thead>
				<tbody>
					@foreach($reviews as $key => $review) 
					<tr id="item-{{ $review->id }}">
						<td class="check">
							<div class="checkbox checkbox-success">
								<input id="post-{{ $review->id }}" type="checkbox" name="posts[]" value="{{ $review->id }}">
								<label for="post-{{ $review->id }}"></label>
							</div>
						</td>
						<td class="stt">{{$key+1}}</td>
						<td class="image">
							<a href="{{route('editReviewAdmin',['id'=>$review->id])}}" class="edit">
								{!! image($review->image,50,50,$review->name) !!}
							</a>
						</td>
						<td class="name">
							<a href="{{route('editReviewAdmin',$review->id)}}">{{$review->name}}</a>
						</td>				
						<td class="title">{{ $review->title }}</td>	
						<td>{{ getListTextCountryWhereInID($review->list_destination) }}</td>
						<td>{{ getListTextTourStyleWhereInID($review->list_tour_style) }}</td>			
						<td class="action">							
							<a href="{{route('editReviewAdmin',$review->id)}}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
							<a href="{{route('deleteReviewAdmin',$review->id)}}" class="btn-delete delete"><i class="fa fa-close" aria-hidden="true"></i></a>
						</td>
					</tr>					
					@endforeach				
				</tbody>
			</table>
		</div>
	</form>
</div>
{!! $reviews->links() !!}
@if(session('success'))
<script type="text/javascript">
	$(function(){
		new PNotify({
			title: 'Successfully',
			text: '{{ session('success') }}',
			type: 'success',
			hide: true,
			delay: 2000,
		});
	})
</script>
@endif
@stop