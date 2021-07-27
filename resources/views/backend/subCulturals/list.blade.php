@extends('backend.layout.index')
@section('title','Sub-Cultural Guide')
@section('content')
@php
	$culturalGuides = getListCulturalGuides();
	$parent_id = isset($parent_id)? $parent_id : '';
	$parentTitle  = '-- Cultural Parent --';
	if($parent_id != ''){
		$parentTitle = getGuideByID($parent_id)->long_title;
	}
	$key = isset($s)? $s:'';
@endphp
<div id="guides" class="page">
	<div class="head">
		<h1 class="title">Sub-Cultural Guide</h1>		
		<a href="{{ route('storeSubCulturalAdmin') }}" class="btn btn-add">Add new</a>
	</div>
	<div class="main">
		<div class="search-form">
			<form name="s" action="{{route('searchSubCulturalAdmin')}}" method="GET">
				<div class="row">
					<div id="frm-parent" class="col-md-6">
						<div class="desc list">
							<div class="dropdown vs-drop">
	                            @if(isset($parent_id))
									<a class="dropdown-toggle" href="#" role="button" id="dropdown-parent" data-value="{{$parent_id}}" data-toggle="dropdown">{{ $parentTitle }}</a>
                            	@else
                            		<a class="dropdown-toggle" href="#" role="button" id="dropdown-parent" data-value="" data-toggle="dropdown">-- Cultural Parent --</a>
                            	@endif
	                            <input type="hidden" name="parent_id" class="value" value="{{$parent_id}}">
	                            <div class="dropdown-menu" aria-labelledby="dropdown-cat" x-placement="bottom-start">
	                                <ul class="list-item dropdown-country scrollbar-inner">
	                                	@foreach ($culturalGuides as $guide)
	                                		<li><a href="#{{$guide->slug}}" data-value="{{$guide->id}}" >{{$guide->long_title}}</a></li>
	                                	@endforeach
	                                </ul>
	                            </div>
	                        </div>							
						</div>			
					</div>
					<div id="frm-keyword" class="col-md-6"><input type="text" name="s" class="form-control" placeholder="Input key word..." value="{{$key}}"></div>
				</div>
				<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
			</form>
		</div>
		<form action="#" method="post" class="dev-form list-guides" data-delete="{{ route('deleteAllSubCulturalAdmin') }}">
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
							<th scope="col" class="image">Image</th>
							<th scope="col" class="title">Title</th>
							<th scope="col" class="desc">Description</th>
							<th scope="col" class="parent">Parent</th>
							<th scope="col" class="action"></th>
						</tr>
					</thead>
					<tbody>
						@foreach($subCulturals as $key => $item)
						@php
							$guide = getGuideByID($item->parent_id);
						@endphp
							<tr id="item-{{$item->id}}">
								<td class="check">
									<div class="checkbox checkbox-success">
										<input id="item-{{$item->id}}" type="checkbox" name="items[]" value="{{$item->id}}">
										<label for="item-{{$item->id}}"></label>
									</div>
								</td>
								<th scope="row">{{$key+1}}</th>
								<td class="image"><a href="#">{!!image($item->image, 50,50, $item->title)!!}</a></td>
								<td class="title"><a href="{{ route('editSubCulturalAdmin', ['slug'=>$item->slug]) }}">{{$item->title}}</a></td>
								<td class="desc"><div class="text">{!! $item->desc !!}</div></td>
								<td class="parent">
									@if($guide) {{$guide->long_title}} @endif
								</td>
								<td class="action">
									@handheld<a href="#" data-value="{{$item->id}}" class="view"><i class="fa fa-eye" aria-hidden="true"></i></a>@endhandheld
									<a href="{{ route('editSubCulturalAdmin', ['slug'=>$item->slug]) }}" class="edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
									<a href="{{ route('deleteSubCulturalAdmin', ['id'=>$item->id]) }}" class="delete delete-item"><i class="fa fa-close" aria-hidden="true"></i></a>					
								</td>
							</tr>
						@endforeach				
					</tbody>
				</table>
			</div>
		</form>
	</div>
</div>
{!! $subCulturals->links() !!}
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