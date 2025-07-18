<div class="card-body pt-0">
    <div class="table-responsive">
        <table class="table table-hover table-nowrap align-middle mb-0">
            <thead class="table-light">
                <tr>
                   
                    <th scope="col" class="text-nowrap">Permission Name</th>
                    <th scope="col" class="text-nowrap" style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($permissions as $permission)
                    <tr>
                     
                        <td>{{ $permission->name }}</td>
                        <td>
                            <div class="hstack gap-2">
                                
                                <button type="button"
                                        class="btn btn-sm btn-soft-warning permission-edit-btn"
                                        data-id="{{ $permission->id }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#permissionEditModal"
                                        data-bs-placement="top" data-bs-title="Edit Permission">
                                    <i class="mdi mdi-pencil-outline"></i>
                                </button>
                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="btn btn-sm btn-soft-danger permission-delete-btn" {{-- Critical class for ListHandler --}}
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Delete Permission">
                                        <i class="mdi mdi-delete-outline"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">No permissions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $permissions->appends(request()->query())->links('vendor.pagination.bootstrap-5') }} {{-- Adjust 'vendor.pagination.bootstrap-5' if your pagination view is different --}}
    </div>
</div>