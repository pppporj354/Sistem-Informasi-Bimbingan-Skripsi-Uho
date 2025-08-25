<x-dashboard-layout :title="$title">
    <x-slot name="header">{{ $header }}</x-slot>
    <x-slot name="header_subtitle">{{ $header_subtitle }}</x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card surface">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold" style="color: var(--uho-primary);">
                            <i class="fas fa-users-cog me-2"></i>
                            Daftar Pengguna Sistem
                        </h5>
                        <p class="mb-0 text-muted mt-1" style="font-size: 14px;">
                            Total {{ $users->total() }} pengguna terdaftar
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <!-- Filter Role -->
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                                <i class="fas fa-filter me-1"></i>
                                Filter Role
                            </button>
                            <ul class="dropdown-menu surface">
                                <li><a class="dropdown-item" href="{{ route('dashboard.kelola-user.index') }}">Semua Role</a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard.kelola-user.index', ['role' => 'admin']) }}">Administrator</a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard.kelola-user.index', ['role' => 'HoD']) }}">Ketua Jurusan</a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard.kelola-user.index', ['role' => 'lecturer']) }}">Dosen</a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard.kelola-user.index', ['role' => 'student']) }}">Mahasiswa</a></li>
                            </ul>
                        </div>

                        <!-- Add User Button -->
                        <a href="{{ route('dashboard.kelola-user.create') }}"
                           class="btn btn-primary btn-sm"
                           style="border-radius: 8px;">
                            <i class="fas fa-plus me-1"></i>
                            Tambah User
                        </a>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="card-body border-bottom">
                    <form method="GET" action="{{ route('dashboard.kelola-user.index') }}" class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text" style="background: rgba(11, 61, 145, 0.05); border-color: var(--uho-border);">
                                    <i class="fas fa-search" style="color: var(--uho-primary);"></i>
                                </span>
                                <input type="text"
                                       class="form-control"
                                       name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Cari berdasarkan nama, email, atau username..."
                                       style="border-left: none;">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select name="role" class="form-select">
                                <option value="">Semua Role</option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="HoD" {{ request('role') === 'HoD' ? 'selected' : '' }}>Ketua Jurusan</option>
                                <option value="lecturer" {{ request('role') === 'lecturer' ? 'selected' : '' }}>Dosen</option>
                                <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Mahasiswa</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-1"></i>Cari
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="table">
                            <thead>
                                <tr style="background: rgba(11, 61, 145, 0.05);">
                                    <th style="color: var(--uho-primary); font-weight: 600;">Foto</th>
                                    <th style="color: var(--uho-primary); font-weight: 600;">Nama & Email</th>
                                    <th style="color: var(--uho-primary); font-weight: 600;">Username</th>
                                    <th style="color: var(--uho-primary); font-weight: 600;">Role</th>
                                    <th style="color: var(--uho-primary); font-weight: 600;">Info Tambahan</th>
                                    <th style="color: var(--uho-primary); font-weight: 600;">Terdaftar</th>
                                    <th style="color: var(--uho-primary); font-weight: 600;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="avatar avatar-sm">
                                                @if($user->photo)
                                                    <img src="{{ $user->photoFile }}"
                                                         class="rounded-circle"
                                                         alt="{{ $user->name }}"
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <img src="https://eu.ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=250&background=ffc107&color=0b3d91&bold=true"
                                                         class="rounded-circle"
                                                         alt="{{ $user->name }}"
                                                         style="width: 40px; height: 40px;">
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-semibold">{{ $user->name }}</div>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-soft text-primary">{{ $user->username }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $roleConfig = [
                                                    'admin' => ['color' => 'danger', 'icon' => 'user-shield', 'label' => 'Administrator'],
                                                    'HoD' => ['color' => 'warning', 'icon' => 'user-tie', 'label' => 'Ketua Jurusan'],
                                                    'lecturer' => ['color' => 'info', 'icon' => 'chalkboard-teacher', 'label' => 'Dosen'],
                                                    'student' => ['color' => 'success', 'icon' => 'user-graduate', 'label' => 'Mahasiswa']
                                                ];
                                                $config = $roleConfig[$user->role] ?? ['color' => 'secondary', 'icon' => 'user', 'label' => ucfirst($user->role)];
                                            @endphp
                                            <span class="badge bg-{{ $config['color'] }}-subtle text-{{ $config['color'] }}">
                                                <i class="fas fa-{{ $config['icon'] }} me-1"></i>
                                                {{ $config['label'] }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($user->role === 'student' && $user->student)
                                                <small class="text-muted">
                                                    <i class="fas fa-id-card me-1"></i>
                                                    {{ $user->student->formattedNIM }}
                                                </small>
                                            @elseif(in_array($user->role, ['lecturer', 'HoD']))
                                                @php $profile = $user->role === 'lecturer' ? $user->lecturer : $user->headOfDepartement; @endphp
                                                @if($profile)
                                                    <div class="small text-muted">
                                                        @if($profile->nidn)
                                                            <div><i class="fas fa-id-badge me-1"></i>NIDN: {{ $profile->formattedNIDN }}</div>
                                                        @endif
                                                        @if($profile->nip)
                                                            <div><i class="fas fa-id-card me-1"></i>NIP: {{ $profile->formattedNIP }}</div>
                                                        @endif
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $user->created_at->format('d/m/Y') }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('dashboard.kelola-user.show', $user) }}"
                                                   class="btn btn-sm btn-outline-info"
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('dashboard.kelola-user.edit', $user) }}"
                                                   class="btn btn-sm btn-outline-warning"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($user->id !== auth()->id())
                                                    <form method="POST"
                                                          action="{{ route('dashboard.kelola-user.destroy', $user) }}"
                                                          class="d-inline"
                                                          onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-danger"
                                                                title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div style="color: var(--uho-muted);">
                                                <i class="fas fa-users fa-3x mb-3 opacity-50"></i>
                                                <p class="mb-0">Tidak ada data pengguna ditemukan</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($users->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} hasil
                            </div>
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
