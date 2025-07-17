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
        $sortColumn = $request->query('sort', 'name');
        $sortDirection = $request->query('direction', 'asc');
        $perPage = $request->query('per_page', 10);

        $users = User::query()
            ->where('status', '!=', 'archived')
            ->when($search, function ($query, $search) {
                $searchTerm = '%' . strtolower($search) . '%';
                return $query->whereRaw('LOWER(name) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(email) LIKE ?', [$searchTerm]);
            })
            ->orderBy($sortColumn, $sortDirection)
            ->paginate($perPage);

        if ($request->ajax()) {
            return view('user.users.partials.user_table', compact('users'))->render();
        }

        return view('user.users.index', compact('users', 'perPage'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('user.users.create', compact('roles'));
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

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('user.users.partials.user_form', compact('user', 'roles'))->render();
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

    public function archive(User $user)
    {
        $user->update(['status' => 'archived']);
        return response()->json(['success' => true, 'message' => 'User archived successfully.']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
    }
}