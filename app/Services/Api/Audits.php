<?php

namespace App\Services\Api;

use App\Models\Projects\Audits as ProjectAudits;
use http\Exception\RuntimeException;
use Throwable;

Trait Audits
{
    public function proyectAudits(array $project)
    {
        try {
            ProjectAudits::create($project);
        } catch (Throwable $exception) {
            throw new RuntimeException([
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
            ]);
        }
    }
}
