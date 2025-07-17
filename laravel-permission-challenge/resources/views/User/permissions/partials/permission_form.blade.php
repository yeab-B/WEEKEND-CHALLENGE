<div class="modal-header">
    <h5 class="modal-title">{{ $permission ? 'Edit Permission' : 'Create New Permission' }}</h5>
</div>
<form id="{{ $permission ? 'editForm' : 'createForm' }}" method="POST" action="{{ $permission ? route('permissions.update', $permission->id) : route('permissions.store') }}">
    @csrf
    @if($permission)
        @method('PUT')
    @endif
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Permission Name</label>
            <input type="text" class="form-control" name="name" value="{{ $permission->name ?? '' }}" required>
            <div class="text-danger" id="name-error"></div>
            <small class="form-text text-muted">
                Enter the permission name with at least two words. The last word will be treated as the module.
                Example: "edit user" → Action: "edit", Module: "user".
            </small>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ $permission ? 'Update Permission' : 'Save Permission' }}</button>
    </div>
</form>