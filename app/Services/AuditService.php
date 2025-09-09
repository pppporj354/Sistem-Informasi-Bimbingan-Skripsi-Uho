<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    /**
     * Log an audit event
     */
    public static function log(
        string $eventType,
        string $description,
        ?string $entityType = null,
        ?string $entityId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?Request $request = null
    ): AuditLog {
        $user = Auth::user();
        $request = $request ?: request();

        return AuditLog::create([
            'event_type' => $eventType,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'user_id' => $user?->id,
            'user_name' => $user?->name ?? 'System',
            'user_role' => $user?->role ?? 'system',
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);
    }

    /**
     * Log authentication events
     */
    public static function logAuth(string $eventType, string $description, ?Request $request = null): AuditLog
    {
        return self::log($eventType, $description, null, null, null, null, $request);
    }

    /**
     * Log CRUD operations
     */
    public static function logCrud(
        string $action,
        string $entityType,
        string $entityId,
        string $description,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?Request $request = null
    ): AuditLog {
        return self::log($action, $description, $entityType, $entityId, $oldValues, $newValues, $request);
    }

    /**
     * Log guidance-related events
     */
    public static function logGuidance(
        string $action,
        string $guidanceId,
        string $description,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?Request $request = null
    ): AuditLog {
        return self::logCrud($action, 'Guidance', $guidanceId, $description, $oldValues, $newValues, $request);
    }

    /**
     * Log student-related events
     */
    public static function logStudent(
        string $action,
        string $studentId,
        string $description,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?Request $request = null
    ): AuditLog {
        return self::logCrud($action, 'Student', $studentId, $description, $oldValues, $newValues, $request);
    }

    /**
     * Log lecturer-related events
     */
    public static function logLecturer(
        string $action,
        string $lecturerId,
        string $description,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?Request $request = null
    ): AuditLog {
        return self::logCrud($action, 'Lecturer', $lecturerId, $description, $oldValues, $newValues, $request);
    }

    /**
     * Log user management events
     */
    public static function logUser(
        string $action,
        string $userId,
        string $description,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?Request $request = null
    ): AuditLog {
        return self::logCrud($action, 'User', $userId, $description, $oldValues, $newValues, $request);
    }

    /**
     * Log exam-related events
     */
    public static function logExam(
        string $action,
        string $examId,
        string $description,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?Request $request = null
    ): AuditLog {
        return self::logCrud($action, 'ExamResult', $examId, $description, $oldValues, $newValues, $request);
    }

    /**
     * Log system administration events
     */
    public static function logSystem(string $description, ?Request $request = null): AuditLog
    {
        return self::log('system', $description, null, null, null, null, $request);
    }

    /**
     * Get recent audit logs
     */
    public static function getRecentLogs(int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        return AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get audit logs for a specific entity
     */
    public static function getEntityLogs(string $entityType, string $entityId): \Illuminate\Database\Eloquent\Collection
    {
        return AuditLog::with('user')
            ->where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get audit logs for a specific user
     */
    public static function getUserLogs(string $userId): \Illuminate\Database\Eloquent\Collection
    {
        return AuditLog::with('user')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
