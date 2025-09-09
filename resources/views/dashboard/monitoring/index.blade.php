<x-dashboard-layout title="Monitoring Bimbingan">
    <x-slot name="header">Monitoring Bimbingan</x-slot>

    <!-- Navigation Tabs -->
    <div class="nav-tabs-container mb-4">
        <ul class="nav nav-tabs" id="monitoringTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" href="{{ route('dashboard.monitoring.index') }}">
                    <i class="fas fa-list me-2"></i>Daftar Bimbingan
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="{{ route('dashboard.monitoring.workload') }}">
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
        <div class="col-md-3">
            <div class="card p-3">
                <div class="text-muted">Total</div>
                <div class="fs-4 fw-bold">{{ $stats['total'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <div class="text-muted">Pending</div>
                <div class="fs-4 fw-bold">{{ $stats['pending'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <div class="text-muted">Disetujui</div>
                <div class="fs-4 fw-bold">{{ $stats['approved'] }}</div>
            </div>
        </div>
    </div>

    <div class="card p-3 mb-4">
        <form method="GET" action="{{ route('dashboard.monitoring.index') }}" class="row g-3">
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="pending" {{ ($filters['status'] ?? '') == 'pending' ? 'selected' : '' }}>Diajukan</option>
                    <option value="approved" {{ ($filters['status'] ?? '') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Dosen</label>
                <select name="lecturer_id" class="form-select">
                    <option value="all">Semua</option>
                    @foreach($lecturers as $lec)
                        <option value="{{ $lec->id }}" {{ ($filters['lecturer_id'] ?? '') == $lec->id ? 'selected' : '' }}>
                            {{ $lec->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Cari (Nama/NIM)</label>
                <input type="text" class="form-control" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Ketik untuk mencari..." />
            </div>
            <div class="col-md-2">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" name="start_date" value="{{ $filters['start_date'] ?? '' }}" />
            </div>
            <div class="col-md-2">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date" class="form-control" name="end_date" value="{{ $filters['end_date'] ?? '' }}" />
            </div>
            <div class="col-md-2 align-self-end">
                <div class="row g-2">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('dashboard.monitoring.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('dashboard.monitoring.export') }}?{{ http_build_query(request()->query()) }}" 
                           class="btn btn-success w-100">
                            <i class="fas fa-download me-1"></i>Export
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Mahasiswa</th>
                        <th>Dosen</th>
                        <th>Judul Skripsi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guidances as $g)
                        <tr>
                            <td>{{ optional($g->schedule)->format('Y-m-d H:i') ?? '-' }}</td>
                            <td>
                                {{ $g->student->user->name }}<br>
                                <small class="text-muted">{{ $g->student->nim }}</small>
                            </td>
                            <td>{{ $g->lecturer->user->name }}</td>
                            <td>{{ $g->thesis->title ?? '-' }}</td>
                            <td>
                                @if($g->status_request === 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($g->status_request === 'pending')
                                    <span class="badge bg-warning">Diajukan</span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $guidances->links() }}
        </div>
    </div>
</x-dashboard-layout>
