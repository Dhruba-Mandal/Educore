<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Login Page
    |--------------------------------------------------------------------------
    */
    
    public function adminShowLogin()
    {
        if(session('role_id') !== null){
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function facultyShowLogin()
    {
       // dd(session('role_id'));
        if(session('role_id') != null){
            return redirect()->route('admin.dashboard');
        }

        return view('faculty.login');
    }


    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role_id' => ['required'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Get Login Data
        |--------------------------------------------------------------------------
        */

        $roleId = $request->input('role_id');
        $email = $request->input('email');
        $password = $request->input('password');


        /*
        |--------------------------------------------------------------------------
        | ADMIN LOGIN
        |--------------------------------------------------------------------------
        */

        if ($roleId == 1) {

            $user = User::where('email', $email)->first();
            /*
            |--------------------------------------------------------------------------
            | Check Admin Email & Password
            |--------------------------------------------------------------------------
            */

            if (
                !$user ||
                !Hash::check($password, $user->password)
            ) {
                return back()
                    ->withInput()
                    ->with('error', 'Invalid email or password.');
            }

            /*
            |--------------------------------------------------------------------------
            | Check Admin Status
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
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Redirect Admin
            |--------------------------------------------------------------------------
            */

            return redirect()->route('admin.dashboard');
        }


        /*
        |--------------------------------------------------------------------------
        | FACULTY LOGIN
        |--------------------------------------------------------------------------
        */

        elseif ($roleId == 2) {

            $faculty = Faculty::where('email', $email)->first();


            /*
            |--------------------------------------------------------------------------
            | Check Faculty Email & Password
            |--------------------------------------------------------------------------
            */

            if (
                !$faculty ||
                !Hash::check($password, $faculty->password)
            ) {
                return back()
                    ->withInput()
                    ->with('error', 'Invalid email or password.');
            }


            /*
            |--------------------------------------------------------------------------
            | Check Faculty Status
            |--------------------------------------------------------------------------
            */

            if (
                $faculty->status !== null &&
                $faculty->status != 1 &&
                $faculty->status !== 'active'
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
            | Store Faculty Session
            |--------------------------------------------------------------------------
            */

            session([
                'id' => $faculty->id,
                'name' => $faculty->name,
                'email' => $faculty->email,
                'role_id' => 2,
            ]);
            //print_r(session()->all());exit;

            /*
            |--------------------------------------------------------------------------
            | Redirect Faculty
            |--------------------------------------------------------------------------
            */

            return redirect()->route('admin.dashboard');
        }


        /*
        |--------------------------------------------------------------------------
        | STUDENT LOGIN
        |--------------------------------------------------------------------------
        */

        elseif ($roleId == 3) {

            /*
            |--------------------------------------------------------------------------
            | Currently using users table for Student
            |--------------------------------------------------------------------------
            */

            $user = User::where('email', $email)->first();


            /*
            |--------------------------------------------------------------------------
            | Check Student Email & Password
            |--------------------------------------------------------------------------
            */

            if (
                !$user ||
                !Hash::check($password, $user->password)
            ) {
                return back()
                    ->withInput()
                    ->with('error', 'Invalid email or password.');
            }


            /*
            |--------------------------------------------------------------------------
            | Check Student Status
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
            | Store Student Session
            |--------------------------------------------------------------------------
            */

            session([
                'student_id' => $user->id,
                'student_name' => $user->name,
                'student_email' => $user->email,
                'student_role_id' => 3,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Redirect Student
            |--------------------------------------------------------------------------
            */

            return redirect()->route('admin.dashboard');
        }


        /*
        |--------------------------------------------------------------------------
        | INVALID ROLE
        |--------------------------------------------------------------------------
        */

        else {

            return back()
                ->withInput()
                ->with('error', 'Invalid role selected.');
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        /*
        |--------------------------------------------------------------------------
        | Check Admin Login
        |--------------------------------------------------------------------------
        */

        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }


        /*
        |--------------------------------------------------------------------------
        | Get Admin
        |--------------------------------------------------------------------------
        */

        $admin = User::find(session('admin_id'));


        /*
        |--------------------------------------------------------------------------
        | Admin Not Found
        |--------------------------------------------------------------------------
        */

        if (!$admin) {

            session()->forget([
                'admin_id',
                'admin_name',
                'admin_email',
                'admin_role_id',
            ]);

            return redirect()->route('admin.login');
        }


        /*
        |--------------------------------------------------------------------------
        | Return Dashboard
        |--------------------------------------------------------------------------
        */

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
        /*
        |--------------------------------------------------------------------------
        | Clear Session
        |--------------------------------------------------------------------------
        */

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        /*
        |--------------------------------------------------------------------------
        | Redirect To Login
        |--------------------------------------------------------------------------
        */

        return redirect()->route('role.selection');
    }
}