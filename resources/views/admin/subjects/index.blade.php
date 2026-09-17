@extends('layouts.admin')

@section('title', 'Subjects')

@section('styles')

    <link rel="stylesheet"
          href="{{ asset('css/admin-subjects.css') }}">

@endsection


@section('content')

<div class="subject-page">


    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}

    <div class="subject-header">

        <div>

            <h1>
                Subjects
            </h1>

            <p>
                Manage subjects and their department allocation
            </p>

        </div>


        <a href="{{ route('admin.subjects.create') }}"
           class="btn-add-subject">

            <i class="fa-solid fa-plus"></i>

            Add Subject

        </a>

    </div>



    {{-- =========================================================
         VALIDATION ERRORS
    ========================================================== --}}

    @if($errors->any())

        <div class="subject-alert error">

            <i class="fa-solid fa-circle-exclamation"></i>

            <div>

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        </div>

    @endif



    {{-- =========================================================
         FILTER BAR
    ========================================================== --}}

    <form method="GET"
          action="{{ route('admin.subjects') }}"
          id="subjectFilterForm"
          class="subject-filter-form">


        {{-- =====================================================
             SEARCH
        ====================================================== --}}

        <div class="subject-search-box">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                name="search"
                id="subjectSearch"
                value="{{ $search }}"
                placeholder="Search by subject name or code..."
                autocomplete="off"
            >

        </div>



        {{-- =====================================================
             DEPARTMENT FILTER
        ====================================================== --}}

        <div class="subject-filter-select">

            <i class="fa-solid fa-filter"></i>

            <select
                name="department_id"
                id="departmentFilter"
            >

                {{-- All Departments --}}
                <option value="">
                    All Departments
                </option>


                {{-- Departments --}}
                @foreach($departments as $department)

                    <option
                        value="{{ $department->id }}"
                        {{ (string) $departmentId === (string) $department->id ? 'selected' : '' }}
                    >

                        {{ $department->department_name }}

                    </option>

                @endforeach

            </select>

        </div>



        {{-- =====================================================
             STATUS FILTER
        ====================================================== --}}

        <div class="subject-filter-select status-select">

            <select
                name="status"
                id="statusFilter"
            >

                {{-- All Status --}}
                <option value="">
                    All Status
                </option>


                {{-- Active --}}
                <option
                    value="1"
                    {{ (string) $status === '1' ? 'selected' : '' }}
                >

                    Active

                </option>


                {{-- Inactive --}}
                <option
                    value="0"
                    {{ (string) $status === '0' ? 'selected' : '' }}
                >

                    Inactive

                </option>

            </select>

        </div>



        {{-- =====================================================
             APPLY BUTTON
        ====================================================== --}}

        <button
            type="submit"
            class="subject-filter-button"
        >

            Apply

        </button>



        {{-- =====================================================
             CLEAR BUTTON
        ====================================================== --}}

        <a href="{{ route('admin.subjects') }}"
           class="btn-clear">

            <i class="fa-solid fa-rotate-left"></i>

            Clear

        </a>

    </form>



    {{-- =========================================================
         SUBJECT LIST
    ========================================================== --}}

    <div class="subject-list">


        @forelse($subjects as $subject)


            {{-- =================================================
                 SUBJECT CARD
            ================================================== --}}

            <div class="subject-card">


                {{-- =================================================
                     TOP SECTION
                ================================================== --}}

                <div class="subject-card-top">


                    {{-- Subject Icon --}}
                    <div class="subject-icon">

                        <i class="fa-solid fa-book"></i>

                    </div>



                    {{-- Subject Information --}}
                    <div class="subject-main">

                        <h3>

                            {{ $subject->subject_name }}

                        </h3>


                        <div class="subject-code">

                            {{ $subject->subject_code }}

                        </div>

                    </div>



                    {{-- =================================================
                         STATUS
                    ================================================== --}}

                    <div>

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

                </div>



                {{-- =================================================
                     DEPARTMENTS
                ================================================== --}}

                <div class="subject-department">


                    <div class="subject-department-label">

                        Department

                    </div>


                    <div class="subject-department-content">


                        @forelse($subject->departments as $department)

                            <span class="department-tag">

                                {{ $department->department_name }}

                            </span>

                        @empty

                            <span class="department-not-assigned">

                                Not Assigned

                            </span>

                        @endforelse


                    </div>

                </div>



                {{-- =================================================
                     ACTIONS
                ================================================== --}}

                <div class="subject-actions">


                    {{-- =================================================
                         VIEW
                    ================================================== --}}

                    <a
                        href="{{ route('admin.subjects.show', ['id' => $subject->subject_id]) }}"
                        class="action-btn view"
                    >

                        <i class="fa-regular fa-eye"></i>

                        View Subject

                    </a>



                    {{-- =================================================
                         EDIT
                    ================================================== --}}

                    <a
                        href="{{ route('admin.subjects.edit', ['id' => $subject->subject_id]) }}"
                        class="action-btn edit"
                    >

                        <i class="fa-solid fa-pen"></i>

                        Edit Subject

                    </a>



                    {{-- =================================================
                         DELETE
                    ================================================== --}}

                    <form
                        action="{{ route('admin.subjects.destroy', ['id' => $subject->subject_id]) }}"
                        method="POST"
                        style="display: inline;"
                    >

                        @csrf

                        @method('DELETE')


                        <button
                            type="submit"
                            class="action-btn delete"
                            onclick="return confirm('Are you sure you want to delete this subject?')"
                        >

                            <i class="fa-solid fa-trash"></i>

                            Delete Subject

                        </button>

                    </form>


                </div>

            </div>


        @empty


            {{-- =================================================
                 NO SUBJECTS
            ================================================== --}}

            <div class="no-subjects">

                <i class="fa-solid fa-book-open"></i>

                <h3>

                    No Subjects Found

                </h3>

                <p>

                    Try changing your search or filters.

                </p>

            </div>


        @endforelse


    </div>



    {{-- =========================================================
         PAGINATION
    ========================================================== --}}

    @if($subjects->hasPages())

        <div class="subject-pagination">

            {{ $subjects->withQueryString()->links() }}

        </div>

    @endif


</div>

@endsection



{{-- =============================================================
     PAGE-SPECIFIC JAVASCRIPT
============================================================= --}}

@section('scripts')

    <script src="{{ asset('js/admin-subjects.js') }}"></script>

@endsection