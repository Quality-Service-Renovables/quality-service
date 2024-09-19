<?php

/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\MobileApp;

use App\Models\Status\Category;
use App\Models\Status\Status;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class MobileAppService extends Service
{
    public string $nameService = 'mobile_app_service';

    /**
     * Creates a new trademark based on the provided request data.
     *
     * @param Request $request The request object containing the trademark data.
     *
     * @return array The response array containing the created trademark data.
     *
     * @throws Throwable If an error occurs during the creation process.
     */
    public function sync(): array
    {
        try {
            $user = auth()->user();

            $categoryStatus = Category::where([
                'ct_status_code' => 'proyecto'
            ])->first();

            $status = Status::where([
                    'ct_status_id' => $categoryStatus->ct_status_id,
                ])->get();

            $status->each(function ($status) use ($user) {
                $status->projects = DB::table('project_employees')
                    ->join('projects', 'projects.project_id', '=', 'project_employees.project_id')
                    ->join('status', 'status.status_id', '=', 'projects.status_id')
                    ->whereNull('project_employees.deleted_at')
                    ->whereNull('projects.deleted_at')
                    ->whereNull('status.deleted_at')
                    ->where([
                        'status.status_id' => $status->status_id,
                        'project_employees.user_id' => $user->id
                    ])
                    ->select('projects.*')
                    ->get();
                if ($status->projects->isNotEmpty()) {
                    $status->projects->each(function ($project) {
                        $inspection = DB::table('inspections')
                            ->join(
                                'ct_inspections',
                                'ct_inspections.ct_inspection_id',
                                '=', 'inspections.ct_inspection_id'
                            )->where('project_id', $project->project_id)
                            ->first();
                        dd($inspection);
                        // Requeridos para la app
                        $project->inspection_uuid = $inspection?->inspection_uuid;
                        $project->ct_inspection_uuid = $inspection?->ct_inspection_uuid;
                    });
                }
            });
            // Define parámetros de respuesta
            $this->statusCode = 200;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = [
                'status' => $status,
            ];
        } catch (Throwable $exceptions) {
            // Parámetros de respuesta en caso de error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }
}
