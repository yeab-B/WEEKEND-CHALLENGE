@extends('layouts.app') {{-- Assumes you have a base layout file --}}

@section('styles')
    {{-- Add any specific styles here, e.g., for multi-select checkboxes if custom styling is applied --}}
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-dark">Roles Management</h4>
                        {{-- Button to open the create role modal --}}
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#roleCreateModal">
                            <i class="mdi mdi-plus-circle-outline me-1"></i> Add New Role
                        </button>
                    </div>
                    <div class="card-body border-bottom">
                        <form method="GET" id="role-search-form" class="mb-3">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-5 col-lg-4">
                                    <input type="text" id="role-search" name="search" class="form-control" placeholder="Search role name..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3 col-lg-2">
                                    <select name="per_page" id="role-per_page" class="form-select">
                                        <option value="5" {{ request('per_page', 10) == 5 ? 'selected' : '' }}>5 per page</option>
                                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 per page</option>
                                        <option value="20" {{ request('per_page', 10) == 20 ? 'selected' : '' }}>20 per page</option>
                                        <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50 per page</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary w-100">
                                        <i class="mdi mdi-filter-off me-1"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- This div will be updated with AJAX results by RoleListHandler --}}
                    <div id="role-search-results">
                        {{-- Initial load of role list, will be replaced by AJAX on search/pagination --}}
                        @include('user.roles.result', ['roles' => $roles])
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Role Modal --}}
    <div class="modal fade" id="roleCreateModal" tabindex="-1" aria-labelledby="roleCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {{-- Content for create form will be included directly, passing all permissions --}}
                @include('user.roles.partials.form', ['role' => null, 'allPermissions' => $allPermissions ?? []])
              

            </div>
        </div>
    </div>

    {{-- Edit Role Modal --}}
    <div class="modal fade" id="roleEditModal" tabindex="-1" aria-labelledby="roleEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {{-- Content for edit form will be loaded dynamically via AJAX by RoleListHandler --}}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Pass necessary data to your JavaScript --}}
    <script>
        const AppData = {
            RolesIndexRoute: "{{ route('roles.index') }}",
            csrfToken: "{{ csrf_token() }}"
            // Any other routes your RoleListHandler might specifically need for form loading
        };
    </script>
    {{-- Ensure your app.js (which initializes RoleListHandler) is loaded after AppData --}}
    @vite(['resources/js/app.js'])
@endsection