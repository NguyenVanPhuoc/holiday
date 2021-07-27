@php
	/*
	* Template table country
	* @param request $list_country
	*/
@endphp
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
			<th scope="col" class="image">Image</th>
			<th scope="col" class="title">Title</th>
			<th scope="col" class="url">Copy URL</th>
			<th scope="col" class="parent">Parent</th>				
			<th scope="col" class="action"></th>
		</tr>
	</thead>
	<tbody class="sortable" data-action="{{ route('positionCountry') }}">
		@if(isset($list_country) && count($list_country) > 0)
			@foreach($list_country as $key => $item)
				@php
					$level = getLevelCountry($item->id);
					$copyTitle = '';
					$urlCopy = '';
					if($level == 1){
						$copyTitle = 'Overview';
						$urlCopy = route('overviewCountry', ['slug_country'=>$item->slug]);
					} 
					else{
						$copyTitle = 'Places to visit';
						$farthestParentID = getFarthestParentCountry($item->id);
						$farthestParent = getCountryById($farthestParentID);
						$urlCopy = route('countryPlaceToVisit' , ['slug_country'=>$farthestParent->slug , 'slug'=>$item->slug]);
					}
				@endphp
				<tr id="item-{{$item->id}}" class="ui-state-default" data-id="{{ $item->id }}" data-position="{{ $item->position }}">
					<td class="check">
						<div class="checkbox checkbox-success">
							<input id="article-{{$item->id}}" type="checkbox" name="articles[]" value="{{$item->id}}">
							<label for="article-{{$item->id}}"></label>
						</div>
					</td>
					<td scope="row stt" class="stt">{{$key + 1}}</td>
					<td class="image"><a href="{{route('editCountryAdmin', ['slug'=>$item->slug])}}">{!!image($item->image, 50,50, $item->name)!!}</a></td>
					<td class="title"><a href="{{route('editCountryAdmin', ['slug'=>$item->slug])}}">{{$item->title}}</a></td>
					<td class="url">
						<div class="tooltip click-to-copy">
							<a href="{{ $urlCopy }}">
								<span class="tooltiptext" id="myTooltip">Click to copy URL</span>
								{{ $copyTitle }}
							</a> 
						</div>
					</td>
					<td class="parent">
						@if($item->parent_id != 0)
							@php $parent = getCountryById($item->parent_id); @endphp
							@if($parent) {{$parent->title}} @endif
						@else
							None
						@endif
					</td>
					<td class="action">						
						<a href="{{route('editCountryAdmin', ['slug'=>$item->slug])}}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
						<a href="{{ route('deleteCountryAdmin',['id'=>$item->id]) }}" class="delete"><i class="fa fa-close" aria-hidden="true"></i></a>
					</td>
				</tr>				
			@endforeach	
		@endif			
	</tbody>
</table>
{!! $list_country->links() !!}
