@extends('layouts.app') 



@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-dark">Articles Management</h4>
                        @can('create articles')
                            {{-- Button to open the Create Article Modal --}}
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#articleCreateModal">
                                <i class="mdi mdi-plus-circle-outline me-1"></i> Add New Article
                            </button>
                        @endcan
                    </div>
                    <div class="card-body border-bottom">
                        <form method="GET" id="article-search-form" class="mb-3">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-5 col-lg-4">
                                    <input id="article-search" name="search" class="form-control" placeholder="Search by title or content..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3 col-lg-2">
                                    <select name="per_page" id="article-per_page" class="form-select">
                                        <option value="5" {{ request('per_page', 10) == 5 ? 'selected' : '' }}>5 per page</option>
                                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 per page</option>
                                        <option value="20" {{ request('per_page', 10) == 20 ? 'selected' : '' }}>20 per page</option>
                                        <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50 per page</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary w-100">
                                        <i class="mdi mdi-filter-off me-1"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="article-search-results">
                        @include('user.articles.result', ['articles' => $articles])
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Article Modal --}}
    <div class="modal fade" id="articleCreateModal" tabindex="-1" aria-labelledby="articleCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                @include('user.articles.partials.form', ['article' => null])
               
            </div>
        </div>
    </div>

    {{-- Edit Article Modal --}}
    <div class="modal fade" id="articleEditModal" tabindex="-1" aria-labelledby="articleEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {{-- Content will be loaded via AJAX from articles.edit --}}
            </div>
        </div>
    </div>

    {{-- View Article Modal --}}
    <div class="modal fade" id="articleViewModal" tabindex="-1" aria-labelledby="articleViewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {{-- Content will be loaded via AJAX from articles.show --}}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        const AppData = {
            ArticlesIndexRoute: "{{ route('articles.index') }}",
            csrfToken: "{{ csrf_token() }}"
          
        };
    </script>
@endsection