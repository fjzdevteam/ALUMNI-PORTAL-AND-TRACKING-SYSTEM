<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Traits\AuditLogTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    use AuditLogTrait;

    public function index(Request $request)
    {
        $query = User::query();
        $query->where('id', '!=', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('id', 'asc')->paginate(10);
        $this->addAuditLog("Viewed user management list");

        return view('admin.portal.user.user-management', compact('users'));
    }

    public function showAddUser()
    {
        $this->addAuditLog("Opened add user page");
        return view('admin.portal.user.add-user');
    }

    public function addUser(Request $request)
    {
        $request->validate([
            'last_name' => 'required|string|max:100',
            'first_name' => 'required|string|max:191',
            'middle_name' => 'nullable|string|max:100',
            'suffix' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ], [
            'password.regex' => 'Password must include at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ]);

        $user = User::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'suffix' => $request->suffix,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $this->addAuditLog("Created a new user '{$user->username}' ({$user->role})");

        return redirect()->route('show.add.user')->with('success', 'Admin user added successfully.');
    }

    public function viewUser($id)
    {
        $user = User::findOrFail($id);
        $this->addAuditLog("Viewed profile of user '{$user->username}'");

        return view('admin.portal.user.view-user', compact('user'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $user = User::findOrFail($id);
        $oldStatus = $user->status;
        $user->status = $request->status;
        $user->save();

        $this->addAuditLog("Updated status of user '{$user->username}' from '{$oldStatus}' to '{$user->status}'");

        return redirect()->back()->with('success', 'User status updated successfully.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $username = $user->username;
        $role = $user->role;
        $user->delete();

        $this->addAuditLog("Deleted user '{$username}' ({$role})");

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
