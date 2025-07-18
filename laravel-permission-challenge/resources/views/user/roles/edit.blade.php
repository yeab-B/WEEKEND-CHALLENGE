@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
    <div class="container">
        <h2>Edit Role</h2>
       <form action="{{ route('roles.update', $role->id) }}" method="POST">

    @csrf
    @method('PUT')
    ...
</form>

            <div class="mb-3">
                <label class="form-label"><strong>Role Name</strong></label>
                <input type="text" class="form-control" value="{{ $role->name }}" disabled>
                <input type="hidden" name="name" value="{{ $role->name }}">
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>Permissions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $groupedPermissions = $permissions->groupBy(function ($permission) {
                            $parts = explode(' ', $permission->name);
                            return strtolower(array_pop($parts));
                        });
                    @endphp
                    @foreach($groupedPermissions as $module => $permissionsInModule)
                        <tr>
                            <td><strong>{{ ucfirst($module) }}</strong></td>
                            <td>
                                @foreach($permissionsInModule as $permission)
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->name }}"
                                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ ucfirst(explode(' ', $permission->name)[0]) }}</label>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection