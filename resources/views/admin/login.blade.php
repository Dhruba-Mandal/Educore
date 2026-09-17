<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>EduCore - Administrator Login</title>

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Admin Login CSS -->
    <link rel="stylesheet"
          href="{{ asset('css/admin-login.css') }}">
</head>

<body>

<div class="login-page">

    <!-- ========================================= -->
    <!-- LEFT PANEL -->
    <!-- ========================================= -->

    <section class="login-left">

        <!-- Brand -->

        <div class="brand">

            <div class="brand-logo">
                E
            </div>

            <div class="brand-name">
                EduCore
            </div>

        </div>


        <!-- Main Content -->

        <div class="left-main">

            <div class="purple-line"></div>

            <h1>
                Secure. Centralized.<br>
                Intelligent.
            </h1>

            <p class="left-description">
                Your institutional portal gives you real-time
                access to academic data, course management,
                and collaborative tools — all in one place.
            </p>


            <!-- Features -->

            <div class="feature-list">

                <div class="feature-item">

                    <div class="feature-bullet">
                        <span></span>
                    </div>

                    <div class="feature-text">
                        99.9% Uptime SLA
                    </div>

                </div>


                <div class="feature-item">

                    <div class="feature-bullet">
                        <span></span>
                    </div>

                    <div class="feature-text">
                        AES-256 Encryption
                    </div>

                </div>


                <div class="feature-item">

                    <div class="feature-bullet">
                        <span></span>
                    </div>

                    <div class="feature-text">
                        FERPA Compliant
                    </div>

                </div>


                <div class="feature-item">

                    <div class="feature-bullet">
                        <span></span>
                    </div>

                    <div class="feature-text">
                        24/7 Support
                    </div>

                </div>

            </div>

        </div>


        <!-- Footer -->

        <div class="left-footer">

            <span class="status-dot"></span>

            <span>
                All systems operational
            </span>

        </div>

    </section>


    <!-- ========================================= -->
    <!-- RIGHT PANEL -->
    <!-- ========================================= -->

    <section class="login-right">

        <div class="login-wrapper">


            <!-- Back -->

            <a href="{{ route('role.selection') }}"
               class="back-link">

                <span class="back-x">×</span>

                Back to role selection

            </a>


            <!-- Login Card -->

            <div class="login-card">


                <!-- Role Badge -->

                <div class="role-badge">

                    <span class="badge-dot"></span>

                    Administrator

                </div>


                <!-- Heading -->

                <h2>
                    Administrator Login
                </h2>

                <p class="login-subtitle">
                    Access the institutional administration portal
                </p>


                <!-- Error Message -->

                @if ($errors->any())

                    <div class="error-message">

                        <i class="fa-solid fa-circle-exclamation"></i>

                        <div>

                            @foreach ($errors->all() as $error)

                                <div>{{ $error }}</div>

                            @endforeach

                        </div>

                    </div>

                @endif


                <!-- Login Form -->

                <form method="POST"
                      action="{{ route('admin.login.submit') }}">

                    @csrf


                    <!-- EMAIL -->

                    <div class="form-group">

                        <label for="email">
                            Email Address
                        </label>


                        <div class="input-wrapper">

                            <i class="fa-regular fa-envelope input-icon"></i>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="name@institution.edu"
                                autocomplete="email"
                                required
                            >

                        </div>

                    </div>


                    <!-- PASSWORD -->

                    <div class="form-group password-group">

                        <label for="password">
                            Password
                        </label>


                        <div class="input-wrapper">

                            <i class="fa-solid fa-lock input-icon"></i>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="••••••••"
                                autocomplete="current-password"
                                required
                            >


                            <button
                                type="button"
                                class="password-toggle"
                                id="passwordToggle"
                                aria-label="Show password">

                                <i class="fa-regular fa-eye"
                                   id="eyeIcon"></i>

                            </button>

                        </div>

                    </div>


                    <!-- OPTIONS -->

                    <div class="login-options">

                        <label class="remember-label">

                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                            >

                            <span class="custom-checkbox"></span>

                            <span class="remember-text">
                                Remember me
                            </span>

                        </label>


                        <a href="#"
                           class="forgot-link">
                            Forgot password?
                        </a>

                    </div>


                    <!-- BUTTON -->

                    <button type="submit"
                            class="login-button">

                        <span>
                            Sign In as Administrator
                        </span>

                        <i class="fa-solid fa-chevron-right"></i>

                    </button>

                </form>

            </div>


            <!-- Security Footer -->

            <div class="security-footer">

                Protected by EduCore Security
                <span>·</span>
                TLS 1.3 Encrypted

            </div>

        </div>

    </section>

</div>


<!-- ========================================= -->
<!-- PASSWORD SHOW / HIDE -->
<!-- ========================================= -->

<script>

    const passwordInput =
        document.getElementById('password');

    const passwordToggle =
        document.getElementById('passwordToggle');

    const eyeIcon =
        document.getElementById('eyeIcon');


    passwordToggle.addEventListener('click', function () {

        if (passwordInput.type === 'password') {

            passwordInput.type = 'text';

            eyeIcon.classList.remove('fa-eye');

            eyeIcon.classList.add('fa-eye-slash');

            passwordToggle.setAttribute(
                'aria-label',
                'Hide password'
            );

        } else {

            passwordInput.type = 'password';

            eyeIcon.classList.remove('fa-eye-slash');

            eyeIcon.classList.add('fa-eye');

            passwordToggle.setAttribute(
                'aria-label',
                'Show password'
            );
        }

    });

</script>

</body>

</html>