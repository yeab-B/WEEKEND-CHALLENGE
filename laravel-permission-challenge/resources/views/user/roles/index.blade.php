@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Roles</h2>
            
                <a href="{{ route('roles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Create Role
                </a>
            
        </div>

        <table class="table table-bordered table-hover">
            <thead class="table-light">
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
                            <table class="table table-sm table-borderless mb-0">
                                @foreach ($groupedPermissions as $module => $permissionsInModule)
                                    <tr>
                                        <td class="fw-bold">{{ ucfirst($module) }}</td>
                                        <td>
                                            @foreach ($permissionsInModule as $permission)
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" class="form-check-input"
                                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label">
                                                        {{ ucfirst(explode(' ', $permission->name)[0]) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this role?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        const AppData = {
            RolesIndexRoute: "{{ route('roles.index') }}",
            csrfToken: "{{ csrf_token() }}"
        };
    </script>
@endsection
