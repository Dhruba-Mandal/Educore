<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use App\Models\Subject;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Course List
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        // Base course query
        $query = Course::with('department');

        /*
        |--------------------------------------------------------------------------
        | Search By Course Name Or Course Code
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('course_code', 'like', '%' . $search . '%')
                  ->orWhere('course_name', 'like', '%' . $search . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Department Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        | Database status:
        | 1 = Active
        | 0 = Inactive
        |--------------------------------------------------------------------------
        */
        if ($request->status === 'active') {
            $query->where('status', 1);
        } elseif ($request->status === 'inactive') {
            $query->where('status', 0);
        }

        /*
        |--------------------------------------------------------------------------
        | Get Courses With Pagination
        |--------------------------------------------------------------------------
        */
        $courses = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Get Departments For Filter
        |--------------------------------------------------------------------------
        */
        $departments = Department::orderBy(
            'department_name',
            'asc'
        )->get();

        /*
        |--------------------------------------------------------------------------
        | Filter Values For Blade View
        |--------------------------------------------------------------------------
        */
        $search = $request->input('search', '');
        $departmentId = $request->input('department_id', '');
        $status = $request->input('status', '');

        /*
        |--------------------------------------------------------------------------
        | Return Course List
        |--------------------------------------------------------------------------
        */
        return view('admin.courses.index', compact(
            'courses',
            'departments',
            'search',
            'departmentId',
            'status'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Create Course Form
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $departments = Department::where('status', true)
            ->orderBy('department_name')
            ->get();

        return view('admin.courses.create', compact('departments'));
    }


    /*
    |--------------------------------------------------------------------------
    | Fetch Subjects According To Department
    |--------------------------------------------------------------------------
    */
    public function getSubjects($department_id)
    {
        $subjects = Subject::whereHas('departments', function ($query) use ($department_id) {
                $query->where('departments.id', $department_id);
            })
            ->where('status', 1)
            ->orderBy('subject_code')
            ->get([
                'subject_id',
                'subject_code',
                'subject_name',
                'status'
            ]);

        return response()->json($subjects);
    }


    /*
    |--------------------------------------------------------------------------
    | Store Course
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'department_id' => [
                'required',
                'exists:departments,id'
            ],

            'course_code' => [
                'required',
                'string',
                'max:255',
                'unique:courses,course_code'
            ],

            'course_name' => [
                'required',
                'string',
                'max:255'
            ],

            'duration_years' => [
                'required',
                'integer',
                'min:1',
                'max:5'
            ],

            'status' => [
                'nullable',
                'boolean'
            ],

            'semester_1' => 'nullable|array',
            'semester_1.*' => 'integer|exists:subjects,subject_id',

            'semester_2' => 'nullable|array',
            'semester_2.*' => 'integer|exists:subjects,subject_id',

            'semester_3' => 'nullable|array',
            'semester_3.*' => 'integer|exists:subjects,subject_id',

            'semester_4' => 'nullable|array',
            'semester_4.*' => 'integer|exists:subjects,subject_id',

            'semester_5' => 'nullable|array',
            'semester_5.*' => 'integer|exists:subjects,subject_id',

            'semester_6' => 'nullable|array',
            'semester_6.*' => 'integer|exists:subjects,subject_id',

            'semester_7' => 'nullable|array',
            'semester_7.*' => 'integer|exists:subjects,subject_id',

            'semester_8' => 'nullable|array',
            'semester_8.*' => 'integer|exists:subjects,subject_id',

            'semester_9' => 'nullable|array',
            'semester_9.*' => 'integer|exists:subjects,subject_id',

            'semester_10' => 'nullable|array',
            'semester_10.*' => 'integer|exists:subjects,subject_id',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create Course
        |--------------------------------------------------------------------------
        */
        $course = new Course();

        $course->department_id = $request->department_id;
        $course->course_code = $request->course_code;
        $course->course_name = $request->course_name;
        $course->duration_years = $request->duration_years;

        /*
        |--------------------------------------------------------------------------
        | Store Subjects For All 10 Semesters
        |--------------------------------------------------------------------------
        */
        for ($i = 1; $i <= 10; $i++) {
            $semester = 'semester_' . $i;

            $course->$semester = $request->input($semester, []);
        }

        /*
        |--------------------------------------------------------------------------
        | Course Status
        |--------------------------------------------------------------------------
        */
        $course->status = $request->has('status') ? 1 : 0;

        $course->save();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Show Course
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $course = Course::with('department')->findOrFail($id);

        $semesterSubjects = [];

        for ($i = 1; $i <= 10; $i++) {
            $semester = 'semester_' . $i;

            $subjectIds = $course->$semester ?? [];

            // Convert JSON string to array if necessary
            if (is_string($subjectIds)) {
                $subjectIds = json_decode($subjectIds, true) ?? [];
            }

            if (!is_array($subjectIds)) {
                $subjectIds = [];
            }

            $semesterSubjects[$i] = Subject::whereIn(
                    'subject_id',
                    $subjectIds
                )
                ->where('status', 1)
                ->get();
        }

        return view('admin.courses.show', compact(
            'course',
            'semesterSubjects'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Course Form
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $course = Course::findOrFail($id);

        // Active departments
        $departments = Department::where('status', 1)
            ->orderBy('department_name')
            ->get();

        // Subjects belonging to the selected department
        $subjects = Subject::whereHas('departments', function ($query) use ($course) {
                $query->where('departments.id', $course->department_id);
            })
            ->where('status', true)
            ->orderBy('subject_code')
            ->get();

        return view('admin.courses.edit', compact(
            'course',
            'departments',
            'subjects'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Update Course
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'department_id' => [
                'required',
                'exists:departments,id'
            ],

            'course_code' => [
                'required',
                'string',
                'max:255',
                'unique:courses,course_code,' . $id
            ],

            'course_name' => [
                'required',
                'string',
                'max:255'
            ],

            'duration_years' => [
                'required',
                'integer',
                'min:1',
                'max:5'
            ],

            'status' => [
                'nullable',
                'boolean'
            ],

            'semester_1' => 'nullable|array',
            'semester_1.*' => 'integer|exists:subjects,subject_id',

            'semester_2' => 'nullable|array',
            'semester_2.*' => 'integer|exists:subjects,subject_id',

            'semester_3' => 'nullable|array',
            'semester_3.*' => 'integer|exists:subjects,subject_id',

            'semester_4' => 'nullable|array',
            'semester_4.*' => 'integer|exists:subjects,subject_id',

            'semester_5' => 'nullable|array',
            'semester_5.*' => 'integer|exists:subjects,subject_id',

            'semester_6' => 'nullable|array',
            'semester_6.*' => 'integer|exists:subjects,subject_id',

            'semester_7' => 'nullable|array',
            'semester_7.*' => 'integer|exists:subjects,subject_id',

            'semester_8' => 'nullable|array',
            'semester_8.*' => 'integer|exists:subjects,subject_id',

            'semester_9' => 'nullable|array',
            'semester_9.*' => 'integer|exists:subjects,subject_id',

            'semester_10' => 'nullable|array',
            'semester_10.*' => 'integer|exists:subjects,subject_id',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Basic Course Details
        |--------------------------------------------------------------------------
        */
        $course->department_id = $request->department_id;
        $course->course_code = $request->course_code;
        $course->course_name = $request->course_name;
        $course->duration_years = $request->duration_years;

        /*
        |--------------------------------------------------------------------------
        | Update All 10 Semesters
        |--------------------------------------------------------------------------
        */
        for ($i = 1; $i <= 10; $i++) {
            $semester = 'semester_' . $i;

            $course->$semester = $request->input($semester, []);
        }

        /*
        |--------------------------------------------------------------------------
        | Course Status
        |--------------------------------------------------------------------------
        */
        $course->status = $request->has('status') ? 1 : 0;

        $course->save();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Course
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}