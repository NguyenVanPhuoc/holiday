
<div class="col-md-4 wrap-item grid-item">
	<div class="item">
		{!!$image!!}
		<h3 class="title-country white">{{$item->title}}</h3>
		<a class="link" href="{{ route('tour', ['slug_country'=>$country->slug,'slug'=>$item->slug ]) }}"></a>
		<div class="desc_hover"> 
            <div class="text-center">
                <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> 
                <h7 class="title_hover yellow">{{$item->title}}</h7>
                <div class="white">{!! $item->desc !!}</div>
            </div>
        </div>
	</div>
</div>