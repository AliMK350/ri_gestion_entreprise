<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    function login()
    {
        // If user is already authenticated, redirect to their dashboard to avoid loops
        if (Auth::check()) {
            $userType = Auth::user()->user_type;
            switch ($userType) {
                case 1:
                    return redirect('admin/dashboard');
                case 2:
                    return redirect('secretaire/dashboard');
                case 3:
                    return redirect('employe/dashboard');
                case 4:
                    return redirect('gerant/dashboard');
                default:
                    return redirect(url(''));
            }
        }
        // Not authenticated – show login form
        return view('auth.login');
    }

    function authLogin(Request $request)
    {
        $remember = !empty($request->remember) ? true : false;

        $user = User::where('email', $request->email)->where('is_delete', 0)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $remember);

            $userType = Auth::user()->user_type;
            if ($userType == 1) {
                return redirect('admin/dashboard');
            } elseif ($userType == 2) {
                return redirect('secretaire/dashboard');
            } elseif ($userType == 3) {
                return redirect('employe/dashboard');
            } elseif ($userType == 4) {
                return redirect('gerant/dashboard');
            } else {
                return redirect(url(''));
            }
        } else {
            return redirect()->back()->with('error', 'wrong credentials');
        }
    }

    public function forgotPassword()
    {
        return view('auth.forgot');
    }

    public function postForgotPassword(Request $request)
    {
        $user = User::getEmailSingle($request->email);
        if (!empty($user)) {
            $user->remember_token = Str::random(30);
            $user->save();

            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return redirect()
                ->back()
                ->with('success', 'Check your email for a password reset link');
        } else {
            return redirect()->back()->with('error', "Email not found");
        }
    }

    public function reset($remember_token)
    {
        $user = User::getTokenSingle($remember_token);

        if (!empty($user)) {
            $data['user'] = $user;
            return view('auth.reset', $data);
        } else {
            abort(404);
        }
    }

    public function postResetPassword($token, Request $request)
    {
        if ($request->password == $request->cpassword) {
            $user = User::getTokenSingle($token);
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30);
            $user->save();

            return redirect('login')->with('success', "Password reset succesfully");
        } else {
            return redirect()->back()->with('error', "Password does not match!");
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect(url(''));
    }
}
