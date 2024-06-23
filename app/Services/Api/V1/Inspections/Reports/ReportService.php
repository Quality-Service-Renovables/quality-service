<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections\Reports;

use App\Models\Inspections\Inspection;
use App\Services\Api\Audits;
use App\Services\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ReportService extends Service
{
    use Audits;
    public string $nameService = 'inspection_report';

    /**
     * Get the document for a given inspection UUID.
     *
     * @param string $uuid The inspection UUID.
     *
     * @return array The response containing the document information.
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
                'project',
            ])->where('inspection_uuid', $uuid)->first();
            dd($inspection);
            if ($inspection) {
                $inspection->provider = $user->client;
                // Generación de la vista en base a la información de la colección.
                $document = PDF::loadView('api.V1.Inspections.Reports.inspection_report', compact('inspection'));
                // Nombre del documento
                $filename = $inspection->category->ct_inspection_code.'_'.now()->format('Y-m-d_His').'.pdf';
                // Obtener el contenido PDF como una cadena
                $pdfContent = $document->output();
                $paths = $this->getApplicationPaths();
                $pathStorage = $paths->evidences->reports.'/'.$filename;
                // Registro de reporte en el storage
                Storage::disk('public_direct')
                    ->put($pathStorage, $pdfContent);
                $this->statusCode = 202;
                $this->response['message'] = trans('api.document_generated');
                $this->response['data'] = $pathStorage;

                $this->logService->create('inspection_report', [
                    $this->nameService,
                    compact('uuid'),
                    $this->response,
                    trans('api.inspection_not_found'),
                    auth()->user()->id,
                ]);

                $this->proyectAudits(
                    $inspection->project->project_id,
                    $inspection->project->status->status_id,
                    $this->logService->log->application_log_id,
                    trans('api.document_generated')
                );
            } else {
                $this->statusCode = 404;
                $this->response['message'] = trans('api.inspection_not_found');
                $this->response['data'] = [];
            }
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }
}
