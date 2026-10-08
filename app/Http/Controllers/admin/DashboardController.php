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
        //dd(session('role_id') );
        if (session('role_id') == '') {
            return redirect()->route('role.selection');
        }
        // if (!session()->has('admin_id')) {
        //     return redirect()->route('admin.login');
        // }
        // if (!session()->has('faculty_id')) {
        //     return redirect()->route('faculty.login');
        // }
        //dd(session()->has('faculty_id'));

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