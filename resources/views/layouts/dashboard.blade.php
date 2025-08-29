<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="theme-uho">

@php
    $baseUrl = config('app.url');
    $baseUrl = explode('://', $baseUrl)[1];

    if (request()->secure()) {
        $baseUrl = 'https://' . $baseUrl;
    } else {
        $baseUrl = 'http://' . $baseUrl;
    }

    $isUsernameAndPasswordSame = Auth::user()->username === Auth::user()->email ||
                                (Auth::user()->username && Auth::user()->username === 'password');
@endphp

<head>
    <x-meta-data :title="$title" csrfToken="{{ csrf_token() }}" :baseurl="$baseUrl"/>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css">

    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- UHO Theme Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <!-- jQuery (Load early for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="theme-uho">
    <!-- Layout wrapper -->
    <div class="layout-wrapper">
        <div class="layout-container">
            <!-- Sidebar -->
            @include('components.sidebar')

            <!-- Layout page -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('components.navbar')

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1">
                        @if (isset($header))
                            <header class="card header-card">
                                <div class="d-flex align-items-end row">
                                    <div class="col-sm-8">
                                        <div class="card-body position-relative">
                                            <h4 class="card-title fw-bold mb-3" style="color: white;">
                                                <i class="fas fa-university me-2" style="color: var(--uho-accent);"></i>
                                                {{ $header }}
                                            </h4>
                                            @if (isset($header_subtitle))
                                                <p class="mb-0 opacity-75" style="font-size: 16px;">
                                                    {{ $header_subtitle }}
                                                </p>
                                            @endif
                                            <div class="mt-3">
                                                <span class="badge" style="background: rgba(255, 255, 255, 0.2); color: white; font-size: 12px;">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ now()->format('d F Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 text-center text-sm-end">
                                        <div class="card-body pb-0 px-0 px-md-12 position-relative">
                                            <div class="d-flex justify-content-end">
                                                <div style="width: 100px; height: 100px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                                                    <i class="fas fa-graduation-cap" style="font-size: 36px; color: var(--uho-accent);"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </header>
                        @endif

                        <main>
                            {{ $slot }}
                        </main>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('components.footer')
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        @php
            $isToastDisplayed = Session::get('toastDisplayed');
        @endphp

        @if ($isUsernameAndPasswordSame && !$isToastDisplayed)
            <div class="position-fixed" style="bottom: 25px; right: 30px; z-index: 1050;">
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" style="border-radius: 16px; box-shadow: 0 10px 40px rgba(11, 61, 145, 0.2); background: var(--uho-surface);">
                    <div class="toast-header pb-2" style="background: linear-gradient(135deg, var(--uho-primary), var(--uho-secondary)); color: white; border-radius: 16px 16px 0 0;">
                        <i class="fas fa-shield-alt me-2"></i>
                        <strong class="me-auto">SI Bimbingan Skripsi UHO</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body border-top pt-3">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0 me-3">
                                <div style="width: 40px; height: 40px; background: rgba(255, 193, 7, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-exclamation-triangle" style="color: var(--uho-warning);"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-3">Demi keamanan akun Anda, silahkan mengganti password Anda dan jangan samakan dengan username Anda.</p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('profile.edit') }}#update-password" class="btn btn-sm btn-primary">
                                        <i class="fas fa-key me-1"></i>Ubah Password
                                    </a>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="toast">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                Session::put('toastDisplayed', true);
            @endphp
        @endif

        <!-- Layout Overlay for mobile -->
        <div class="layout-overlay" onclick="toggleSidebar()"></div>
    </div>

    @include('vendor.sweetalert.alert')

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>

    <!-- Custom Dashboard Scripts -->
    <script>
        // Enhanced DataTables with UHO theme
        $(document).ready(function() {
            // Initialize DataTables
            $('table[id^="table"]').each(function() {
                $(this).DataTable({
                    dom: '<"d-flex justify-content-between align-items-center mb-3"<"d-flex align-items-center gap-3"l><"d-flex align-items-center"f>>rtip',
                    language: {
                        search: "",
                        searchPlaceholder: "Cari data...",
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                        infoEmpty: "Menampilkan 0 hingga 0 dari 0 data",
                        infoFiltered: "(difilter dari _MAX_ total data)",
                        zeroRecords: "Tidak ada data yang ditemukan",
                        emptyTable: "Tidak ada data tersedia di tabel",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        }
                    },
                    pageLength: 10,
                    responsive: true,
                    order: [[0, 'asc']]
                });
            });

            // Sidebar menu toggle animation
            $('.menu-toggle').on('click', function(e) {
                e.preventDefault();
                const menuItem = $(this).closest('.menu-item');
                menuItem.toggleClass('open');

                const submenu = menuItem.find('.menu-sub');
                submenu.slideToggle(300);

                const icon = $(this).find('.menu-arrow');
                icon.toggleClass('fa-chevron-down fa-chevron-up');
            });

            // Stats cards hover effect
            $('.stats-card').hover(
                function() {
                    $(this).find('.stats-icon').addClass('pulse');
                },
                function() {
                    $(this).find('.stats-icon').removeClass('pulse');
                }
            );
        });

        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.querySelector('.layout-menu');
            const overlay = document.querySelector('.layout-overlay');

            sidebar.classList.toggle('menu-expanded');
            overlay.classList.toggle('active');
        }

        // Layout menu toggle for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.querySelector('.layout-menu-toggle a');
            if (menuToggle) {
                menuToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleSidebar();
                });
            }
        });
    </script>

    <style>
        /* Additional responsive styles */
        .layout-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .layout-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        @media (max-width: 1200px) {
            .layout-overlay.active ~ .layout-menu {
                transform: translateX(0);
            }
        }
    </style>
</body>
</html>
