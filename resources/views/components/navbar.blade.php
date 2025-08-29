<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)" onclick="toggleSidebar()">
            <i class="bx bx-menu bx-sm text-white"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Left Side - University Info -->
        <div class="navbar-nav align-items-center me-auto">
            <div class="nav-item d-flex align-items-center">
                <img src="{{ asset('logo-uho.png') }}"
                     alt="UHO Logo"
                     class="me-2"
                     style="width: 28px; height: 28px; object-fit: contain;">
                <div class="d-none d-md-block">
                    <span class="fw-semibold text-white" style="font-size: 14px;">Universitas Halu Oleo</span>
                    <div style="font-size: 11px; color: rgba(255, 255, 255, 0.8); line-height: 1.2;">
                        Sistem Informasi Bimbingan Skripsi
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - User Menu -->
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Notifications (Optional) -->
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                <a class="nav-link dropdown-toggle hide-arrow btn btn-sm"
                   href="javascript:void(0);"
                   data-bs-toggle="dropdown"
                   data-bs-auto-close="outside"
                   aria-expanded="false"
                   style="background: rgba(255, 255, 255, 0.1); color: white; border-radius: 8px; padding: 8px 12px;">
                    <i class="bx bx-bell bx-sm"></i>
                    <span class="badge rounded-pill bg-danger badge-notifications" style="font-size: 10px;">0</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end py-0" style="border-radius: 12px; border: none; box-shadow: 0 8px 25px rgba(11, 61, 145, 0.25); min-width: 300px;">
                    <li class="dropdown-menu-header border-bottom" style="background: linear-gradient(135deg, var(--uho-primary), var(--uho-secondary)); color: white; border-radius: 12px 12px 0 0;">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h5 class="text-body mb-0 me-auto fw-semibold" style="color: white !important;">Notifikasi</h5>
                        </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container ps-0">
                        <div class="text-center py-4 text-muted">
                            <i class="bx bx-bell-off bx-lg mb-2" style="opacity: 0.5;"></i>
                            <p class="mb-0" style="font-size: 14px;">Tidak ada notifikasi</p>
                        </div>
                    </li>
                </ul>
            </li>

            <!-- User Profile -->
            <li class="nav-item navbar-dropdown dropdown">
                 <a class="nav-link dropdown-toggle hide-arrow btn btn-sm"
                   href="javascript:void(0);"
                   data-bs-toggle="dropdown"
                   data-bs-auto-close="outside"
                   aria-expanded="false"
                   style="background: rgba(255, 255, 255, 0.1); color: white; border-radius: 8px; padding: 8px 12px;">
                    <div class="avatar avatar-online me-2">
                        @if(Auth::user()->photo)
                            <img src="{{ Auth::user()->photoFile }}"
                                 alt="User Avatar"
                                 class="rounded-circle"
                                 style="width: 32px; height: 32px; object-fit: cover; border: 2px solid rgba(255, 255, 255, 0.3);">
                        @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 32px; height: 32px; background: var(--uho-accent); color: var(--uho-primary); font-weight: 700; font-size: 14px; border: 2px solid rgba(255, 255, 255, 0.3);">
                                {{ substr(Auth::user()->name, 0, 2) }}
                            </div>
                        @endif
                    </div>
                    <div class="d-none d-sm-block">
                        <span class="fw-semibold text-white" style="font-size: 14px;">{{ Auth::user()->name }}</span>
                        <div style="font-size: 11px; color: rgba(255, 255, 255, 0.8); line-height: 1.2;">
                            {{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}
                        </div>
                    </div>

                </a>

                 <ul class="dropdown-menu dropdown-menu-end py-0" style="border-radius: 12px; border: none; box-shadow: 0 8px 25px rgba(11, 61, 145, 0.25); min-width: 300px;">
                    <li class="dropdown-menu-header border-bottom" style="background: linear-gradient(135deg, var(--uho-primary), var(--uho-secondary)); color: white; border-radius: 12px 12px 0 0;">
                        <div class="py-3 px-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    @if(Auth::user()->photo)
                                        <div class="avatar avatar-online">
                                            <img src="{{ Auth::user()->photoFile }}"
                                                 alt="User Avatar"
                                                 class="rounded-circle"
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        </div>
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px; background: var(--uho-accent); color: var(--uho-primary); font-weight: 700; font-size: 16px;">
                                            {{ substr(Auth::user()->name, 0, 2) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block" style="color: white;">{{ Auth::user()->name }}</span>
                                    <small class="text-white opacity-75">{{ Auth::user()->email }}</small>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider" style="margin: 0;"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('profile.edit') }}">
                            <i class="bx bx-user me-2 text-primary"></i>
                            <span>Profil Saya</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('profile.edit') }}#update-password">
                            <i class="bx bx-cog me-2 text-warning"></i>
                            <span>Pengaturan</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="dropdown-item p-0">
                            @csrf
                            <button type="submit"
                                    class="btn btn-link dropdown-item d-flex align-items-center py-2 text-danger w-100 text-start"
                                    style="border: none; background: none; text-decoration: none;">
                                <i class="bx bx-power-off me-2"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
