<div class="col-md-6 col-pd">
    @php
        $From_date = new DateTime($item->from_date);
        $To_date = new DateTime($item->to_date);
        $days  = $To_date->diff($From_date)->format('%a');
        $to_date = date('F Y', strtotime($item->to_date));
        $tourstyle_ids = array_filter(explode(',', $item->list_tour_style));
        if($tourstyle_ids) {
            $tourstyle_text = '';
            $tour_title = get_title_category_tour($tourstyle_ids[0]);
            if($tour_title) $tourstyle_text .= $tour_title->title;
        }else $tourstyle_text = false;
    @endphp 
    <div class="wrap_review graybg">
        <div class="item">
            <h7 class="title_review"><a href="{{ route('detailClientReview',['slug'=>$item->slug]) }}">{{ $item->title }}</a></h7>
            <div class="desc">
                {!! str_limit($item->content, 190) !!}
                <a href="{{ route('detailClientReview',['slug'=>$item->slug]) }}">More</a>
            </div>
            <div class="rv_author">
                <a href="{{ route('detailClientReview',['slug'=>$item->slug]) }}" class="thumb">
                    {!! image($item->image, 80, 80, $item->name) !!}
                </a>
                <span class="name">{{ $item->name }}</span>
                <span class="day">{{ $to_date }}</span>
            </div>
            <div>
                <span>{{getTitleOfGroupType($item->group_type_id)}} / </span>
                <span>{{ $days + 1 }} days</span> 
                <span> / {{ $tour_title->title }}</span>
            </div>
        </div>
    </div>
</div>