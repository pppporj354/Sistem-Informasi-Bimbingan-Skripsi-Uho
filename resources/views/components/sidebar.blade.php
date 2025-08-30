@php
    $homeLink = null;

    if(Auth::user()->role == 'student') {
        $homeLink = route('dashboard.bimbingan.index');
    } elseif(Auth::user()->role == 'lecturer') {
        $homeLink = route('dashboard.atur-jadwal-bimbingan.index');
    } elseif(Auth::user()->role == 'HoD') {
        $homeLink = route('dashboard.aktivitas-bimbingan.index');
    } elseif(Auth::user()->role == 'admin') {
        $homeLink = route('dashboard');
    }
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu app-sidebar">
    <!-- Brand -->
    <div class="app-brand ">
        <a href="{{ $homeLink }}" class="app-brand-link d-flex align-items-center text-decoration-none">
            <div class="d-flex align-items-center w-100">
                <div style="width: 45px; height: 45px; background: rgba(255, 255, 255, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 12px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                    <img src="{{ asset('logo-uho.png') }}"
                         alt="UHO Logo"
                         class="uho-logo"
                         style="width: 32px; height: 32px; object-fit: contain; filter: brightness(0) invert(1);">
                </div>
                <div class="flex-grow-1">
                    <div class="brand fw-bold text-white" style="font-size: 18px; line-height: 1.2;">
                        SIBS UHO
                    </div>
                    <div class="sidebar-title" style="font-size: 11px; opacity: 0.8; color: rgba(255, 255, 255, 0.8);">
                        Sistem Bimbingan Skripsi
                    </div>
                </div>
            </div>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle text-white"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-3">
    @if(Auth::user()->role === 'student')
            <!-- Student Menu -->
            <li class="menu-header small text-uppercase mt-3 mb-2">
                <span class="menu-header-text">
                    <i class="fas fa-user-graduate me-2" style="font-size: 12px;"></i>
                    MENU MAHASISWA
                </span>
            </li>

            <li class="menu-item {{ request()->is('bimbingan*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon fas fa-list-check me-2"></i>
                    <div data-i18n="Bimbingan">Bimbingan Skripsi</div>
                    <i class="menu-arrow fas fa-chevron-down ms-auto"></i>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('dashboard.bimbingan.*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.bimbingan.index') }}" class="menu-link">
                            <i class="fas fa-comments me-2"></i>
                            <div data-i18n="Bimbingan">Semua Bimbingan</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('dashboard.bimbingan-1.*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.bimbingan-1.index') }}" class="menu-link">
                            <i class="fas fa-user-tie me-2"></i>
                            <div data-i18n="Dosen Pembimbing 1">Pembimbing 1</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('dashboard.bimbingan-2.*') ? 'active' : '' }}">
                        <a href="{{ route('dashboard.bimbingan-2.index') }}" class="menu-link">
                            <i class="fas fa-user-graduate me-2"></i>
                            <div data-i18n="Dosen Pembimbing 2">Pembimbing 2</div>
                        </a>
                    </li>
                </ul>
            </li>
    @endif

    @if(Auth::user()->role === 'lecturer')
            <!-- Lecturer Menu -->
            <li class="menu-header small text-uppercase mt-3 mb-2">
                <span class="menu-header-text">
                    <i class="fas fa-chalkboard-teacher me-2" style="font-size: 12px;"></i>
                    MENU DOSEN
                </span>
            </li>

            <li class="menu-item {{ request()->routeIs('dashboard.atur-jadwal-bimbingan.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.atur-jadwal-bimbingan.index') }}" class="menu-link">
                    <i class="menu-icon fas fa-calendar-alt me-2"></i>
                    <div data-i18n="Jadwal Bimbingan">Jadwal Bimbingan</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('dashboard.mahasiswa-bimbingan.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.mahasiswa-bimbingan.index') }}" class="menu-link">
                    <i class="menu-icon fas fa-users me-2"></i>
                    <div data-i18n="Bimbingan Mahasiswa">Mahasiswa Bimbingan</div>
                </a>
            </li>
    @endif

    @if(Auth::user()->role === 'HoD')
            <!-- Head of Department Menu -->
            <li class="menu-header small text-uppercase mt-3 mb-2">
                <span class="menu-header-text">
                    <i class="fas fa-user-tie me-2" style="font-size: 12px;"></i>
                    MENU KETUA JURUSAN
                </span>
            </li>

            <li class="menu-item {{ request()->routeIs('dashboard.aktivitas-bimbingan.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.aktivitas-bimbingan.index') }}" class="menu-link">
                    <i class="menu-icon fas fa-chart-line me-2"></i>
                    <div data-i18n="Aktivitas Bimbingan">Aktivitas Bimbingan</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('dashboard.ujian-hasil.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.ujian-hasil.index') }}" class="menu-link">
                    <i class="menu-icon fas fa-clipboard-check me-2"></i>
                    <div data-i18n="Ujian Hasil">Persetujuan Ujian</div>
                </a>
            </li>
    @endif

    @if(Auth::user()->role === 'admin')
            <!-- Admin Menu -->
            <li class="menu-header small text-uppercase mt-3 mb-2">
                <span class="menu-header-text">
                    <i class="fas fa-user-shield me-2" style="font-size: 12px;"></i>
                    MENU ADMINISTRATOR
                </span>
            </li>

            <li class="menu-item {{ request()->routeIs('dashboard') && !request()->is('dashboard/*') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <i class="menu-icon fas fa-tachometer-alt me-2"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('dashboard/kelola-user*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.kelola-user.index') }}" class="menu-link">
                    <i class="menu-icon fas fa-users-cog me-2"></i>
                    <div data-i18n="Kelola User">Kelola Pengguna</div>
                </a>
            </li>

            <!-- Data Master -->
            <li class="menu-header small text-uppercase mt-4 mb-2">
                <span class="menu-header-text">
                    <i class="fas fa-database me-2" style="font-size: 12px;"></i>
                    DATA MASTER
                </span>
            </li>

            <li class="menu-item {{ request()->routeIs('dashboard.student.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.student.index') }}" class="menu-link">
                    <i class="menu-icon fas fa-user-graduate me-2"></i>
                    <div data-i18n="Mahasiswa">Data Mahasiswa</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('dashboard.lecturer.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.lecturer.index') }}" class="menu-link">
                    <i class="menu-icon fas fa-chalkboard-user me-2"></i>
                    <div data-i18n="Dosen">Data Dosen</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('dashboard.kajur.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.kajur.index') }}" class="menu-link">
                    <i class="menu-icon fas fa-user-tie me-2"></i>
                    <div data-i18n="Kajur">Ketua Jurusan</div>
                </a>
            </li>
    @endif

        <!-- Common Menu -->
        <li class="menu-header small text-uppercase mt-4 mb-2">
            <span class="menu-header-text">
                <i class="fas fa-cog me-2" style="font-size: 12px;"></i>
                PENGATURAN
            </span>
        </li>

        <li class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <a href="{{ route('profile.edit') }}" class="menu-link">
                <i class="menu-icon fas fa-user-circle me-2"></i>
                <div data-i18n="Profil">Profil Saya</div>
            </a>
        </li>

        <!-- UHO Branding Footer -->
        <li class="mt-5 px-3">
            <div class="text-center">
                <div style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; backdrop-filter: blur(10px); box-shadow: 0 8px 25px rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.15);">
                    <img src="{{ asset('logo-uho.png') }}"
                         alt="UHO Logo"
                         class="uho-logo"
                         style="width: 42px; height: 42px; object-fit: contain; filter: brightness(0) invert(1);">
                </div>
                <div class="text-white opacity-75" style="font-size: 13px; line-height: 1.4;">
                    <div class="fw-bold">Universitas Halu Oleo</div>
                    <div class="fw-medium" style="font-size: 11px; margin-top: 4px;">
                        FKIP - PTIK
                    </div>
                    <div style="font-size: 10px; margin-top: 8px; opacity: 0.8;">
                        © {{ date('Y') }} SI Bimbingan Skripsi
                    </div>
                </div>
            </div>
        </li>
    </ul>
</aside>
