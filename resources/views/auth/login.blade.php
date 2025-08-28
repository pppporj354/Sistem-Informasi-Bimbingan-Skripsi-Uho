<x-auth-layout title="Login">
    <!-- Login Card -->
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card surface"
                style="border-radius: 20px; box-shadow: 0 20px 60px rgba(11, 61, 145, 0.15); backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                <div class="card-body p-4">
                    <!-- University Logo and Title -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('logo-uho.png') }}"
                             alt="UHO Logo"
                             style="width: 70px; height: 70px; object-fit: contain;">
                        <h4 class="fw-bold mb-2"
                            style="color: var(--uho-primary); font-size: 20px;">
                            Masuk ke Sistem
                        </h4>
                        <p class="text-muted mb-0" style="font-size: 14px;">
                            SI Bimbingan Skripsi - Universitas Halu Oleo
                        </p>
                    </div>

                    <!-- Welcome Message -->
                    <div class="text-center mb-4">
                        <h5 class="fw-semibold mb-2" style="color: var(--uho-heading);">
                            Selamat Datang Kembali
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 13px;">
                            Masukkan kredensial Anda untuk mengakses akun
                        </p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert"
                             style="border-radius: 12px; border: none; background: rgba(22, 163, 74, 0.1); color: var(--uho-success);">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                <span>{{ session('status') }}</span>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" novalidate>
                        @csrf

                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium"
                                style="color: var(--uho-text); font-size: 14px;">
                                <i class="fas fa-envelope me-2"
                                    style="color: var(--uho-primary);"></i>
                                Email atau Username
                            </label>
                            <input type="text"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                placeholder="Masukkan email atau username Anda"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                style="padding: 12px 16px; border-radius: 12px; border: 1px solid var(--uho-border); background: #fff;" />

                            @error('email')
                            <div class="invalid-feedback d-flex align-items-center"
                                style="font-size: 12px;">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-medium mb-0" for="password"
                                    style="color: var(--uho-text); font-size: 14px;">
                                    <i class="fas fa-lock me-2"
                                        style="color: var(--uho-primary);"></i>
                                    Kata Sandi
                                </label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                        class="text-decoration-none"
                                        style="color: var(--uho-secondary); font-size: 12px;">
                                        Lupa kata sandi?
                                    </a>
                                @endif
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    placeholder="Masukkan kata sandi Anda"
                                    required
                                    style="padding: 12px 16px; border-radius: 12px 0 0 12px; border: 1px solid var(--uho-border); background: #fff;" />
                                <span class="input-group-text cursor-pointer"
                                    style="border-radius: 0 12px 12px 0; border: 1px solid var(--uho-border); border-left: none; background: #fff;">
                                    <i class="bx bx-hide" style="color: var(--uho-muted);"></i>
                                </span>
                            </div>
                            @error('password')
                            <div class="invalid-feedback d-flex align-items-center"
                                style="font-size: 12px;">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-4">
                            <div class="form-check d-flex align-items-center">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="remember_me"
                                       name="remember"
                                       style="border-radius: 4px;" />
                                <label class="form-check-label ms-2"
                                       for="remember_me"
                                       style="color: var(--uho-text); font-size: 14px;">
                                    Ingat saya
                                </label>
                            </div>
                        </div>

                        <!-- Login Button -->
                        <div class="mb-4">
                            <button class="btn btn-primary d-grid w-100 fw-semibold"
                                type="submit"
                                style="padding: 14px; border-radius: 12px; background: linear-gradient(135deg, var(--uho-primary), var(--uho-secondary)); border: none; box-shadow: 0 8px 20px rgba(11, 61, 145, 0.3);">
                                <span class="d-flex align-items-center justify-content-center gap-2">
                                    <i class="fas fa-sign-in-alt"></i>
                                    <span>Masuk ke Akun</span>
                                </span>
                            </button>
                        </div>
                    </form>

                    <!-- Register Link -->
                    <div class="text-center mb-4">
                        <p class="mb-0 text-muted" style="font-size: 14px;">
                            Belum memiliki akun?
                            <a href="{{ route('register') }}"
                               class="text-decoration-none fw-medium"
                               style="color: var(--uho-secondary);">
                                Daftar di sini
                            </a>
                        </p>
                    </div>

                    <!-- Additional Info -->
                    <div class="text-center">
                        <div
                            style="background: rgba(11, 61, 145, 0.05); border-radius: 12px; padding: 16px;">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <i class="fas fa-info-circle me-2"
                                    style="color: var(--uho-info);"></i>
                                <span class="fw-medium"
                                    style="color: var(--uho-primary); font-size: 14px;">
                                    Panduan Login
                                </span>
                            </div>
                            <p class="mb-2 text-muted" style="font-size: 12px;">
                                Gunakan email atau username yang telah terdaftar
                            </p>
                            <p class="mb-2 text-muted" style="font-size: 12px;">
                                Pastikan kata sandi Anda benar dan sesuai
                            </p>
                            <p class="mb-0 text-muted" style="font-size: 12px;">
                                Kesulitan masuk? Hubungi admin di
                                <a href="mailto:admin@uho.ac.id"
                                    style="color: var(--uho-secondary);">admin@uho.ac.id</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordToggles = document.querySelectorAll('.form-password-toggle');

            passwordToggles.forEach(function(toggle) {
                const passwordInput = toggle.querySelector('input[type="password"]');
                const toggleButton = toggle.querySelector('.input-group-text');
                const toggleIcon = toggleButton.querySelector('i');

                toggleButton.addEventListener('click', function() {
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        toggleIcon.classList.remove('bx-hide');
                        toggleIcon.classList.add('bx-show');
                    } else {
                        passwordInput.type = 'password';
                        toggleIcon.classList.remove('bx-show');
                        toggleIcon.classList.add('bx-hide');
                    }
                });
            });
        });
    </script>
</x-auth-layout>
