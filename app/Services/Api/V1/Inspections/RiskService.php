<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections;

use App\Models\Inspections\CtRisk;
use App\Services\Service;
use Throwable;

class RiskService extends Service
{
    /**
     * Retrieve the list of categories.
     *
     * @return array The response containing the list of categories.
     *
     * @throws \Exception If there is an error retrieving the list of categories.
     */
    public function read(): array
    {
        try {
            $this->response['message'] = trans('api.read');
            $this->response['data'] = CtRisk::all();
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }
}
