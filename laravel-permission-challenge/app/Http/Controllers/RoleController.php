<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Policies\GenericPolicy; // Import the GenericPolicy class
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    protected $genericPolicy;

    public function __construct(GenericPolicy $genericPolicy)
    {
        $this->genericPolicy = $genericPolicy;
    }

    public function index()
    {
        // Check if the user has permission to view roles
        if (!$this->genericPolicy->view(Auth::user(), new Role())) {
            abort(403, 'Unauthorized action.');
        }

        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('user.roles.index', compact('roles', 'permissions'));
    }

    public function create()
    {
        // Check if the user has permission to create roles
        if (!$this->genericPolicy->create(Auth::user(), new Role())) {
            abort(403, 'Unauthorized action.');
        }

        $permissions = Permission::all();
        return view('user.roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        // Check if the user has permission to create roles
        if (!$this->genericPolicy->create(Auth::user(), new Role())) {
            abort(403, 'Unauthorized action.');
        }



        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        // Check if the user has permission to edit roles
        if (!$this->genericPolicy->update(Auth::user(), $role)) {
            abort(403, 'Unauthorized action.');
        }

        $permissions = Permission::all();
        return view('user.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified role in storage.
     *
     * @param  \App\Http\Requests\RoleRequest  $request
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleRequest $request, Role $role)
    {
        // Check if the user has permission to update roles
        if (!$this->genericPolicy->update(Auth::user(), $role)) {
            abort(403, 'Unauthorized action.');
        }

        // Get validated data
        $validated = $request->validated();

        // Log the incoming request data
        Log::info('Role update request data:', [
            'validated_data' => $validated
        ]);

        // Update role name
        $role->update(['name' => $validated['name']]);

        // Handle permissions
        $permissions = $validated['permissions'] ?? [];
        Log::info('Permissions before processing:', ['permissions' => $permissions]);

        if (empty($permissions)) {
            $permissions = [];
        } elseif (is_string($permissions)) {
            $permissions = array_filter(explode(',', $permissions));
        }

        Log::info('Permissions after processing:', ['permissions' => $permissions]);

        // Sync permissions
        try {
            $role->permissions()->sync($permissions);
            Log::info('Permissions synced successfully');
        } catch (\Exception $e) {
            Log::error('Error syncing permissions:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        // Check if the user has permission to delete roles
        if (!$this->genericPolicy->delete(Auth::user(), $role)) {
            abort(403, 'Unauthorized action.');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
