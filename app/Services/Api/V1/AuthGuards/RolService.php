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

namespace App\Services\Api\V1\AuthGuards;

use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolService extends Service implements ServiceInterface
{
    public string $nameService = 'auth_guard_rol_service';

    /**
     * Create a new equipment
     *
     * @param Request $request The request object
     *
     * @return array Returns an array containing the created equipment data
     */
    public function create(Request $request): array
    {
    }

    /**
     * Retrieve all equipment data
     *
     * @return array Returns an array containing the equipment data
     */
    public function read(): array
    {
        $this->response['message'] = trans('api.read');
        $this->response['data'] = Role::with('permissions')->get();

        return $this->response;
    }

    /**
     * Update equipment data
     *
     * @param Request $request The request object containing the updated data
     *
     * @return array Returns an array containing the updated equipment data
     */
    public function update(Request $request): array
    {
    }

    /**
     * Delete equipment by UUID.
     *
     * @param string $uuid The UUID of the equipment to be deleted.
     *
     * @return array The response array with status, message, and data.
     */
    public function delete(string $uuid): array
    {
    }

    /**
     * Retrieves a category by UUID
     *
     * @param string $uuid The UUID of the category to retrieve
     *
     * @return array Returns an array containing the status, message, and data of the response
     */
    public function show(string $uuid): array
    {
    }
}
