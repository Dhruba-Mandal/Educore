@extends('layouts.admin')

@section('title', 'Edit Subject')

@section('styles')
<link
    rel="stylesheet"
    href="{{ asset('css/admin-subjects.css') }}"
>
@endsection

@section('content')

<div class="subject-form-page">

    {{-- PAGE HEADER --}}
    <div class="form-page-header">

        <div>
            <h1>Edit Subject</h1>

            <p>
                Update subject information
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


    {{-- FORM CARD --}}
    <div class="subject-form-card">

        <form
            action="{{ route('admin.subjects.update', $subject->subject_id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            {{-- DEPARTMENT --}}
            <div class="form-group">

                <label>
                    Department Name
                    <span>*</span>
                </label>

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

                    {{
                        in_array(
                            $department->id,
                            old(
                                'department_ids',
                                $subject->departments
                                    ->pluck('id')
                                    ->toArray()
                            )
                        )
                        ? 'checked'
                        : ''
                    }}
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

</div>

                @error('department_id')
                    <small class="error">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            {{-- SUBJECT CODE --}}
            <div class="form-group">

                <label>
                    Subject Code
                    <span>*</span>
                </label>

                <input
                    type="text"
                    name="subject_code"
                    value="{{ old('subject_code', $subject->subject_code) }}"
                    required
                >

                @error('subject_code')
                    <small class="error">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            {{-- SUBJECT NAME --}}
            <div class="form-group">

                <label>
                    Subject Name
                    <span>*</span>
                </label>

                <input
                    type="text"
                    name="subject_name"
                    value="{{ old('subject_name', $subject->subject_name) }}"
                    required
                >

                @error('subject_name')
                    <small class="error">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            {{-- STATUS --}}
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
                        {{ old('status', $subject->status) == 1 ? 'selected' : '' }}
                    >
                        Active
                    </option>

                    <option
                        value="0"
                        {{ old('status', $subject->status) == 0 ? 'selected' : '' }}
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


            {{-- BUTTONS --}}
            <div class="form-actions">

                <button
                    type="submit"
                    class="btn-save"
                >
                    <i class="fa-solid fa-check"></i>
                    Update Subject
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