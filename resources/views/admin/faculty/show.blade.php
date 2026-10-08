@extends('layouts.admin')

@section('title', 'EduCore - Faculty Details')

@section('styles')

<link rel="stylesheet"
      href="{{ asset('css/admin-faculty.css') }}">

@endsection


@section('content')

<div class="faculty-page">

    {{-- PAGE HEADER --}}

    <div class="faculty-page-header">

        <div>

            <h1>
                Faculty Details
            </h1>

            <p>
                View faculty member information
            </p>

        </div>


        <div>

            <a
                href="{{ route(
                    'admin.faculty.edit',
                    $faculty->id
                ) }}"
                class="faculty-add-button"
            >

                <i class="fa-solid fa-pen"></i>

                Edit Faculty

            </a>

        </div>

    </div>


    {{-- FACULTY DETAILS --}}

    <div class="faculty-detail-card">

        <div class="faculty-detail-header">

            <div class="faculty-detail-avatar">

                {{ strtoupper(
                    substr(
                        $faculty->name,
                        0,
                        2
                    )
                ) }}

            </div>


            <div>

                <h2>
                    {{ $faculty->name }}
                </h2>

                <p>
                    Faculty ID: {{ $faculty->id }}
                </p>

            </div>

        </div>


        <div class="faculty-detail-grid">

            {{-- ROLE --}}

            <div class="faculty-detail-item">

                <label>
                    Faculty ID
                </label>

                <strong>
                    {{ $faculty->faculty_id }}
                </strong>

            </div>


            {{-- DEPARTMENT --}}

            <div class="faculty-detail-item">

                <label>
                    Department
                </label>

                <strong>
                    {{ $faculty->department->department_name ?? 'N/A' }}
                </strong>

            </div>


            {{-- DESIGNATION --}}

            <div class="faculty-detail-item">

                <label>
                    Designation
                </label>

                <strong>
                    {{ $faculty->designation }}
                </strong>

            </div>


            {{-- EXPERIENCE --}}

            <div class="faculty-detail-item">

                <label>
                    Experience
                </label>

                <strong>
                    {{ $faculty->experience_years }} years
                </strong>

            </div>


            {{-- EMAIL --}}

            <div class="faculty-detail-item">

                <label>
                    Email
                </label>

                <strong>
                    {{ $faculty->email }}
                </strong>

            </div>


            {{-- PHONE --}}

            <div class="faculty-detail-item">

                <label>
                    Phone Number
                </label>

                <strong>
                    {{ $faculty->phone_no ?? 'N/A' }}
                </strong>

            </div>


            {{-- STATUS --}}

            <div class="faculty-detail-item">

                <label>
                    Status
                </label>

                @if($faculty->status)

                    <span class="faculty-status active">

                        <span class="status-dot"></span>

                        Active

                    </span>

                @else

                    <span class="faculty-status inactive">

                        <span class="status-dot"></span>

                        Inactive

                    </span>

                @endif

            </div>


            {{-- CREATED BY --}}

            <div class="faculty-detail-item">

                <label>
                    Created By
                </label>

                <strong>
                    {{ $faculty->created_by ?? 'N/A' }}
                </strong>

            </div>


            {{-- UPDATED BY --}}

            <div class="faculty-detail-item">

                <label>
                    Updated By
                </label>

                <strong>
                    {{ $faculty->updated_by ?? 'N/A' }}
                </strong>

            </div>


            {{-- CREATED AT --}}

            <div class="faculty-detail-item">

                <label>
                    Created At
                </label>

                <strong>
                    {{ $faculty->created_at
                        ? $faculty->created_at->format('d M Y, h:i A')
                        : 'N/A'
                    }}
                </strong>

            </div>


            {{-- UPDATED AT --}}

            <div class="faculty-detail-item">

                <label>
                    Updated At
                </label>

                <strong>
                    {{ $faculty->updated_at
                        ? $faculty->updated_at->format('d M Y, h:i A')
                        : 'N/A'
                    }}
                </strong>

            </div>

        </div>

    </div>

</div>

@endsection