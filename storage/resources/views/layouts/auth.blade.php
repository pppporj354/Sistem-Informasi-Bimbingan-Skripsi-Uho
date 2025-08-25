<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="theme-uho">

@php
    $baseUrl = config('app.url');
    $baseUrl = explode('://', $baseUrl)[1];

    if (request()->secure()) {
        $baseUrl = 'https://' . $baseUrl;
    } else {
        $baseUrl = 'http://' . $baseUrl;
    }
@endphp

<head>
    <x-meta-data :title="$title" csrfToken="{{ csrf_token() }}" :baseurl="$baseUrl"/>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- UHO Theme Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <style>
        /* Inline critical styles to prevent FOUC */
        :root {
            --uho-primary: #0b3d91;
            --uho-secondary: #1b6dc1;
            --uho-accent: #ffc107;
            --uho-surface: #ffffff;
            --uho-border: #e5e7eb;
            --uho-text: #111827;
            --uho-muted: #6b7280;
        }

        body.theme-uho {
            font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, var(--uho-primary) 0%, var(--uho-secondary) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body class="theme-uho">
    <!-- University Background Pattern -->
    <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.05; z-index: 0; pointer-events: none;">
        <div style="background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><circle cx=\"50\" cy=\"50\" r=\"2\" fill=\"white\"/></svg>'); background-size: 50px 50px; width: 100%; height: 100%;"></div>
    </div>

    <div class="container-xxl position-relative" style="z-index: 1;">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- University Header -->
                <div class="text-center mb-5">
                    <div style="width: 100px; height: 100px; background: var(--uho-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);">
                        <i class="fas fa-university" style="color: var(--uho-primary); font-size: 40px;"></i>
                    </div>
                    <h2 class="text-white fw-bold mb-2">Universitas Halu Oleo</h2>
                    <p class="text-white opacity-75 mb-0">Sistem Informasi Bimbingan Skripsi</p>
                    <p class="text-white opacity-50" style="font-size: 14px;">Program Studi Pendidikan Teknologi Informasi dan Komunikasi</p>
                </div>

                {{ $slot }}

                <!-- Footer -->
                <div class="text-center mt-4">
                    <p class="text-white opacity-50" style="font-size: 12px;">
                        &copy; {{ date('Y') }} Universitas Halu Oleo. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Password Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            const passwordToggles = document.querySelectorAll('.form-password-toggle');

            passwordToggles.forEach(function(toggle) {
                const toggleButton = toggle.querySelector('.input-group-text');
                const passwordInput = toggle.querySelector('input[type="password"]');
                const icon = toggleButton.querySelector('i');

                if (toggleButton && passwordInput && icon) {
                    toggleButton.addEventListener('click', function() {
                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                            icon.classList.remove('bx-hide');
                            icon.classList.add('bx-show');
                        } else {
                            passwordInput.type = 'password';
                            icon.classList.remove('bx-show');
                            icon.classList.add('bx-hide');
                        }
                    });
                }
            });

            // Form validation feedback
            const forms = document.querySelectorAll('form');
            forms.forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    const requiredFields = form.querySelectorAll('[required]');
                    let isValid = true;

                    requiredFields.forEach(function(field) {
                        if (!field.value.trim()) {
                            field.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) {
                        event.preventDefault();
                    }
                });
            });

            // Real-time validation
            const inputs = document.querySelectorAll('.form-control, .form-select');
            inputs.forEach(function(input) {
                input.addEventListener('blur', function() {
                    if (input.hasAttribute('required') && !input.value.trim()) {
                        input.classList.add('is-invalid');
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                input.addEventListener('input', function() {
                    if (input.classList.contains('is-invalid') && input.value.trim()) {
                        input.classList.remove('is-invalid');
                    }
                });
            });
        });
    </script>
</body>
</html>
