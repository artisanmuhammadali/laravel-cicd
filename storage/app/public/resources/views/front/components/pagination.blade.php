@if ($items->hasPages())
    <nav class="d-md-none d-block">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($items->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">@lang('pagination.previous')</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $items->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                </li>
            @endif
            <li class="page-item" aria-disabled="true"><span class="page-link">Page {{$items->currentPage().' of '.$items->lastPage() }}</span></li>
            {{-- Next Page Link --}}
            @if ($items->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $items->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">@lang('pagination.next')</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
