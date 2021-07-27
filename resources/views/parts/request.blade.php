<div class="container">
	<div class="list-request">
		<div class="row item-request">
			<div class="col-md-5 col-sm-6 item">
				{{-- <img src="{!! getImgUrl($img_request)!!}" alt="image"> --}}
				{!! image($img_request,300,220,'image') !!}
			</div>
			<div class="col-md-7 col-sm-6 text-center item">
				<span class="aplan yellow">{!! $title_request !!}</span>
				<a class="btn btn-request" href="{{ route('createMyTrip')}}">REQUEST A FREE QUOTE</a>
			</div>
		</div>
	</div>
</div>
