<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections\Reports;

use App\Models\Inspections\Inspection;
use App\Services\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Throwable;

class ReportService extends Service
{
    public string $nameService = 'inspection_equipment';

    public string $filename = 'inspection_report';
    public $document = false;

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
            $user = auth()->user()->load('client');
            $inspection = Inspection::with([
                'client',
                'equipment.model.trademark',
                'category.sections.subSections.fields.result',
                'inspectionEquipments.equipment',
                'evidences',
            ])->where('inspection_uuid', $uuid)->first();

            if ($inspection) {
                $inspection->provider = $user->client;
                $this->document = PDF::loadView('api.V1.Inspections.Reports.inspection_report', compact('inspection'));
                $this->filename = $inspection->category->ct_inspection_code.'_'.now()->format('Y-m-d H:i:s').'.pdf';
                $this->document->download($this->filename);
            }
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }
}
