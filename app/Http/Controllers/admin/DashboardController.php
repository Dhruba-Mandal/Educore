<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;

class DashboardController extends Controller
{
    public function index()
    {
        // Check admin login
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        // Dynamic department count
        $departmentCount = Department::count();

        return view(
            'admin.dashboard.index',
            compact('departmentCount')
        );
    }
}