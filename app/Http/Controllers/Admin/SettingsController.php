<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Traits\AuditLogTrait;

class SettingsController extends Controller
{
    use AuditLogTrait;

    public function profile()
    {
        $user = Auth::user();
        return view('admin.portal.settings.admin-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'last_name' => 'required|string|max:100',
            'first_name' => 'required|string|max:191',
            'middle_name' => 'nullable|string|max:100',
            'suffix' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($user->image_path && Storage::disk('public')->exists($user->image_path)) {
                Storage::disk('public')->delete($user->image_path);
            }

            $path = $request->file('profile_picture')->store('profile_images', 'public');
            $user->image_path = $path;
        }

        $oldData = $user->only(['first_name', 'last_name', 'middle_name', 'suffix', 'email', 'username']);

        $user->update([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'suffix' => $request->suffix,
            'email' => $request->email,
            'username' => $request->username,
            'image_path' => $user->image_path,
        ]);

        $this->addAuditLog('Profile updated: ' . $user->first_name . ' ' . $user->last_name);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function changePassword()
    {
        return view('admin.portal.settings.password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*]/',
                'confirmed'
            ],
        ], [
            'new_password.regex' => 'Password must contain at least 1 uppercase letter, 1 number, and 1 special character.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        $this->addAuditLog("Changed password for user '{$user->username}'");

        return back()->with('success', 'Password updated successfully!');
    }
}
