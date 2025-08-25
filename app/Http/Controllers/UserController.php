<?php


namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\HeadOfDepartement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('admin')) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::with(['student', 'lecturer', 'headOfDepartement'])
            ->when($request->filled('role'), function ($query) use ($request) {
                return $query->where('role', $request->role);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('username', 'like', '%' . $request->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('dashboard.kelola-user.index', [
            'title' => 'Kelola User',
            'header' => 'Kelola User',
            'header_subtitle' => 'Manajemen pengguna sistem bimbingan skripsi',
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.kelola-user.create', [
            'title' => 'Tambah User Baru',
            'header' => 'Tambah User Baru',
            'header_subtitle' => 'Buat akun pengguna baru untuk sistem bimbingan skripsi'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Create user
        $user = User::create($validatedData);

        // Create role-specific record
        $this->createRoleSpecificRecord($user, $validatedData);

        return redirect()
            ->route('dashboard.kelola-user.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $kelola_user)
    {
        $kelola_user->load(['student', 'lecturer', 'headOfDepartement']);

        return view('dashboard.kelola-user.show', [
            'title' => 'Detail User',
            'header' => 'Detail User: ' . $kelola_user->name,
            'header_subtitle' => 'Informasi lengkap pengguna sistem',
            'user' => $kelola_user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $kelola_user)
    {
        $kelola_user->load(['student', 'lecturer', 'headOfDepartement']);

        return view('dashboard.kelola-user.edit', [
            'title' => 'Edit User',
            'header' => 'Edit User: ' . $kelola_user->name,
            'header_subtitle' => 'Perbarui informasi pengguna sistem',
            'user' => $kelola_user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $kelola_user)
    {
        $validatedData = $request->validated();

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($kelola_user->photo && Storage::disk('public')->exists($kelola_user->photo)) {
                Storage::disk('public')->delete($kelola_user->photo);
            }
            $validatedData['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // Hash password if provided
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        // Update user
        $kelola_user->update($validatedData);

        // Update role-specific record if role changed
        if ($request->filled('role') && $kelola_user->role !== $request->role) {
            $this->updateRoleSpecificRecord($kelola_user, $validatedData);
        } else {
            // Update existing role-specific record
            $this->updateExistingRoleSpecificRecord($kelola_user, $validatedData);
        }

        return redirect()
            ->route('dashboard.kelola-user.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $kelola_user)
    {
        // Don't allow deleting own account
        if ($kelola_user->id === auth()->id()) {
            return redirect()
                ->route('dashboard.kelola-user.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        // Delete photo if exists
        if ($kelola_user->photo && Storage::disk('public')->exists($kelola_user->photo)) {
            Storage::disk('public')->delete($kelola_user->photo);
        }

        // Delete role-specific records
        $this->deleteRoleSpecificRecord($kelola_user);

        // Delete user
        $kelola_user->delete();

        return redirect()
            ->route('dashboard.kelola-user.index')
            ->with('success', 'User berhasil dihapus.');
    }

    /**
     * Create role-specific record for user
     */
    private function createRoleSpecificRecord(User $user, array $data)
    {
        switch ($user->role) {
            case 'student':
                Student::create([
                    'id' => $user->id,
                    'user_id' => $user->id,
                    'nim' => $data['nim'] ?? null,
                    'lecturer_id_1' => $data['lecturer_id_1'] ?? null,
                    'lecturer_id_2' => $data['lecturer_id_2'] ?? null,
                ]);
                break;

            case 'lecturer':
                Lecturer::create([
                    'id' => $user->id,
                    'user_id' => $user->id,
                    'nidn' => $data['nidn'] ?? null,
                    'nip' => $data['nip'] ?? null,
                ]);
                break;

            case 'HoD':
                HeadOfDepartement::create([
                    'id' => $user->id,
                    'user_id' => $user->id,
                    'nidn' => $data['nidn'] ?? null,
                    'nip' => $data['nip'] ?? null,
                ]);
                break;
        }
    }

    /**
     * Update role-specific record when role changes
     */
    private function updateRoleSpecificRecord(User $user, array $data)
    {
        // Delete old role-specific record
        $this->deleteRoleSpecificRecord($user);

        // Create new role-specific record
        $this->createRoleSpecificRecord($user, $data);
    }

    /**
     * Update existing role-specific record
     */
    private function updateExistingRoleSpecificRecord(User $user, array $data)
    {
        switch ($user->role) {
            case 'student':
                if ($user->student) {
                    $user->student->update([
                        'nim' => $data['nim'] ?? $user->student->nim,
                        'lecturer_id_1' => $data['lecturer_id_1'] ?? $user->student->lecturer_id_1,
                        'lecturer_id_2' => $data['lecturer_id_2'] ?? $user->student->lecturer_id_2,
                    ]);
                }
                break;

            case 'lecturer':
                if ($user->lecturer) {
                    $user->lecturer->update([
                        'nidn' => $data['nidn'] ?? $user->lecturer->nidn,
                        'nip' => $data['nip'] ?? $user->lecturer->nip,
                    ]);
                }
                break;

            case 'HoD':
                if ($user->headOfDepartement) {
                    $user->headOfDepartement->update([
                        'nidn' => $data['nidn'] ?? $user->headOfDepartement->nidn,
                        'nip' => $data['nip'] ?? $user->headOfDepartement->nip,
                    ]);
                }
                break;
        }
    }

    /**
     * Delete role-specific record
     */
    private function deleteRoleSpecificRecord(User $user)
    {
        switch ($user->role) {
            case 'student':
                $user->student?->delete();
                break;
            case 'lecturer':
                $user->lecturer?->delete();
                break;
            case 'HoD':
                $user->headOfDepartement?->delete();
                break;
        }
    }
}
