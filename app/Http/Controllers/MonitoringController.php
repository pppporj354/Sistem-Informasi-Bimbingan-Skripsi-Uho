<?php

namespace App\Http\Controllers;

use App\Models\Guidance;
use App\Models\Lecturer;
use App\Models\Student;
use App\Exports\GuidanceExport;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MonitoringController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('HoD') && !Gate::allows('admin')) {
                abort(403);
            }
            return $next($request);
        });
    }

    /**
     * Monitoring Bimbingan - daftar dan filter
     */
    public function index(Request $request): View
    {
        $status = $request->query('status'); // pending|approved|null
        $lecturerId = $request->query('lecturer_id');
        $q = $request->query('q'); // cari nama / NIM mahasiswa
        $start = $request->query('start_date');
        $end = $request->query('end_date');

        $guidancesQuery = Guidance::with(['student.user', 'lecturer.user', 'thesis'])
            ->latest('schedule');

        if ($status && in_array($status, ['pending', 'approved'])) {
            $guidancesQuery->where('status_request', $status);
        }

        if ($lecturerId && $lecturerId !== 'all') {
            $guidancesQuery->where('lecturer_id', $lecturerId);
        }

        if ($q) {
            $guidancesQuery->whereHas('student', function ($sq) use ($q) {
                $sq->where('nim', 'like', "%$q%");
            })->orWhereHas('student.user', function ($uq) use ($q) {
                $uq->where('name', 'like', "%$q%");
            });
        }

        if ($start) {
            $guidancesQuery->whereDate('schedule', '>=', $start);
        }

        if ($end) {
            $guidancesQuery->whereDate('schedule', '<=', $end);
        }

        $guidances = $guidancesQuery->paginate(20)->withQueryString();

        // Statistik ringkas (berdasarkan filter saat ini, kecuali status)
        $baseStatsQuery = Guidance::query();
        if ($lecturerId && $lecturerId !== 'all') {
            $baseStatsQuery->where('lecturer_id', $lecturerId);
        }
        if ($q) {
            $baseStatsQuery->whereHas('student', function ($sq) use ($q) {
                $sq->where('nim', 'like', "%$q%");
            })->orWhereHas('student.user', function ($uq) use ($q) {
                $uq->where('name', 'like', "%$q%");
            });
        }
        if ($start) {
            $baseStatsQuery->whereDate('schedule', '>=', $start);
        }
        if ($end) {
            $baseStatsQuery->whereDate('schedule', '<=', $end);
        }

        $totalCount = (clone $baseStatsQuery)->count();
        $pendingCount = (clone $baseStatsQuery)->where('status_request', 'pending')->count();
        $approvedCount = (clone $baseStatsQuery)->where('status_request', 'approved')->count();

        $lecturers = Lecturer::with('user')->get()->sortBy(function ($lec) {
            return $lec->user->name;
        })->values();

        return view('dashboard.monitoring.index', [
            'guidances' => $guidances,
            'lecturers' => $lecturers,
            'filters' => [
                'status' => $status,
                'lecturer_id' => $lecturerId,
                'q' => $q,
                'start_date' => $start,
                'end_date' => $end,
            ],
            'stats' => [
                'total' => $totalCount,
                'pending' => $pendingCount,
                'approved' => $approvedCount,
            ]
        ]);
    }

    /**
     * Export guidance data to Excel
     */
    public function export(Request $request): BinaryFileResponse
    {
        $filters = [
            'status' => $request->query('status'),
            'lecturer_id' => $request->query('lecturer_id'),
            'q' => $request->query('q'),
            'start_date' => $request->query('start_date'),
            'end_date' => $request->query('end_date'),
        ];

        $filename = 'monitoring-bimbingan-' . date('Y-m-d-H-i-s') . '.xlsx';
        
        return Excel::download(new GuidanceExport($filters), $filename);
    }

    /**
     * Workload monitoring per lecturer
     */
    public function workload(Request $request): View
    {
        $lecturerId = $request->query('lecturer_id');
        $month = $request->query('month') ?? date('Y-m');

        $lecturersQuery = Lecturer::with(['user']);

        if ($lecturerId && $lecturerId !== 'all') {
            $lecturersQuery->where('id', $lecturerId);
        }

        $lecturers = $lecturersQuery->get();

        $workloadData = [];

        foreach ($lecturers as $lecturer) {
            $studentsCount = Student::where('lecturer_id_1', $lecturer->id)
                ->orWhere('lecturer_id_2', $lecturer->id)
                ->count();

            $guidancesThisMonth = Guidance::where('lecturer_id', $lecturer->id)
                ->whereYear('schedule', substr($month, 0, 4))
                ->whereMonth('schedule', substr($month, 5, 2))
                ->count();

            $pendingGuidances = Guidance::where('lecturer_id', $lecturer->id)
                ->where('status_request', 'pending')
                ->count();

            $workloadData[] = [
                'lecturer' => $lecturer,
                'students_count' => $studentsCount,
                'guidances_this_month' => $guidancesThisMonth,
                'pending_guidances' => $pendingGuidances,
            ];
        }

        $allLecturers = Lecturer::with('user')->get()->sortBy(function ($lec) {
            return $lec->user->name;
        })->values();

        return view('dashboard.monitoring.workload', [
            'workloadData' => $workloadData,
            'lecturers' => $allLecturers,
            'filters' => [
                'lecturer_id' => $lecturerId,
                'month' => $month,
            ]
        ]);
    }

    /**
     * Progress monitoring per student
     */
    public function progress(Request $request): View
    {
        $lecturerId = $request->query('lecturer_id');
        $batch = $request->query('batch');
        $q = $request->query('q');

        $studentsQuery = Student::with(['user', 'firstSupervisor.user', 'secondSupervisor.user', 'thesis'])
            ->withCount(['guidances', 'guidances as approved_guidances_count' => function ($query) {
                $query->where('status_request', 'approved');
            }]);

        if ($lecturerId && $lecturerId !== 'all') {
            $studentsQuery->where(function ($query) use ($lecturerId) {
                $query->where('lecturer_id_1', $lecturerId)
                    ->orWhere('lecturer_id_2', $lecturerId);
            });
        }

        if ($batch) {
            $studentsQuery->where('batch', $batch);
        }

        if ($q) {
            $studentsQuery->where(function ($query) use ($q) {
                $query->where('nim', 'like', "%$q%")
                    ->orWhereHas('user', function ($uq) use ($q) {
                        $uq->where('name', 'like', "%$q%");
                    });
            });
        }

        $students = $studentsQuery->paginate(20)->withQueryString();

        $lecturers = Lecturer::with('user')->get()->sortBy(function ($lec) {
            return $lec->user->name;
        })->values();

        $batches = Student::select('batch')->distinct()->orderBy('batch', 'desc')->pluck('batch');

        return view('dashboard.monitoring.progress', [
            'students' => $students,
            'lecturers' => $lecturers,
            'batches' => $batches,
            'filters' => [
                'lecturer_id' => $lecturerId,
                'batch' => $batch,
                'q' => $q,
            ]
        ]);
    }
}
