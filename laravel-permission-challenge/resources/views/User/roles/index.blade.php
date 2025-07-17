@extends('layouts.master')

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
                                $groupedPermissions = [];

                                // Group permissions by module (last word)
                                foreach ($permissions as $permission) {
                                    $parts = explode(' ', $permission->name);

                                    if (count($parts) > 1) {
                                        $module = array_pop($parts); // Take the last word as the module
                                        $action = implode(' ', $parts); // Remaining words as the action

                                        $groupedPermissions[$module][] = [
                                            'id' => $permission->id,
                                            'action' => ucfirst($action),
                                        ];
                                    }
                                }
                            @endphp

                            <table class="table table-borderless">
                                @foreach ($groupedPermissions as $module => $actions)
                                    <tr>
                                        <td><strong>{{ ucfirst($module) }}</strong></td>
                                        <td>
                                            @foreach ($actions as $item)
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" class="form-check-input"
                                                        {{ $role->permissions->contains($item['id']) ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label">{{ $item['action'] }}</label>
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
