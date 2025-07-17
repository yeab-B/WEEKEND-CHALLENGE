<div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="permissionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-light">

      <div class="modal-header">
        <h5 class="modal-title" id="permissionModalLabel">{{ $permission ? 'Edit Permission' : 'Create New Permission' }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="{{ $permission ? 'editForm' : 'createForm' }}" method="POST" action="{{ $permission ? route('permissions.update', $permission->id) : route('permissions.store') }}">
        @csrf
        @if($permission)
          @method('PUT')
        @endif

        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label text-light">Permission Name</label>
            <input type="text" class="form-control bg-dark text-light border-secondary" name="name" value="{{ $permission->name ?? '' }}" required>
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

    </div>
  </div>
</div>
