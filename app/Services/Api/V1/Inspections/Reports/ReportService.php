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
    public function getDocument(string $uuid)
    {
        try {
            $user = auth()->user()->load('client');

            $document = response();
            $inspection = Inspection::with([
                'client',
                'equipment.equipment.model.trademark',
                'category.sections.subSections.fields.result',
                'equipmentsInspection.equipment',
                'evidences',
            ])->where('inspection_uuid', $uuid)->first();

            if ($inspection) {
                $inspection->provider = $user->client;
                $document = PDF::loadView('api.V1.Inspections.Reports.inspection_report', compact('inspection'));
                $filename = $inspection->category->ct_inspection_code.'_'.now()->format('Y-m-d H:i:s');

                return $document->download($filename);
            }

            return $document;

        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }
}
