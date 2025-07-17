@extends('layouts.master')

@section('title', 'Create Role')

@section('content')
<div class="container">
    <h2>Create Role</h2>

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Role Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Assign Permissions</label>

            @php
                // Group permissions by the last word (module)
                $permissionsGrouped = $permissions->groupBy(function ($permission) {
                    $permissionParts = explode(' ', $permission->name);
                    return strtolower(array_pop($permissionParts)); // Take the last word as module
                });
            @endphp

            <table class="table">
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>Permissions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissionsGrouped as $module => $permissionsInModule)
                        <tr>
                            <!-- Module Name -->
                            <td><strong>{{ ucfirst($module) }}</strong></td>

                            <!-- Action Checkboxes for the Module -->
                            <td>
                                @foreach($permissionsInModule as $permission)
                                    <div class="form-check d-inline-block mr-3">
                                        <input class="form-check-input action-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                                        <label class="form-check-label">{{ ucfirst(explode(' ', $permission->name)[0]) }}</label>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-success">Create Role</button>
    </form>
</div>

@section('scripts')
<script>
    // JavaScript to handle auto-selecting all actions when a module checkbox is clicked
    document.querySelectorAll('.module-checkbox').forEach(moduleCheckbox => {
        moduleCheckbox.addEventListener('change', function() {
            // Find all action checkboxes for this module and select/deselect them based on the module checkbox state
            const module = this.getAttribute('data-module');
            const actionCheckboxes = document.querySelectorAll(`.action-checkbox[value^="${module}"]`);

            actionCheckboxes.forEach(actionCheckbox => {
                actionCheckbox.checked = this.checked;
            });
        });
    });
</script>
@endsection

@endsection
