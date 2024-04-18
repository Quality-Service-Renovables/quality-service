<?php

/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedMethodInspection */

namespace App\Http\Modules\Api\V1\Equipments;

use App\Http\Modules\Applications\LogModule;
use App\Models\Equipments\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryModule
{
    public string $nameModule;

    public array $response;

    public int $statusCode;

    public LogModule $logModule;

    /**
     * Class constructor.
     * Sets the name module, response array, status code and log module.
     *
     * @return void
     */
    public function __construct()
    {
        $this->nameModule = 'equipment_module';
        $this->response = [
            'status' => 'ok',
            'message' => null,
            'data' => [],
        ];
        $this->statusCode = 200;
        $this->logModule = new LogModule();
    }

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
            // Agrega atributos a la solicitud
            $request->merge(['equipment_category_uuid' => Str::uuid()->toString()]);
            $request->merge(['equipment_category_code' => create_slug($request->get('equipment_category'))]);
            // Registra los atributos de la solicitud a la categoria
            $category = Category::create($request->all());
            // Define parámetros de respuesta
            $this->statusCode = 201;
            $this->response['data'] = $category;
            // Registro en log
            $this->logModule->create(
                $this->nameModule,
                $request->all(),
                $this->response,
                'Create equipment request',
            );
            // Finaliza Transacción
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            // Parámetros de respuesta en caso de error
            $this->response['status'] = 'error';
            $this->response['message'] = $exception->getMessage();
            $this->statusCode = 500;
        }
        // Respuesta del módulo
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
            // Asignación de identificadores
            $slug = create_slug($request->get('equipment_category'));
            // Agregar elementos al request
            $request->merge([
                'equipment_category_code' => $slug,
            ]);
            // Actualiza Equipo
            Category::where('equipment_category_uuid', $request->equipment_category_uuid)->update($request->all());
            // Recupera Equipo Actualizado
            $equipmentUpdated = Category::where('equipment_category_uuid', $request->equipment_category_uuid)->first();
            $this->response['data'] = $equipmentUpdated;
            // Registro de log
            $this->logModule->create(
                $this->nameModule,
                $request->all(),
                $this->response,
                'Update equipment request',
            );
            // Confirmación de transacción
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            // Parámetros de respuesta en caso de error
            $this->response['status'] = 'error';
            $this->response['message'] = $exception->getMessage();
            $this->statusCode = 500;
        }

        return $this->response;
    }

    /**
     * Retrieve all equipment data
     *
     * @return array Returns an array containing the equipment data
     */
    public function read(): array
    {
        $this->response['data'] = Category::all();

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
            Category::where('equipment_category_uuid', $uuid)->update(['deleted_at' => now()]);
            // Registro en Log
            $this->logModule->create(
                $this->nameModule,
                compact('uuid'),
                $this->response,
                'Delete equipment category request',
            );
            // Parámetros de respuesta
            $this->response['message'] = 'Category deleted successfully';
        } catch (Exception $exception) {
            // Parámetros de respuesta en caso de error
            $this->response['status'] = 'error';
            $this->response['message'] = $exception->getMessage();
            $this->statusCode = 500;
        }

        return $this->response;
    }

    public function show(string $uuid): array
    {
        try {
            // Obtiene categoria del equipo
            $category = Category::where('equipment_category_uuid', $uuid)->first();
            $this->response['message'] = $category === null ? 'Category not found' : 'Category found';
            $this->response['data'] = $category ?? [];
        } catch (Exception $exception) {
            DB::rollBack();
            // Parámetros de respuesta en caso de error
            $this->response['status'] = 'error';
            $this->response['message'] = $exception->getMessage();
            $this->statusCode = 500;
        }

        return $this->response;
    }
}
