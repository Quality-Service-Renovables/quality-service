<?php

namespace App\Services;

use App\Services\Applications\ApplicationPaths;
use App\Services\Applications\LogService;
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
        $this->response['message'] = $exceptions->getMessage();
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
