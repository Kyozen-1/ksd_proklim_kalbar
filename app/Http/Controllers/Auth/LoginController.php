<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login.index');
    }


    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required|max:50',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withInput($request->only('email'))
                ->with('failed', 'Email atau password salah.');
        }

        if ($user->status_aktif !== '1') {
            return back()
                ->withInput($request->only('email'))
                ->with('failed', 'Akun sudah tidak aktif. Silakan hubungi administrator.');
        }

        if (Auth::attempt(
            [
                'email' => $request->email,
                'password' => $request->password,
            ],
        )) {
            $request->session()->regenerate();

            return redirect()->route('cms.dashboard.index');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('failed', 'Email atau password salah.');
    }


    public function logout()
    {
        Auth::logout(Auth::user());
        return redirect()->route('login');
    }
}
