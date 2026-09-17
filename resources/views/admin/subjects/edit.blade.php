@extends('layouts.admin')

@section('title', 'Edit Subject')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-subjects.css') }}">
@endsection

@section('content')

<div class="subject-form-page">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}

    <div class="form-page-header">

        <div>
            <h1>Edit Subject</h1>

            <p>
                Update subject information and department assignments.
            </p>
        </div>

        <a href="{{ route('admin.subjects') }}"
           class="btn-back">

            <i class="fa-solid fa-arrow-left"></i>

            Back to Subjects

        </a>

    </div>


    {{-- =========================================================
         FORM CARD
    ========================================================== --}}

    <div class="subject-form-card">

        <form action="{{ route('admin.subjects.update', $subject->subject_id) }}"
              method="POST">

            @csrf

            @method('PUT')


            {{-- =================================================
                 DEPARTMENTS
            ================================================== --}}

            <div class="form-group">

                <label>
                    Departments <span>*</span>
                </label>


                <div class="department-multiselect"
                     id="departmentMultiselect">


                    {{-- =========================================
                         SELECT TRIGGER
                    ========================================== --}}

                    <button type="button"
                            class="department-select-trigger"
                            id="departmentSelectTrigger">

                        <div class="department-selected-items"
                             id="departmentSelectedItems">

                            <span class="department-placeholder">
                                Select Departments
                            </span>

                        </div>


                        <i class="fa-solid fa-chevron-down department-arrow"></i>

                    </button>


                    {{-- =========================================
                         DROPDOWN
                    ========================================== --}}

                    <div class="department-dropdown"
                         id="departmentDropdown">


                        {{-- Search --}}
                        <div class="department-search">

                            <i class="fa-solid fa-magnifying-glass"></i>

                            <input type="text"
                                   id="departmentSearch"
                                   placeholder="Search departments..."
                                   autocomplete="off">

                        </div>


                        {{-- Department Options --}}
                        <div class="department-options"
                             id="departmentOptions">


                            @forelse($departments as $department)

                                @php
                                    /*
                                    |--------------------------------------------------------------------------
                                    | Check whether this department is already assigned
                                    |--------------------------------------------------------------------------
                                    */

                                    $isSelected = $subject->departments
                                        ->contains('id', $department->id);

                                    /*
                                    |--------------------------------------------------------------------------
                                    | If validation failed, use old input instead
                                    |--------------------------------------------------------------------------
                                    */

                                    if (old('department_ids') !== null) {
                                        $isSelected = in_array(
                                            (string) $department->id,
                                            array_map(
                                                'strval',
                                                old('department_ids', [])
                                            ),
                                            true
                                        );
                                    }
                                @endphp


                                <label class="department-option">

                                    <input type="checkbox"
                                           name="department_ids[]"
                                           value="{{ $department->id }}"
                                           data-name="{{ $department->department_name }}"
                                           {{ $isSelected ? 'checked' : '' }}>


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


            {{-- =================================================
                 SUBJECT CODE
            ================================================== --}}

            <div class="form-group">

                <label>
                    Subject Code <span>*</span>
                </label>


                <input type="text"
                       name="subject_code"
                       value="{{ old('subject_code', $subject->subject_code) }}"
                       placeholder="e.g. CS001"
                       maxlength="100"
                       required>


                @error('subject_code')

                    <small class="error">
                        {{ $message }}
                    </small>

                @enderror

            </div>


            {{-- =================================================
                 SUBJECT NAME
            ================================================== --}}

            <div class="form-group">

                <label>
                    Subject Name <span>*</span>
                </label>


                <input type="text"
                       name="subject_name"
                       value="{{ old('subject_name', $subject->subject_name) }}"
                       placeholder="e.g. Data Structure"
                       maxlength="255"
                       required>


                @error('subject_name')

                    <small class="error">
                        {{ $message }}
                    </small>

                @enderror

            </div>


            {{-- =================================================
                 STATUS
            ================================================== --}}

            <div class="form-group">

                <label>
                    Status <span>*</span>
                </label>


                <select name="status" required>

                    <option value="">
                        Select Status
                    </option>


                    <option value="1"
                        {{ old('status', (string) $subject->status) === '1' ? 'selected' : '' }}>

                        Active

                    </option>


                    <option value="0"
                        {{ old('status', (string) $subject->status) === '0' ? 'selected' : '' }}>

                        Inactive

                    </option>

                </select>


                @error('status')

                    <small class="error">
                        {{ $message }}
                    </small>

                @enderror

            </div>


            {{-- =================================================
                 FORM ACTIONS
            ================================================== --}}

            <div class="form-actions">

                <button type="submit"
                        class="btn-save">

                    <i class="fa-solid fa-check"></i>

                    Update Subject

                </button>


                <a href="{{ route('admin.subjects') }}"
                   class="btn-cancel">

                    Cancel

                </a>

            </div>

        </form>

    </div>

</div>

@endsection


{{-- =============================================================
     PAGE-SPECIFIC JAVASCRIPT
============================================================= --}}

@section('scripts')

    <script src="{{ asset('js/admin-subjects.js') }}"></script>

@endsection