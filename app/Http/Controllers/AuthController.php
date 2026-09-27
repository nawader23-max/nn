<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('pages.auth.login');
    }

    public function login(Request $r)
    {
        $r->validate(['email' => 'required|email', 'password' => 'required']);
        if (Auth::attempt($r->only('email', 'password'), $r->boolean('remember'))) {
            $r->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['email' => 'البريد أو كلمة المرور غير صحيحة'])->onlyInput('email');
    }

    public function registerForm()
    {
        return view('pages.auth.register');
    }

    public function register(Request $r)
    {
        $r->validate(['name' => 'required', 'email' => 'required|email|unique:users', 'password' => 'required|min:8|confirmed']);
        $user = User::create(['name' => $r->name, 'email' => $r->email, 'password' => bcrypt($r->password)]);
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function verifyForm()
    {
        return view('pages.auth.verify');
    }

    public function forgotForm()
    {
        return view('pages.auth.forgot');
    }

    public function forgot(Request $r)
    {
        return back()->with('status', 'تم إرسال رابط إعادة التعيين');
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();

        return redirect('/');
    }
}
