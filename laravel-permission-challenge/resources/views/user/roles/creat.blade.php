@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
    <div class="container">
        <h2>Create Role</h2>
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Role Name</label>
                <input type="text" name="name" class="form-control" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label>Assign Permissions</label>
                @php
                    $permissionsGrouped = $permissions->groupBy(function ($permission) {
                        $parts = explode(' ', $permission->name);
                        return strtolower(array_pop($parts));
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
                                <td><strong>{{ ucfirst($module) }}</strong></td>
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
@endsection