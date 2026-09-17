@extends('layouts.admin')

@section('title', 'View Subject')

@section('styles')
    <link
        rel="stylesheet"
        href="{{ asset('css/admin-subjects.css') }}"
    >
@endsection

@section('content')

<div class="subject-form-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="form-page-header">

        <div>
            <h1>
                Subject Details
            </h1>

            <p>
                View subject information
            </p>
        </div>

        <a
            href="{{ route('admin.subjects') }}"
            class="btn-back"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Back to Subjects
        </a>

    </div>


    {{-- =====================================================
         SUBJECT DETAILS
    ====================================================== --}}

    <div class="subject-details-card">

        {{-- SUBJECT NAME --}}

        <div class="detail-row">

            <span>
                Subject Name
            </span>

            <strong>
                {{ $subject->subject_name }}
            </strong>

        </div>


        {{-- SUBJECT CODE --}}

        <div class="detail-row">

            <span>
                Subject Code
            </span>

            <strong>
                {{ $subject->subject_code }}
            </strong>

        </div>


        {{-- DEPARTMENT --}}

        <div class="detail-row">

            <span>
                Department
            </span>

            <strong>
                <div class="subject-department-list">

                    @forelse($subject->departments as $department)

                        <span class="department-badge">
                            {{ $department->department_name }}
                        </span>

                    @empty

                        <strong>
                            Not Assigned
                        </strong>

                    @endforelse

                </div>
            </strong>

        </div>


        {{-- STATUS --}}

        <div class="detail-row">

            <span>
                Status
            </span>

            @if($subject->status == 1)

                <span class="status-badge active">
                    Active
                </span>

            @else

                <span class="status-badge inactive">
                    Inactive
                </span>

            @endif

        </div>


        {{-- CREATED DATE --}}

        <div class="detail-row">

            <span>
                Created
            </span>

            <strong>
                {{ $subject->created_at?->format('d M Y, h:i A') ?? 'N/A' }}
            </strong>

        </div>


        {{-- UPDATED DATE --}}

        <div class="detail-row">

            <span>
                Last Updated
            </span>

            <strong>
                {{ $subject->updated_at?->format('d M Y, h:i A') ?? 'N/A' }}
            </strong>

        </div>


        {{-- =================================================
             ACTIONS
        ================================================== --}}

        <div class="detail-actions">

            {{-- EDIT --}}

            <a
                href="{{ route('admin.subjects.edit', $subject) }}"
                class="action-btn edit"
            >
                <i class="fa-solid fa-pen"></i>
                Edit Subject
            </a>


            {{-- BACK --}}

            <a
                href="{{ route('admin.subjects') }}"
                class="btn-cancel"
            >
                Back
            </a>

        </div>

    </div>

</div>

@endsection


@section('scripts')

<script src="{{ asset('js/admin-subjects.js') }}"></script>

@endsection