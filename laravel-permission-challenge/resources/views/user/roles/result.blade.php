<div class="card-body pt-0">
    <div class="table-responsive">
        <table class="table table-hover table-nowrap align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col" class="text-nowrap" style="width: 50px;">ID</th>
                    <th scope="col" class="text-nowrap">Role Name</th>
                    <th scope="col" class="text-nowrap">Permissions</th>
                    <th scope="col" class="text-nowrap" style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <td class="text-muted">{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @forelse ($role->permissions as $permission)
                                <span class="badge bg-primary me-1 mb-1">{{ $permission->name }}</span>
                            @empty
                                <span class="badge bg-secondary">No Permissions</span>
                            @endforelse
                        </td>
                        <td>
                            <div class="hstack gap-2">
                                {{-- Edit Button --}}
                                <button type="button"
                                        class="btn btn-sm btn-soft-warning role-edit-btn"
                                        data-id="{{ $role->id }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Edit Role">
                                    <i class="mdi mdi-pencil-outline"></i>
                                </button>

                                {{-- Delete Button --}}
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="btn btn-sm btn-soft-danger role-delete-btn" {{-- Critical class for ListHandler --}}
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Delete Role">
                                        <i class="mdi mdi-delete-outline"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No roles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $roles->appends(request()->query())->links('vendor.pagination.bootstrap-5') }} {{-- Ensure this path is correct for your pagination view --}}
    </div>
</div>