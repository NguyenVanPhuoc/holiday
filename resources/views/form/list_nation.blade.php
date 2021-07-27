@php
	$total_nation = getTotalNation();
    $main_nation = getListNation();
    $other_nation = getListNation(($total_nation - 6), 6);
@endphp
@if($main_nation)
    @foreach($main_nation as $nation)
        <li>
            <label for="nation-{{ $nation->id }}" value="{{ $nation->slug }}">
                <input type="radio" class="filter-value" id="nation-{{ $nation->id }}" name="nationality_id" value="{{ $nation->slug }}" >
                <span class="title_nation">{{ $nation->title }}</span>
            </label>
        </li>
    @endforeach
@endif
<hr class="line">
@if($other_nation)
    @foreach($other_nation as $nation)
        <li>
            <label for="nation-{{ $nation->id }}" value="{{ $nation->slug }}">
                <input type="radio" class="filter-value" id="nation-{{ $nation->id }}" name="nationality_id" value="{{ $nation->slug }}" >
                 <span class="title_nation">{{ $nation->title }}</span>
            </label>
        </li>
    @endforeach
@endif