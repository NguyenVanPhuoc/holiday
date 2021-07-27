 @php
	$list_reviewer = getListReviewer(NULL, NULL, 3);
	$regions = getAllCountryByLevel(1);
	$durations = getListDuration();
	$styles = getAllCountryTourStyle();
	$list_country = getAllCountryByLevel(1);
@endphp
<div class="looking looking-tour-mobile"  style="background-image: url('{!! getImgUrl(getDsMetas(168)) !!}');">
		<div class="list-search">
			<div class="filter-about gr-filter">
				<h2 class="title-header">LOOKING FOR A TOUR PLAN?</h2>
				<form action="{{ route('asiaTour') }}" method="GET" class="search_form">
				{{-- {{ csrf_field() }} --}}
				<div class="list-filter">
					<div class="box-items region">
						<select class="select_filter" name="destination_id">
							<option value="" >Country</option>
							@foreach($regions as $region)
								<option value="{{ $region->id }}">{{ $region->title }}</option>
								
							@endforeach
						</select>
					</div>
					<div class="box-items duration">
						<select class="select_filter" name="duration_id">
							<option value="">Duration</option>
							@foreach($durations as $duration)
								<option value="{{ $duration->id }}">{{ $duration->title }}</option>
								
							@endforeach
						</select>
					</div>
					<div class="box-items styles">
						<select class="select_filter" name="cat_id">
							<option value="">Tour styles</option>
							@foreach($styles as $style)
								<option value="{{ $style->id }}">{{ $style->title }}</option>
								
							@endforeach
						</select>
					</div>
					<div class="submit_search">
						<input type="submit" name="search" class="search" value="Search">
						<img src="{{asset('public/images/loupe search.png')}}" alt="image">
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="Country light-graynvp">
		<div class="container">
			<div class="text-center">
				<h2 class="pink">{!! getDsMetas(169) !!}</h2>
				<div class="description">
					{!! getDsMetas(170) !!}
				</div>
			</div>
			@if(isset($list_country))
				<div class="slide-style list-tour-style yellow">
					@foreach($list_country as $overview) 
					<div class="wrapper-item">
						<a class="link_country" href="{{ route('overviewCountry', ['slug_country'=>$overview->slug]) }}"></a>
						<div class="item" style="background-image: url('{!! getImgUrl($overview->image) !!}');">
							<h3 class="title">{{ $overview->title }}</h3>
							@desktop
							<div class="desc_hover">
								<div class="desc">
									<img src="http://sonasia-holiday.com/public/uploads/rcan-vbpl-v3-logo-website-whitepngpng.png"/>
									<h3 class="title_hover">{{ $overview->title }}</h3>
									Welcome to the Kingdom of wonders
								</div>
							</div>
							@enddesktop
						</div>
					</div>
					@endforeach
				</div>
			@endif
		</div>
	</div>
	<div class="looking request"  style="background-image: url('{!! getImgUrl(getDsMetas(171)) !!}');">
		<div class="container">
			<div class="list-request">
				<div class="row item-request">
					<div class="col-md-5 col-sm-6 item">
						{!! image(getDsMetas(172),300,220,'image') !!}
					</div>
					<div class="col-md-7 col-sm-6 text-center item">
						<h3 class="aplan">Already got a plan?</h3>
						<a class="btn btn-request" href="{!! getDsMetas(173) !!}">REQUEST A FREE QUOTE</a>
					</div>
				</div>
			</div>
		</div>
	</div>