@php
/**
 * template section four item 2
 * @param array object $list_fourItem2 
 */
@endphp
<div class="row">
	<div class="col-md-4">
		@if(isset($list_fourItem2[0]))
		<div class="item">
			<a class="thumb">
				{!! image($list_fourItem2[0]->image, 350, 650, $list_fourItem2[0]->long_title) !!}
			</a>
			<a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $list_fourItem2[0]->slug]) }}" class="title has-icon">
				@if($list_fourItem2[0]->white_icon)
					{!! imageAuto($list_fourItem2[0]->white_icon, $list_fourItem2[0]->long_title) !!}
				@endif
				@if($list_fourItem2[0]->short_title)
					{{$list_fourItem2[0]->short_title}}	
				@else	
					{{$list_fourItem2[0]->title}}	
				@endif						
			</a>
		</div>
		@endif
	</div>
	<div class="col-md-8">
		<div class="row">
			@for($i = 1; $i < 3; $i++)
				@if(isset($list_fourItem2[$i]))
					<div class="col-md-6">
						<div class="item">
							<a class="thumb">
								{!! image($list_fourItem2[$i]->image, 350, 320, $list_fourItem2[$i]->long_title) !!}
							</a>
							<a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $list_fourItem2[$i]->slug]) }}" class="title has-icon">
								@if($list_fourItem2[$i]->white_icon)
									{!! imageAuto($list_fourItem2[$i]->white_icon, $list_fourItem2[$i]->long_title) !!}
								@endif
								@if($list_fourItem2[$i]->short_title)
									{{$list_fourItem2[$i]->short_title}}	
								@else	
									{{$list_fourItem2[$i]->title}}	
								@endif								
							</a>
						</div>
					</div>
				@endif
			@endfor

			@if(isset($list_fourItem2[3]))
				<div class="col-md-12">
					<div class="item">
						<div class="item">
							<a class="thumb">
								{!! image($list_fourItem2[3]->image, 710, 320, $list_fourItem2[3]->long_title) !!}
							</a>
							<a href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $list_fourItem2[3]->slug]) }}" class="title has-icon">
								@if($list_fourItem2[3]->white_icon)
									{!! imageAuto($list_fourItem2[3]->white_icon, $list_fourItem2[3]->long_title) !!}
								@endif
								@if($list_fourItem2[3]->short_title)
									{{$list_fourItem2[3]->short_title}}	
								@else	
									{{$list_fourItem2[3]->title}}	
								@endif									
							</a>
						</div>
					</div>
				</div>
			@endif
		</div>
	</div>
</div>