@php
 	$cat_guide = getListCatGuide();
 	$destination = getListMainCountry();
@endphp
	<div class="content-guide">
		<form action="" method="GET" class="form-show frm-market-nvp">
			{!!csrf_field()!!}
			<div class="form-group-show gr-filter">
				@if($destination)
					<div class="box-item1 single-value">
	                    <span class="title">Destinations</span>
	                    <ul class="list-unstyled">
	                        @foreach($destination as $des)
	                            <li>
	                                <label for="des-{{ $des->id }}" value="{{ $des->slug }}">
	                                    <input type="radio" class="filter-value" id="des-{{ $des->id }}" name="destination_id" value="{{ $des->slug }}" >
	                                    {{ $des->title }}
	                                </label>
	                            </li>
	                        @endforeach
	                    </ul>
	                </div>
				@endif
				<div class="box-item1 single-value nationality" data-link="">
                    <input type="text" name="key_nation" placeholder="Your nationality" value="" autocomplete="off">
                    {!!csrf_field()!!}
                    <ul class="list-unstyled list-hightlight">
                    	@include('form.list_nation')
                    </ul>
                    <div id="search-res" data-href="{{ route('searchNation') }}"></div>
				</div>
				<div class="submit_show">
					<input type="submit" name="submit" value="Show" class="btn-show">
					<i class="fa fa-search" aria-hidden="true"></i>
				</div>
			</div>
		</form>
		@if($cat_guide)
		<div class="@desktop slide-style @elsedesktop slide-dost @enddesktop list-guide">
			@foreach($cat_guide as $key => $item)
                <div class="wrapper-item">
                    <div class="item" style="background-image: url('{!! getImgUrl($item->feature_image); !!}')">
                    	@handheld
							<img class="plus" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Plus-white">
						@endhandheld
                        <h7 class="title-country white">{{$item->title}}</h7>
                        <div class="desc_hover">
                            <div class="text-center">
                            	@desktop
                                <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> 
                                @elsedesktop
                                <img class="cross" src="{{asset('public/images/icons/Cross_Yellow.png')}}" alt="Cross-white">
                                @enddesktop
                                <h7 class="title_hover yellow">
                                    {{$item->title}}
                                </h7>
                                <ul class="country_cat">
                                    @foreach($destination as $country)
                                        <li>
                                            <a href="{{ route('postTypeCountryTravel', ['slug_country'=>$country->slug , 'slug'=>$item->slug]) }}">{{($country->title)}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
			@endforeach
		</div>
		@endif
	</div>
