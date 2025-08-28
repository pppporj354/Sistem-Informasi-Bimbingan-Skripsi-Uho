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
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \App\Http\Requests\Auth\RegisterRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        // Create the main user record
        $user = User::create([
            'id' => Str::uuid(),
            'name' => $request->validated()['name'],
            'email' => $request->validated()['email'],
            'username' => $request->validated()['email'], // Use email as username initially
            'password' => Hash::make($request->validated()['password']),
            'role' => $request->validated()['role'],
        ]);

        // Create role-specific record based on selected role
        if ($request->validated()['role'] === 'student') {
            Student::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'fullname' => $request->validated()['name'],
                'nim' => null, // Will be set by admin later
                'angkatan' => null, // Will be set by admin later
                'lecturer_id_1' => null,
                'lecturer_id_2' => null,
            ]);
        } elseif ($request->validated()['role'] === 'lecturer') {
            Lecturer::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'fullname' => $request->validated()['name'],
                'nidn' => null, // Will be set by admin later
                'nip' => null, // Will be set by admin later
            ]);
        }

        // Fire the registered event
        event(new Registered($user));

        // Automatically login the user
        Auth::login($user);

        // Redirect based on user role
        switch ($user->role) {
            case 'student':
                return redirect()->route('dashboard.bimbingan.index');
            case 'lecturer':
                return redirect()->route('dashboard.atur-jadwal-bimbingan.index');
            case 'HoD':
                return redirect()->route('dashboard.aktivitas-bimbingan.index');
            case 'admin':
                return redirect()->route('dashboard');
            default:
                return redirect()->route('dashboard');
        }
    }
}
