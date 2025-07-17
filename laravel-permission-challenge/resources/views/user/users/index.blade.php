@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 card-title flex-grow-1">User List</h5>
                        <div class="flex-shrink-0">
                            @can('create user')
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">Add User</button>
                                <a href="{{ route('users.index') }}" class="btn btn-light"><i class="mdi mdi-refresh"></i></a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body border-bottom">
                    <form method="GET" id="user-search-form" class="mb-3">
                        <div class="row g-3">
                            <div class="col-xxl-4 col-lg-6">
                                <input id="user-search" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                            </div>
                            <div class="col-xxl-2 col-lg-6">
                                <select name="per_page" id="user-per_page" class="form-select" onchange="this.form.submit()">
                                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                </select>
                            </div>
                            <div class="col-xxl-2 col-lg-4">
                                <a href="{{ route('users.index') }}" class="btn btn-soft-secondary w-100"><i class="mdi mdi-filter-outline align-middle"></i> Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="user-search-results">
                    @include('user_control.users.partials.user_table', ['users' => $users])
                </div>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                @include('user_control.users.partials.user_form', ['user' => null])
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Content loaded via AJAX -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const usersIndexRoute = "{{ route('users.index') }}";
        const csrfToken = "{{ csrf_token() }}";

        $(document).ready(function () {
            function performAjaxRequest(url, type, data = {}) {
                $.ajax({
                    url: url,
                    type: type,
                    data: data,
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    success: function (response) {
                        $('#user-search-results').html(response);
                    },
                    error: function (response) {
                        if (response.responseJSON && response.responseJSON.errors) {
                            $.each(response.responseJSON.errors, function (key, value) {
                                $(`#${key}-error`).text(value[0]);
                            });
                        } else {
                            toastr.error('An error occurred. Please try again.');
                        }
                    }
                });
            }

            $('#user-search').on('keyup', function () {
                performAjaxRequest(usersIndexRoute, 'GET', $('#user-search-form').serialize());
            });

            $('#user-per_page').on('change', function () {
                performAjaxRequest(usersIndexRoute, 'GET', $('#user-search-form').serialize());
            });

            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                performAjaxRequest($(this).attr('href'), 'GET');
            });

            $(document).on('submit', '#createForm, #editForm', function (e) {
                e.preventDefault();
                performAjaxRequest($(this).attr('action'), $(this).attr('method') === 'PUT' ? 'PUT' : 'POST', $(this).serialize(), function (response) {
                    $('#createUserModal, #editUserModal').modal('hide');
                    toastr.success(response.message);
                    performAjaxRequest(usersIndexRoute, 'GET', $('#user-search-form').serialize());
                });
            });

            $(document).on('click', '.user-edit-btn', function () {
                const userId = $(this).data('id');
                $.ajax({
                    url: `/users/${userId}/edit`,
                    type: 'GET',
                    success: function (response) {
                        $('#editUserModal .modal-content').html(response);
                        $('#editUserModal').modal('show');
                    },
                    error: function () {
                        toastr.error('Failed to load edit form.');
                    }
                });
            });

            $(document).on('click', '.user-archive-btn', function (e) {
                e.preventDefault();
                const form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, archive it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        performAjaxRequest(form.attr('action'), 'POST', { per_page: $('#user-per_page').val() }, function (response) {
                            toastr.success(response.message);
                            performAjaxRequest(usersIndexRoute, 'GET', $('#user-search-form').serialize());
                        });
                    }
                });
            });

            $('#createUserModal, #editUserModal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
                $(this).find('.text-danger').text('');
            });
        });
    </script>
@endsection