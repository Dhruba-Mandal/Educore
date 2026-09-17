<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'EduCore - Admin')</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet"
          href="{{ asset('css/admin-dashboard.css') }}">

    @yield('styles')

</head>

<body>

<div class="dashboard-wrapper">

    {{-- =========================================================
         SIDEBAR
    ========================================================== --}}

    <aside class="sidebar">

        {{-- Logo --}}

        <div class="sidebar-logo">

            <div class="logo-box">
                E
            </div>

            <span>EduCore</span>

        </div>


        {{-- Administration --}}

        <div class="sidebar-section-title">
            ADMINISTRATION
        </div>


        <nav class="sidebar-menu">

    {{-- Dashboard --}}
    <a href="{{ route('admin.dashboard') }}"
       class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

        <i class="fa-solid fa-table-cells-large"></i>

        <span>Dashboard</span>

        <small></small>

    </a>


    {{-- Students --}}
    <a href="{{ route('admin.students') }}"
       class="menu-item {{ request()->routeIs('admin.students*') ? 'active' : '' }}">

        <i class="fa-solid fa-users"></i>

        <span>Students</span>

        <small></small>

    </a>


    {{-- Faculty --}}
    <a href="{{ route('admin.faculty') }}"
       class="menu-item {{ request()->routeIs('admin.faculty*') ? 'active' : '' }}">

        <i class="fa-solid fa-user-group"></i>

        <span>Faculty</span>

        <small></small>

    </a>


    {{-- Departments --}}
    <a href="{{ route('admin.departments') }}"
       class="menu-item {{ request()->routeIs('admin.departments*') ? 'active' : '' }}">

        <i class="fa-solid fa-building"></i>

        <span>Departments</span>

        <small></small>

    </a>


    {{-- Courses --}}
    <a href="{{ route('admin.courses') }}"
       class="menu-item {{ request()->routeIs('admin.courses*') ? 'active' : '' }}">

        <i class="fa-solid fa-book-open"></i>

        <span>Courses</span>

        <small></small>

    </a>


    {{-- Subjects --}}
    <a href="{{ route('admin.subjects') }}"
       class="menu-item {{ request()->routeIs('admin.subjects*') ? 'active' : '' }}">

        <i class="fa-regular fa-folder"></i>

        <span>Subjects</span>

        <small></small>

    </a>


    {{-- Attendance --}}
    <a href="{{ route('admin.attendance') }}"
       class="menu-item {{ request()->routeIs('admin.attendance*') ? 'active' : '' }}">

        <i class="fa-regular fa-calendar-check"></i>

        <span>Attendance</span>

        <small></small>

    </a>


    {{-- Assignments --}}
    <a href="{{ route('admin.assignments') }}"
       class="menu-item {{ request()->routeIs('admin.assignments*') ? 'active' : '' }}">

        <i class="fa-solid fa-clipboard-list"></i>

        <span>Assignments</span>

        <small></small>

    </a>


    {{-- Examinations --}}
    <a href="{{ route('admin.examinations') }}"
       class="menu-item {{ request()->routeIs('admin.examinations*') ? 'active' : '' }}">

        <i class="fa-solid fa-graduation-cap"></i>

        <span>Examinations</span>

        <small></small>

    </a>


    {{-- Results --}}
    <a href="{{ route('admin.results') }}"
       class="menu-item {{ request()->routeIs('admin.results*') ? 'active' : '' }}">

        <i class="fa-solid fa-chart-column"></i>

        <span>Results</span>

        <small></small>

    </a>


    {{-- Timetable --}}
    <a href="{{ route('admin.timetable') }}"
       class="menu-item {{ request()->routeIs('admin.timetable*') ? 'active' : '' }}">

        <i class="fa-regular fa-clock"></i>

        <span>Timetable</span>

        <small></small>

    </a>


    {{-- Notices --}}
    <a href="{{ route('admin.notices') }}"
       class="menu-item {{ request()->routeIs('admin.notices*') ? 'active' : '' }}">

        <i class="fa-regular fa-bell"></i>

        <span>Notices</span>

        <small></small>

    </a>


    {{-- Reports --}}
    <a href="{{ route('admin.reports') }}"
       class="menu-item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">

        <i class="fa-solid fa-chart-pie"></i>

        <span>Reports</span>

        <small></small>

    </a>


    {{-- Settings --}}
    <a href="{{ route('admin.settings') }}"
       class="menu-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">

        <i class="fa-solid fa-gear"></i>

        <span>Settings</span>

        <small></small>

    </a>

</nav>


        {{-- User --}}

        <div class="sidebar-user">

    <div class="user-avatar">

        {{ strtoupper(substr(session('admin_name', 'Administrator'), 0, 2)) }}

    </div>

    <div class="user-details">

        <strong>
            {{ session('admin_name', 'Administrator') }}
        </strong>

        <span>
            Super Admin
        </span>

    </div>

    {{-- Logout Button --}}
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf

        <button type="submit"
                class="logout-button"
                title="Logout">

            <i class="fa-solid fa-right-from-bracket"></i>

        </button>

    </form>

</div>

    </aside>


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}

    <main class="main-content">

        {{-- TOP BAR --}}

       <header class="topbar">

    <div class="topbar-spacer"></div>

    <div class="topbar-right">

        {{-- Notifications --}}
        <button type="button" class="topbar-icon" title="Notifications">
            <i class="fa-regular fa-bell"></i>
        </button>

        <div class="divider"></div>

        {{-- Messages --}}
        <button type="button" class="topbar-icon" title="Messages">
            <i class="fa-regular fa-message"></i>
        </button>

        <div class="divider"></div>

        {{-- Profile --}}
        {{-- Profile Dropdown --}}
<div class="profile-dropdown">

    <button type="button"
            class="profile"
            id="profileButton">

        <div class="profile-avatar">
            {{ strtoupper(substr(session('admin_name', 'Administrator'), 0, 2)) }}
        </div>

        <div class="profile-info">

            <strong>
                {{ session('admin_name', 'Administrator') }}
            </strong>

            <span>
                Super Admin
            </span>

        </div>

        <i class="fa-solid fa-chevron-down profile-arrow"></i>

    </button>


    {{-- Dropdown Menu --}}
    <div class="profile-menu" id="profileMenu">

        {{-- Profile --}}
        <a href="#"
           class="profile-menu-item">

            <i class="fa-regular fa-user"></i>

            <span>Profile</span>

        </a>


        {{-- Settings --}}
        <a href="{{ route('admin.settings') }}"
           class="profile-menu-item">

            <i class="fa-solid fa-gear"></i>

            <span>Settings</span>

        </a>


        <div class="profile-menu-divider"></div>


        {{-- Logout --}}
        <form method="POST"
              action="{{ route('admin.logout') }}">

            @csrf

            <button type="submit"
                    class="profile-menu-item logout-menu-item">

                <i class="fa-solid fa-right-from-bracket"></i>

                <span>Logout</span>

            </button>

        </form>

    </div>

</div>

    </div>

</header>


        {{-- PAGE CONTENT --}}

        <section class="content">

            @if(session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif


            @if(session('error'))

                <div class="alert alert-error">
                    {{ session('error') }}
                </div>

            @endif


            @yield('content')

        </section>

    </main>

</div>
<script>

    document.addEventListener('DOMContentLoaded', function () {

        const profileButton = document.getElementById('profileButton');
        const profileDropdown = document.querySelector('.profile-dropdown');

        if (!profileButton || !profileDropdown) {
            return;
        }


        /* Open / Close dropdown */

        profileButton.addEventListener('click', function (event) {

            event.stopPropagation();

            profileDropdown.classList.toggle('open');

        });


        /* Close when clicking outside */

        document.addEventListener('click', function (event) {

            if (!profileDropdown.contains(event.target)) {

                profileDropdown.classList.remove('open');

            }

        });


        /* Close with Escape */

        document.addEventListener('keydown', function (event) {

            if (event.key === 'Escape') {

                profileDropdown.classList.remove('open');

            }

        });

    });

</script>
</body>

</html>
