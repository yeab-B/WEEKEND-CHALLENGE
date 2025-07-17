@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Roles</h2>
        @can('create role')
            <a href="{{ route('roles.create') }}" class="btn btn-primary">Create Role</a>
        @endcan
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                            @php
                                $groupedPermissions = $permissions->groupBy(function ($permission) {
                                    $parts = explode(' ', $permission->name);
                                    return strtolower(array_pop($parts));
                                });
                            @endphp
                            <table class="table table-borderless">
                                @foreach ($groupedPermissions as $module => $permissionsInModule)
                                    <tr>
                                        <td><strong>{{ ucfirst($module) }}</strong></td>
                                        <td>
                                            @foreach ($permissionsInModule as $permission)
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" class="form-check-input"
                                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label">{{ ucfirst(explode(' ', $permission->name)[0]) }}</label>
                                                </div>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                        <td>
                            @can('update role')
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            @endcan
                            @can('delete role')
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection