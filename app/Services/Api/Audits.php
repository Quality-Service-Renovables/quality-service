<?php

namespace App\Services\Api;

use App\Models\Projects\Audits as ProjectAudits;
use Illuminate\Support\Str;

trait Audits
{
    public function proyectAudits(int $project, int $status, int $log, string $comments = null)
    {
        ProjectAudits::create([
            'project_audit_uuid' => Str::uuid()->toString(),
            'project_id' => $project,
            'status_id' => $status,
            'application_log_id' => $log,
            'comments' => $comments,
        ]);
    }
}
