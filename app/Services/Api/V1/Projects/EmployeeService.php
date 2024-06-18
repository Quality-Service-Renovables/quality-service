<?php
/**
 * Porject Employees Service.
 *
 * Register relation project with employees
 *
 * @author   Luis Adrian Olvera Facio
 *
 * @version  1.0
 *
 * @since    2024.1
 */

/** @noinspection NullPointerExceptionInspection */

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Projects;

use App\Models\Projects\Employee;
use App\Models\Projects\Project;
use App\Models\Status\Status;
use App\Models\Users\User;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class EmployeeService extends Service implements ServiceInterface
{
    public string $nameService = 'project_employee_service';

    /**
     * Create a new equipment
     *
     * @param  Request  $request  The request object
     * @return array Returns an array containing the created equipment data
     */
    public function create(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            $project = Project::where('project_uuid', '=', $request->project_uuid)->first();
            $project->status_id = Status::where('status_code', '=', 'proceso_asignado')
                ->first()->status_id;
            $project->save();

            foreach ($request->employees as $employee) {
                $user = User::where('uuid', '=', $employee['employee_uuid'])->first();
                // Agrega atributos a la solicitud
                $request->merge([
                    'project_employee_uuid' => Str::uuid()->toString(),
                    'user_id' => $user->id,
                    'project_id' => $project->project_id,
                ]);

                // Registra los atributos de la solicitud
                $this->statusCode = 201;
                $this->response['message'] = trans('api.created');
                $this->response['data'][] = Employee::firstOrCreate([
                    'user_id' => $request->user_id,
                    'project_id' => $request->project_id,
                ], [
                    'project_employee_uuid' => $request->project_employee_uuid,
                ]);
            }
            // Registro en log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                trans('api.message_log'),
            );
            // Finaliza Transacción
            DB::commit();
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Retrieve all equipment data
     *
     * @return array Returns an array containing the equipment data
     */
    public function read(): array
    {
        $this->response['message'] = trans('api.read');
        $this->response['data'] = Employee::with(['user', 'project'])->get();

        return $this->response;
    }

    /**
     * Update equipment data
     *
     * @param  Request  $request  The request object containing the updated data
     * @return array Returns an array containing the updated equipment data
     */
    public function update(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            $project = Project::where('project_uuid', '=', $request->project_uuid)->first();
            $user = User::where('uuid', '=', $request->employee_uuid)->first();
            // Agrega atributos a la solicitud
            $request->merge([
                'user_id' => $user->id,
                'project_id' => $project->project_id,
            ]);
            // Registra los atributos de la solicitud
            $this->response['message'] = trans('api.created');
            $this->response['data'] = Employee::updateOrCreate([
                'user_id' => $request->user_id,
                'project_id' => $request->project_id,
            ], [
                'update_at' => now(),
            ]);
            // Registro en log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                trans('api.message_log'),
            );
            // Finaliza Transacción
            DB::commit();
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Delete equipment by UUID.
     *
     * @param  string  $uuid  The UUID of the equipment to be deleted.
     * @return array The response array with status, message, and data.
     */
    public function delete(string $uuid): array
    {
        try {
            // Aplica soft delete al equipo especificado por medio de su uuid
            Employee::where('project_employee_uuid', $uuid)->update(['deleted_at' => now()]);
            $this->logService->create(
                $this->nameService,
                compact('uuid'),
                $this->response,
                trans('api.message_log'),
            );
            $this->response['message'] = trans('api.deleted');
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Retrieves a category by UUID
     *
     * @param  string  $uuid  The UUID of the category to retrieve
     * @return array Returns an array containing the status, message, and data of the response
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene categoría del equipo
            $project = Employee::with([
                'user', 'project',
            ])->where('project_employee_uuid', $uuid)->first();
            $this->response['message'] = $project === null
                ? trans('api.not_found')
                : trans('api.show');
            $this->response['data'] = $project ? $project->toArray() : [];
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }
}
