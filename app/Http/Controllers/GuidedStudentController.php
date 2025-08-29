<?php

namespace App\Http\Controllers;

use App\Models\Guidance;
use App\Models\Student;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class GuidedStudentController extends Controller
{
    public function __construct()
    {
        if (!Gate::allows('lecturer')) {
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $students = Student::where('lecturer_id_1', Auth::user()->lecturer->id)
            ->orWhere('lecturer_id_2', Auth::user()->lecturer->id)
            ->with(['guidance', 'user', 'thesis'])
            ->get();

        return view('dashboard.mahasiswa-bimbingan.index', compact('students'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $mahasiswa_bimbingan): View
    {
        $guidances = Guidance::where('student_id', $mahasiswa_bimbingan->id)->with('thesis')->get();
        return view('dashboard.mahasiswa-bimbingan.show', compact('mahasiswa_bimbingan', 'guidances'));
    }
}
