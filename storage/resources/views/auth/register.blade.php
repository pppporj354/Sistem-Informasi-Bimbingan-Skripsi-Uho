<x-auth-layout title="Registrasi">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <div class="card surface" style="border-radius: 20px; box-shadow: 0 20px 60px rgba(11, 61, 145, 0.15); backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                <div class="card-body">
                    <!-- University Logo and Title -->
                    <div class="text-center mb-4">
                        <div style="width: 70px; height: 70px; background: var(--uho-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 8px 20px rgba(255, 193, 7, 0.3);">
                            <i class="fas fa-user-plus" style="color: var(--uho-primary); font-size: 28px;"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: var(--uho-primary); font-size: 20px;">
                            Registrasi Akun
                        </h4>
                        <p class="text-muted mb-0" style="font-size: 14px;">
                            SI Bimbingan Skripsi - Universitas Halu Oleo
                        </p>
                    </div>

                    <!-- Welcome Message -->
                    <div class="text-center mb-4">
                        <h5 class="fw-semibold mb-2" style="color: var(--uho-heading);">
                            Bergabung dengan Sistem
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 13px;">
                            Buat akun baru untuk mengakses layanan bimbingan skripsi
                        </p>
                    </div>

                    <!-- Registration Form -->
                    <form method="POST" action="{{ route('register') }}" novalidate>
                        @csrf

                        <!-- Name Input -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium">
                                <i class="fas fa-user me-2" style="color: var(--uho-primary);"></i>
                                Nama Lengkap
                            </label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   placeholder="Masukkan nama lengkap Anda"
                                   value="{{ old('name') }}"
                                   required
                                   autofocus />

                            @error('name')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">
                                <i class="fas fa-envelope me-2" style="color: var(--uho-primary);"></i>
                                Email Address
                            </label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   placeholder="Masukkan email Anda"
                                   value="{{ old('email') }}"
                                   required />

                            @error('email')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Role Selection -->
                        <div class="mb-3">
                            <label for="role" class="form-label fw-medium">
                                <i class="fas fa-user-tag me-2" style="color: var(--uho-primary);"></i>
                                Peran dalam Sistem
                            </label>
                            <select class="form-select @error('role') is-invalid @enderror"
                                    id="role"
                                    name="role"
                                    required>
                                <option value="">Pilih peran Anda</option>
                                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Mahasiswa</option>
                                <option value="lecturer" {{ old('role') == 'lecturer' ? 'selected' : '' }}>Dosen</option>
                            </select>

                            @error('role')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label fw-medium" for="password">
                                <i class="fas fa-lock me-2" style="color: var(--uho-primary);"></i>
                                Password
                            </label>
                            <div class="input-group input-group-merge">
                                <input type="password"
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password"
                                       placeholder="Buat password yang kuat"
                                       required />
                                <span class="input-group-text cursor-pointer">
                                    <i class="bx bx-hide" style="color: var(--uho-muted);"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="mb-4 form-password-toggle">
                            <label class="form-label fw-medium" for="password_confirmation">
                                <i class="fas fa-lock me-2" style="color: var(--uho-primary);"></i>
                                Konfirmasi Password
                            </label>
                            <div class="input-group input-group-merge">
                                <input type="password"
                                       id="password_confirmation"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       name="password_confirmation"
                                       placeholder="Ulangi password Anda"
                                       required />
                                <span class="input-group-text cursor-pointer">
                                    <i class="bx bx-hide" style="color: var(--uho-muted);"></i>
                                </span>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-4">
                            <div class="form-check d-flex align-items-start">
                                <input class="form-check-input mt-1 @error('terms') is-invalid @enderror"
                                       type="checkbox"
                                       id="terms"
                                       name="terms"
                                       value="1"
                                       {{ old('terms') ? 'checked' : '' }}
                                       required />
                                <label class="form-check-label ms-2" for="terms" style="color: var(--uho-text); font-size: 13px; line-height: 1.4;">
                                    Saya menyetujui
                                    <a href="#" style="color: var(--uho-secondary);">syarat dan ketentuan</a>
                                    serta
                                    <a href="#" style="color: var(--uho-secondary);">kebijakan privasi</a>
                                    yang berlaku di Sistem Informasi Bimbingan Skripsi UHO.
                                </label>
                            </div>
                            @error('terms')
                                <div class="text-danger d-flex align-items-center mt-2" style="font-size: 12px;">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Register Button -->
                        <div class="mb-4">
                            <button class="btn btn-primary d-grid w-100 fw-semibold" type="submit">
                                <span class="d-flex align-items-center justify-content-center gap-2">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Daftar Akun</span>
                                </span>
                            </button>
                        </div>
                    </form>

                    <!-- Login Link -->
                    <div class="text-center mb-4">
                        <p class="mb-0 text-muted" style="font-size: 14px;">
                            Sudah memiliki akun?
                            <a href="{{ route('login') }}"
                               class="text-decoration-none fw-medium"
                               style="color: var(--uho-secondary);">
                                Masuk di sini
                            </a>
                        </p>
                    </div>

                    <!-- Registration Info -->
                    <div class="info-box">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-info-circle me-2" style="color: var(--uho-info);"></i>
                            <span class="fw-medium" style="color: var(--uho-primary); font-size: 14px;">
                                Informasi Registrasi
                            </span>
                        </div>
                        <ul class="mb-0 text-muted" style="font-size: 12px; line-height: 1.4;">
                            <li>Akun akan diverifikasi oleh administrator</li>
                            <li>Gunakan email yang valid dan aktif</li>
                            <li>Password minimal 8 karakter dengan kombinasi huruf dan angka</li>
                            <li>Hubungi admin jika mengalami kesulitan: admin@uho.ac.id</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
