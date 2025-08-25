<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->email, // Use email as username for now
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Create role-specific record
        if ($request->role === 'student') {
            Student::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'fullname' => $request->name,
                'nim' => null, // Will be set by admin later
                'angkatan' => null, // Will be set by admin later
                'lecturer_id_1' => null,
                'lecturer_id_2' => null,
            ]);
        } elseif ($request->role === 'lecturer') {
            Lecturer::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'fullname' => $request->name,
                'nidn' => null, // Will be set by admin later
                'nip' => null, // Will be set by admin later
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on role
        if ($user->role === 'student') {
            return redirect()->route('dashboard.bimbingan.index');
        } elseif ($user->role === 'lecturer') {
            return redirect()->route('dashboard.atur-jadwal-bimbingan.index');
        } else {
            return redirect()->route('dashboard');
        }
    }
}
