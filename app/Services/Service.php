<?php

namespace App\Services;

use App\Services\Applications\ApplicationPaths;
use App\Services\Applications\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class Service
{
    use ApplicationPaths;

    public array $response;

    public int $statusCode;

    public LogService $logService;

    /**
     * Class constructor.
     *
     * Initializes the response array with default values.
     * Sets the default status code to 200.
     * Sets the log module instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->response = [
            'status' => 'ok',
            'message' => null,
            'data' => [],
        ];
        $this->statusCode = 200;
        $this->logService = new LogService();
    }

    /**
     * Set exceptions.
     *
     * Sets the response status to 'error'.
     * Sets the response message to the exception message.
     * Sets the status code to 500.
     *
     * @param  Throwable  $exceptions  The exception object.
     */
    public function setExceptions(Throwable $exceptions): void
    {
        $this->response['status'] = 'error';
        $this->response['message'] = $exceptions->getMessage().' Line: '.$exceptions->getLine();
        $this->statusCode = 500;
    }

    /**
     * Set validation failure response.
     *
     * Updates the status code to 400.
     * Updates the status value to 'fail'.
     * Updates the message value to the provided errors.
     *
     * @param  mixed  $errors  The validation errors.
     */
    public function setFailValidation(mixed $errors): void
    {
        $this->statusCode = 400;
        $this->response['status'] = 'fail';
        $this->response['message'] = $errors;
    }

    /**
     * Sets the fields for the equipment.
     *
     * @param  Request  $request  The request object.
     * @return array The formatted request data.
     *
     * @throws \JsonException
     */
    public function storeFile(Request $request, string $fileRequest, string $fileDatabase, string $module, bool $deleteAttribute = false): array
    {
        $paths = $this->getApplicationPaths();
        // Establece la ruta de guardado
        $storagePath = match ($module) {
            'clients' => $paths->clients->logos,
            'equipments' => $paths->equipments->images,
            'evidences' => $paths->evidences->inspections,
            default => 'tmp',
        };
        // Si se ha seleccionado una imagen se guarda en el storage
        if ($request->hasFile($fileRequest)) {
            $this->addFileToRequest(
                $request,
                $fileRequest,
                $fileDatabase,
                $storagePath,
            );
        }
        // Eliminar atributo
        if ($deleteAttribute) {
            $request->offsetUnset($fileRequest);
        }

        return $request->all();
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
    private function addFileToRequest(Request $request, string $fileRequest, string $fileDatabase, string $storagePath): void
    {
        // Si existe una imagen o manual anterior se purga el archivo
        if ($request->$fileDatabase) {
            $this->purgeFile($request->$fileDatabase);
        }

        // Guardar imagen o manual y obtener ruta
        $path = $request
            ->file($fileRequest)
            ->store($storagePath, 'public_direct');

        // Agregar el atributo a la solicitud
        $request->merge([
            $fileDatabase => $this->getApplicationPaths()->application.$path,
        ]);
    }

    /**
     * Deletes a file if it exists in the storage.
     *
     * If the file exists, it will be deleted from the storage.
     */
    public function purgeFile($path): void
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}
