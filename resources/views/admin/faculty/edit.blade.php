@extends('layouts.admin')

@section('title', 'EduCore - Edit Faculty')

@section('styles')

<link rel="stylesheet"
      href="{{ asset('css/admin-faculty.css') }}">

@endsection


@section('content')

<div class="faculty-form-page">

    {{-- PAGE HEADER --}}

    <div class="faculty-page-header">

        <div>

            <h1>
                Edit Faculty
            </h1>

            <p>
                Update faculty member information
            </p>

        </div>

    </div>


    {{-- FORM CARD --}}

    <div class="faculty-form-card">

        <div class="faculty-form-header">

            <h2>
                Faculty Information
            </h2>

            <p>
                Update the details of this faculty member.
            </p>

        </div>


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
            action="{{ route(
                'admin.faculty.update',
                $faculty->id
            ) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <div class="faculty-form-grid">

                {{-- FACULTY ID --}}

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
                        value="{{ old(
                            'faculty_id',
                            $faculty->faculty_id
                        ) }}"
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
                        value="{{ old(
                            'name',
                            $faculty->name
                        ) }}"
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
                                {{ old(
                                    'department_id',
                                    $faculty->department_id
                                ) == $department->id
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
                            {{ old(
                                'designation',
                                $faculty->designation
                            ) == 'Professor'
                                ? 'selected'
                                : ''
                            }}
                        >
                            Professor
                        </option>

                        <option
                            value="Associate Professor"
                            {{ old(
                                'designation',
                                $faculty->designation
                            ) == 'Associate Professor'
                                ? 'selected'
                                : ''
                            }}
                        >
                            Associate Professor
                        </option>

                        <option
                            value="Assistant Professor"
                            {{ old(
                                'designation',
                                $faculty->designation
                            ) == 'Assistant Professor'
                                ? 'selected'
                                : ''
                            }}
                        >
                            Assistant Professor
                        </option>

                        <option
                            value="Lecturer"
                            {{ old(
                                'designation',
                                $faculty->designation
                            ) == 'Lecturer'
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
                        min="0"
                        max="60"
                        value="{{ old(
                            'experience_years',
                            $faculty->experience_years
                        ) }}"
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
                        value="{{ old(
                            'email',
                            $faculty->email
                        ) }}"
                        required
                    >

                    @error('email')

                        <small class="faculty-field-error">
                            {{ $message }}
                        </small>

                    @enderror

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
                        value="{{ old(
                            'phone_no',
                            $faculty->phone_no
                        ) }}"
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
                            {{ old(
                                'status',
                                $faculty->status
                            ) ? 'checked' : '' }}
                        >

                        <label for="status">
                            Active Faculty
                        </label>

                    </div>

                </div>

            </div>


            {{-- BUTTONS --}}

            <div class="faculty-form-actions">

                <button
                    type="submit"
                    class="faculty-save-button"
                >

                    <i class="fa-solid fa-check"></i>

                    Update Faculty

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