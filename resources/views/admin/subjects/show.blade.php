@extends('layouts.admin')

@section('title', 'View Subject')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin-subjects.css') }}">
@endsection

@section('content')

<div class="subject-view-page">

    {{-- Page Header --}}
    <div class="subject-view-header">
        <div>
            <h1>Subject Details</h1>
            <p>View complete subject information and department allocation.</p>
        </div>

        <a href="{{ route('admin.subjects') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Subjects
        </a>
    </div>


    {{-- Main Subject Card --}}
    <div class="subject-view-card">

        {{-- Subject Summary --}}
        <div class="subject-summary">

            <div class="subject-view-icon">
                <i class="fa-solid fa-book"></i>
            </div>

            <div class="subject-summary-info">
                <span class="subject-label">SUBJECT</span>

                <h2>{{ $subject->subject_name }}</h2>

                <div class="subject-code-view">
                    <i class="fa-solid fa-hashtag"></i>
                    {{ $subject->subject_code }}
                </div>
            </div>

            <div class="subject-status">
                @if($subject->status == 1)
                    <span class="status-badge active">
                        <i class="fa-solid fa-circle"></i>
                        Active
                    </span>
                @else
                    <span class="status-badge inactive">
                        <i class="fa-solid fa-circle"></i>
                        Inactive
                    </span>
                @endif
            </div>

        </div>


        {{-- Subject Information --}}
        <div class="subject-info-section">

            <div class="section-heading">
                <i class="fa-solid fa-circle-info"></i>
                <div>
                    <h3>Subject Information</h3>
                    <p>Basic information about this subject.</p>
                </div>
            </div>


            <div class="subject-info-grid">

                {{-- Subject Name --}}
                <div class="info-item">
                    <span class="info-label">Subject Name</span>
                    <strong>{{ $subject->subject_name }}</strong>
                </div>


                {{-- Subject Code --}}
                <div class="info-item">
                    <span class="info-label">Subject Code</span>
                    <strong>{{ $subject->subject_code }}</strong>
                </div>



                {{-- Departments --}}
                <div class="info-item department-info">
                    <span class="info-label">Departments</span>

                    <div class="department-view-list">

                        @forelse($subject->departments as $department)

                            <span class="department-view-tag">
                                <i class="fa-solid fa-building-columns"></i>
                                {{ $department->department_name }}
                            </span>

                        @empty

                            <span class="not-assigned">
                                No department assigned
                            </span>

                        @endforelse

                    </div>
                </div>

            </div>

        </div>


        {{-- Record Information --}}
        <div class="subject-record-section">

            <div class="section-heading">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <div>
                    <h3>Record Information</h3>
                    <p>System record timestamps.</p>
                </div>
            </div>


            <div class="record-grid">

                <div class="record-item">
                    <div class="record-icon">
                        <i class="fa-regular fa-calendar-plus"></i>
                    </div>

                    <div>
                        <span>Created On</span>
                        <strong>
                            {{ $subject->created_at?->format('d M Y, h:i A') ?? 'N/A' }}
                        </strong>
                    </div>
                </div>


                <div class="record-item">
                    <div class="record-icon">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </div>

                    <div>
                        <span>Last Updated</span>
                        <strong>
                            {{ $subject->updated_at?->format('d M Y, h:i A') ?? 'N/A' }}
                        </strong>
                    </div>
                </div>

            </div>

        </div>


        {{-- Actions --}}
        <div class="subject-view-actions">

            <a href="{{ route('admin.subjects.edit', ['id' => $subject->subject_id]) }}"
               class="view-action edit">
                <i class="fa-solid fa-pen"></i>
                Edit Subject
            </a>

            <a href="{{ route('admin.subjects') }}"
               class="view-action back">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Subjects
            </a>

        </div>

    </div>

</div>

@endsection

@section('scripts')
<script src="{{ asset('js/admin-subjects.js') }}"></script>
@endsection