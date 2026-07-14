<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;


class AuditLogService
{
    public function log(string $action, string $subjectType, ?int $subjectId, string $description): void
    {
        \App\Models\AuditLog::create([
            'user_name' => Auth::check() ? Auth::user()->name : 'Guest',
            'action' => $action,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'description' => $description,
        ]);
    }
}
