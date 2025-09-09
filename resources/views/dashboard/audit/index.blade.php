<x-dashboard-layout title="Audit Trail">
    <x-slot:header>
        Audit Trail - Log Aktivitas Sistem
    </x-slot:header>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="h4 mb-0">{{ number_format($stats['total_logs']) }}</div>
                            <div class="small">Total Log</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-list fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="h4 mb-0">{{ $stats['today_logs'] }}</div>
                            <div class="small">Hari Ini</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-day fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="h4 mb-0">{{ $stats['week_logs'] }}</div>
                            <div class="small">Minggu Ini</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-week fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="h4 mb-0">{{ $stats['month_logs'] }}</div>
                            <div class="small">Bulan Ini</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="m-0">Filter & Pencarian</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard.audit.index') }}" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Jenis Event</label>
                    <select name="event_type" class="form-select">
                        <option value="">Semua</option>
                        @foreach($eventTypes as $type)
                            <option value="{{ $type }}" {{ request('event_type') == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Tipe Entitas</label>
                    <select name="entity_type" class="form-select">
                        <option value="">Semua</option>
                        @foreach($entityTypes as $type)
                            <option value="{{ $type }}" {{ request('entity_type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Pengguna</label>
                    <select name="user_id" class="form-select">
                        <option value="">Semua</option>
                        @foreach($users as $user)
                            <option value="{{ $user->user_id }}" {{ request('user_id') == $user->user_id ? 'selected' : '' }}>
                                {{ $user->user_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Pencarian</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi...">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('dashboard.audit.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-refresh me-1"></i> Reset
                    </a>
                    <a href="{{ route('dashboard.audit.export') }}?{{ http_build_query(request()->query()) }}"
                       class="btn btn-success">
                        <i class="fas fa-download me-1"></i> Export CSV
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Audit Logs Table -->
    <div class="card">
        <div class="card-header">
            <h6 class="m-0">Log Aktivitas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Event</th>
                            <th>Entitas</th>
                            <th>Pengguna</th>
                            <th>Deskripsi</th>
                            <th>IP Address</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auditLogs as $log)
                            <tr>
                                <td>
                                    <div class="text-nowrap">
                                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                                    </div>
                                    <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    @php
                                        $eventColors = [
                                            'create' => 'success',
                                            'update' => 'warning',
                                            'delete' => 'danger',
                                            'login' => 'info',
                                            'logout' => 'secondary',
                                            'approve' => 'success',
                                            'reject' => 'danger',
                                            'system' => 'dark'
                                        ];
                                        $color = $eventColors[$log->event_type] ?? 'primary';
                                    @endphp
                                    <span class="badge bg-{{ $color }}">{{ ucfirst($log->event_type) }}</span>
                                </td>
                                <td>
                                    @if($log->entity_type)
                                        <div>{{ $log->entity_type }}</div>
                                        @if($log->entity_id)
                                            <small class="text-muted">ID: {{ $log->entity_id }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $log->user_name }}</div>
                                    <small class="text-muted">{{ ucfirst($log->user_role) }}</small>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 300px;" title="{{ $log->description }}">
                                        {{ $log->description }}
                                    </div>
                                </td>
                                <td>
                                    <span class="font-monospace small">{{ $log->ip_address ?? '-' }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('dashboard.audit.show', $log) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        Tidak ada log audit yang ditemukan.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($auditLogs->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $auditLogs->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Audit Activity Chart -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0">Aktivitas Audit</h6>
                    <select id="auditPeriodSelect" class="form-select form-select-sm" style="width: auto;">
                        <option value="daily">Harian (30 hari)</option>
                        <option value="weekly" selected>Mingguan (12 minggu)</option>
                        <option value="monthly">Bulanan (12 bulan)</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="auditActivityChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom styles -->
    <style>
        .table td {
            vertical-align: middle;
        }
        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

    <!-- Chart Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeAuditActivityChart();

            document.getElementById('auditPeriodSelect').addEventListener('change', function() {
                updateAuditActivityChart(this.value);
            });
        });

        let auditActivityChart;

        function initializeAuditActivityChart() {
            const ctx = document.getElementById('auditActivityChart').getContext('2d');
            auditActivityChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Aktivitas Audit',
                        data: [],
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Load initial data
            updateAuditActivityChart('weekly');
        }

        function updateAuditActivityChart(period) {
            fetch(`{{ route('dashboard.audit.activity') }}?period=${period}`)
                .then(response => response.json())
                .then(data => {
                    auditActivityChart.data.labels = data.map(item => item.label);
                    auditActivityChart.data.datasets[0].data = data.map(item => item.value);
                    auditActivityChart.update();
                })
                .catch(error => {
                    console.error('Error loading audit activity data:', error);
                });
        }
    </script>
</x-dashboard-layout>
