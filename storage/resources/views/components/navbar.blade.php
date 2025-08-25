<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center app-navbar"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- University Branding -->
        <div class="me-auto d-none d-lg-flex align-items-center">
            <div class="d-flex align-items-center">
                <div style="width: 32px; height: 32px; background: var(--uho-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 8px;">
                    <i class="fas fa-university" style="color: var(--uho-primary); font-size: 14px;"></i>
                </div>
                <span class="fw-semibold" style="color: rgba(255, 255, 255, 0.9);">Universitas Halu Oleo</span>
            </div>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Notifications (optional) -->
            <li class="nav-item me-2">
                <button class="btn btn-link nav-link p-2" style="color: rgba(255, 255, 255, 0.8);" title="Notifikasi">
                    <i class="fas fa-bell"></i>
                    <span class="badge bg-warning badge-dot"></span>
                </button>
            </li>

            <!-- User Profile -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online me-2">
                        @if (Auth::user()->photo)
                            <img src="{{ Auth::user()->photoFile }}"
                                class="w-px-40 h-auto rounded-circle" alt="{{ Auth::user()->name }}" />
                        @else
                            <img src="https://eu.ui-avatars.com/api/?name={{ Auth::user()->name }}&size=250&background=ffc107&color=0b3d91&bold=true"
                                class="w-px-40 h-auto rounded-circle" alt="{{ Auth::user()->name }}" />
                        @endif
                    </div>
                    <div class="d-none d-sm-block">
                        <span class="fw-medium" style="color: white; font-size: 14px;">{{ Str::limit(auth()->user()->name, 20) }}</span>
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end surface" style="min-width: 280px; border-radius: 14px; box-shadow: 0 10px 40px rgba(11, 61, 145, 0.2);">
                    <li>
                        <div class="dropdown-item-text p-3" style="background: linear-gradient(135deg, var(--uho-primary), var(--uho-secondary)); color: white; border-radius: 14px 14px 0 0;">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        @if (Auth::user()->photo)
                                            <img src="{{ Auth::user()->photoFile }}"
                                                class="w-px-50 h-auto rounded-circle border border-2 border-white"
                                                alt="{{ Auth::user()->name }}" />
                                        @else
                                            <img src="https://eu.ui-avatars.com/api/?name={{ Auth::user()->name }}&size=250&background=ffc107&color=0b3d91&bold=true"
                                                class="w-px-50 h-auto rounded-circle border border-2 border-white"
                                                alt="{{ Auth::user()->name }}" />
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">{{ auth()->user()->name }}</h6>
                                    @if (auth()->user()->role == 'lecturer')
                                        <small class="opacity-75">
                                            <i class="fas fa-chalkboard-teacher me-1"></i>
                                            NIDN: {{ auth()->user()->lecturer->nidn }}
                                        </small>
                                    @elseif (auth()->user()->role == 'student')
                                        <small class="opacity-75">
                                            <i class="fas fa-user-graduate me-1"></i>
                                            NIM: {{ auth()->user()->student->formattedNIM }}
                                        </small>
                                    @elseif (auth()->user()->role == 'HoD')
                                        <small class="opacity-75">
                                            <i class="fas fa-user-tie me-1"></i>
                                            Ketua Jurusan
                                        </small>
                                    @elseif (auth()->user()->role == 'admin')
                                        <small class="opacity-75">
                                            <i class="fas fa-user-shield me-1"></i>
                                            Administrator
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>

                    <li><hr class="dropdown-divider m-0" /></li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('profile.edit') }}">
                            <div class="flex-shrink-0 me-3">
                                <div style="width: 32px; height: 32px; background: rgba(11, 61, 145, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user-edit" style="color: var(--uho-primary); font-size: 14px;"></i>
                                </div>
                            </div>
                            <div>
                                <div class="fw-medium">Profil Saya</div>
                                <small class="text-muted">Kelola informasi profil</small>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('profile.edit') }}#update-password">
                            <div class="flex-shrink-0 me-3">
                                <div style="width: 32px; height: 32px; background: rgba(255, 193, 7, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-key" style="color: var(--uho-accent); font-size: 14px;"></i>
                                </div>
                            </div>
                            <div>
                                <div class="fw-medium">Ubah Password</div>
                                <small class="text-muted">Keamanan akun</small>
                            </div>
                        </a>
                    </li>

                    <li><hr class="dropdown-divider" /></li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center py-2 text-danger">
                                <div class="flex-shrink-0 me-3">
                                    <div style="width: 32px; height: 32px; background: rgba(220, 38, 38, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-sign-out-alt" style="color: var(--uho-danger); font-size: 14px;"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-medium">Logout</div>
                                    <small class="text-muted">Keluar dari sistem</small>
                                </div>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
