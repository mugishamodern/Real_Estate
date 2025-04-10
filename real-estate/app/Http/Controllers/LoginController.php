<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\returnSelf;

class LoginController extends Controller
{
    public function show(){
        return view('login');
    }

    public function check(Request $request){
        $validated = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (auth()->attempt($validated)) {

            $user = Auth::user();

            $redirectPath = $this->getredirectedBasedOnRole($user);

            return redirect()->intended(route($redirectPath))->with('success', 'Login successful!');

        }
        // If login fails, redirect back with an error message
        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));

    }

    public function getredirectedBasedOnRole($user){

        switch($user->role){
            case 'admin':
            return '';

            case 'customer':
            return '';

            case 'owner':
           return 'property.owner.dashboard';

            default:
            return 'home';
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
