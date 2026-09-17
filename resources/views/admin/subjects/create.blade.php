@extends('layouts.admin')

@section('title', 'Add Subject')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-subjects.css') }}">
@endsection

@section('content')

<div class="subject-form-page">

    {{-- Page Header --}}
    <div class="form-page-header">
        <div>
            <h1>Add Subject</h1>
            <p>
                Create a new subject and assign it to one or more departments.
            </p>
        </div>

        <a href="{{ route('admin.subjects') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Subjects
        </a>
    </div>


    {{-- Form Card --}}
    <div class="subject-form-card">

        <form
            action="{{ route('admin.subjects.store') }}"
            method="POST"
        >

            @csrf


            {{-- =========================================================
                Departments
            ========================================================== --}}
            <div class="form-group">

                <label>
                    Departments <span>*</span>
                </label>

                <div
                    class="department-multiselect"
                    id="departmentMultiselect"
                >

                    {{-- Select Button --}}
                    <button
                        type="button"
                        class="department-select-trigger"
                        id="departmentSelectTrigger"
                    >

                        <div
                            class="department-selected-items"
                            id="departmentSelectedItems"
                        >
                            <span class="department-placeholder">
                                Select Departments
                            </span>
                        </div>

                        <i class="fa-solid fa-chevron-down department-arrow"></i>

                    </button>


                    {{-- Dropdown --}}
                    <div
                        class="department-dropdown"
                        id="departmentDropdown"
                    >

                        {{-- Search --}}
                        <div class="department-search">

                            <i class="fa-solid fa-magnifying-glass"></i>

                            <input
                                type="text"
                                id="departmentSearch"
                                placeholder="Search departments..."
                                autocomplete="off"
                            >

                        </div>


                        {{-- Department Options --}}
                        <div
                            class="department-options"
                            id="departmentOptions"
                        >

                            @forelse($departments as $department)

                                <label class="department-option">

                                    <input
                                        type="checkbox"
                                        name="department_ids[]"
                                        value="{{ $department->id }}"
                                        data-name="{{ $department->department_name }}"
                                        {{ in_array(
                                            (string) $department->id,
                                            array_map(
                                                'strval',
                                                old('department_ids', [])
                                            )
                                        ) ? 'checked' : '' }}
                                    >

                                    <span class="department-checkmark">
                                        <i class="fa-solid fa-check"></i>
                                    </span>

                                    <span class="department-option-name">
                                        {{ $department->department_name }}
                                    </span>

                                </label>

                            @empty

                                <div class="department-empty">

                                    <i class="fa-solid fa-building"></i>

                                    <span>
                                        No departments available
                                    </span>

                                </div>

                            @endforelse

                        </div>

                    </div>

                </div>


                {{-- Department Validation --}}
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


            {{-- =========================================================
                Subject Code
            ========================================================== --}}
            <div class="form-group">

                <label>
                    Subject Code <span>*</span>
                </label>

                <input
                    type="text"
                    name="subject_code"
                    value="{{ old('subject_code') }}"
                    placeholder="e.g. CS001"
                    maxlength="100"
                    required
                >

                @error('subject_code')
                    <small class="error">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            {{-- =========================================================
                Subject Name
            ========================================================== --}}
            <div class="form-group">

                <label>
                    Subject Name <span>*</span>
                </label>

                <input
                    type="text"
                    name="subject_name"
                    value="{{ old('subject_name') }}"
                    placeholder="e.g. Data Structure"
                    maxlength="255"
                    required
                >

                @error('subject_name')
                    <small class="error">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            {{-- =========================================================
                Status
            ========================================================== --}}
            <div class="form-group">

                <label>
                    Status <span>*</span>
                </label>

                <select name="status" required>

                    <option value="">
                        Select Status
                    </option>

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


            {{-- =========================================================
                Actions
            ========================================================== --}}
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