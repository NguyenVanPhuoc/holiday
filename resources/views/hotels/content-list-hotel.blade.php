@php
/**
 * template content list hotel
 * @param $list_hotel
 */
@endphp

<div class="list-hotel">
	<div class="row">
		@foreach($list_hotel as $hotel)
			<div class="col-md-6">
				@include('hotels.item')
			</div>
		@endforeach
	</div>
</div>
<div class="text-right paginate-sec">{!! $list_hotel->render('custom_view'); !!}</div>