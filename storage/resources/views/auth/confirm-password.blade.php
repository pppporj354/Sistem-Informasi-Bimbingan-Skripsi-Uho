<x-auth-layout title="Konfirmasi Password">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card surface" style="border-radius: 20px; box-shadow: 0 20px 60px rgba(11, 61, 145, 0.15); backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                <div class="card-body p-4">
                    <!-- University Logo and Title -->
                    <div class="text-center mb-4">
                        <div style="width: 70px; height: 70px; background: rgba(14, 165, 233, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 8px 20px rgba(14, 165, 233, 0.2);">
                            <i class="fas fa-shield-alt" style="color: var(--uho-info); font-size: 28px;"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: var(--uho-primary); font-size: 20px;">
                            Konfirmasi Password
                        </h4>
                        <p class="text-muted mb-0" style="font-size: 14px;">
                            Universitas Halu Oleo
                        </p>
                    </div>

                    <!-- Confirmation Message -->
                    <div class="text-center mb-4">
                        <h5 class="fw-semibold mb-2" style="color: var(--uho-heading);">
                            Verifikasi Keamanan
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 13px; line-height: 1.5;">
                            Untuk melanjutkan, silakan konfirmasi password Anda terlebih dahulu sebagai langkah keamanan.
                        </p>
                    </div>

                    <!-- Confirmation Form -->
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <!-- Password Input -->
                        <div class="mb-4 form-password-toggle">
                            <label class="form-label fw-medium" for="password" style="color: var(--uho-text); font-size: 14px;">
                                <i class="fas fa-lock me-2" style="color: var(--uho-primary);"></i>
                                Password Anda
                            </label>
                            <div class="input-group input-group-merge">
                                <input type="password"
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password"
                                       placeholder="Masukkan password Anda"
                                       autofocus
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

                        <!-- Submit Button -->
                        <div class="mb-4">
                            <button class="btn btn-info d-grid w-100 fw-semibold"
                                    type="submit"
                                    style="padding: 14px; border-radius: 12px; background: linear-gradient(135deg, var(--uho-info), #0284c7); border: none; box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);">
                                <i class="fas fa-check-shield me-2"></i>
                                Konfirmasi Password
                            </button>
                        </div>
                    </form>

                    <!-- Security Note -->
                    <div style="background: rgba(11, 61, 145, 0.05); border-radius: 12px; padding: 16px;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-info-circle me-2" style="color: var(--uho-info);"></i>
                            <span class="fw-medium" style="color: var(--uho-primary); font-size: 14px;">
                                Catatan Keamanan
                            </span>
                        </div>
                        <p class="mb-0 text-muted" style="font-size: 12px; line-height: 1.4;">
                            Verifikasi password diperlukan untuk mengakses area yang memerlukan tingkat keamanan tinggi dalam sistem.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
