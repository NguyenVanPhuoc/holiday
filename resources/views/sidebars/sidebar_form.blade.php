@php
$list_reviewer = getListReviewer(NULL, NULL, 1);
@endphp
<div class="padding_auto">
	@if(isset($list_reviewer))
		@php
			$From_date = new DateTime($list_reviewer[0]->from_date);
			$To_date = new DateTime($list_reviewer[0]->to_date);
			$days  = $To_date->diff($From_date)->format('%a');
			$to_date = date('F y', strtotime($list_reviewer[0]->to_date));
			$tourstyle_ids = array_filter(explode(',', $list_reviewer[0]->list_tour_style));
			if($tourstyle_ids) {
				$tourstyle_text = '';
				$tour_title = get_title_category_tour($tourstyle_ids[0]);
				if($tour_title) $tourstyle_text .= $tour_title->title;
			}else $tourstyle_text = false;
		@endphp 
		<div class="wrap_review graybg">
			<div class="item">
				<h7 class="title_review"><a href="{{ route('detailClientReview',['slug'=>$list_reviewer[0]->slug]) }}" target="_blank">{{ $list_reviewer[0]->title }}</a></h7>
				<div class="desc">
				    {!! str_limit($list_reviewer[0]->content, 170) !!}
				    <a href="{{ route('detailClientReview',['slug'=>$list_reviewer[0]->slug]) }}" target="_blank">More</a>
				</div>
				<div class="rv_author">
					<a href="{{ route('detailClientReview',['slug'=>$list_reviewer[0]->slug]) }}" class="thumb" target="_blank">
						{!! image($list_reviewer[0]->image, 80, 80, $list_reviewer[0]->name) !!}
					</a>
					<span class="name">{{ $list_reviewer[0]->name }}</span>
					<span class="day">{{ $to_date }}</span>
				</div>
				<div>
					<span>{{getTitleOfGroupType($list_reviewer[0]->group_type_id)}} / </span>
					<span>{{ $days + 1}} days</span> 
					<span> / {{ $tour_title->title }}</span>
				</div>
			</div>
		</div>
	@endif
</div>
<div class="textcode">
	{!! getDsMetas(315) !!}
</div>