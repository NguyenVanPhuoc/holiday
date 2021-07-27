@if($nations && count($nations) > 0)
    @foreach($nations as $nation)
        <li><a href="#" class="link_city">{{ $nation->title }}</a></li>
    @endforeach
@endif