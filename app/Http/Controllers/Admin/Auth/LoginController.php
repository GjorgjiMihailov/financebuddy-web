<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'editor'])) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Внесете е-маил адреса.',
            'email.email'       => 'Внесете валидна е-маил адреса.',
            'password.required' => 'Внесете лозинка.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            if (! in_array(Auth::user()->role, ['admin', 'editor'])) {
                Auth::logout();
                return back()->withErrors(['email' => 'Немате пристап до admin панелот.'])->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Невалидна е-маил адреса или лозинка.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
