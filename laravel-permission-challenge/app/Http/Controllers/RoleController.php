<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Policies\GenericPolicy;

class RoleController extends Controller
{
   protected $genericPolicy;

    public function __construct(GenericPolicy $genericPolicy)
    {
        $this->genericPolicy = $genericPolicy;
    }

   public function index()
{
    $roles = Role::with('permissions')->paginate(10); // eager load permissions
    $allPermissions = Permission::all(); // fetch all permissions for checkboxes

    if (request()->ajax()) {
        return view('user.roles.result', compact('roles'))->render();
    }

    return view('user.roles.index', compact('roles', 'allPermissions'));
}
    public function create()
    {
        $permissions = Permission::all();
        return view('user.roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('user.roles.edit', compact('role', 'permissions'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}