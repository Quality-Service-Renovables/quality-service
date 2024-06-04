<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections\Reports;

use App\Models\Equipments\Equipment;
use App\Models\Inspections\Equipment as InspectionEquipment;
use App\Models\Inspections\Inspection;
use App\Services\Api\V1\Inspections\Throwable;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportService extends Service
{
    public string $nameService = 'inspection_equipment';
    /**
     * Retrieve the list of categories.
     *
     * @return array The response containing the list of categories.
     *
     * @throws \Exception If there is an error retrieving the list of categories.
     */
    public function getResume(string $uuid)
    {
        try {
            $inspection = Inspection::with([
                'category.sections',
                'equipments.equipment',
                'evidences',
                'forms.field',
            ])->where(['inspection_uuid' => $uuid])->first();

            $this->response['data'] = $inspection;

        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }

    /**
     * Retrieve the list of categories.
     *
     * @return array The response containing the list of categories.
     *
     * @throws \Exception If there is an error retrieving the list of categories.
     */
    public function getDocument(string $uuid): array
    {
        try {
            $inspection = Inspection::with([
                'equipment.equipment.model.trademark',
                'category.sections.subSections.fields.result',
                'equipmentsInspection.equipment',
                'evidences',
            ])->where('inspection_uuid', $uuid)->first();

            $document = PDF::loadView('api.V1.Inspections.Reports.inspection_report', compact('inspection'));

            return $document->download();
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }
}
