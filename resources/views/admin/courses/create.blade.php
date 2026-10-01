@extends('layouts.admin')

@section('title', 'EduCore - Add Course')

@section('styles')

<link rel="stylesheet" href="{{ asset('css/admin-course-form.css') }}">

@endsection


@section('content')

<div class="course-form-page">


    {{-- =========================================================
         PAGE HEADER
         ========================================================= --}}
    <div class="course-form-header">

        <div>

            <span class="course-form-label">
                ACADEMIC MANAGEMENT
            </span>

            <h1>
                Add New Course
            </h1>

            <p>
                Create a new course and assign subjects semester-wise.
            </p>

        </div>


        <a
            href="{{ route('admin.courses.index') }}"
            class="course-back-button"
        >

            <i class="fas fa-arrow-left"></i>

            Back to Courses

        </a>

    </div>



    {{-- =========================================================
         VALIDATION ERRORS
         ========================================================= --}}
    @if ($errors->any())

        <div class="course-error-box">

            <div class="course-error-title">

                <i class="fas fa-exclamation-circle"></i>

                Please fix the following errors:

            </div>


            <ul>

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif



    {{-- =========================================================
         COURSE FORM
         ========================================================= --}}
    <form
        action="{{ route('admin.courses.store') }}"
        method="POST"
        id="courseForm"
        data-subjects-url="{{ route('admin.courses.subjects', ['department_id' => '__DEPARTMENT__']) }}"
    >

        @csrf



        {{-- =====================================================
             COURSE INFORMATION
             ===================================================== --}}
        <div class="course-form-card">


            <div class="course-form-card-header">

                <div class="course-form-icon">

                    <i class="fas fa-book"></i>

                </div>


                <div>

                    <h2>
                        Course Information
                    </h2>

                    <p>
                        Enter the basic details of the course.
                    </p>

                </div>

            </div>



            <div class="course-form-grid">


                {{-- =================================================
                     Department
                     ================================================= --}}
                <div class="course-form-group">

                    <label for="department_id">

                        Department

                        <span>*</span>

                    </label>


                    <select
                        name="department_id"
                        id="department_id"
                        class="course-form-control"
                        required
                    >

                        <option value="">
                            Select Department
                        </option>


                        @foreach ($departments as $department)

                            <option
                                value="{{ $department->id }}"
                                {{ old('department_id') == $department->id ? 'selected' : '' }}
                            >

                                {{ $department->department_name }}

                            </option>

                        @endforeach

                    </select>


                    @error('department_id')

                        <small class="course-field-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>



                {{-- =================================================
                     Course Code
                     ================================================= --}}
                <div class="course-form-group">

                    <label for="course_code">

                        Course Code

                        <span>*</span>

                    </label>


                    <input
                        type="text"
                        name="course_code"
                        id="course_code"
                        class="course-form-control"
                        placeholder="Example: BCA001"
                        value="{{ old('course_code') }}"
                        required
                    >


                    @error('course_code')

                        <small class="course-field-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>



                {{-- =================================================
                     Course Name
                     ================================================= --}}
                <div class="course-form-group course-full-width">

                    <label for="course_name">

                        Course Name

                        <span>*</span>

                    </label>


                    <input
                        type="text"
                        name="course_name"
                        id="course_name"
                        class="course-form-control"
                        placeholder="Example: Bachelor of Computer Applications"
                        value="{{ old('course_name') }}"
                        required
                    >


                    @error('course_name')

                        <small class="course-field-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>



                {{-- =================================================
                     Duration
                     ================================================= --}}
                <div class="course-form-group">

                    <label for="duration_years">

                        Duration

                        <span>*</span>

                    </label>


                    <select
                        name="duration_years"
                        id="duration_years"
                        class="course-form-control"
                        required
                    >

                        <option value="">
                            Select Duration
                        </option>


                        <option
                            value="1"
                            {{ old('duration_years') == 1 ? 'selected' : '' }}
                        >
                            1 Year
                        </option>


                        <option
                            value="2"
                            {{ old('duration_years') == 2 ? 'selected' : '' }}
                        >
                            2 Years
                        </option>


                        <option
                            value="3"
                            {{ old('duration_years') == 3 ? 'selected' : '' }}
                        >
                            3 Years
                        </option>


                        <option
                            value="4"
                            {{ old('duration_years') == 4 ? 'selected' : '' }}
                        >
                            4 Years
                        </option>


                        <option
                            value="5"
                            {{ old('duration_years') == 5 ? 'selected' : '' }}
                        >
                            5 Years
                        </option>

                    </select>


                    @error('duration_years')

                        <small class="course-field-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>



                {{-- =================================================
                     Status
                     ================================================= --}}
                <div class="course-form-group">

                    <label>
                        Status
                    </label>


                    <label class="course-switch">

                        <input
                            type="checkbox"
                            name="status"
                            value="1"
                            {{ old('status', 1) ? 'checked' : '' }}
                        >


                        <span class="course-slider"></span>


                        <span class="course-switch-text">
                            Active
                        </span>

                    </label>

                </div>


            </div>

        </div>



        {{-- =====================================================
             SEMESTER & SUBJECTS
             ===================================================== --}}
        <div class="course-form-card semester-card">


            {{-- =================================================
                 Section Header
                 ================================================= --}}
            <div class="course-form-card-header">

                <div class="course-form-icon semester-icon">

                    <i class="fas fa-layer-group"></i>

                </div>


                <div>

                    <h2>
                        Semester & Subjects
                    </h2>

                    <p>
                        Select subjects for each semester.
                    </p>

                </div>

            </div>



            {{-- =================================================
                 Subject Message
                 ================================================= --}}
            <div
                id="subjectMessage"
                class="subject-message"
            >

                <i class="fas fa-info-circle"></i>

                Please select a department first to load its subjects.

            </div>



            {{-- =================================================
                 Loading
                 ================================================= --}}
            <div
                id="subjectLoading"
                class="subject-loading"
                style="display: none;"
            >

                <i class="fas fa-spinner fa-spin"></i>

                Loading subjects...

            </div>



            {{-- =================================================
                 Semester Grid
                 ================================================= --}}
            <div class="semester-grid">


                @for ($semester = 1; $semester <= 10; $semester++)

                    <div class="semester-box">


                        {{-- =========================================
                             Semester Header
                             ========================================= --}}
                        <div class="semester-header">

                            <div>

                                <span class="semester-number">

                                    Semester {{ $semester }}

                                </span>


                                <small>
                                    Select subjects
                                </small>

                            </div>


                            <span
                                class="subject-count"
                                id="count-{{ $semester }}"
                            >

                                0 selected

                            </span>

                        </div>



                        {{-- =========================================
                             Subject List
                             ========================================= --}}
                        <div
                            class="subject-list"
                            id="subjects-{{ $semester }}"
                            data-old-subjects='@json(old("semester_" . $semester, []))'
                        >

                            <div class="no-subjects">

                                <i class="fas fa-book-open"></i>

                                <span>
                                    Select a department first
                                </span>

                            </div>

                        </div>


                    </div>

                @endfor


            </div>

        </div>



        {{-- =====================================================
             FORM BUTTONS
             ===================================================== --}}
        <div class="course-form-actions">


            <a
                href="{{ route('admin.courses.index') }}"
                class="course-cancel-button"
            >

                Cancel

            </a>


            <button
                type="submit"
                class="course-save-button"
            >

                <i class="fas fa-save"></i>

                Create Course

            </button>


        </div>


    </form>


</div>

@endsection



{{-- =========================================================
     EXTERNAL JAVASCRIPT
     ========================================================= --}}
@section('scripts')

<script src="{{ asset('js/admin-course.js') }}"></script>

@endsection