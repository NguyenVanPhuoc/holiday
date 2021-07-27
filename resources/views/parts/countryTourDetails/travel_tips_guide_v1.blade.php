@php
 	$guides = getListTravelTipsByCountry('travel_tip', $country->id);
@endphp
	<div class="content-guide">
		<div class="search-box white">
        	<form action="" method="get" id="search-city">
				{!!csrf_field()!!}
				<input type="text" name="keyword" class="white" placeholder="Search for your nationality" data-action="{{ route('searchNationality', $country->slug) }}" autocomplete="off"/>
				<button type="submit" class="submit_cities"><img src="{{ asset('public/images/icons/all/loupe-white.png') }}" alt="loupe-white"></button>
				<div class="list-result list-place">
					<ul>
						@include('form.nations_tips_guide')
					</ul>
				</div>
			</form>
		</div>
		@if($guides)
		<div class="@desktop slide-style @elsedesktop slide-dost @enddesktop list-guide">
			@foreach($guides as $key => $item)
                <div class="wrapper-item">
                    <div class="item" style="background-image: url('{!! getImgUrl($item->image); !!}')">
                        <h3 class="title-country white">{{$item->title}}</h3>
                        @handheld
	                     <a class="link" href="{{ route('postTypeCountryTravel', ['slug_country'=>$country->slug ,'slug'=>$item->slug ]) }}"  rel="dofollow"></a>
	                    @endhandheld
                        <div class="desc_hover">
                        	<a class="link_traveltips" href="{{ route('postTypeCountryTravel', ['slug_country'=>$country->slug ,'slug'=>$item->slug ]) }}"></a>
                            <div class="desc">
                                <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> 
                                <h7 class="title_hover yellow">
                                    {{$item->title}}
                                </h7>
                            </div>
                        </div>
                    </div>
                </div>
			@endforeach
		</div>
		@endif
	</div>
