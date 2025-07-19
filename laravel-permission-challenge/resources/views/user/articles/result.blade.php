<div class="card-body pt-0">
    <div class="table-responsive">
        <table class="table table-hover table-nowrap align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col" class="text-nowrap">No.</th>
                    <th scope="col" class="text-nowrap">
                        <a href="{{ route('articles.index', array_merge(request()->query(), ['sort' => 'title', 'direction' => request('direction') == 'asc' && request('sort') == 'title' ? 'desc' : 'asc'])) }}"
                           class="text-dark text-decoration-none">
                            Title
                            @if (request('sort') == 'title')
                                <i class="mdi mdi-sort-{{ request('direction') == 'asc' ? 'ascending' : 'descending' }}"></i>
                            @else
                                <i class="mdi mdi-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="text-nowrap">Author</th>
                    <th scope="col" class="text-nowrap">
                        <a href="{{ route('articles.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => request('direction') == 'asc' && request('sort') == 'created_at' ? 'desc' : 'asc'])) }}"
                           class="text-dark text-decoration-none">
                            Created At
                            @if (request('sort') == 'created_at')
                                <i class="mdi mdi-sort-{{ request('direction') == 'asc' ? 'ascending' : 'descending' }}"></i>
                            @else
                                <i class="mdi mdi-sort"></i>
                            @endif
                        </a>
                    </th>
                    <th scope="col" class="text-nowrap">Status</th>
                    
                    <th scope="col" class="text-nowrap">Actions</th>
                    
                </tr>
            </thead>
            <tbody>
                @forelse ($articles as $key => $article)
                    <tr>
                        <td class="text-muted">{{ ($articles->currentPage() - 1) * $articles->perPage() + $key + 1 }}</td>
                        <td>
                            <h6 class="mb-0">{{ Str::limit($article->title, 50) }}</h6>
                            <small class="text-muted">{{ Str::limit($article->content, 70) }}</small>
                        </td>
                        <td>{{ $article->user->name ?? 'N/A' }}</td> {{-- Assuming Article belongsTo User --}}
                        <td>
                            <span class="d-block">{{ $article->created_at->format('Y-m-d H:i:s') }}</span>
                            <small class="text-muted">{{ $article->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            @if ($article->approved)
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            <div class="hstack gap-2">
                                {{-- Changed 'view post' to 'view article' --}}
                                @can('view article')
                                    <button data-id="{{ $article->id }}"
                                            class="btn btn-sm btn-soft-info article-view-btn"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="View Details">
                                        <i class="mdi mdi-eye-outline"></i>
                                    </button>
                                @endcan
                                {{-- Changed 'update post' to 'update article' --}}
                                @can('update article')
                                    <button data-id="{{ $article->id }}"
                                            class="btn btn-sm btn-soft-warning article-edit-btn"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Edit">
                                        <i class="mdi mdi-pencil-outline"></i>
                                    </button>
                                @endcan
                                {{-- Changed 'approve post' to 'approve article' --}}
                                @can('approve article')
                                    @if (!$article->approved)
                                        <form action="{{ route('articles.approve', $article->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-sm btn-soft-success"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Approve Article"
                                                    onclick="return confirm('Are you sure you want to approve this article?');">
                                                <i class="mdi mdi-check-circle-outline"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endcan
                                {{-- Changed 'delete post' to 'delete article' --}}
                                @can('delete article')
                                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm btn-soft-danger article-delete-btn"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Delete">
                                            <i class="mdi mdi-delete-outline"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No articles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $articles->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>