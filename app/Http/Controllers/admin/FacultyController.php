<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class FacultyController extends Controller
{
    /**
     * =========================================================
     * Faculty List
     * =========================================================
     */
    public function index(Request $request)
    {
        $query = Faculty::with('department');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('faculty_id', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('designation', 'like', '%' . $search . '%')
                    ->orWhereHas('department', function ($departmentQuery) use ($search) {

                        $departmentQuery->where(
                            'department_name',
                            'like',
                            '%' . $search . '%'
                        );

                    });

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Faculty List
        |--------------------------------------------------------------------------
        */

        $faculties = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();


        return view(
            'admin.faculty.index',
            compact('faculties')
        );
    }


    /**
     * =========================================================
     * Add Faculty Page
     * =========================================================
     */
    public function create()
    {
        /*
        |--------------------------------------------------------------------------
        | Get Active Departments
        |--------------------------------------------------------------------------
        */

        $departments = Department::where('status', 1)
            ->orderBy('department_name', 'asc')
            ->get();


        return view(
            'admin.faculty.create',
            compact('departments')
        );
    }


    /**
     * =========================================================
     * Store New Faculty
     * =========================================================
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'department_id' => [
                'required',
                'exists:departments,id'
            ],

            'designation' => [
                'required',
                'string',
                'max:100'
            ],

            'experience_years' => [
                'required',
                'integer',
                'min:0',
                'max:60'
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:faculties,email'
            ],

            'phone_no' => [
                'nullable',
                'string',
                'max:20'
            ],

            'status' => [
                'nullable',
                'boolean'
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate Faculty ID
        |
        | First Faculty  = FA101
        | Second Faculty = FA102
        | Third Faculty  = FA103
        |--------------------------------------------------------------------------
        */

        $lastFaculty = Faculty::orderBy('id', 'desc')->first();


        if ($lastFaculty && !empty($lastFaculty->faculty_id)) {

            /*
            |--------------------------------------------------------------------------
            | Remove "FA" from the previous ID
            |--------------------------------------------------------------------------
            */

            $lastNumber = (int) str_replace(
                'FA',
                '',
                strtoupper($lastFaculty->faculty_id)
            );


            /*
            |--------------------------------------------------------------------------
            | Generate next number
            |--------------------------------------------------------------------------
            */

            $nextNumber = $lastNumber + 1;


        } else {

            /*
            |--------------------------------------------------------------------------
            | First Faculty
            |--------------------------------------------------------------------------
            */

            $nextNumber = 101;
        }


        $facultyId = 'FA' . $nextNumber;


        /*
        |--------------------------------------------------------------------------
        | Create Faculty
        |--------------------------------------------------------------------------
        */
        $user_id = session()->get('admin_id');

        Faculty::create([

            'faculty_id' => $facultyId,

            'name' => $request->name,

            'department_id' => $request->department_id,

            'designation' => $request->designation,

            'experience_years' => $request->experience_years,

            'email' => $request->email,

            'phone_no' => $request->phone_no,

            'password' => Hash::make('nopass'), // Default password

            'status' => $request->has('status') ? 1 : 0,
            'created_by' => $user_id,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.faculty')
            ->with(
                'success',
                'Faculty added successfully.'
            );
    }


    /**
     * =========================================================
     * Show Faculty
     * =========================================================
     */
    public function show($id)
    {
        /*
        |--------------------------------------------------------------------------
        | Find Faculty
        |--------------------------------------------------------------------------
        */

        $faculty = Faculty::with('department')
            ->findOrFail($id);


        return view(
            'admin.faculty.show',
            compact('faculty')
        );
    }


    /**
     * =========================================================
     * Edit Faculty Page
     * =========================================================
     */
    public function edit($id)
    {
        /*
        |--------------------------------------------------------------------------
        | Find Faculty
        |--------------------------------------------------------------------------
        */

        $faculty = Faculty::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Get Active Departments
        |--------------------------------------------------------------------------
        */

        $departments = Department::where('status', 1)
            ->orderBy('department_name', 'asc')
            ->get();


        return view(
            'admin.faculty.edit',
            compact(
                'faculty',
                'departments'
            )
        );
    }


    /**
     * =========================================================
     * Update Faculty
     * =========================================================
     */
    public function update(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | Find Faculty
        |--------------------------------------------------------------------------
        */

        $faculty = Faculty::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'department_id' => [
                'required',
                'exists:departments,id'
            ],

            'designation' => [
                'required',
                'string',
                'max:100'
            ],

            'experience_years' => [
                'required',
                'integer',
                'min:0',
                'max:60'
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('faculties', 'email')
                    ->ignore($faculty->id)
            ],

            'phone_no' => [
                'nullable',
                'string',
                'max:20'
            ],

            'status' => [
                'nullable',
                'boolean'
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Update Faculty
        |
        | IMPORTANT:
        | faculty_id is NOT changed.
        | created_by is NOT changed.
        |--------------------------------------------------------------------------
        */
        $user_id = session()->get('admin_id');
        $faculty->update([

            'name' => $request->name,

            'department_id' => $request->department_id,

            'designation' => $request->designation,

            'experience_years' => $request->experience_years,

            'email' => $request->email,

            'phone_no' => $request->phone_no,

            'status' => $request->has('status') ? 1 : 0,

            /*
            |--------------------------------------------------------------------------
            | Current logged-in user
            |--------------------------------------------------------------------------
            */

            'updated_by' => $user_id,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.faculty')
            ->with(
                'success',
                'Faculty updated successfully.'
            );
    }


    /**
     * =========================================================
     * Delete Faculty
     * =========================================================
     */
    public function destroy($id)
    {
        /*
        |--------------------------------------------------------------------------
        | Find Faculty
        |--------------------------------------------------------------------------
        */

        $faculty = Faculty::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Delete
        |--------------------------------------------------------------------------
        */

        $faculty->delete();


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.faculty')
            ->with(
                'success',
                'Faculty deleted successfully.'
            );
    }
}