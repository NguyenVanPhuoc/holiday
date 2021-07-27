@if($nations->count() > 0 )
    @foreach($nations as $nation)
        <li>
            <label for="nation-{{ $nation->id }}" value="{{ $nation->slug }}">
                <input type="radio" class="filter-value" id="nation-{{ $nation->id }}" name="nationality_id" value="{{ $nation->id }}" >
                <span class="title_nation">{{ $nation->title }}</span>
            </label>
        </li>
    @endforeach
@endif