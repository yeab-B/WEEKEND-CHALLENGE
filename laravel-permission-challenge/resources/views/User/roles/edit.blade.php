
@extends('layouts.master')

@section('title', 'Edit Role')

@section('content')
<div class="container">
    <h2>Edit Role</h2>
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

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
                    $groupedPermissions = [];

                    // Group permissions by module (last word)
                    foreach ($permissions as $permission) {
                        $parts = explode(' ', $permission->name);
                        if (count($parts) > 1) {
                            $module = array_pop($parts); // Last word as module
                            $action = implode(' ', $parts); // Remaining words as action

                            $groupedPermissions[$module][] = [
                                'id' => $permission->id,
                                'action' => ucfirst($action)
                            ];
                        }
                    }
                @endphp

                @foreach($groupedPermissions as $module => $actions)
                <tr>
                    <td><strong>{{ ucfirst($module) }}</strong></td>
                    <td>
                        @foreach($actions as $item)
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $item['id'] }}"
                                    {{ $role->permissions->contains($item['id']) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $item['action'] }}</label>
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
