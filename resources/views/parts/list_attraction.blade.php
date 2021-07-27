@desktop
 <div class="wrapper-item">
    <div class="item" style="background-image: url('{!! getImgUrl($item->image); !!}')">
        <h7 class="title-style-tour white">{{$item->title}}</h7>
        <div class="desc_hover">
            <div class="text-center">
                <img class="bee" src="{{asset('public/images/bee/bee-white.png')}}" alt="bee-white"> 
                <h3 class="title_hover yellow">{{$item->title}}</h3>
                <div class="desc_vp">
                    <div class="white">
                       {!! str_limit($item->desc, 170) !!}
                    </div>
                    <a href="#" class="btn btn-gallery" data-modal="#gallery-style" data-key="{{ $key }}">VIEW GALLERY</a>
                </div>
            </div>
        </div>
    </div>
</div>
@elsedesktop
<div class="wrapper-item">
    <div class="item plus-desc" style="background-image: url('{!! getImgUrl($item->image); !!}')">
        <img class="pluss" src="{{asset('public/images/icons/Cross-White.png')}}" alt="Plus-white" data-key="{{ $key }}">
        <h3 class="title-style-tour white">{{$item->title}}</h3>
    </div>
</div>
@enddesktop