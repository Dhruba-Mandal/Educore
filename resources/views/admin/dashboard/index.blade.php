@extends('layouts.admin')

@section('title', 'EduCore - Admin Dashboard')


@section('content')

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}

    <div class="page-header">

        <div>

            <h1>Dashboard</h1>

            <p>
                Welcome back, {{ session('admin_name', 'Administrator') }} ·
                {{ now()->format('l, d F') }}
            </p>

        </div>


        <button class="quick-add">

            <i class="fa-solid fa-plus"></i>

            Quick Add

        </button>

    </div>


    {{-- =========================================================
         STAT CARDS
    ========================================================== --}}

    <div class="stats-grid">


        {{-- Students --}}

        <div class="stat-card">

            <div class="stat-icon purple">

                <i class="fa-regular fa-user"></i>

            </div>

            <div class="stat-top">

                <span class="growth">
                    ↗ +
                </span>

            </div>

            <h2>1,250</h2>

            <p>Total Students</p>

            <small>
                +48 this month
            </small>

        </div>


        {{-- Faculty --}}

        <div class="stat-card">

            <div class="stat-icon violet">

                <i class="fa-solid fa-graduation-cap"></i>

            </div>

            <div class="stat-top">

                <span class="growth">
                    ↗ +
                </span>

            </div>

            <h2>85</h2>

            <p>Total Faculty</p>

            <small>
                +3 this month
            </small>

        </div>


        {{-- Departments --}}

        <div class="stat-card">

            <div class="stat-icon blue">

                <i class="fa-regular fa-building"></i>

            </div>

            <h2>{{ $departmentCount }}</h2>
            <p>Departments</p>

            <!-- <small>
                No change
            </small> -->

        </div>


        {{-- Courses --}}

        <div class="stat-card">

            <div class="stat-icon green">

                <i class="fa-solid fa-book-open"></i>

            </div>

            <div class="stat-top">

                <span class="growth">
                    ↗ +
                </span>

            </div>

            <h2>48</h2>

            <p>Active Courses</p>

            <small>
                +5 this semester
            </small>

        </div>

    </div>


    {{-- =========================================================
         MIDDLE SECTION
    ========================================================== --}}

    <div class="middle-grid">


        {{-- Student Enrollment --}}

        <div class="panel enrollment-panel">

            <div class="panel-header">

                <div>

                    <h3>
                        Student Enrollment
                    </h3>

                    <p>
                        Monthly new admissions — 2024
                    </p>

                </div>

                <span class="legend">

                    <b></b>

                    Admissions

                </span>

            </div>


            <div class="chart">

                <div class="chart-values">

                    <span>120</span>
                    <span>145</span>
                    <span>108</span>
                    <span>185</span>
                    <span>160</span>
                    <span>200</span>
                    <span>178</span>
                    <span>215</span>

                </div>


                <div class="chart-line">

                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>

                </div>


                <div class="chart-months">

                    <span>Jan</span>
                    <span>Feb</span>
                    <span>Mar</span>
                    <span>Apr</span>
                    <span>May</span>
                    <span>Jun</span>
                    <span>Jul</span>
                    <span>Aug</span>

                </div>

            </div>

        </div>


        {{-- Department Distribution --}}

        <div class="panel department-panel">

            <div class="panel-header">

                <div>

                    <h3>
                        Department Distribution
                    </h3>

                    <p>
                        Student share by department
                    </p>

                </div>

            </div>


            <div class="department-list">


                <div class="department-row">

                    <div>

                        <span class="dot purple-dot"></span>

                        Computer Science

                    </div>

                    <strong>35%</strong>

                </div>

                <div class="progress">
                    <span style="width:35%"></span>
                </div>


                <div class="department-row">

                    <div>

                        <span class="dot violet-dot"></span>

                        Electronics

                    </div>

                    <strong>25%</strong>

                </div>

                <div class="progress">
                    <span style="width:25%"></span>
                </div>


                <div class="department-row">

                    <div>

                        <span class="dot blue-dot"></span>

                        Mechanical

                    </div>

                    <strong>20%</strong>

                </div>

                <div class="progress">
                    <span style="width:20%"></span>
                </div>


                <div class="department-row">

                    <div>

                        <span class="dot green-dot"></span>

                        Civil

                    </div>

                    <strong>12%</strong>

                </div>

                <div class="progress">
                    <span style="width:12%"></span>
                </div>


                <div class="department-row">

                    <div>

                        <span class="dot orange-dot"></span>

                        Electrical

                    </div>

                    <strong>8%</strong>

                </div>

                <div class="progress">
                    <span style="width:8%"></span>
                </div>

            </div>


            <div class="department-footer">

                <span>
                    Total: 12 departments
                </span>

                <span>
                    1,250 students
                </span>

            </div>

        </div>

    </div>


    {{-- =========================================================
         BOTTOM SECTION
    ========================================================== --}}

    <div class="bottom-grid">


        {{-- Recent Activities --}}

        <div class="panel activities-panel">

            <div class="panel-header">

                <h3>
                    Recent Activities
                </h3>

                <a href="#">
                    View all
                </a>

            </div>


            <div class="activity-list">


                <div class="activity">

                    <div class="activity-icon purple-bg">

                        <i class="fa-regular fa-user"></i>

                    </div>

                    <div>

                        <p>
                            New student Priya Nair enrolled
                            in B.Tech CS — Semester 1
                        </p>

                        <small>
                            10:32 AM
                        </small>

                    </div>

                </div>


                <div class="activity">

                    <div class="activity-icon green-bg">

                        <i class="fa-solid fa-user-check"></i>

                    </div>

                    <div>

                        <p>
                            Prof. Kumar submitted attendance
                            for Data Structures (Section B)
                        </p>

                        <small>
                            09:58 AM
                        </small>

                    </div>

                </div>


                <div class="activity">

                    <div class="activity-icon purple-bg">

                        <i class="fa-solid fa-file"></i>

                    </div>

                    <div>

                        <p>
                            Result sheet uploaded for ECE
                            Mid-Semester Examinations
                        </p>

                        <small>
                            09:14 AM
                        </small>

                    </div>

                </div>


                <div class="activity">

                    <div class="activity-icon orange-bg">

                        <i class="fa-regular fa-bell"></i>

                    </div>

                    <div>

                        <p>
                            Notice published: Diwali Holiday
                            on 13 Nov — No Classes
                        </p>

                        <small>
                            Yesterday
                        </small>

                    </div>

                </div>


                <div class="activity">

                    <div class="activity-icon blue-bg">

                        <i class="fa-solid fa-book"></i>

                    </div>

                    <div>

                        <p>
                            Dr. Reddy updated the syllabus
                            for Advanced Algorithms
                        </p>

                        <small>
                            Yesterday
                        </small>

                    </div>

                </div>

            </div>

        </div>


        {{-- Right Column --}}

        <div class="right-column">


            {{-- Quick Actions --}}

            <div class="panel quick-panel">

                <h3>
                    Quick Actions
                </h3>


                <div class="quick-grid">


                    <a href="#">

                        <i class="fa-regular fa-user"></i>

                        Add Student

                    </a>


                    <a href="#">

                        <i class="fa-solid fa-graduation-cap"></i>

                        Add Faculty

                    </a>


                    <a href="#">

                        <i class="fa-regular fa-file-lines"></i>

                        Create Notice

                    </a>


                    <a href="#">

                        <i class="fa-solid fa-chart-column"></i>

                        View Reports

                    </a>

                </div>

            </div>


            {{-- Attendance --}}

            <div class="panel attendance-panel">

                <h3>
                    Attendance Overview
                </h3>


                <div class="attendance-row">

                    <span>CS</span>

                    <div class="attendance-progress">

                        <span style="width:87%"></span>

                    </div>

                    <strong>87%</strong>

                </div>


                <div class="attendance-row">

                    <span>EC</span>

                    <div class="attendance-progress">

                        <span style="width:91%"></span>

                    </div>

                    <strong>91%</strong>

                </div>


                <div class="attendance-row">

                    <span>ME</span>

                    <div class="attendance-progress">

                        <span style="width:76%"></span>

                    </div>

                    <strong>76%</strong>

                </div>

            </div>

        </div>

    </div>

@endsection