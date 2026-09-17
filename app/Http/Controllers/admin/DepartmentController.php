<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Department List
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        // Check admin login
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $search = $request->input('search', '');

        $query = Department::query();

        if ($search !== '') {
            $query->where(
                'department_name',
                'like',
                '%' . $search . '%'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Get Departments
        |--------------------------------------------------------------------------
        */

        $departments = $query
            ->orderBy('department_name', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.departments.index',
            compact('departments', 'search')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create Department
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        return view('admin.departments.create');
    }


    /*
    |--------------------------------------------------------------------------
    | Store Department
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'department_name' => [
                'required',
                'string',
                'max:255',
                'unique:departments,department_name',
            ],

            'hod_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:1,0',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Create Department
        |--------------------------------------------------------------------------
        */

        Department::create([
            'department_name' => $request->department_name,
            'hod_name'        => $request->hod_name,
            'status'          => $request->status,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.departments')
            ->with('success', 'Department added successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Show Department
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $department = Department::findOrFail($id);

        return view(
            'admin.departments.show',
            compact('department')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Department
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $department = Department::findOrFail($id);

        return view(
            'admin.departments.edit',
            compact('department')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Department
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $department = Department::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'department_name' => [
                'required',
                'string',
                'max:255',
                'unique:departments,department_name,' . $department->id,
            ],

            'hod_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:1,0',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Update Department
        |--------------------------------------------------------------------------
        */

        $department->update([
            'department_name' => $request->department_name,
            'hod_name'        => $request->hod_name,
            'status'          => $request->status,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.departments')
            ->with('success', 'Department updated successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Department
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $department = Department::findOrFail($id);

        $department->delete();

        return redirect()
            ->route('admin.departments')
            ->with('success', 'Department deleted successfully.');
    }
}