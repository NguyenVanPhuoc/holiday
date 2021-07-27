@php
 	$nation = getListNation();
@endphp
	<div class="content-guide">
		<div class="search-box white">
        	<form action="" method="get" id="search-city">
				{!!csrf_field()!!}
				<input type="text" name="keyword" class="white" placeholder="Search for your nationality" data-action="{{ route('searchNationality', $country->slug) }}" autocomplete="off"/>
				<input type="hidden" name="country" value="{{$country->slug}}">
				<button type="submit" class="submit_cities"><img src="{{ asset('public/images/icons/all/loupe-white.png') }}"></button>
				<div class="list-result list-place">
					<ul>
						@include('form.nations_tips_guide')
					</ul>
				</div>
			</form>
		</div>
		@if($nation)
		@desktop
		<div class="slide-style list-guide">
			@foreach($nation as $key => $item)
                <div class="wrapper-item">
                    <div class="item" style="background-image: url('{!! getImgUrl($item->feature_image); !!}')">
                        <h7 class="title-country white">
                            {{$item->title}}
                        </h7>
                        <div class="desc_hover">
                        	<a class="link_traveltips" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item->slug]) }}"></a>
                            <div class="text-center">
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
		@elsedesktop
		<div class="slide-dost list-guide">
			@foreach($nation as $key => $item)
                <div class="wrapper-item">
                    <div class="item" style="background-image: url('{!! getImgUrl($item->feature_image); !!}')">
                        <h7 class="title-country white">{{$item->title}}</h7>
                        	<a class="link" href="{{ route('postTypeCountryTravel', ['slug_country' => $country->slug,'slug' => $item->slug]) }}"></a>
                        <div class="desc_hover">
                            <div class="text-center">
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
		@enddesktop
		@endif
	</div>
