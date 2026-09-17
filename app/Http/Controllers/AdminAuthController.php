<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Admin Login
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        if (session()->has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Login
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        /*
        |--------------------------------------------------------------------------
        | Check User
        |--------------------------------------------------------------------------
        */

        if (
            !$user ||
            !Hash::check($request->password, $user->password)
        ) {
            return back()
                ->withInput()
                ->with('error', 'Invalid email or password.');
        }


        /*
        |--------------------------------------------------------------------------
        | Check User Status
        |--------------------------------------------------------------------------
        */

        if (
            $user->status !== null &&
            $user->status != 1 &&
            $user->status !== 'active'
        ) {
            return back()
                ->withInput()
                ->with('error', 'Your account is inactive.');
        }


        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | Store Admin Session
        |--------------------------------------------------------------------------
        */

        session([
            'admin_id'      => $user->id,
            'admin_name'    => $user->name,
            'admin_email'   => $user->email,
            'admin_role_id' => $user->role_id,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect To Dashboard
        |--------------------------------------------------------------------------
        */

        return redirect()->route('admin.dashboard');
    }


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $admin = User::find(session('admin_id'));

        if (!$admin) {

            session()->forget([
                'admin_id',
                'admin_name',
                'admin_email',
                'admin_role_id',
            ]);

            return redirect()->route('admin.login');
        }

        return view(
            'admin.dashboard.index',
            compact('admin')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}