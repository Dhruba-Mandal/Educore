@extends('layouts.admin')

@section('title', 'Add Department')

@section('styles')
    <link rel="stylesheet"
          href="{{ asset('css/admin-departments.css') }}">
@endsection

@section('content')

<div class="department-page">

    <div class="department-header">

        <div>
            <h1>Add Department</h1>

            <p>
                Create a new institutional department
            </p>
        </div>

        <a
            href="{{ route('admin.departments') }}"
            class="add-department-btn"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Back to Departments
        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-success"
             style="background:#fff1f2;color:#dc2626;border-color:#fecdd3;">

            <i class="fa-solid fa-circle-exclamation"></i>

            <div>

                @foreach($errors->all() as $error)

                    <div>{{ $error }}</div>

                @endforeach

            </div>

        </div>

    @endif


    <div class="department-card">

        <form
            method="POST"
            action="{{ route('admin.departments.store') }}"
        >

            @csrf


            <div style="display:grid;gap:18px;">

                <div>

                    <label
                        style="display:block;margin-bottom:7px;font-size:13px;font-weight:600;"
                    >
                        Department Name
                    </label>

                    <input
                        type="text"
                        name="department_name"
                        value="{{ old('department_name') }}"
                        placeholder="e.g. Computer Science & Engineering"
                        required
                        style="width:100%;height:42px;padding:0 12px;border:1px solid #e1e5eb;border-radius:8px;box-sizing:border-box;"
                    >

                </div>


                <div>

                    <label
                        style="display:block;margin-bottom:7px;font-size:13px;font-weight:600;"
                    >
                        HOD Name
                    </label>

                    <input
                        type="text"
                        name="hod_name"
                        value="{{ old('hod_name') }}"
                        placeholder="e.g. Dr. Rajesh Mehta"
                        style="width:100%;height:42px;padding:0 12px;border:1px solid #e1e5eb;border-radius:8px;box-sizing:border-box;"
                    >

                </div>


                <div>

                    <label
                        style="display:block;margin-bottom:7px;font-size:13px;font-weight:600;"
                    >
                        Status
                    </label>

                    <select
                        name="status"
                        style="width:100%;height:42px;padding:0 12px;border:1px solid #e1e5eb;border-radius:8px;background:#fff;"
                    >

                        <option value="1">
                            Active
                        </option>

                        <option value="0">
                            Inactive
                        </option>

                    </select>

                </div>


                <div style="display:flex;gap:10px;">

                    <button
                        type="submit"
                        class="add-department-btn"
                    >

                        <i class="fa-solid fa-check"></i>

                        Save Department

                    </button>


                    <a
                        href="{{ route('admin.departments') }}"
                        class="action-btn view-btn"
                        style="padding:10px 16px;"
                    >

                        Cancel

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection