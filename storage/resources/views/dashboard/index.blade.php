<x-dashboard-layout title="Dashboard">
    <x-slot name="header">
        Dashboard Administrator
    </x-slot>
    <x-slot name="header_subtitle">
        Selamat datang di Sistem Informasi Bimbingan Skripsi Universitas Halu Oleo
    </x-slot>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="stats-icon mb-3">
                                <i class="fas fa-chalkboard-user"></i>
                            </div>
                            <h6 class="fw-semibold text-muted mb-2">Total Dosen</h6>
                            <h3 class="fw-bold mb-0 text-uho-primary">{{ $totalLecturers }}</h3>
                            <small class="text-success mt-1">
                                <i class="fas fa-arrow-up me-1"></i>
                                Aktif dalam sistem
                            </small>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0 text-uho-muted" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <h6 class="dropdown-header">Aksi</h6>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('dashboard.lecturer.index') }}">
                                    <i class="fas fa-list me-2 text-uho-primary"></i>
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="stats-icon mb-3" style="background: linear-gradient(135deg, var(--uho-success), #10b981);">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h6 class="fw-semibold text-muted mb-2">Total Mahasiswa</h6>
                            <h3 class="fw-bold mb-0 text-uho-primary">{{ $totalStudents }}</h3>
                            <small class="text-success mt-1">
                                <i class="fas fa-arrow-up me-1"></i>
                                Terdaftar aktif
                            </small>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0 text-uho-muted" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <h6 class="dropdown-header">Aksi</h6>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('dashboard.student.index') }}">
                                    <i class="fas fa-list me-2 text-uho-success"></i>
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="stats-icon mb-3" style="background: linear-gradient(135deg, var(--uho-accent), #f59e0b);">
                                <i class="fas fa-comments"></i>
                            </div>
                            <h6 class="fw-semibold text-muted mb-2">Total Bimbingan</h6>
                            <h3 class="fw-bold mb-0 text-uho-primary">{{ $totalGuidances }}</h3>
                            <small class="text-warning mt-1">
                                <i class="fas fa-clock me-1"></i>
                                Sedang berjalan
                            </small>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0 text-uho-muted" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <h6 class="dropdown-header">Aksi</h6>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('dashboard.aktivitas-bimbingan.index') }}">
                                    <i class="fas fa-list me-2 text-uho-accent"></i>
                                    Lihat Aktivitas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="stats-icon mb-3" style="background: linear-gradient(135deg, var(--uho-info), #06b6d4);">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <h6 class="fw-semibold text-muted mb-2">Total Ujian Hasil</h6>
                            <h3 class="fw-bold mb-0 text-uho-primary">{{ $totalExamResults }}</h3>
                            <small class="text-info mt-1">
                                <i class="fas fa-check-circle me-1"></i>
                                Telah diselesaikan
                            </small>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0 text-uho-muted" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <h6 class="dropdown-header">Aksi</h6>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('dashboard.ujian-hasil.index') }}">
                                    <i class="fas fa-list me-2 text-uho-info"></i>
                                    Lihat Ujian
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 fw-semibold text-uho-primary">
                        <i class="fas fa-rocket me-2 text-uho-accent"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('dashboard.student.create') }}" class="btn w-100 text-start" style="background: rgba(11, 61, 145, 0.1); color: var(--uho-primary); border-radius: 12px; padding: 16px;">
                                <i class="fas fa-user-plus mb-2" style="font-size: 20px;"></i>
                                <div class="fw-semibold">Tambah Mahasiswa</div>
                                <small class="text-muted">Daftarkan mahasiswa baru</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('dashboard.lecturer.create') }}" class="btn w-100 text-start" style="background: rgba(22, 163, 74, 0.1); color: var(--uho-success); border-radius: 12px; padding: 16px;">
                                <i class="fas fa-chalkboard-user mb-2" style="font-size: 20px;"></i>
                                <div class="fw-semibold">Tambah Dosen</div>
                                <small class="text-muted">Daftarkan dosen pembimbing</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('dashboard.kajur.create') }}" class="btn w-100 text-start" style="background: rgba(255, 193, 7, 0.1); color: var(--uho-accent); border-radius: 12px; padding: 16px;">
                                <i class="fas fa-user-tie mb-2" style="font-size: 20px;"></i>
                                <div class="fw-semibold">Tambah Kajur</div>
                                <small class="text-muted">Daftarkan ketua jurusan</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('dashboard.aktivitas-bimbingan.index') }}" class="btn w-100 text-start" style="background: rgba(14, 165, 233, 0.1); color: var(--uho-info); border-radius: 12px; padding: 16px;">
                                <i class="fas fa-chart-line mb-2" style="font-size: 20px;"></i>
                                <div class="fw-semibold">Lihat Aktivitas</div>
                                <small class="text-muted">Monitor bimbingan</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 fw-semibold text-uho-primary">
                <i class="fas fa-history me-2 text-uho-accent"></i>
                Daftar Mahasiswa Yang Telah Melakukan Bimbingan
            </h5>
        </div>
        <div class="card-body">
            @if($studentsWithGuidances->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="table">
                        <thead>
                            <tr>
                                <th class="fw-semibold">
                                    <i class="fas fa-hashtag me-2"></i>NIM
                                </th>
                                <th class="fw-semibold">
                                    <i class="fas fa-user me-2"></i>NAMA
                                </th>
                                <th class="fw-semibold">
                                    <i class="fas fa-book me-2"></i>JUDUL SKRIPSI
                                </th>
                                <th class="fw-semibold">
                                    <i class="fas fa-user-tie me-2"></i>DOSEN PEMBIMBING 1
                                </th>
                                <th class="fw-semibold">
                                    <i class="fas fa-user-graduate me-2"></i>DOSEN PEMBIMBING 2
                                </th>
                                <th class="fw-semibold text-center">
                                    <i class="fas fa-comments me-2"></i>TOTAL BIMBINGAN
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($studentsWithGuidances as $student)
                                <tr>
                                    <td class="fw-medium">
                                        <span class="badge bg-uho-primary text-white">
                                            {{ $student->formattedNIM }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3">
                                                @if($student->user->photo)
                                                    <img src="{{ $student->user->photoFile }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;" alt="{{ $student->fullname }}">
                                                @else
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--uho-accent), #f59e0b); color: white; font-weight: bold; font-size: 12px;">
                                                        {{ substr($student->fullname, 0, 2) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $student->fullname }}</div>
                                                <small class="text-muted">Angkatan {{ $student->angkatan }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium" style="max-width: 300px;">
                                            {{ $student->latestThesis->title ?? 'Belum ditentukan' }}
                                        </div>
                                        @if($student->latestThesis)
                                            <small class="text-muted">{{ Str::limit($student->latestThesis->topic, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($student->firstSupervisor)
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-xs me-2">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-uho-primary text-white" style="width: 24px; height: 24px; font-size: 10px;">
                                                        <i class="fas fa-user-tie"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-medium">{{ $student->firstSupervisor->fullname }}</div>
                                                    <small class="text-muted">NIDN: {{ $student->firstSupervisor->nidn }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Belum ditetapkan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($student->secondSupervisor)
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-xs me-2">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-uho-secondary text-white" style="width: 24px; height: 24px; font-size: 10px;">
                                                        <i class="fas fa-user-graduate"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-medium">{{ $student->secondSupervisor->fullname }}</div>
                                                    <small class="text-muted">NIDN: {{ $student->secondSupervisor->nidn }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Belum ditetapkan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill bg-uho-success text-white" style="font-size: 14px; padding: 8px 12px;">
                                            {{ $student->guidances_count }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <p class="mb-0">Belum ada data bimbingan tersedia</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h5>Belum ada aktivitas bimbingan</h5>
                    <p class="mb-0">Data akan muncul setelah mahasiswa mulai melakukan bimbingan</p>
                </div>
            @endif
        </div>
    </div>
</x-dashboard-layout>
