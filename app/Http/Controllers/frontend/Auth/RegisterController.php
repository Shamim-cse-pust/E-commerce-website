<?php

namespace App\Http\Controllers\frontend\Auth;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterStoreRequest;

class RegisterController extends Controller
{
    public function registerPage()
    {

        return view('frontend.pages.Auth.register');

    }
    public function registerStore(RegisterStoreRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $credentials =([
        'email'=> $request->email,
        'password' => $request->password,

        ]);

        if(Auth::attempt($credentials)){
            // $request->session()->regenerate();
            return redirect()->route('customer.dashboard');
        }
        return back();
    }
    public function loginPage()
    {

        return view('frontend.pages.Auth.login');

    }
    public function loginStore(Request $request)
    {

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:4'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // login attempt if success then redirect dashboard
        if(Auth::attempt($credentials, $request->filled('remember'))){
            // $request->session()->regenerate();
            return redirect()->intended('customer/dashboard');
        }

        // return error message
        return back()->withErrors([
            'email' => 'Wrong Credentials found!'
        ])->onlyInput('email');

    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.page');

    }
}
