<nav aria-label="Page navigation example">
    @if ($paginator->lastPage() > 1)
    <ul class="pagination justify-content-end">
        <li class="{{ ($paginator->currentPage() == 1) ? ' page-item disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->url($paginator->currentPage()-1) }}">&laquo; Previous</a>
        </li>
        <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' page-item disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->url($paginator->currentPage()+1) }}" >Next &raquo;</a>
        </li>
    </ul>
    @endif
</nav>