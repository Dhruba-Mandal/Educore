<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EduCore - Select Role</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/role-selection.css') }}">
</head>

<body>

<div class="role-page">

    <!-- LEFT SIDE -->
    <section class="role-left">

        <div class="brand">
            <div class="brand-logo">E</div>
            <div class="brand-name">EduCore</div>
        </div>

        <div class="left-main">

            <h1>
                One Campus.<br>
                One Intelligent<br>
                Platform.
            </h1>

            <p class="left-description">
                Streamline administration, enhance teaching
                outcomes, and empower students with a unified
                college management solution.
            </p>

            <div class="feature-list">

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <div>
                        <h3>Secure</h3>
                        <p>
                            Enterprise-grade security with role-based
                            access control
                        </p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>

                    <div>
                        <h3>Centralized</h3>
                        <p>
                            All institutional data unified in one intelligent
                            platform
                        </p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fa-regular fa-user"></i>
                    </div>

                    <div>
                        <h3>Role-Based</h3>
                        <p>
                            Tailored experiences for every user type
                        </p>
                    </div>
                </div>

            </div>

        </div>

        <div class="left-footer">
            <span class="status-dot"></span>
            All systems operational · EduCore v2.4.1
        </div>

    </section>


    <!-- RIGHT SIDE -->
    <section class="role-right">

        <div class="role-container">

            <h2>Welcome to EduCore</h2>

            <p class="role-subtitle">
                Choose your account type to continue
            </p>


            <!-- ADMIN -->
            <a href="{{ route('admin.login') }}" class="role-card">

                <div class="role-card-left">

                    <div class="role-icon admin">
                        A
                    </div>

                    <div class="role-info">

                        <div class="role-title-row">
                            <h3>Administrator</h3>
                            <span>Full Access</span>
                        </div>

                        <p>
                            Manage the entire institution
                        </p>

                    </div>

                </div>

                <i class="fa-solid fa-chevron-right role-arrow"></i>

            </a>


            <!-- FACULTY -->
            <a href="{{ route('faculty.login') }}" class="role-card">

                <div class="role-card-left">

                    <div class="role-icon faculty">
                        F
                    </div>

                    <div class="role-info">

                        <div class="role-title-row">
                            <h3>Faculty</h3>
                            <span>Teaching Portal</span>
                        </div>

                        <p>
                            Manage courses and students
                        </p>

                    </div>

                </div>

                <i class="fa-solid fa-chevron-right role-arrow"></i>

            </a>


            <!-- STUDENT -->
            <a href="{{ route('student.login') }}" class="role-card">

                <div class="role-card-left">

                    <div class="role-icon student">
                        S
                    </div>

                    <div class="role-info">

                        <div class="role-title-row">
                            <h3>Student</h3>
                            <span>Academic Portal</span>
                        </div>

                        <p>
                            Access your academic portal
                        </p>

                    </div>

                </div>

                <i class="fa-solid fa-chevron-right role-arrow"></i>

            </a>


            <div class="role-footer">
                © 2024 EduCore. All rights reserved.
            </div>

        </div>

    </section>

</div>

</body>
</html>