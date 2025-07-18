<div class="modal-header">
    <h5 class="modal-title" id="{{ isset($permission) ? 'permissionEditModalLabel' : 'permissionCreateModalLabel' }}">
        {{ isset($permission) ? 'Edit Permission' : 'Create New Permission' }}
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="{{ isset($permission) ? 'editForm' : 'createForm' }}"
      method="POST"
      action="{{ isset($permission) ? route('permissions.update', $permission->id) : route('permissions.store') }}">
    @csrf
    @if(isset($permission))
        @method('PUT') {{-- Method spoofing for PUT requests --}}
    @endif
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Permission Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $permission->name ?? '') }}" required>
            {{-- Placeholder for AJAX validation error for 'name' field --}}
            <div class="text-danger mt-1 small" id="name-error"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" data-loading-text="{{ isset($permission) ? 'Updating...' : 'Saving...' }}">
            {{ isset($permission) ? 'Update Permission' : 'Save Permission' }}
        </button>
    </div>
</form>