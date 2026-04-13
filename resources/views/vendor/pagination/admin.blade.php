@if ($paginator->hasPages())
    <nav class="admin-pagination" role="navigation" aria-label="Pagination Navigation">
        <div class="admin-pagination-summary">
            แสดง {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} จาก {{ $paginator->total() }} รายการ
        </div>

        <div class="admin-pagination-links">
            @if ($paginator->onFirstPage())
                <span class="admin-page-link is-disabled">ก่อนหน้า</span>
            @else
                <a class="admin-page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">ก่อนหน้า</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="admin-page-link is-disabled">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="admin-page-link is-active">{{ $page }}</span>
                        @else
                            <a class="admin-page-link" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a class="admin-page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">ถัดไป</a>
            @else
                <span class="admin-page-link is-disabled">ถัดไป</span>
            @endif
        </div>
    </nav>
@endif
