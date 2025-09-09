<x-dashboard-layout title="Monitoring Workload Dosen">
    <x-slot name="header">Monitoring Workload Dosen</x-slot>

    <!-- Navigation Tabs -->
    <div class="nav-tabs-container mb-4">
        <ul class="nav nav-tabs" id="monitoringTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="{{ route('dashboard.monitoring.index') }}">
                    <i class="fas fa-list me-2"></i>Daftar Bimbingan
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link active" href="{{ route('dashboard.monitoring.workload') }}">
                    <i class="fas fa-chart-bar me-2"></i>Workload Dosen
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="{{ route('dashboard.monitoring.progress') }}">
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
                    <li class="breadcrumb-item active">Workload Dosen</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card p-3 mb-4">
        <form method="GET" action="{{ route('dashboard.monitoring.workload') }}" class="row g-3">
            <div class="col-md-4">
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
            <div class="col-md-4">
                <label class="form-label">Bulan</label>
                <input type="month" class="form-control" name="month" value="{{ $filters['month'] ?? '' }}" />
            </div>
            <div class="col-md-2 align-self-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2 align-self-end">
                <a href="{{ route('dashboard.monitoring.workload') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>Dosen</th>
                        <th>Jumlah Mahasiswa</th>
                        <th>Bimbingan Bulan Ini</th>
                        <th>Pending</th>
                        <th>Beban Kerja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workloadData as $data)
                        <tr>
                            <td>{{ $data['lecturer']->user->name }}</td>
                            <td>{{ $data['students_count'] }} mahasiswa</td>
                            <td>{{ $data['guidances_this_month'] }} sesi</td>
                            <td>
                                @if($data['pending_guidances'] > 0)
                                    <span class="badge bg-warning">{{ $data['pending_guidances'] }}</span>
                                @else
                                    <span class="badge bg-success">0</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $workload = $data['students_count'] + ($data['guidances_this_month'] * 0.5);
                                @endphp
                                @if($workload > 15)
                                    <span class="badge bg-danger">Tinggi ({{ number_format($workload, 1) }})</span>
                                @elseif($workload > 10)
                                    <span class="badge bg-warning">Sedang ({{ number_format($workload, 1) }})</span>
                                @else
                                    <span class="badge bg-success">Rendah ({{ number_format($workload, 1) }})</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard-layout>
