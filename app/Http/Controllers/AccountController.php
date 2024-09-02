<?php

namespace App\Http\Controllers;

// app/Http/Controllers/AccountController.php

use App\Models\Users;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function show()
    {
        // Fetch the authenticated user along with related authorized_user and employee data
        $user = Users::with(['authorized_user.employee'])->findOrFail(auth()->id());

        return view('account', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $user->email = $request->input('email');
        $user->save();

        $authorizedUser = $user->authorized_user;
        $authorizedUser->fname = $request->input('fname');
        $authorizedUser->mname = $request->input('mname');
        $authorizedUser->lname = $request->input('lname');
        $authorizedUser->save();

        return redirect()->route('account')->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match our records.']);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->route('account')->with('success', 'Password changed successfully.');
    }
}

