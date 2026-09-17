@extends('layouts.admin')

@section('title', 'Departments')

@section('styles')
    <link rel="stylesheet"
          href="{{ asset('css/admin-departments.css') }}">
@endsection

@section('content')

<div class="department-page">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}

    <div class="department-header">

        <div>
            <h1>Departments</h1>

            <p>
                Manage institutional departments and faculty allocation
            </p>
        </div>

        <a href="{{ route('admin.departments.create') }}"
           class="add-department-btn">

            <i class="fa-solid fa-plus"></i>

            Add Department

        </a>

    </div>


    {{-- =========================================================
         ALERTS
    ========================================================== --}}

    @if(session('success'))

        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i>

            {{ session('success') }}
        </div>

    @endif


    {{-- =========================================================
         SEARCH
    ========================================================== --}}

    <div class="department-toolbar">

        <form method="GET"
              action="{{ route('admin.departments') }}"
              class="department-search">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Search by Department Name..."
            >

            @if($search)

                <a href="{{ route('admin.departments') }}"
                   class="clear-search">

                    <i class="fa-solid fa-xmark"></i>

                </a>

            @endif

        </form>

    </div>


    {{-- =========================================================
         DEPARTMENT LIST
    ========================================================== --}}

    @if($departments->count() > 0)

        <div class="department-grid">

            @foreach($departments as $department)

                <div class="department-card">

                    {{-- Card Top --}}

                    <div class="department-card-top">

                        <div class="department-icon">

                            <i class="fa-solid fa-building"></i>

                        </div>


                        <div class="department-title">

                            <h3>
                                {{ $department->department_name }}
                            </h3>

                            <p>
                                HOD:
                                {{ $department->hod_name ?: 'Not Assigned' }}
                            </p>

                        </div>


                        {{-- Status --}}

                        <div class="department-status">

                            @if($department->status)

                                <span class="status active">
                                    Active
                                </span>

                            @else

                                <span class="status inactive">
                                    Inactive
                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- =================================================
                         COUNTS
                    ================================================== --}}

                    <div class="department-counts">

                        <div class="count-item">

                            <strong>
                                {{ $department->faculty_count }}
                            </strong>

                            <span>
                                Faculty
                            </span>

                        </div>


                        <div class="count-divider"></div>


                        <div class="count-item">

                            <strong>
                                {{ $department->students_count }}
                            </strong>

                            <span>
                                Students
                            </span>

                        </div>


                        <div class="count-divider"></div>


                        <div class="count-item">

                            <strong>
                                {{ $department->courses_count }}
                            </strong>

                            <span>
                                Courses
                            </span>

                        </div>

                    </div>


                    {{-- =================================================
                         ACTIONS
                    ================================================== --}}

                    <div class="department-actions">

                        <a
                            href="{{ route(
                                'admin.departments.show',
                                $department
                            ) }}"
                            class="action-btn view-btn"
                        >

                            <i class="fa-regular fa-eye"></i>

                            View Department

                        </a>


                        <a
                            href="{{ route(
                                'admin.departments.edit',
                                $department
                            ) }}"
                            class="action-btn edit-btn"
                        >

                            <i class="fa-solid fa-pen"></i>

                            Edit Department

                        </a>


                        <form
                            method="POST"
                            action="{{ route(
                                'admin.departments.destroy',
                                $department
                            ) }}"
                            onsubmit="return confirm(
                                'Are you sure you want to delete this department?'
                            );"
                        >

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="action-btn delete-btn"
                            >

                                <i class="fa-regular fa-trash-can"></i>

                                Delete Department

                            </button>

                        </form>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-state">

            <div class="empty-icon">

                <i class="fa-solid fa-building"></i>

            </div>

            <h3>No Departments Found</h3>

            <p>
                @if($search)
                    No department matches "{{ $search }}".
                @else
                    Start by adding your first department.
                @endif
            </p>

            @if(!$search)

                <a
                    href="{{ route('admin.departments.create') }}"
                    class="add-department-btn"
                >

                    <i class="fa-solid fa-plus"></i>

                    Add Department

                </a>

            @endif

        </div>

    @endif

</div>

@endsection