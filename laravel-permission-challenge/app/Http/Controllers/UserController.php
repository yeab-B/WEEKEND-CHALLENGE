<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $sortColumn = $request->query('sort', 'first_name'); // Default sort column
        $sortDirection = $request->query('direction', 'asc'); // Default sort direction
        $perPage = $request->query('per_page', 10); // Default items per page

        $users = User::query()
            ->where('status', '!=', 'archived') // Exclude archived users
            ->when($search, function ($query, $search) {
                $searchTerm = '%' . strtolower($search) . '%';
                return $query->whereRaw('LOWER(name) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(email) LIKE ?', [$searchTerm]);
            })
            ->orderBy($sortColumn, $sortDirection)
            ->paginate($perPage);

        if ($request->ajax()) {
            return view('user_control.users.partials.user_table', compact('users'))->render();
        }

        return view('user_control.users.index', compact('users', 'perPage'));
    }

    public function store(UserRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->role);

        return response()->json(['success' => true, 'message' => 'User created successfully.']);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        Log::info('Fetched roles:', ['roles' => $roles]);
        return view('user_control.users.partials.user_form', compact('user', 'roles'))->render();
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        $user->syncRoles([$request->role]);

        return response()->json(['success' => true, 'message' => 'User updated successfully.']);
    }

    public function archive($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'status' => 'archived',
            'updated_by' => Auth::id(),
        ]);

        return response()->json(['success' => 'true', 'message' => 'User archived successfully.']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
    }
}
