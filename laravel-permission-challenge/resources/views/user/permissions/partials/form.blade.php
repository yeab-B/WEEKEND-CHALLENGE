<form
    id="{{ isset($permission) ? 'editForm' : 'createForm' }}"
    method="POST"
    action="{{ isset($permission) ? route('permissions.update', $permission->id) : route('permissions.store') }}"
>
    @csrf
    @if(isset($permission))
        @method('PUT')
    @endif

    <div class="modal-body bg-dark text-light">
        <div class="mb-3">
            <label for="name" class="form-label">Permission Name</label>
            <input
                type="text"
                name="name"
                class="form-control bg-dark text-light border-secondary"
                value="{{ old('name', $permission->name ?? '') }}"
                required
                placeholder="e.g., edit user"
            >
            <div class="text-danger small" id="name-error"></div>
            <small class="form-text text-muted">
                Use at least two words. The last word will be used as the module name.<br>
                Example: <strong>edit user</strong> → Action: edit, Module: user
            </small>
        </div>
    </div>

    <div class="modal-footer bg-dark border-top">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">
            {{ isset($permission) ? 'Update' : 'Save' }}
        </button>
    </div>
</form>
