<x-auth-layout title="Login">
    <!-- Login Card -->
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card surface"
                style="border-radius: 20px; box-shadow: 0 20px 60px rgba(11, 61, 145, 0.15); backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                <div class="card-body p-4">
                    <!-- University Logo and Title -->
                    <div class="text-center mb-4">
                        <div
                            style="width: 70px; height: 70px; background: var(--uho-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 8px 20px rgba(255, 193, 7, 0.3);">
                            <i class="fas fa-graduation-cap"
                                style="color: var(--uho-primary); font-size: 28px;"></i>
                        </div>
                        <h4 class="fw-bold mb-2"
                            style="color: var(--uho-primary); font-size: 20px;">
                            SI Bimbingan Skripsi
                        </h4>
                        <p class="text-muted mb-0" style="font-size: 14px;">
                            Universitas Halu Oleo
                        </p>
                    </div>

                    <!-- Welcome Message -->
                    <div class="text-center mb-4">
                        <h5 class="fw-semibold mb-2" style="color: var(--uho-heading);">
                            Selamat Datang
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 13px;">
                            Silakan masuk dengan akun Anda
                        </p>
                    </div>

                    <!-- Login Form -->
                    <form method="post" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium"
                                style="color: var(--uho-text); font-size: 14px;">
                                <i class="fas fa-envelope me-2"
                                    style="color: var(--uho-primary);"></i>
                                Email Address
                            </label>
                            <input type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" placeholder="Masukkan email Anda"
                                value="{{ old('email') }}" autofocus
                                style="padding: 12px 16px; border-radius: 12px; border: 1px solid var(--uho-border); background: #fff;" />

                            @error('email')
                            <div class="invalid-feedback d-flex align-items-center"
                                style="font-size: 12px;">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                            @enderror

                            @if ($errors->any() && !$errors->has('email'))
                            <div class="text-danger d-flex align-items-center mt-2"
                                style="font-size: 12px;">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                @foreach ($errors->all() as $error)
                                {{ $error }}
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <!-- Password Input -->
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-medium mb-0" for="password"
                                    style="color: var(--uho-text); font-size: 14px;">
                                    <i class="fas fa-lock me-2"
                                        style="color: var(--uho-primary);"></i>
                                    Password
                                </label>
                                <a href="{{ route('password.request') }}"
                                    class="text-decoration-none"
                                    style="color: var(--uho-secondary); font-size: 12px;">
                                    <i class="fas fa-question-circle me-1"></i>
                                    Lupa Password?
                                </a>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="Masukkan password Anda"
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

                        <!-- Remember Me Checkbox -->
                        <div class="mb-4">
                            <div class="form-check d-flex align-items-center">
                                <input class="form-check-input" type="checkbox" id="remember"
                                    name="remember"
                                    style="border-radius: 6px; border: 1px solid var(--uho-border);" />
                                <label class="form-check-label ms-2" for="remember"
                                    style="color: var(--uho-text); font-size: 14px;">
                                    Ingat saya di perangkat ini
                                </label>
                            </div>
                        </div>

                        <!-- Login Button -->
                        <div class="mb-4">
                            <button class="btn btn-primary d-grid w-100 fw-semibold"
                                type="submit"
                                style="padding: 14px; border-radius: 12px; background: linear-gradient(135deg, var(--uho-primary), var(--uho-secondary)); border: none; box-shadow: 0 8px 20px rgba(11, 61, 145, 0.3);">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Masuk ke Sistem
                            </button>
                        </div>
                    </form>

                    <!-- Additional Info -->
                    <div class="text-center">
                        <div
                            style="background: rgba(11, 61, 145, 0.05); border-radius: 12px; padding: 16px;">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <i class="fas fa-info-circle me-2"
                                    style="color: var(--uho-info);"></i>
                                <span class="fw-medium"
                                    style="color: var(--uho-primary); font-size: 14px;">
                                    Bantuan Login
                                </span>
                            </div>
                            <p class="mb-2 text-muted" style="font-size: 12px;">
                                Gunakan email dan password yang telah diberikan oleh
                                administrator sistem.
                            </p>
                            <p class="mb-2 text-muted" style="font-size: 12px;">
                                Belum memiliki akun?
                                <a href="{{ route('register') }}"
                                    class="text-decoration-none fw-medium"
                                    style="color: var(--uho-secondary);">
                                    Daftar di sini
                                </a>
                            </p>
                            <p class="mb-0 text-muted" style="font-size: 12px;">
                                Kesulitan login? Hubungi admin di
                                <a href="mailto:admin@uho.ac.id"
                                    style="color: var(--uho-secondary);">admin@uho.ac.id</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
