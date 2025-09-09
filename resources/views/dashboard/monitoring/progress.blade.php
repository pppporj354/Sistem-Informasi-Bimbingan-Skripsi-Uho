<x-dashboard-layout title="Monitoring Progress Mahasiswa">
    <x-slot name="header">Monitoring Progress Mahasiswa</x-slot>

    <!-- Navigation Tabs -->
    <div class="nav-tabs-container mb-4">
        <ul class="nav nav-tabs" id="monitoringTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="{{ route('dashboard.monitoring.index') }}">
                    <i class="fas fa-list me-2"></i>Daftar Bimbingan
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="{{ route('dashboard.monitoring.workload') }}">
                    <i class="fas fa-chart-bar me-2"></i>Workload Dosen
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link active" href="{{ route('dashboard.monitoring.progress') }}">
                    <i class="fas fa-chart-line me-2"></i>Progress Mahasiswa
                </a>
            </li>
        </ul>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.monitoring.index') }}">Monitoring</a></li>
                    <li class="breadcrumb-item active">Progress Mahasiswa</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card p-3 mb-4">
        <form method="GET" action="{{ route('dashboard.monitoring.progress') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Dosen</label>
                <select name="lecturer_id" class="form-select">
                    <option value="all">Semua Dosen</option>
                    @foreach($lecturers as $lec)
                        <option value="{{ $lec->id }}" {{ ($filters['lecturer_id'] ?? '') == $lec->id ? 'selected' : '' }}>
                            {{ $lec->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Angkatan</label>
                <select name="batch" class="form-select">
                    <option value="">Semua</option>
                    @foreach($batches as $batch)
                        <option value="{{ $batch }}" {{ ($filters['batch'] ?? '') == $batch ? 'selected' : '' }}>
                            {{ $batch }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Cari (Nama/NIM)</label>
                <input type="text" class="form-control" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Ketik untuk mencari..." />
            </div>
            <div class="col-md-2 align-self-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2 align-self-end">
                <a href="{{ route('dashboard.monitoring.progress') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Pembimbing</th>
                        <th>Judul Skripsi</th>
                        <th>Total Bimbingan</th>
                        <th>Disetujui</th>
                        <th>Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>
                                {{ $student->user->name }}<br>
                                <small class="text-muted">{{ $student->nim }} - {{ $student->batch }}</small>
                            </td>
                            <td>
                                <div class="small">
                                    <strong>P1:</strong> {{ $student->firstSupervisor->user->name ?? '-' }}<br>
                                    <strong>P2:</strong> {{ $student->secondSupervisor->user->name ?? '-' }}
                                </div>
                            </td>
                            <td>{{ $student->thesis->title ?? 'Belum ada judul' }}</td>
                            <td>{{ $student->guidances_count }} sesi</td>
                            <td>{{ $student->approved_guidances_count }} sesi</td>
                            <td>
                                @php
                                    $progressPercentage = $student->guidances_count > 0
                                        ? ($student->approved_guidances_count / max($student->guidances_count, 1)) * 100
                                        : 0;
                                @endphp
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar
                                        @if($progressPercentage >= 80) bg-success
                                        @elseif($progressPercentage >= 60) bg-info
                                        @elseif($progressPercentage >= 40) bg-warning
                                        @else bg-danger
                                        @endif"
                                        role="progressbar"
                                        style="width: {{ $progressPercentage }}%"
                                        aria-valuenow="{{ $progressPercentage }}"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                        {{ number_format($progressPercentage, 0) }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $students->links() }}
        </div>
    </div>
</x-dashboard-layout>
