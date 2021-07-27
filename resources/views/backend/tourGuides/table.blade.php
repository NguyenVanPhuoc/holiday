@php
	/**
	 * template table consultants
	 * @param $list_tourGuide
	 */
@endphp


<table  class="table table-striped">
	<thead class="thead-dark">
		<tr>
			<th id="check-all" scope="col" class="check">
				<div class="checkbox checkbox-success">
					<input id="check" type="checkbox" name="checkAll[]" value="">
					<label for="check"></label>
				</div>
			</th>
			<th scope="col" class="stt">#</th>
			<th scope="col" class="avatar">Avatar</th>
			<th scope="col" class="title">Name</th>
			<th scope="col" class="tour-style">Tour Style</th>						
			<th scope="col" class="country">Country</th>
			<th scope="col" class="desc">Short Description</th>
			<th scope="col" class="action"></th>
		</tr>
	</thead>
	<tbody>
		@foreach($list_tourGuide as $key => $c)
		<tr id="item-{{$c->id}}">
			<td class="check">
				<div class="checkbox checkbox-success">
					<input id="item-{{$c->id}}" type="checkbox" name="items[]" value="{{$c->id}}">
					<label for="item-{{$c->id}}"></label>
				</div>
			</td>
			<th scope="row">{{$key+1}}</th>
			<td class="avatar"><a href="{{ route('editTourGuideAdmin', $c->id) }}">{!!image($c->image, 50,50, $c->title)!!}</a></td>
			<td class="title"><a href="{{ route('editTourGuideAdmin', $c->id) }}">{{$c->title}}</a></td>
			<td class="country">{{ $c->country->title }}</td>
			<td class="desc"><div class="text">{!! $c->short_desc !!}</div></td>
			<td class="action">
				@handheld<a href="#" data-value="{{$c->id}}" class="view"><i class="fa fa-eye" aria-hidden="true"></i></a>@endhandheld
				<a href="{{ route('editTourGuideAdmin', $c->id) }}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
				<a href="{{ route('deleteTourGuideAdmin', $c->id) }}" class="delete delete-item"><i class="fa fa-close" aria-hidden="true"></i></a>					
			</td>
		</tr>
		@handheld
		<tr class="item-{{$c->id}} detail">
			<td colspan="7">					
				<ul class="info">
					<li>Name: <a href="#">{{ $c->title }}</a></li>
					<li>Country: {{ $c->country->title }}</li>
					<li>Short Description: <strong>{{ $c->short_desc }}</strong></li>
				</ul>
				<a href="#" class="read-more"><i class="fa fa-angle-right" aria-hidden="true"></i>View</a>
			</td>
		</tr>
		@endhandheld
		@endforeach				
	</tbody>
</table>

{!! $list_tourGuide->links() !!}