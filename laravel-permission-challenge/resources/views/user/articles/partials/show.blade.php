<div class="modal-header">
    <h5 class="modal-title" id="articleViewModalLabel">Article Details: {{ $article->title }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="mb-3">
        <strong>Title:</strong>
        <p>{{ $article->title }}</p>
    </div>
    <div class="mb-3">
        <strong>Content:</strong>
        <div class="card bg-light p-3">
            <p style="white-space: pre-wrap;">{{ $article->content }}</p> {{-- Use white-space: pre-wrap for preserving formatting --}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <strong>Author:</strong>
            <p>{{ $article->user->name ?? 'N/A' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <strong>Status:</strong>
            <p>
                @if ($article->approved)
                    <span class="badge bg-success">Approved</span>
                @else
                    <span class="badge bg-warning text-dark">Pending</span>
                @endif
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <strong>Created At:</strong>
            <p>{{ $article->created_at->format('Y-m-d H:i:s') }} ({{ $article->created_at->diffForHumans() }})</p>
        </div>
        <div class="col-md-6 mb-3">
            <strong>Last Updated:</strong>
            <p>{{ $article->updated_at->format('Y-m-d H:i:s') }} ({{ $article->updated_at->diffForHumans() }})</p>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>