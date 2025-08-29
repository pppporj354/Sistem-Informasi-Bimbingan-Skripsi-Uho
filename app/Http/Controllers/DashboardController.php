<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Guidance;
use App\Models\ExamResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index(): View
    {
        // Only admin can access this dashboard
        if (! Gate::allows('admin')) {
            abort(403);
        }

        $totalLecturers = Lecturer::count();
        $totalStudents = Student::count();
        $totalGuidances = Guidance::count();
        $totalExamResults = ExamResult::count();

        $studentsWithGuidances = Student::with([
            'user',
            'firstSupervisor',
            'secondSupervisor',
            'latestThesis'
        ])
        ->withCount('guidances')
        ->having('guidances_count', '>', 0)
        ->orderBy('guidances_count', 'desc')
        ->limit(10)
        ->get();

        return view('dashboard.index', compact(
            'totalLecturers',
            'totalStudents',
            'totalGuidances',
            'totalExamResults',
            'studentsWithGuidances'
        ));
    }

    /**
     * Display the student dashboard
     */
    public function student(): View
    {
        if (! Gate::allows('student')) {
            abort(403);
        }

        $student = Auth::user()->student;

        if (!$student) {
            abort(403, 'Student profile not found');
        }

        $hasFirstSupervisor = !is_null($student->lecturer_id_1);
        $hasSecondSupervisor = !is_null($student->lecturer_id_2);

        $guidanceCount = $student->guidances()->count();
        $pendingGuidances = $student->guidances()->where('status_request', 'pending')->count();
        $approvedGuidances = $student->guidances()->where('status_request', 'approved')->count();

        return view('dashboard.student-welcome', compact(
            'student',
            'hasFirstSupervisor',
            'hasSecondSupervisor',
            'guidanceCount',
            'pendingGuidances',
            'approvedGuidances'
        ));
    }

    /**
     * Display the lecturer dashboard
     */
    public function lecturer(): View
    {
        if (! Gate::allows('lecturer')) {
            abort(403);
        }

        $lecturer = Auth::user()->lecturer;

        if (!$lecturer) {
            abort(403, 'Lecturer profile not found');
        }

        $studentsAsFirstSupervisor = Student::where('lecturer_id_1', $lecturer->id)->count();
        $studentsAsSecondSupervisor = Student::where('lecturer_id_2', $lecturer->id)->count();
        $totalStudents = $studentsAsFirstSupervisor + $studentsAsSecondSupervisor;

        $pendingGuidances = Guidance::where('lecturer_id', $lecturer->id)
            ->where('status_request', 'pending')
            ->count();

        return view('dashboard.lecturer-welcome', compact(
            'lecturer',
            'studentsAsFirstSupervisor',
            'studentsAsSecondSupervisor',
            'totalStudents',
            'pendingGuidances'
        ));
    }

    /**
     * Display the HoD dashboard
     */
    public function hod(): View
    {
        if (! Gate::allows('HoD')) {
            abort(403);
        }

        $totalStudents = Student::count();
        $totalLecturers = Lecturer::count();
        $totalGuidances = Guidance::count();
        $pendingExamResults = ExamResult::where('status_request', 'pending')->count();

        return view('dashboard.hod-welcome', compact(
            'totalStudents',
            'totalLecturers',
            'totalGuidances',
            'pendingExamResults'
        ));
    }
}
