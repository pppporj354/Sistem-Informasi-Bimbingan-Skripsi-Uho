<?php

namespace App\Http\Controllers;

use App\Models\Guidance;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Thesis;
use App\Models\ExamResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'HoD'])) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function index()
    {
        // Get basic statistics
        $totalStudents = Student::count();
        $totalLecturers = Lecturer::count();
        $totalGuidances = Guidance::count();
        $totalTheses = Thesis::count();

        // Guidance status statistics
        $guidanceStatusStats = Guidance::select('status_request', DB::raw('count(*) as count'))
            ->groupBy('status_request')
            ->get()
            ->pluck('count', 'status_request')
            ->toArray();

        // Monthly guidance trends (last 12 months)
        $monthlyGuidances = Guidance::select(
                DB::raw('strftime("%Y", created_at) as year'),
                DB::raw('strftime("%m", created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Lecturer workload distribution
        $lecturerWorkload = Lecturer::withCount('guidances')
            ->with('user:id,name')
            ->get()
            ->map(function ($lecturer) {
                return [
                    'name' => $lecturer->user->name,
                    'count' => $lecturer->guidances_count
                ];
            });

        // Student progress by concentration
        $concentrationProgress = Student::select('concentration', DB::raw('count(*) as count'))
            ->groupBy('concentration')
            ->get()
            ->pluck('count', 'concentration')
            ->toArray();

        // Exam results statistics
        $examStats = ExamResult::select('status_request', DB::raw('count(*) as count'))
            ->groupBy('status_request')
            ->get()
            ->pluck('count', 'status_request')
            ->toArray();

        // Recent activity (last 30 days)
        $recentActivity = [
            'new_guidances' => Guidance::where('created_at', '>=', Carbon::now()->subDays(30))->count(),
            'approved_guidances' => Guidance::where('status_request', 'approved')
                ->where('updated_at', '>=', Carbon::now()->subDays(30))->count(),
            'new_theses' => Thesis::where('created_at', '>=', Carbon::now()->subDays(30))->count(),
            'exam_requests' => ExamResult::where('created_at', '>=', Carbon::now()->subDays(30))->count(),
        ];

        // Weekly guidance trends (last 8 weeks)
        $weeklyGuidances = Guidance::select(
                DB::raw('strftime("%Y", created_at) as year'),
                DB::raw('strftime("%W", created_at) as week'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subWeeks(8))
            ->groupBy('year', 'week')
            ->orderBy('year', 'asc')
            ->orderBy('week', 'asc')
            ->get();

        return view('dashboard.analytics.index', compact(
            'totalStudents',
            'totalLecturers',
            'totalGuidances',
            'totalTheses',
            'guidanceStatusStats',
            'monthlyGuidances',
            'lecturerWorkload',
            'concentrationProgress',
            'examStats',
            'recentActivity',
            'weeklyGuidances'
        ));
    }

    public function getGuidanceData(Request $request)
    {
        $period = $request->get('period', 'monthly'); // daily, weekly, monthly, yearly

        switch ($period) {
            case 'daily':
                $data = $this->getDailyGuidanceData();
                break;
            case 'weekly':
                $data = $this->getWeeklyGuidanceData();
                break;
            case 'yearly':
                $data = $this->getYearlyGuidanceData();
                break;
            default:
                $data = $this->getMonthlyGuidanceData();
        }

        return response()->json($data);
    }

    private function getDailyGuidanceData()
    {
        return Guidance::select(
                DB::raw('date(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => Carbon::parse($item->date)->format('M d'),
                    'value' => $item->count
                ];
            });
    }

    private function getWeeklyGuidanceData()
    {
        return Guidance::select(
                DB::raw('strftime("%Y", created_at) as year'),
                DB::raw('strftime("%W", created_at) as week'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subWeeks(12))
            ->groupBy('year', 'week')
            ->orderBy('year', 'asc')
            ->orderBy('week', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => "Week {$item->week}, {$item->year}",
                    'value' => $item->count
                ];
            });
    }

    private function getMonthlyGuidanceData()
    {
        return Guidance::select(
                DB::raw('strftime("%Y", created_at) as year'),
                DB::raw('strftime("%m", created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => Carbon::create($item->year, $item->month, 1)->format('M Y'),
                    'value' => $item->count
                ];
            });
    }

    private function getYearlyGuidanceData()
    {
        return Guidance::select(
                DB::raw('strftime("%Y", created_at) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->year,
                    'value' => $item->count
                ];
            });
    }

    public function getLecturerPerformance()
    {
        $lecturerStats = Lecturer::with('user:id,name')
            ->withCount([
                'guidances',
                'guidances as pending_guidances_count' => function ($query) {
                    $query->where('status_request', 'pending');
                },
                'guidances as approved_guidances_count' => function ($query) {
                    $query->where('status_request', 'approved');
                }
            ])
            ->get()
            ->map(function ($lecturer) {
                $total = $lecturer->guidances_count;
                $approved = $lecturer->approved_guidances_count;
                $approvalRate = $total > 0 ? round(($approved / $total) * 100, 1) : 0;

                return [
                    'name' => $lecturer->user->name,
                    'total_guidances' => $total,
                    'pending_guidances' => $lecturer->pending_guidances_count,
                    'approved_guidances' => $approved,
                    'approval_rate' => $approvalRate
                ];
            })
            ->sortByDesc('total_guidances');

        return response()->json($lecturerStats);
    }

    public function getStudentProgress()
    {
        $studentProgress = Student::with('user:id,name')
            ->withCount([
                'guidances',
                'guidances as approved_guidances_count' => function ($query) {
                    $query->where('status_request', 'approved');
                }
            ])
            ->get()
            ->map(function ($student) {
                $total = $student->guidances_count;
                $approved = $student->approved_guidances_count;
                $progress = $total > 0 ? round(($approved / $total) * 100, 1) : 0;

                return [
                    'name' => $student->user->name,
                    'nim' => $student->formattedNIM,
                    'concentration' => $student->concentration,
                    'total_guidances' => $total,
                    'approved_guidances' => $approved,
                    'progress_percentage' => $progress
                ];
            })
            ->sortByDesc('progress_percentage');

        return response()->json($studentProgress);
    }
}
