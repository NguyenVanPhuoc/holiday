@if ($paginator->hasPages())
    @php
        /*if(isset($set_currentPage) && $set_currentPage != ''){
            $setPaginate = json_decode($paginator->toJson()); 
            $setPaginate->current_page = 2;
        }*/
        
    @endphp
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <li class="page-item"><a class="page-link page-arrow page-prev" href="{{ $paginator->previousPageUrl() }}" rel="prev"><img src="{{asset('public/images/temp/icons/arrow.png')}}" alt="arrow"><span>Prev</span></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }} </span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                    
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link page-arrow page-next" href="{{ $paginator->nextPageUrl() }}" rel="next"><span>Next</span><img src="{{asset('public/images/temp/icons/arrow.png')}}" alt="arrow"></a></li>
        @else
            <li class="page-item disabled"><span class="page-link page-arrow page-next"><span>Next</span><img src="{{asset('public/images/temp/icons/arrow.png')}}" alt="arrow"></li>
        @endif
    </ul>
@endif
