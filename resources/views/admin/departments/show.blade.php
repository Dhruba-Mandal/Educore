@extends('layouts.admin')

@section('title', 'Department Details')

@section('styles')
    <link rel="stylesheet"
          href="{{ asset('css/admin-departments.css') }}">
@endsection

@section('content')

<div class="department-page">

    <div class="department-header">

        <div>

            <h1>
                {{ $department->department_name }}
            </h1>

            <p>
                Department details and statistics
            </p>

        </div>

        <div style="display:flex;gap:8px;">

            <a
                href="{{ route(
                    'admin.departments.edit',
                    $department
                ) }}"
                class="add-department-btn"
            >

                <i class="fa-solid fa-pen"></i>

                Edit Department

            </a>

            <a
                href="{{ route('admin.departments') }}"
                class="action-btn view-btn"
                style="padding:10px 16px;"
            >

                Back

            </a>

        </div>

    </div>


    <div class="department-card">

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


        <div style="padding-top:15px;border-top:1px solid #eef0f4;">

            <p style="font-size:12px;color:#8993a4;margin:0;">

                Created:
                {{ $department->created_at->format('d M Y') }}

            </p>

        </div>

    </div>

</div>

@endsection