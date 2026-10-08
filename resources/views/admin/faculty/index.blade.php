@extends('layouts.admin')

@section('title', 'EduCore - Faculty')

@section('styles')

<link rel="stylesheet"
      href="{{ asset('css/admin-faculty.css') }}">

@endsection


@section('content')

<div class="faculty-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="faculty-page-header">

        <div>

            <h1>
                Faculty
            </h1>

            <p>
                Manage faculty members across all departments
            </p>

        </div>


        <div>

            <a
                href="{{ route('admin.faculty.create') }}"
                class="faculty-add-button"
            >

                <i class="fa-solid fa-plus"></i>

                Add Faculty

            </a>

        </div>

    </div>


    {{-- =====================================================
         SUCCESS MESSAGE
    ====================================================== --}}

    @if(session('success'))

        <div class="faculty-success">

            {{ session('success') }}

        </div>

    @endif


    {{-- =====================================================
         SEARCH
    ====================================================== --}}

    <div class="faculty-search-panel">

        <form
            action="{{ route('admin.faculty') }}"
            method="GET"
        >

            <div class="faculty-search-box">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name, department, or email..."
                >

            </div>

        </form>


        <div class="faculty-count">

            {{ $faculties->total() }} faculty members

        </div>

    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="faculty-table-panel">

        <div class="faculty-table-wrapper">

            <table class="faculty-table">

                <thead>

                    <tr>

                        <th>
                            FACULTY MEMBER
                        </th>

                        <th>
                            DEPARTMENT
                        </th>

                        <th>
                            DESIGNATION
                        </th>

                        <th>
                            EXPERIENCE
                        </th>

                        <th>
                            EMAIL
                        </th>

                        <th>
                            STATUS
                        </th>

                        <th>
                            ACTIONS
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($faculties as $faculty)

                        <tr>

                            {{-- FACULTY MEMBER --}}

                            <td>

                                <div class="faculty-member">

                                    <div class="faculty-avatar">

                                        {{ strtoupper(
                                            substr(
                                                $faculty->name,
                                                0,
                                                2
                                            )
                                        ) }}

                                    </div>


                                    <div>

                                        <strong>
                                            {{ $faculty->name }}
                                        </strong>

                                        <span>
                                            ID: {{ $faculty->id }}
                                        </span>

                                    </div>

                                </div>

                            </td>


                            {{-- DEPARTMENT --}}

                            <td>

                                {{ $faculty->department->department_name ?? 'N/A' }}

                            </td>


                            {{-- DESIGNATION --}}

                            <td>

                                <span class="designation-badge">

                                    {{ $faculty->designation }}

                                </span>

                            </td>


                            {{-- EXPERIENCE --}}

                            <td>

                                {{ $faculty->experience_years }} yrs

                            </td>


                            {{-- EMAIL --}}

                            <td>

                                <span class="faculty-email">

                                    <i class="fa-regular fa-envelope"></i>

                                    {{ $faculty->email }}

                                </span>

                            </td>


                            {{-- STATUS --}}

                            <td>

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

                            </td>


                            {{-- ACTIONS --}}

                            <td>

                                <div class="faculty-actions">

                                    {{-- VIEW --}}

                                    <a
                                        href="{{ route(
                                            'admin.faculty.show',
                                            $faculty->id
                                        ) }}"
                                        title="View"
                                    >

                                        <i class="fa-regular fa-eye"></i>

                                    </a>


                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route(
                                            'admin.faculty.edit',
                                            $faculty->id
                                        ) }}"
                                        title="Edit"
                                    >

                                        <i class="fa-regular fa-pen-to-square"></i>

                                    </a>


                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route(
                                            'admin.faculty.destroy',
                                            $faculty->id
                                        ) }}"
                                        method="POST"
                                        onsubmit="return confirm(
                                            'Are you sure you want to delete this faculty member?'
                                        );"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Delete"
                                        >

                                            <i class="fa-regular fa-trash-can"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="faculty-empty"
                            >

                                No faculty members found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}

        @if($faculties->hasPages())

            <div class="faculty-pagination">

                {{ $faculties->links() }}

            </div>

        @endif

    </div>

</div>

@endsection