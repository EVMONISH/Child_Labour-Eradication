@if ($paginator->hasPages())
    <nav class="pagination-nav" style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
        
        <div style="font-size: 13px; color: var(--text3);">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>

        <div style="display: flex; gap: 8px;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="btn btn-ghost btn-sm" style="opacity: 0.5; cursor: not-allowed;">Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-primary btn-sm">Previous</a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-primary btn-sm">Next</a>
            @else
                <span class="btn btn-ghost btn-sm" style="opacity: 0.5; cursor: not-allowed;">Next</span>
            @endif
        </div>
    </nav>
@endif
