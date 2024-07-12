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
     * @param Throwable $exceptions The exception object.
     */
    public function setExceptions(Throwable $exceptions): void
    {
        $this->response['status'] = 'error';
        $this->response['message'] = $exceptions->getMessage() . ' Line: ' . $exceptions->getLine();
        $this->statusCode = 500;
    }

    /**
     * Set validation failure response.
     *
     * Updates the status code to 400.
     * Updates the status value to 'fail'.
     * Updates the message value to the provided errors.
     *
     * @param mixed $errors The validation errors.
     */
    public function setFailValidation(mixed $errors): void
    {
        $this->statusCode = 400;
        $this->response['status'] = 'fail';
        $this->response['message'] = $errors;
    }

    /**
     * @throws \JsonException
     */
    public function storeFile(Request $request, string $file, string $module, ?string $path = null): Request
    {
        // Obtiene el directorio en base al módulo solicitado
        $directory = $this->getDirectory($module);
        // Si se ha seleccionado una archivo se guarda en el storage
        if ($request->hasFile($file)) {
            // Guardar archivo y obtener ruta
            $pathStorage = $request
                ->file($file)
                ->store($directory, 'public_direct');
            /**
             * En caso de no recibir un nombre de atributo personalizado en $path
             * Se establece el mismo nombre del atributo $file en una instancia
             * clonada del Request, en caso de proveer el nombre personalizado en el
             * atributo $path se retorna sobre este atributo la ruta de guardado del documento.
             **/
            if (($file === $path) || !$path) {
                $path = $file;
                $request = new Request($request->except($file));
            }
            $request->merge([
                $path => $this->getApplicationPaths()->application . $pathStorage,
            ]);
        }

        return $request;
    }

    /**
     * @throws \JsonException
     */
    private function getDirectory($module): string
    {
        $paths = $this->getApplicationPaths();

        // Establece la ruta de guardado
        return match ($module) {
            'clients' => $paths->clients->logos,
            'equipment_images' => $paths->equipments->images,
            'equipment_documents' => $paths->equipments->documents,
            'equipment_diagrams' => $paths->equipments->diagrams,
            'evidences' => $paths->evidences->inspections,
            'users' => $paths->users->image_profile,
            default => 'tmp',
        };
    }

    /**
     * Deletes a file if it exists in the storage.
     *
     * If the file exists, it will be deleted from the storage.
     */
    public function purgeFile($path, $disk = 'public_direct'): void
    {
        if (Storage::disk($disk)->exists($path)) {
            $filename = pathinfo($path, PATHINFO_FILENAME);
            if ($filename !== 'default') {
                Storage::disk($disk)->delete($path);
            }
        }
    }
}
