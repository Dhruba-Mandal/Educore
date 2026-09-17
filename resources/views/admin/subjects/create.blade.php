@extends('layouts.admin')

@section('title', 'Add Subject')

@section('styles')
    <link
        rel="stylesheet"
        href="{{ asset('css/admin-subjects.css') }}"
    >
@endsection


@section('content')

<div class="subject-form-page">

    {{-- HEADER --}}

    <div class="form-page-header">

        <div>

            <h1>
                Add Subject
            </h1>

            <p>
                Create a new subject
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


    {{-- FORM --}}

    <div class="subject-form-card">

        <form
            action="{{ route('admin.subjects.store') }}"
            method="POST"
        >

            @csrf


            {{-- =====================================================
                 DEPARTMENTS
            ====================================================== --}}

            <div class="form-group">

                <label>
                    Department Name
                    <span>*</span>
                </label>


                <div class="department-checkbox-list">

                    @foreach($departments as $department)

                        <label class="department-checkbox">

                            <input
                                type="checkbox"
                                name="department_ids[]"
                                value="{{ $department->id }}"
                                {{ in_array(
                                    $department->id,
                                    old('department_ids', [])
                                ) ? 'checked' : '' }}
                            >

                            <span>
                                {{ $department->department_name }}
                            </span>

                        </label>

                    @endforeach

                </div>


                @error('department_ids')

                    <small class="error">
                        {{ $message }}
                    </small>

                @enderror

                @error('department_ids.*')

                    <small class="error">
                        {{ $message }}
                    </small>

                @enderror

            </div>


            {{-- =====================================================
                 SUBJECT CODE
            ====================================================== --}}

            <div class="form-group">

                <label>
                    Subject Code
                    <span>*</span>
                </label>

                <input
                    type="text"
                    name="subject_code"
                    value="{{ old('subject_code') }}"
                    placeholder="e.g. CS301"
                    required
                >

                @error('subject_code')

                    <small class="error">
                        {{ $message }}
                    </small>

                @enderror

            </div>


            {{-- =====================================================
                 SUBJECT NAME
            ====================================================== --}}

            <div class="form-group">

                <label>
                    Subject Name
                    <span>*</span>
                </label>

                <input
                    type="text"
                    name="subject_name"
                    value="{{ old('subject_name') }}"
                    placeholder="e.g. Data Structures"
                    required
                >

                @error('subject_name')

                    <small class="error">
                        {{ $message }}
                    </small>

                @enderror

            </div>


            {{-- =====================================================
                 STATUS
            ====================================================== --}}

            <div class="form-group">

                <label>
                    Status
                    <span>*</span>
                </label>

                <select
                    name="status"
                    required
                >

                    <option
                        value="1"
                        {{ old('status', '1') == '1' ? 'selected' : '' }}
                    >
                        Active
                    </option>

                    <option
                        value="0"
                        {{ old('status') === '0' ? 'selected' : '' }}
                    >
                        Inactive
                    </option>

                </select>


                @error('status')

                    <small class="error">
                        {{ $message }}
                    </small>

                @enderror

            </div>


            {{-- =====================================================
                 BUTTONS
            ====================================================== --}}

            <div class="form-actions">

                <button
                    type="submit"
                    class="btn-save"
                >
                    <i class="fa-solid fa-check"></i>
                    Save Subject
                </button>


                <a
                    href="{{ route('admin.subjects') }}"
                    class="btn-cancel"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection


@section('scripts')

<script src="{{ asset('js/admin-subjects.js') }}"></script>

@endsection