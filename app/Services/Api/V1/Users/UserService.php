<?php
/**
 * Equipment Service.
 *
 * Register equipments
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

namespace App\Services\Api\V1\Users;

use App\Models\Equipments\Category;
use App\Models\Equipments\Equipment;
use App\Models\Users\User;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class UserService extends Service implements ServiceInterface
{
    public string $nameService = 'user_service';

    private string $imageDefault = 'img/users/default.png';

    public function create(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Agrega atributos a la solicitud
            $request->merge(['uuid' => Str::uuid()->toString()]);
            // Obtiene los identificadores de los códigos y depura atributos a la solicitud
            $input = $this->setRequest($request);
            // Registra los atributos de la solicitud al usuario
            $user = User::create($input);
            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = $user;
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

    public function read(): array
    {
        $this->response['message'] = trans('api.read');
        $this->response['data'] = User::with(['client', 'roles'])->get();

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
            // Obtiene los identificadores de los códigos y depura atributos a la solicitud
            $input = $this->setRequest($request);
            // En caso de que no se detecte una imágen se establece una por defecto
            $input['equipment_image'] = $input['equipment_image'] ?? $this->imageDefault;
            // Actualiza Equipo
            Equipment::where('equipment_uuid', $request->equipment_uuid)->update($input);
            // Recupera Equipo Actualizado
            $equipmentUpdated = Equipment::where('equipment_uuid', $request->equipment_uuid)->first();
            $this->response['message'] = trans('api.updated');
            $this->response['data'] = $equipmentUpdated;
            // Registro de log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                trans('api.message_log'),
            );
            // Confirmación de transacción
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
            Equipment::where('equipment_uuid', $uuid)->update(['deleted_at' => now()]);
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
            // Obtiene categoria del equipo
            $equipment = Equipment::with([
                'category', 'status', 'trademark', 'model',
            ])->where('equipment_uuid', $uuid)->first();
            $this->response['message'] = $equipment === null
                ? trans('api.not_found')
                : trans('api.show');
            $this->response['data'] = $equipment ?? [];
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Sets the request data for the equipment.
     *
     * @param  Request  $request  The request object.
     * @return array The formatted request data.
     *
     * @throws \JsonException
     */
    private function setRequest(Request $request): array
    {
        // Obtiene identificadores de códigos
        $rolId = Category::where('rol_code', $request->get('rol_code'))->first()->id;
        // Agrupa el contenido a insertar en la solicitud
        $extraAttributes = [
            'equipment_code' => create_slug($request->equipment),
            'ct_equipment_id' => $categoryId,
            'trademark_id' => $trademarkId,
            'trademark_model_id' => $trademarkModelId,
            'status_id' => $statusId,
        ];
        // Agrupa contenido en la solicitud
        $request->merge($extraAttributes);

        // Omite contenido de la solicitud
        return $this->setFields($request);
    }

    /**
     * Sets the fields for the equipment.
     *
     * @param  Request  $request  The request object.
     * @return array The formatted request data.
     *
     * @throws \JsonException
     */
    private function setFields(Request $request): array
    {
        $paths = $this->getApplicationPaths();

        // Si se ha seleccionado una imagen para el equipo se guarda en el storage
        if ($request->hasFile('equipment_image_storage')) {
            $this->addFileToRequest(
                $request,
                'equipment_image_storage',
                'equipment_image',
                $paths->equipments->images
            );
        }

        // Si se ha seleccionado un manual para el equipo se guarda en el storage
        if ($request->hasFile('manual_storage')) {
            $this->addFileToRequest(
                $request,
                'manual_storage',
                'manual',
                $paths->equipments->documents
            );
        }

        return $request->except([
            'ct_equipment_code',
            'trademark_code',
            'trademark_model_code',
            'status_code',
            'equipment_image_storage',
            'manual_storage',
        ]);
    }

    /**
     * Adds a file to the request and removes the original file field.
     *
     * @param  Request  $request  The request object.
     * @param  string  $fileField  The file field in the request.
     * @param  string  $newField  The new field key to replace the original with in the request.
     * @param  string  $storagePath  The storage path for the file.
     *
     * @throws \JsonException
     */
    private function addFileToRequest(Request $request, string $fileField, string $newField, string $storagePath): void
    {
        // Si existe una imagen o manual anterior se purga el archivo
        if ($request->$newField) {
            $this->purgeFile($request->$newField);
        }

        // Eliminar atributo
        $request->offsetUnset($newField);
        // Guardar imagen o manual y obtener ruta
        $path = $request
            ->file($fileField)
            ->store($storagePath, 'public_direct');

        // Agregar el atributo a la solicitud
        $request->merge([
            $newField => $this->getApplicationPaths()->application.$path,
        ]);
    }

    /**
     * Retrieves users based on their role.
     *
     * @param  string  $rol  The role to filter users.
     * @return array The response containing the users.
     */
    public function getRolUsers(string $rol): array
    {
        $this->response['message'] = trans('api.read');
        $this->response['data'] = User::role($rol)->get();

        return $this->response;
    }
}
