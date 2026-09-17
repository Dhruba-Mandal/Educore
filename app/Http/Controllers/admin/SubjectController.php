<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Department;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        /*
        |--------------------------------------------------------------------------
        | Get Filters
        |--------------------------------------------------------------------------
        */

        $search = trim($request->input('search', ''));

        $departmentId = $request->input('department_id', '');

        $status = $request->input('status', '');


        /*
        |--------------------------------------------------------------------------
        | Normalize "All" Values
        |--------------------------------------------------------------------------
        |
        | If the dropdown sends "all", treat it as no filter.
        |
        */

        if (
            $departmentId === 'all' ||
            $departmentId === null
        ) {
            $departmentId = '';
        }

        if (
            $status === 'all' ||
            $status === null
        ) {
            $status = '';
        }


        /*
        |--------------------------------------------------------------------------
        | Subject Query
        |--------------------------------------------------------------------------
        */

        $query = Subject::with('departments');


        /*
        |--------------------------------------------------------------------------
        | Search Filter
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $searchLower = mb_strtolower(
                $search,
                'UTF-8'
            );

            $query->where(function ($q) use ($searchLower) {

                $q->whereRaw(
                    'LOWER(subject_name) LIKE ?',
                    ['%' . $searchLower . '%']
                );

                $q->orWhereRaw(
                    'LOWER(subject_code) LIKE ?',
                    ['%' . $searchLower . '%']
                );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Department Filter
        |--------------------------------------------------------------------------
        */

        if ($departmentId !== '') {

            $query->whereHas(
                'departments',
                function ($q) use ($departmentId) {

                    $q->where(
                        'departments.id',
                        $departmentId
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($status !== '') {

            $query->where(
                'status',
                $status
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Get Subjects
        |--------------------------------------------------------------------------
        */

        $subjects = $query
            ->orderBy('subject_name', 'asc')
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Departments
        |--------------------------------------------------------------------------
        */

        $departments = Department::orderBy(
            'department_name',
            'asc'
        )->get();


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.subjects.index',
            compact(
                'subjects',
                'departments',
                'search',
                'departmentId',
                'status'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
{
    if (!session()->has('admin_id')) {
        return redirect()->route('admin.login');
    }

    $departments = Department::orderBy('department_name', 'asc')->get();

    return view('admin.subjects.create', compact('departments'));
}

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'department_ids' => [
                'required',
                'array',
                'min:1'
            ],

            'department_ids.*' => [
                'integer',
                'exists:departments,id'
            ],

            'subject_code' => [
                'required',
                'string',
                'max:100',
                'unique:subjects,subject_code'
            ],

            'subject_name' => [
                'required',
                'string',
                'max:255'
            ],

            'status' => [
                'required',
                'in:1,0'
            ],
        ]);

        $subject = Subject::create([
            'subject_code' => $validated['subject_code'],
            'subject_name' => $validated['subject_name'],
            'status' => $validated['status'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Attach Multiple Departments
        |--------------------------------------------------------------------------
        */

        $subject->departments()->sync(
            $validated['department_ids']
        );

        return redirect()
            ->route('admin.subjects')
            ->with('success', 'Subject added successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $subject = Subject::with('departments')
            ->findOrFail($id);

        return view(
            'admin.subjects.show',
            compact('subject')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $subject = Subject::with('departments')
            ->findOrFail($id);

        $departments = Department::orderBy(
            'department_name',
            'asc'
        )->get();

        return view(
            'admin.subjects.edit',
            compact('subject', 'departments')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $subject = Subject::findOrFail($id);

        $validated = $request->validate([
            'department_ids' => [
                'required',
                'array',
                'min:1'
            ],

            'department_ids.*' => [
                'integer',
                'exists:departments,id'
            ],

            'subject_code' => [
                'required',
                'string',
                'max:100',
                'unique:subjects,subject_code,' .
                    $subject->subject_id .
                    ',subject_id'
            ],

            'subject_name' => [
                'required',
                'string',
                'max:255'
            ],

            'status' => [
                'required',
                'in:1,0'
            ],
        ]);

        $subject->update([
            'subject_code' => $validated['subject_code'],
            'subject_name' => $validated['subject_name'],
            'status' => $validated['status'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Replace Department Relationships
        |--------------------------------------------------------------------------
        */

        $subject->departments()->sync(
            $validated['department_ids']
        );

        return redirect()
            ->route('admin.subjects')
            ->with('success', 'Subject updated successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $subject = Subject::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Remove Department Relationships
        |--------------------------------------------------------------------------
        */

        $subject->departments()->detach();

        /*
        |--------------------------------------------------------------------------
        | Delete Subject
        |--------------------------------------------------------------------------
        */

        $subject->delete();

        return redirect()
            ->route('admin.subjects')
            ->with(
                'success',
                'Subject deleted successfully.'
            );
    }
}
