<x-auth-layout title="Reset Password">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card surface" style="border-radius: 20px; box-shadow: 0 20px 60px rgba(11, 61, 145, 0.15); backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                <div class="card-body p-4">
                    <!-- University Logo and Title -->
                    <div class="text-center mb-4">
                        <div style="width: 70px; height: 70px; background: rgba(22, 163, 74, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 8px 20px rgba(22, 163, 74, 0.2);">
                            <i class="fas fa-key" style="color: var(--uho-success); font-size: 28px;"></i>
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
                            Buat Password Baru
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 13px; line-height: 1.5;">
                            Masukkan password baru untuk akun Anda. Pastikan password yang kuat dan mudah diingat.
                        </p>
                    </div>

                    <!-- Reset Password Form -->
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium" style="color: var(--uho-text); font-size: 14px;">
                                <i class="fas fa-envelope me-2" style="color: var(--uho-primary);"></i>
                                Email Address
                            </label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   placeholder="Masukkan email Anda"
                                   value="{{ old('email', $request->email) }}"
                                   autofocus
                                   style="padding: 12px 16px; border-radius: 12px; border: 1px solid var(--uho-border); background: #fff;" />

                            @error('email')
                                <div class="invalid-feedback d-flex align-items-center" style="font-size: 12px;">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- New Password Input -->
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label fw-medium" for="password" style="color: var(--uho-text); font-size: 14px;">
                                <i class="fas fa-lock me-2" style="color: var(--uho-primary);"></i>
                                Password Baru
                            </label>
                            <div class="input-group input-group-merge">
                                <input type="password"
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password"
                                       placeholder="Masukkan password baru"
                                       style="padding: 12px 16px; border-radius: 12px 0 0 12px; border: 1px solid var(--uho-border); background: #fff;" />
                                <span class="input-group-text cursor-pointer" style="border-radius: 0 12px 12px 0; border: 1px solid var(--uho-border); border-left: none; background: #fff;">
                                    <i class="bx bx-hide" style="color: var(--uho-muted);"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-flex align-items-center" style="font-size: 12px;">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="mb-4 form-password-toggle">
                            <label class="form-label fw-medium" for="password_confirmation" style="color: var(--uho-text); font-size: 14px;">
                                <i class="fas fa-lock me-2" style="color: var(--uho-primary);"></i>
                                Konfirmasi Password Baru
                            </label>
                            <div class="input-group input-group-merge">
                                <input type="password"
                                       id="password_confirmation"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       name="password_confirmation"
                                       placeholder="Ulangi password baru"
                                       style="padding: 12px 16px; border-radius: 12px 0 0 12px; border: 1px solid var(--uho-border); background: #fff;" />
                                <span class="input-group-text cursor-pointer" style="border-radius: 0 12px 12px 0; border: 1px solid var(--uho-border); border-left: none; background: #fff;">
                                    <i class="bx bx-hide" style="color: var(--uho-muted);"></i>
                                </span>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-flex align-items-center" style="font-size: 12px;">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="mb-4">
                            <button class="btn btn-success d-grid w-100 fw-semibold"
                                    type="submit"
                                    style="padding: 14px; border-radius: 12px; background: linear-gradient(135deg, var(--uho-success), #10b981); border: none; box-shadow: 0 8px 20px rgba(22, 163, 74, 0.3);">
                                <i class="fas fa-check-circle me-2"></i>
                                Reset Password
                            </button>
                        </div>
                    </form>

                    <!-- Password Requirements -->
                    <div style="background: rgba(11, 61, 145, 0.05); border-radius: 12px; padding: 16px;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-shield-alt me-2" style="color: var(--uho-info);"></i>
                            <span class="fw-medium" style="color: var(--uho-primary); font-size: 14px;">
                                Syarat Password
                            </span>
                        </div>
                        <ul class="mb-0 text-muted" style="font-size: 12px; padding-left: 16px;">
                            <li>Minimal 8 karakter</li>
                            <li>Kombinasi huruf besar dan kecil</li>
                            <li>Mengandung angka</li>
                            <li>Mengandung simbol khusus</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
