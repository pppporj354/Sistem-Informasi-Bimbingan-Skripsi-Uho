<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuditController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !in_array(Auth::user()->role, ['admin'])) {
                abort(403, 'Unauthorized - Admin access required');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = AuditLog::with('user')->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('entity_id', 'like', "%{$search}%");
            });
        }

        $auditLogs = $query->paginate(50);

        // Get filter options
        $eventTypes = AuditLog::distinct()->pluck('event_type')->sort();
        $entityTypes = AuditLog::distinct()->whereNotNull('entity_type')->pluck('entity_type')->sort();
        $users = AuditLog::select('user_id', 'user_name')
            ->distinct()
            ->whereNotNull('user_id')
            ->orderBy('user_name')
            ->get();

        // Get statistics
        $stats = [
            'total_logs' => AuditLog::count(),
            'today_logs' => AuditLog::whereDate('created_at', today())->count(),
            'week_logs' => AuditLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'month_logs' => AuditLog::whereMonth('created_at', now()->month)->count(),
        ];

        return view('dashboard.audit.index', compact(
            'auditLogs',
            'eventTypes',
            'entityTypes',
            'users',
            'stats'
        ));
    }

    public function show(AuditLog $auditLog)
    {
        return view('dashboard.audit.show', compact('auditLog'));
    }

    public function getActivity(Request $request)
    {
        $period = $request->get('period', 'weekly'); // daily, weekly, monthly

        switch ($period) {
            case 'daily':
                $data = $this->getDailyActivity();
                break;
            case 'monthly':
                $data = $this->getMonthlyActivity();
                break;
            default:
                $data = $this->getWeeklyActivity();
        }

        return response()->json($data);
    }

    private function getDailyActivity()
    {
        return AuditLog::selectRaw('date(created_at) as date, COUNT(*) as count')
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

    private function getWeeklyActivity()
    {
        return AuditLog::selectRaw('strftime("%Y", created_at) as year, strftime("%W", created_at) as week, COUNT(*) as count')
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

    private function getMonthlyActivity()
    {
        return AuditLog::selectRaw('strftime("%Y", created_at) as year, strftime("%m", created_at) as month, COUNT(*) as count')
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

    public function export(Request $request)
    {
        // Apply same filters as index but export to CSV
        $query = AuditLog::with('user')->orderBy('created_at', 'desc');

        // Apply filters (same as index method)
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('entity_id', 'like', "%{$search}%");
            });
        }

        $auditLogs = $query->limit(10000)->get(); // Limit export to prevent memory issues

        $fileName = 'audit_logs_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        return response()->stream(function () use ($auditLogs) {
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, [
                'Timestamp',
                'Event Type',
                'Entity Type',
                'Entity ID',
                'User',
                'User Role',
                'Description',
                'IP Address',
                'Changes'
            ]);

            foreach ($auditLogs as $log) {
                fputcsv($handle, [
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->event_type,
                    $log->entity_type ?? '',
                    $log->entity_id ?? '',
                    $log->user_name,
                    $log->user_role,
                    $log->description,
                    $log->ip_address ?? '',
                    $log->changes_description ?? ''
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
