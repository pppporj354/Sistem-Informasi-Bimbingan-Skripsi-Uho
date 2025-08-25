<x-auth-layout title="Verifikasi Email">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card surface" style="border-radius: 20px; box-shadow: 0 20px 60px rgba(11, 61, 145, 0.15); backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                <div class="card-body p-4">
                    <!-- University Logo and Title -->
                    <div class="text-center mb-4">
                        <div style="width: 70px; height: 70px; background: rgba(245, 158, 11, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 8px 20px rgba(245, 158, 11, 0.2);">
                            <i class="fas fa-envelope-open" style="color: var(--uho-warning); font-size: 28px;"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: var(--uho-primary); font-size: 20px;">
                            Verifikasi Email
                        </h4>
                        <p class="text-muted mb-0" style="font-size: 14px;">
                            Universitas Halu Oleo
                        </p>
                    </div>

                    <!-- Verification Message -->
                    <div class="text-center mb-4">
                        <h5 class="fw-semibold mb-2" style="color: var(--uho-heading);">
                            Cek Email Anda
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 13px; line-height: 1.5;">
                            Kami telah mengirimkan link verifikasi ke email Anda. Silakan cek email dan klik link verifikasi untuk melanjutkan.
                        </p>
                    </div>

                    <!-- Status Message -->
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success d-flex align-items-center mb-4" style="border-radius: 12px; border: none; background: rgba(22, 163, 74, 0.1); color: var(--uho-success);">
                            <i class="fas fa-check-circle me-2"></i>
                            <span style="font-size: 14px;">
                                Link verifikasi baru telah dikirim ke email yang Anda daftarkan.
                            </span>
                        </div>
                    @endif

                    <!-- Resend Verification Email Form -->
                    <div class="mb-4">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button class="btn btn-warning d-grid w-100 fw-semibold"
                                    type="submit"
                                    style="padding: 14px; border-radius: 12px; background: linear-gradient(135deg, var(--uho-accent), var(--uho-accent-600)); border: none; color: var(--uho-primary); box-shadow: 0 8px 20px rgba(255, 193, 7, 0.3);">
                                <i class="fas fa-paper-plane me-2"></i>
                                Kirim Ulang Email Verifikasi
                            </button>
                        </form>
                    </div>

                    <!-- Logout Option -->
                    <div class="text-center mb-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="btn btn-outline-secondary"
                                    style="border-radius: 12px; border-color: var(--uho-border);">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>

                    <!-- Verification Instructions -->
                    <div style="background: rgba(11, 61, 145, 0.05); border-radius: 12px; padding: 16px;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-info-circle me-2" style="color: var(--uho-info);"></i>
                            <span class="fw-medium" style="color: var(--uho-primary); font-size: 14px;">
                                Instruksi Verifikasi
                            </span>
                        </div>
                        <ul class="mb-0 text-muted" style="font-size: 12px; padding-left: 16px; line-height: 1.4;">
                            <li>Periksa kotak masuk email Anda</li>
                            <li>Cari email dari sistem SIBS UHO</li>
                            <li>Klik link verifikasi dalam email</li>
                            <li>Periksa folder spam jika email tidak ditemukan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
