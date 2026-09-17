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

        $search = trim($request->input('search', ''));

        $departmentId = $request->input('department_id', '');

        $status = $request->input('status', '');

        $query = Subject::with('departments');

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $searchLower = mb_strtolower($search, 'UTF-8');

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
        | DEPARTMENT FILTER
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
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if ($status !== '') {

            $query->where(
                'status',
                $status
            );
        }

        $subjects = $query
            ->orderBy('subject_name', 'asc')
            ->paginate(10)
            ->withQueryString();

        $departments = Department::orderBy(
            'department_name',
            'asc'
        )->get();

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

        $departments = Department::orderBy(
            'department_name',
            'asc'
        )->get();

        return view(
            'admin.subjects.create',
            compact('departments')
        );
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
                'min:1',
            ],

            'department_ids.*' => [
                'required',
                'integer',
                'exists:departments,id',
            ],

            'subject_code' => [
                'required',
                'string',
                'max:50',
                'unique:subjects,subject_code',
            ],

            'subject_name' => [
                'required',
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
        | CREATE SUBJECT
        |--------------------------------------------------------------------------
        */

        $subject = Subject::create([

            'subject_code' => $validated['subject_code'],

            'subject_name' => $validated['subject_name'],

            'status' => $validated['status'],

        ]);

        /*
        |--------------------------------------------------------------------------
        | ATTACH DEPARTMENTS
        |--------------------------------------------------------------------------
        */

        $subject->departments()->sync(
            $validated['department_ids']
        );

        return redirect()
            ->route('admin.subjects')
            ->with(
                'success',
                'Subject added successfully.'
            );
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
            compact(
                'subject',
                'departments'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $subject = Subject::findOrFail($id);

        $validated = $request->validate([

            'department_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'department_ids.*' => [
                'required',
                'integer',
                'exists:departments,id',
            ],

            'subject_code' => [
                'required',
                'string',
                'max:50',

                'unique:subjects,subject_code,' .
                $subject->subject_id .
                ',subject_id',
            ],

            'subject_name' => [
                'required',
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
        | UPDATE SUBJECT
        |--------------------------------------------------------------------------
        */

        $subject->update([

            'subject_code' => $validated['subject_code'],

            'subject_name' => $validated['subject_name'],

            'status' => $validated['status'],

        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE DEPARTMENTS
        |--------------------------------------------------------------------------
        */

        $subject->departments()->sync(
            $validated['department_ids']
        );

        return redirect()
            ->route('admin.subjects')
            ->with(
                'success',
                'Subject updated successfully.'
            );
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
