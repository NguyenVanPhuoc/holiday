@php
/**
 * template list result of tour
 * @param $list_tour
 */
@endphp

@if(count($list_tour) > 0)
<div class="has-bg-unde tour_craft">
	<div class="bg-under light-graybg"></div>
	<div class="container">
		<div class="list-result-tour list-result">
			<div class="row">
				@foreach($list_tour as $tour)
					@include('tours.related_item_v1')
				@endforeach
			</div>
			<div class="graybg seeing">
				<span>You are seeing <span class="number">{{ $total < 6 ? $total : 6 }}</span> of <span class="total">{{ $total }}</span> tour packages</span>
			</div>
			@if($total>1)
                <div id="load-more">
                    {{ csrf_field() }}
                    <input type="hidden" name="total" value="{{ $total }}">
                    <input type="hidden" name="current" value="1">
                    <a class="view-more" href="javascript:void(0)" data-href="{{ route('loadMoreTourCountry',['slug'=>$country->slug]) }}">View more</a>
                </div>
            @endif
		</div>
	</div>
</div>
<!-- <div class="container"><div class="paginate-sec">{!! $list_tour->render('custom_view'); !!}</div></div> -->
@else
	<div class="container">
		<div class="graybg seeing">
			<span>There is no suitable tour packages for your queries, you can Reset or <a class="pink font-semibold" href="{{ route('contact') }}">CONTACT US</a> for a tailor-made request.</span>
		</div>
	</div>
@endif