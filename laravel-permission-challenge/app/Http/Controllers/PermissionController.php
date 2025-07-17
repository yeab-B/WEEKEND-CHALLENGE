<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Policies\GenericPolicy;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PermissionRequest;

class PermissionController extends Controller
{
    protected $genericPolicy;

    public function __construct(GenericPolicy $genericPolicy)
    {
        $this->genericPolicy = $genericPolicy;
    }

    public function index(Request $request)
    {
        // Check if the user has permission to view permissions
        // if (!Auth::user()->can('view permission')) {
        //     abort(403, 'Unauthorized action.');
        // }

        $search = $request->query('search');
        $sortColumn = $request->query('sort', 'name'); 
        $sortDirection = $request->query('direction', 'asc'); // Default sort direction
        $perPage = $request->query('per_page', 10); // Default items per page

        $permissions = Permission::query()
            ->when($search, function ($query, $search) {
                $searchTerm = '%' . strtolower($search) . '%';
                return $query->whereRaw('LOWER(name) LIKE ?', [$searchTerm]);
            })
            ->orderBy($sortColumn, $sortDirection)
            ->paginate($perPage);

        if ($request->ajax()) {
            return view('user.permissions.result', compact('permissions'))->render();
        }

        return view('user.permissions.index', compact('permissions', 'perPage'));
    }



    public function edit($id)
    {
        // // Check if the user has permission to edit permissions
        // if (!Auth::user()->can('edit permission')) {
        //     abort(403, 'Unauthorized action.');
        // }

        $permission = Permission::findOrFail($id);
        return view('user.permissions.partials.permission_form', compact('permission'))->render();
    }

    public function store(PermissionRequest $request)
    {
        Permission::create(['name' => $request->name]);

        return response()->json([
            'success' => true,
            'message' => 'Permission created successfully.'
        ]);
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->update(['name' => $request->name]);

        return response()->json([
            'success' => true,
            'message' => 'Permission updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        // // Check if the user has permission to delete permissions
        // if (!Auth::user()->can('delete permission')) {
        //     abort(403, 'Unauthorized action.');
        // }

        $permission = Permission::findOrFail($id);
        $permission->delete();

        return response()->json(['success' => true, 'message' => 'Permission deleted successfully.']);
    }
}
