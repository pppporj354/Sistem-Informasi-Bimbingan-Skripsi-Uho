
<x-dashboard-layout title="Dashboard Mahasiswa">
    <x-slot name="header">
        Selamat Datang, {{ Auth::user()->name }}!
    </x-slot>
    <x-slot name="header_subtitle">
        Sistem Informasi Bimbingan Skripsi - Universitas Halu Oleo
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--uho-primary), var(--uho-secondary)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="fas fa-user-graduate" style="font-size: 40px; color: white;"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold text-uho-primary mb-3">Akun Anda Berhasil Didaftarkan!</h4>
                    <p class="text-muted mb-4">
                        Selamat datang di Sistem Informasi Bimbingan Skripsi UHO.
                        Akun Anda sedang dalam proses verifikasi oleh administrator.
                    </p>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                <div class="text-start">
                                    <strong>Langkah selanjutnya:</strong><br>
                                    1. Tunggu verifikasi dari administrator<br>
                                    2. Dosen pembimbing akan ditetapkan oleh admin<br>
                                    3. Anda akan mendapat notifikasi melalui email
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-user-edit me-2"></i>
                            Lengkapi Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
