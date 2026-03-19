@if ($paginator->hasPages())
    <div class="pagination-wrap">

        {{-- Left: range info --}}
        <span class="pagination-info">
        Showing
        <strong>{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</strong>
        of
        <strong>{{ $paginator->total() }}</strong>
        student{{ $paginator->total() !== 1 ? 's' : '' }}
    </span>

        {{-- Right: page buttons --}}
        <div class="pagination-strip">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="pg-btn pg-nav disabled">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
                Prev
            </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pg-btn pg-nav">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Prev
                </a>
            @endif

            {{-- Page numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="pg-btn pg-dots">···</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pg-btn pg-active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pg-btn">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pg-btn pg-nav">
                    Next
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <span class="pg-btn pg-nav disabled">
                Next
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </span>
            @endif

        </div>
    </div>
@endif
