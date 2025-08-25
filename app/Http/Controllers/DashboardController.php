<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Guidance;
use App\Models\ExamResult;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * Show the dashboard with statistics and student guidance data
     * for admin users only.
     */
    public function index(): View|RedirectResponse
    {
        // Ensure only admin users can access the dashboard
        if (!Gate::allows('admin')) {
            abort(403);
        }

        // Get students with their guidance relationships
        // Using more explicit relationship loading for better performance
        $studentsWithGuidances = Student::with([
            'user',
            'firstSupervisor',
            'secondSupervisor',
            'latestThesis'
        ])
        ->has('guidances')
        ->withCount('guidances')
        ->get();

        // Calculate statistics for the dashboard cards
        $totalStudents = Student::count();
        $totalLecturers = Lecturer::count();
        $totalGuidances = Guidance::count();

        // Fix: Use the correct variable name that matches the view
        $totalExamResults = ExamResult::where('status_request', 'approved')->count();

        // Pass all variables to the view using the correct variable names
        return view('dashboard.index', compact(
            'studentsWithGuidances',
            'totalStudents',
            'totalLecturers',
            'totalGuidances',
            'totalExamResults'
        ));
    }
}
