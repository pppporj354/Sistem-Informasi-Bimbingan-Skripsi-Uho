<x-auth-layout title="Lupa Password">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card surface"
                style="border-radius: 20px; box-shadow: 0 20px 60px rgba(11, 61, 145, 0.15); backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                <div class="card-body p-4">
                    <!-- University Logo and Title -->
                    <div class="text-center mb-4">
                        <div
                            style="width: 70px; height: 70px; background: rgba(255, 193, 7, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 8px 20px rgba(255, 193, 7, 0.2);">
                            <i class="fas fa-lock" style="color: var(--uho-warning); font-size: 28px;"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: var(--uho-primary); font-size: 20px;">
                            Reset Password
                        </h4>
                        <p class="text-muted mb-0" style="font-size: 14px;">
                            Universitas Halu Oleo
                        </p>
                    </div>

                    <!-- Reset Password Message -->
                    <div class="text-center mb-4">
                        <h5 class="fw-semibold mb-2" style="color: var(--uho-heading);">
                            Lupa Password? 🔒
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 13px; line-height: 1.5;">
                            Tidak masalah! Masukkan email Anda dan kami akan mengirimkan instruksi untuk mereset password
                            Anda.
                        </p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                    <div class="alert alert-success d-flex align-items-center mb-4"
                        style="border-radius: 12px; border: none; background: rgba(22, 163, 74, 0.1); color: var(--uho-success);">
                        <i class="fas fa-check-circle me-2"></i>
                        <span style="font-size: 14px;">{{ session('status') }}</span>
                    </div>
                    @endif

                    <!-- Reset Password Form -->
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Input -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium"
                                style="color: var(--uho-text); font-size: 14px;">
                                <i class="fas fa-envelope me-2" style="color: var(--uho-primary);"></i>
                                Email Address
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" autofocus
                                style="padding: 12px 16px; border-radius: 12px; border: 1px solid var(--uho-border); background: #fff;" />

                            @error('email')
                            <div class="invalid-feedback d-flex align-items-center" style="font-size: 12px;">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                            @enderror

                            @if ($errors->any() && !$errors->has('email'))
                            <div class="text-danger d-flex align-items-center mt-2" style="font-size: 12px;">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                @foreach ($errors->all() as $error)
                                {{ $error }}
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="mb-4">
                            <button class="btn btn-warning d-grid w-100 fw-semibold" type="submit"
                                style="padding: 14px; border-radius: 12px; background: linear-gradient(135deg, var(--uho-accent), var(--uho-accent-600)); border: none; color: var(--uho-primary); box-shadow: 0 8px 20px rgba(255, 193, 7, 0.3);">
                                <i class="fas fa-paper-plane me-2"></i>
                                Kirim Link Reset Password
                            </button>
                        </div>
                    </form>

                    <!-- Back to Login -->
                    <div class="text-center">
                        <a href="{{ route('login') }}"
                            class="d-flex align-items-center justify-content-center text-decoration-none"
                            style="color: var(--uho-secondary); font-size: 14px;">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali ke halaman login
                        </a>
                    </div>

                    <!-- Additional Info -->
                    <div class="mt-4">
                        <div style="background: rgba(11, 61, 145, 0.05); border-radius: 12px; padding: 16px;">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <i class="fas fa-info-circle me-2" style="color: var(--uho-info);"></i>
                                <span class="fw-medium" style="color: var(--uho-primary); font-size: 14px;">
                                    Informasi Reset Password
                                </span>
                            </div>
                            <p class="mb-2 text-muted" style="font-size: 12px;">
                                Link reset password akan dikirim ke email yang terdaftar di sistem.
                            </p>
                            <p class="mb-0 text-muted" style="font-size: 12px;">
                                Periksa folder spam jika email tidak diterima dalam 5 menit.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
