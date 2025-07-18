<div class="modal-header">
    <h5 class="modal-title" id="{{ isset($role) ? 'roleEditModalLabel' : 'roleCreateModalLabel' }}">
        {{ isset($role) ? 'Edit Role' : 'Create New Role' }}
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="{{ isset($role) ? 'editForm' : 'createForm' }}"
      method="POST"
      action="{{ isset($role) ? route('roles.update', $role->id) : route('roles.store') }}">
    @csrf
    @if(isset($role))
        @method('PUT') {{-- Method spoofing for PUT requests --}}
    @endif
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $role->name ?? '') }}" required>
            {{-- Placeholder for AJAX validation error for 'name' field --}}
            <div class="text-danger mt-1 small" id="name-error"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Permissions</label>
            <div class="row g-2">
                @forelse ($allPermissions as $permission)
                    <div class="col-md-4 col-sm-6"> {{-- 3 columns on desktop, 2 on tablet --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission-{{ $permission->id }}"
                                {{ (isset($role) && $role->hasPermissionTo($permission->name)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="permission-{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-muted">No permissions available.</div>
                @endforelse
            </div>
            {{-- Placeholder for AJAX validation error for 'permissions' field --}}
            <div class="text-danger mt-1 small" id="permissions-error"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" data-loading-text="{{ isset($role) ? 'Updating...' : 'Saving...' }}">
            {{ isset($role) ? 'Update Role' : 'Save Role' }}
        </button>
    </div>
</form>