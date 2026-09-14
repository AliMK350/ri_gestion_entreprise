<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('auth.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(7)],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->must_change_password = false;
        $user->save();

        return redirect($this->dashboardPath($user->user_type))
            ->with('success', 'Votre mot de passe a été modifié avec succès.');
    }

    private function dashboardPath(int $userType): string
    {
        return match ($userType) {
            1 => 'admin/dashboard',
            2 => 'secretaire/dashboard',
            3 => 'employe/dashboard',
            4 => 'gerant/dashboard',
            default => '/',
        };
    }
}
