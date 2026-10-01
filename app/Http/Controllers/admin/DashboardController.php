<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Course;

class DashboardController extends Controller
{
    public function index()
    {
        // Check admin login
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        // Dynamic department count
        $totalDepartments = Department::count();
        $activeDepartments = Department::where('status', 1)->count();
        $inactiveDepartments = Department::where('status', 0)->count();

        // Dynamic course count
        $totalCourses = Course::count();
        $activeCourses = Course::where('status', 1)->count();
        $inactiveCourses = Course::where('status', 0)->count();

        return view(
            'admin.dashboard.index',
            compact('totalDepartments', 'activeDepartments', 'inactiveDepartments', 'totalCourses', 'activeCourses', 'inactiveCourses')
        );
    }
}