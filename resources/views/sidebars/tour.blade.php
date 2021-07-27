<div class="gr-not-fixed" >
	<div class="wrapper has-top-icon sidebar-sec">
		<div class="icon-top">
			<img src="{{ asset('public/images/icons/all/quick-search-gray.png') }}" alt="icon">
		</div>
		<div class="top-title-sb graybg">Quick search</div>
		<form action="{{ route('asiaTour') }}" method="GET" class="quick-search">
			<div class="wrap-sb">		
				<div class="box-item sb-filter destination-box">
					<p class="title">Destination</p>
					<ul>
						@foreach($list_country as $item)
							<li data-id={{$item->id}}>
								<input type="checkbox" name="destination_id[]" value="{{ $item->id }}">{{$item->title}}
							</li>
						@endforeach
					</ul>
				</div>

				@if($durations)
				<div class="box-item sb-filter single-value duration-box">
					<p class="title">Duration</p>
					<ul>
						@foreach($durations as $duration)
							<li data-id="{{$duration->id}}">
								<input type="radio" name="duration_id" value="{{ $duration->id }}">{{$duration->title}}
							</li>
						@endforeach
					</ul>
				</div>
				@endif

				<div class="box-item sb-filter tour-style-box">
					<p class="title">Tour Style</p>
					<ul>
						@foreach($cats as $cat)
							<li data-id="{{$cat->id}}">
								<input type="checkbox" name="cat_id[]" value="{{ $cat->id }}">{{$cat->title}}
							</li>
						@endforeach
					</ul>
				</div>
				
			</div>
			<div class="submit pinkbg">
				<a href="#" class="normal"><i class="fa fa-search" aria-hidden="true"></i>Search</a>
			</div>
		</form>	
	</div>

	

</div>

<div class="group-fixed">
	<div class="sidebar-sec sidebar-box sb-practical-info">
		<div class="title">Essential documents</div>
		<div class="content-sb-box">
			<img src="{{asset('/public/images/bee/base_fill.png')}}" alt="icon">
			<p class="m-0">A brief of practical info to prepare for your journey</p>
		</div>
		<a href="#" class="btn">Practical info.</a>
	</div>
	
	<div class="sidebar-box sidebar-sec sb-consultants">	
			<div class="title">Our local expert</div>
			<div class="content-sb-box">
				@if($consultants)
				@php
					(count($consultants) > 1) ? $class = 'slide-consultants ' : $class = '';
				@endphp
				<div class="sb-list-consultant  {{$class}}">
					@foreach($consultants as $item)
						<div class="item">
							<a class="name yellow">{{ $item->title }}</a>
							<a href="#" class="avatar">
								{!! image($item->image, 100, 100, $item->title) !!}
							</a>
							<div class="desc text-center">{{ $item->short_desc }}</div>	
						</div>
					@endforeach
				</div>
				@endif
			</div>
		
		<a href="#" class="btn"><i class="fa fa-users" aria-hidden="true"></i> Meet our team</a>
	</div>
	<!-- <div class="table-list table-list-schedule">
		<div class="table-content">
			<div class="table-header">
				<span class="icon">
					<img src="{{asset('/public/images/icons/icon-table-list.png')}}" alt="icon">
				</span>
				<h5 class="table-title">Detailed Schedule</h5>
				<span class="close">
					<i class="fa fa-times"></i>
				</span>
			</div>
			<div class="table-body scrollbar-inner">
				<div class="wrap-body">
					<ul>
						@foreach($list_schedule as $key=>$schedule)
							<li>
								<a href="#day-{{$key+1}}"><span>Day {{$key+1}}:</span> {{$schedule->title}}</a>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		<a href="javascript:void(0)" class="table-bar"><img src="{{asset('/public/images/icons/icon-table-list.png')}}" alt="icon"></a>
	</div> -->
</div>