@extends('layouts.admin')

@section('title', 'EduCore - Add Faculty')

@section('styles')

<link rel="stylesheet"
      href="{{ asset('css/admin-faculty.css') }}">

@endsection


@section('content')

<div class="faculty-form-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="faculty-page-header">

        <div>

            <h1>
                Add Faculty
            </h1>

            <p>
                Add a new faculty member to EduCore
            </p>

        </div>

    </div>


    {{-- =====================================================
         FORM CARD
    ====================================================== --}}

    <div class="faculty-form-card">

        <div class="faculty-form-header">

            <h2>
                Faculty Information
            </h2>

            <p>
                Enter the details of the faculty member.
            </p>

        </div>


        {{-- VALIDATION ERRORS --}}

        @if($errors->any())

            <div
                class="faculty-success"
                style="
                    background:#fef2f2;
                    color:#dc2626;
                    border-color:#fecaca;
                "
            >

                <strong>
                    Please fix the following errors:
                </strong>

                <ul style="margin:8px 0 0;padding-left:20px;">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            action="{{ route('admin.faculty.store') }}"
            method="POST"
        >

            @csrf


            <div class="faculty-form-grid">

                {{-- ROLE ID --}}

                <div class="faculty-form-group">

                    <label for="faculty_id">

                        Faculty ID

                        <span>*</span>

                    </label>

                    <input
                        type="text"
                        name="faculty_id"
                        id="faculty_id"
                        class="faculty-form-control"
                        placeholder="Enter faculty ID"
                        value="{{ old('faculty_id') }}"
                        min="1"
                        required
                    >

                    @error('faculty_id')

                        <small class="faculty-field-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- NAME --}}

                <div class="faculty-form-group">

                    <label for="name">

                        Faculty Name

                        <span>*</span>

                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="faculty-form-control"
                        placeholder="Example: Dr. Rajesh Mehta"
                        value="{{ old('name') }}"
                        required
                    >

                    @error('name')

                        <small class="faculty-field-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- DEPARTMENT --}}

                <div class="faculty-form-group">

                    <label for="department_id">

                        Department

                        <span>*</span>

                    </label>

                    <select
                        name="department_id"
                        id="department_id"
                        class="faculty-form-control"
                        required
                    >

                        <option value="">
                            Select Department
                        </option>

                        @foreach($departments as $department)

                            <option
                                value="{{ $department->id }}"
                                {{ old('department_id') == $department->id
                                    ? 'selected'
                                    : ''
                                }}
                            >

                                {{ $department->department_name }}

                            </option>

                        @endforeach

                    </select>

                    @error('department_id')

                        <small class="faculty-field-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- DESIGNATION --}}

                <div class="faculty-form-group">

                    <label for="designation">

                        Designation

                        <span>*</span>

                    </label>

                    <select
                        name="designation"
                        id="designation"
                        class="faculty-form-control"
                        required
                    >

                        <option value="">
                            Select Designation
                        </option>

                        <option
                            value="Professor"
                            {{ old('designation') == 'Professor'
                                ? 'selected'
                                : ''
                            }}
                        >
                            Professor
                        </option>

                        <option
                            value="Associate Professor"
                            {{ old('designation') == 'Associate Professor'
                                ? 'selected'
                                : ''
                            }}
                        >
                            Associate Professor
                        </option>

                        <option
                            value="Assistant Professor"
                            {{ old('designation') == 'Assistant Professor'
                                ? 'selected'
                                : ''
                            }}
                        >
                            Assistant Professor
                        </option>

                        <option
                            value="Lecturer"
                            {{ old('designation') == 'Lecturer'
                                ? 'selected'
                                : ''
                            }}
                        >
                            Lecturer
                        </option>

                    </select>

                    @error('designation')

                        <small class="faculty-field-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- EXPERIENCE --}}

                <div class="faculty-form-group">

                    <label for="experience_years">

                        Experience (Years)

                        <span>*</span>

                    </label>

                    <input
                        type="number"
                        name="experience_years"
                        id="experience_years"
                        class="faculty-form-control"
                        placeholder="Example: 8"
                        min="0"
                        max="60"
                        value="{{ old('experience_years', 0) }}"
                        required
                    >

                    @error('experience_years')

                        <small class="faculty-field-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- EMAIL --}}

                <div class="faculty-form-group">

                    <label for="email">

                        Email

                        <span>*</span>

                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="faculty-form-control"
                        placeholder="faculty@educore.edu"
                        value="{{ old('email') }}"
                        required
                    >

                    @error('email')

                        <small class="faculty-field-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>

                {{-- PASSWORD --}}

                <div class="faculty-form-group">

                    <label for="password">

                        Password

                        <span>*</span>

                    </label>

                    <input
                        type="text"
                        id="password"
                        class="faculty-form-control"
                        value = "nopass"
                        readonly
                    >
                    <small class="faculty-form-help">
                        The default password for the faculty member is "nopass". They can change it after logging in.
                    </small>

                </div>

                {{-- PHONE --}}

                <div class="faculty-form-group">

                    <label for="phone_no">

                        Phone Number

                    </label>

                    <input
                        type="text"
                        name="phone_no"
                        id="phone_no"
                        class="faculty-form-control"
                        placeholder="Enter phone number"
                        value="{{ old('phone_no') }}"
                    >

                    @error('phone_no')

                        <small class="faculty-field-error">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- STATUS --}}

                <div class="faculty-form-group">

                    <label>
                        Status
                    </label>

                    <div class="faculty-status-row">

                        <input
                            type="checkbox"
                            name="status"
                            id="status"
                            value="1"
                            {{ old('status', 1) ? 'checked' : '' }}
                        >

                        <label for="status">
                            Active Faculty
                        </label>

                    </div>

                </div>

            </div>


            {{-- FORM BUTTONS --}}

            <div class="faculty-form-actions">

                <button
                    type="submit"
                    class="faculty-save-button"
                >

                    <i class="fa-solid fa-check"></i>

                    Save Faculty

                </button>


                <a
                    href="{{ route('admin.faculty') }}"
                    class="faculty-cancel-button"
                >

                    Cancel

                </a>

            </div>

        </form>

    </div>

</div>

@endsection