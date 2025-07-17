@extends('layouts.master')

@section('scripts')
    <script>
        const AppData = {
            permissionsIndexRoute: "{{ route('permissions.index') }}",
            csrfToken: "{{ csrf_token() }}"
        };
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-0">Permissions</h5>
                        </div>
                        <div class="col-auto">
                            @can('create permission')
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPermissionModal" id="addPermissionBtn">
                                    <i class="ri-add-line align-bottom me-1"></i> Add Permission
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body border-bottom">
                    <form method="GET" id="permission-search-form" class="mb-3">
                        <div class="row g-3">
                            <div class="col-xxl-3 col-lg-6">
                                <input id="permission-search" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                            </div>
                            <div class="col-xxl-2 col-lg-3">
                                <select name="per_page" id="permission-per_page" class="form-select">
                                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                </select>
                            </div>
                            <div class="col-xxl-2 col-lg-4">
                                <a href="{{ route('permissions.index') }}" class="btn btn-soft-secondary w-100"><i class="mdi mdi-filter-outline align-middle"></i> Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="permission-search-results">
                    @include('user_control.permissions.result', ['permissions' => $permissions])
                </div>
            </div>
        </div>
    </div>

    <!-- Create Permission Modal -->
    <div class="modal fade" id="createPermissionModal" tabindex="-1" aria-labelledby="createPermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                @include('user_control.permissions.partials.permission_form', ['permission' => null])
            </div>
        </div>
    </div>

    <!-- Edit Permission Modal -->
    <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Content will be loaded via AJAX -->
            </div>
        </div>
    </div>
@endsection
