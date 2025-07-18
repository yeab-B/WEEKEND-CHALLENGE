@extends('layouts.app')

@section('title', isset($role) ? 'Edit Role' : 'Create Role')

@section('content')
    <div class="container">
        <h2>{{ isset($role) ? 'Edit Role' : 'Create Role' }}</h2>

        <form action="{{ route('roles.update', $role) }}" method="POST">

            @csrf
            @if(isset($role))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label"><strong>Role Name</strong></label>

                @if(isset($role))
                    <input type="text" class="form-control" value="{{ $role->name }}" disabled>
                    <input type="hidden" name="name" value="{{ $role->name }}">
                @else
                    <input type="text" name="name" class="form-control" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                @endif
            </div>

            @php
                $permissionsGrouped = $permissions->groupBy(function ($permission) {
                    $parts = explode(' ', $permission->name);
                    return strtolower(array_pop($parts));
                });
            @endphp

            <div class="mb-3">
                <label><strong>Assign Permissions</strong></label>
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
                                <td><strong>{{ ucfirst($module) }}</strong></td>
                                <td>
                                    @foreach($permissionsInModule as $permission)
                                        <div class="form-check d-inline-block me-3">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="permissions[]"
                                                value="{{ $permission->name }}"
                                                {{ isset($role) && $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label">
                                                {{ ucfirst(explode(' ', $permission->name)[0]) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success">{{ isset($role) ? 'Save' : 'Create Role' }}</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
