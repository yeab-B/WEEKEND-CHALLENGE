<div class="modal-header">
    <h5 class="modal-title">{{ $user ? 'Edit User' : 'Create New User' }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="{{ $user ? 'editForm' : 'createForm' }}" method="POST" action="{{ $user ? route('users.update', $user->id) : route('users.store') }}">
    @csrf
    @if($user)
        @method('PUT')
    @endif
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $user->name ?? '' }}" required>
            <div class="text-danger" id="name-error"></div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $user->email ?? '' }}" required>
            <div class="text-danger" id="email-error"></div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" {{ $user ? '' : 'required' }}>
            <div class="text-danger" id="password-error"></div>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" {{ $user ? '' : 'required' }}>
            <div class="text-danger" id="password_confirmation-error"></div>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" class="form-control" required>
                @if ($roles && $roles->isNotEmpty())
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $user && $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                @else
                    <option value="" disabled>No roles available</option>
                @endif
            </select>
            <div class="text-danger" id="role-error"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ $user ? 'Update User' : 'Save User' }}</button>
    </div>
</form>