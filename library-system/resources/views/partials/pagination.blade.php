@if ($paginator->hasPages())
    <nav class="simple-pagination" aria-label="Navigasi Halaman">
        @if ($paginator->onFirstPage())
            <span class="btn btn-outline btn-sm" aria-disabled="true" style="opacity:.5; pointer-events:none;">&laquo; Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-outline btn-sm">&laquo; Sebelumnya</a>
        @endif

        <span class="muted" style="font-size:0.85rem;">
            Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}
        </span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-outline btn-sm">Berikutnya &raquo;</a>
        @else
            <span class="btn btn-outline btn-sm" aria-disabled="true" style="opacity:.5; pointer-events:none;">Berikutnya &raquo;</span>
        @endif
    </nav>
@endif
