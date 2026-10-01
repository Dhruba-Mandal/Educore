
@extends('layouts.admin')

@section('title', 'EduCore - Courses')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-courses.css') }}">
@endsection

@section('content')

    {{-- =========================================================
         COURSE PAGE HEADER
    ========================================================== --}}

    <div class="course-page-header">

        <div class="course-page-title">
            <span class="course-page-label">
                ACADEMIC MANAGEMENT
            </span>

            <h1>Courses</h1>

            <p>
                Manage courses, departments, semesters and subjects.
            </p>
        </div>

        <div class="course-header-actions">
            <a href="{{ route('admin.courses.create') }}"
               class="course-add-button">

                <i class="fa-solid fa-plus"></i>
                Add Course

            </a>
        </div>

    </div>


    {{-- =========================================================
         COURSE FILTER BAR
    ========================================================== --}}

    <form method="GET"
          action="{{ route('admin.courses.index') }}"
          id="courseFilterForm"
          class="subject-filter-form">

        {{-- SEARCH COURSES --}}

        <div class="subject-search-box">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                name="search"
                id="courseSearch"
                value="{{ $search ?? request('search') }}"
                placeholder="Search by course name or code..."
                autocomplete="off"
            >

        </div>


        {{-- DEPARTMENT FILTER --}}

        <div class="subject-filter-select">

            <i class="fa-solid fa-filter"></i>

            <select name="department_id" id="departmentFilter">

                <option value="">
                    All Departments
                </option>

                @foreach ($departments as $department)

                    <option
                        value="{{ $department->id }}"
                        {{ (string) ($departmentId ?? request('department_id')) === (string) $department->id ? 'selected' : '' }}
                    >
                        {{ $department->department_name }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- STATUS FILTER --}}

        <div class="subject-filter-select status-select">

            <select name="status" id="statusFilter">

                <option value="">
                    All Status
                </option>

                <option
                    value="active"
                    {{ ($status ?? request('status')) === 'active' ? 'selected' : '' }}
                >
                    Active
                </option>

                <option
                    value="inactive"
                    {{ ($status ?? request('status')) === 'inactive' ? 'selected' : '' }}
                >
                    Inactive
                </option>

            </select>

        </div>


        {{-- APPLY BUTTON --}}

        <button type="submit" class="subject-filter-button">

            <i class="fa-solid fa-magnifying-glass"></i>
            Apply

        </button>


        {{-- CLEAR BUTTON --}}

        <a href="{{ route('admin.courses.index') }}"
           class="btn-clear">

            <i class="fa-solid fa-rotate-left"></i>
            Clear

        </a>

    </form>


    {{-- =========================================================
         COURSE TABLE PANEL
    ========================================================== --}}

    <div class="course-panel">

        {{-- PANEL HEADER --}}

        <div class="course-panel-header">

            <div>
                <h2>All Courses</h2>

                <p>
                    View and manage all available courses.
                </p>
            </div>

        </div>


        {{-- =====================================================
             COURSE TABLE
        ====================================================== --}}

        <div class="course-table-wrapper">

            <table class="course-table">

                <thead>
                    <tr>
                        <th>SL No</th>
                        <th>COURSE</th>
                        <th>DEPARTMENT</th>
                        <th>DURATION</th>
                        <th>SEMESTERS</th>
                        <th>STUDENTS</th>
                        <th>STATUS</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>


                <tbody>

                    @forelse ($courses as $course)

                        <tr>

                            {{-- SERIAL NUMBER --}}

                            <td>
                                <span class="course-id">
                                    {{ $courses->firstItem() + $loop->index }}
                                </span>
                            </td>


                            {{-- COURSE INFORMATION --}}

                            <td>

                                <div class="course-info">

                                    <div class="course-icon">
                                        <i class="fa-solid fa-book-open"></i>
                                    </div>

                                    <div>
                                        <strong>
                                            {{ $course->course_code }}
                                        </strong>

                                        <span>
                                            {{ $course->course_name }}
                                        </span>
                                    </div>

                                </div>

                            </td>


                            {{-- DEPARTMENT --}}

                            <td>
                                <span class="department-badge">
                                    {{ $course->department->department_name ?? 'N/A' }}
                                </span>
                            </td>


                            {{-- DURATION --}}

                            <td>

                                <div class="course-duration">

                                    <strong>
                                        {{ $course->duration_years }}
                                    </strong>

                                    <span>
                                        {{ $course->duration_years == 1 ? 'Year' : 'Years' }}
                                    </span>

                                </div>

                            </td>


                            {{-- SEMESTERS --}}

                            <td>

                                <div class="semester-badge">

                                    <i class="fa-solid fa-layer-group"></i>

                                    {{ $course->duration_years * 2 }} Semesters

                                </div>

                            </td>


                            {{-- STUDENTS --}}

                            <td>

                                <div class="student-count">

                                    <i class="fa-solid fa-users"></i>

                                    <span>
                                        {{ $course->students_count ?? 0 }}
                                    </span>

                                </div>

                            </td>


                            {{-- STATUS --}}

                            <td>

                                @if ($course->status)
                                    <span class="badge bg-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Inactive
                                    </span>
                                @endif

                            </td>


                            {{-- ACTIONS --}}

                            <td>

                                <div class="course-actions">

                                    {{-- VIEW --}}

                                    <a href="{{ route('admin.courses.show', $course->id) }}"
                                       class="course-action view"
                                       title="View Course">

                                        <i class="fa-regular fa-eye"></i>

                                    </a>


                                    {{-- EDIT --}}

                                    <a href="{{ route('admin.courses.edit', $course->id) }}"
                                       class="course-action edit"
                                       title="Edit Course">

                                        <i class="fa-solid fa-pen"></i>

                                    </a>


                                    {{-- DELETE --}}

                                    <form method="POST"
                                          action="{{ route('admin.courses.destroy', $course->id) }}"
                                          onsubmit="return confirm('Are you sure you want to delete this course?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="course-action delete"
                                                title="Delete Course">

                                            <i class="fa-regular fa-trash-can"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        {{-- NO COURSES FOUND --}}

                        <tr>

                            <td colspan="8">

                                <div class="course-empty">

                                    <div class="course-empty-icon">
                                        <i class="fa-solid fa-book-open"></i>
                                    </div>

                                    <h3>No Courses Found</h3>

                                    <p>
                                        There are no courses matching your filters.
                                    </p>

                                    <a href="{{ route('admin.courses.create') }}"
                                       class="course-add-button">

                                        <i class="fa-solid fa-plus"></i>
                                        Add Your First Course

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
             PAGINATION
        ====================================================== --}}

        @if (method_exists($courses, 'links'))

            <div class="course-pagination">
                {{ $courses->withQueryString()->links() }}
            </div>

        @endif

    </div>

@endsection