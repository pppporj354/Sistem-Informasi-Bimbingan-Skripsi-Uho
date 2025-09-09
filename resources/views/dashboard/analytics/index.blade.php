<x-dashboard-layout title="Analytics Dashboard">
    <x-slot:header>
        Analytics Dashboard
    </x-slot:header>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Mahasiswa
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStudents }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Dosen
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalLecturers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Bimbingan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalGuidances }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Skripsi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTheses }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Row -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aktivitas 30 Hari Terakhir</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="text-center">
                                <div class="display-4 text-primary">{{ $recentActivity['new_guidances'] }}</div>
                                <div class="text-muted">Bimbingan Baru</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="text-center">
                                <div class="display-4 text-success">{{ $recentActivity['approved_guidances'] }}</div>
                                <div class="text-muted">Bimbingan Disetujui</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="text-center">
                                <div class="display-4 text-info">{{ $recentActivity['new_theses'] }}</div>
                                <div class="text-muted">Skripsi Baru</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="text-center">
                                <div class="display-4 text-warning">{{ $recentActivity['exam_requests'] }}</div>
                                <div class="text-muted">Permintaan Ujian</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Guidance Trends Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tren Bimbingan</h6>
                    <div class="dropdown no-arrow">
                        <select id="periodSelect" class="form-select form-select-sm">
                            <option value="daily">Harian (30 hari)</option>
                            <option value="weekly">Mingguan (12 minggu)</option>
                            <option value="monthly" selected>Bulanan (12 bulan)</option>
                            <option value="yearly">Tahunan</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="guidanceTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Guidance Status Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Status Bimbingan</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="statusPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Diajukan
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Disetujui
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Charts -->
    <div class="row">
        <!-- Lecturer Workload Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Beban Kerja Dosen</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="lecturerWorkloadChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Progress by Concentration -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mahasiswa per Konsentrasi</h6>
                </div>
                <div class="card-body">
                    <div class="chart-doughnut pt-4 pb-2">
                        <canvas id="concentrationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Tables Row -->
    <div class="row">
        <!-- Top Performing Lecturers -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Performa Dosen</h6>
                </div>
                <div class="card-body">
                    <div id="lecturerPerformance">
                        <div class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Progress Table -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Progress Mahasiswa</h6>
                </div>
                <div class="card-body">
                    <div id="studentProgress">
                        <div class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles for Analytics -->
    <style>
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }
        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }
        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }
        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }
        .chart-area {
            position: relative;
            height: 320px;
            width: 100%;
        }
        .chart-pie {
            position: relative;
            height: 245px;
            width: 100%;
        }
        .chart-bar {
            position: relative;
            height: 320px;
            width: 100%;
        }
        .chart-doughnut {
            position: relative;
            height: 245px;
            width: 100%;
        }
    </style>

    <!-- Analytics JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all charts
            initializeGuidanceTrendChart();
            initializeStatusPieChart();
            initializeLecturerWorkloadChart();
            initializeConcentrationChart();
            loadLecturerPerformance();
            loadStudentProgress();

            // Period selection change handler
            document.getElementById('periodSelect').addEventListener('change', function() {
                updateGuidanceTrendChart(this.value);
            });
        });

        let guidanceTrendChart;

        function initializeGuidanceTrendChart() {
            const ctx = document.getElementById('guidanceTrendChart').getContext('2d');
            guidanceTrendChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($monthlyGuidances->map(function($item) { return \Carbon\Carbon::create($item->year, $item->month, 1)->format('M Y'); })),
                    datasets: [{
                        label: 'Jumlah Bimbingan',
                        data: @json($monthlyGuidances->pluck('count')),
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.1)',
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
        }

        function updateGuidanceTrendChart(period) {
            fetch(`{{ route('dashboard.analytics.guidance-data') }}?period=${period}`)
                .then(response => response.json())
                .then(data => {
                    guidanceTrendChart.data.labels = data.map(item => item.label);
                    guidanceTrendChart.data.datasets[0].data = data.map(item => item.value);
                    guidanceTrendChart.update();
                });
        }

        function initializeStatusPieChart() {
            const ctx = document.getElementById('statusPieChart').getContext('2d');
            const statusData = @json($guidanceStatusStats);

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Diajukan', 'Disetujui'],
                    datasets: [{
                        data: [statusData['pending'] || 0, statusData['approved'] || 0],
                        backgroundColor: ['#f6c23e', '#1cc88a'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        function initializeLecturerWorkloadChart() {
            const ctx = document.getElementById('lecturerWorkloadChart').getContext('2d');
            const workloadData = @json($lecturerWorkload);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: workloadData.map(item => item.name),
                    datasets: [{
                        label: 'Jumlah Bimbingan',
                        data: workloadData.map(item => item.count),
                        backgroundColor: '#4e73df',
                        borderColor: '#4e73df',
                        borderWidth: 1
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
        }

        function initializeConcentrationChart() {
            const ctx = document.getElementById('concentrationChart').getContext('2d');
            const concentrationData = @json($concentrationProgress);

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(concentrationData),
                    datasets: [{
                        data: Object.values(concentrationData),
                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        function loadLecturerPerformance() {
            fetch('{{ route('dashboard.analytics.lecturer-performance') }}')
                .then(response => response.json())
                .then(data => {
                    let html = '<div class="table-responsive"><table class="table table-sm"><thead><tr><th>Dosen</th><th>Total</th><th>Tingkat Persetujuan</th></tr></thead><tbody>';

                    data.slice(0, 10).forEach(lecturer => {
                        const progressClass = lecturer.approval_rate >= 80 ? 'success' : lecturer.approval_rate >= 60 ? 'warning' : 'danger';
                        html += `
                            <tr>
                                <td>${lecturer.name}</td>
                                <td><span class="badge badge-primary">${lecturer.total_guidances}</span></td>
                                <td>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-${progressClass}" style="width: ${lecturer.approval_rate}%"></div>
                                    </div>
                                    <small>${lecturer.approval_rate}%</small>
                                </td>
                            </tr>
                        `;
                    });

                    html += '</tbody></table></div>';
                    document.getElementById('lecturerPerformance').innerHTML = html;
                });
        }

        function loadStudentProgress() {
            fetch('{{ route('dashboard.analytics.student-progress') }}')
                .then(response => response.json())
                .then(data => {
                    let html = '<div class="table-responsive"><table class="table table-sm"><thead><tr><th>Mahasiswa</th><th>NIM</th><th>Progress</th></tr></thead><tbody>';

                    data.slice(0, 10).forEach(student => {
                        const progressClass = student.progress_percentage >= 80 ? 'success' : student.progress_percentage >= 60 ? 'warning' : 'danger';
                        html += `
                            <tr>
                                <td>
                                    <div>${student.name}</div>
                                    <small class="text-muted">${student.concentration}</small>
                                </td>
                                <td><small>${student.nim}</small></td>
                                <td>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-${progressClass}" style="width: ${student.progress_percentage}%"></div>
                                    </div>
                                    <small>${student.progress_percentage}%</small>
                                </td>
                            </tr>
                        `;
                    });

                    html += '</tbody></table></div>';
                    document.getElementById('studentProgress').innerHTML = html;
                });
        }
    </script>
</x-dashboard-layout>
