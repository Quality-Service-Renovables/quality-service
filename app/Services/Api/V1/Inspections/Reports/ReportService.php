<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections\Reports;

use App\Mail\ServiceMail;
use App\Models\Inspections\Inspection;
use App\Services\Api\Audits;
use App\Services\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
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
            // Obtiene datos del usuario
            $user = auth()->user()->load('client.config');
            // Obtiene resumen de inspección
            $inspection = Inspection::with([
                'client',
                'equipment.model.trademark',
                'category.sections.subSections.fields.result',
                'inspectionEquipments.equipment',
                'evidences',
                'project',
            ])->where('inspection_uuid', $uuid)->first();
            // Valida si la inspección tiene información.
            if ($this->isValidInspection($inspection)) {
                $inspection->provider = $user->client;
                // Generación de la vista en base a la información de la colección.
                $document = PDF::loadView('api.V1.Inspections.Reports.inspection_report', compact('inspection'));
                // Cifrar el PDF
                if ($user->client->config && $user->client->config->crypt_report) {
                    $passReport = decrypt($user->client->config->key_report);
                    $this->response['data']['key_report'] = $passReport;
                    $document->getDomPDF()->getCanvas()->get_cpdf()->setEncryption($passReport);
                }
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
                $this->response['data']['path_storage'] = $pathStorage;
                $mail = [
                    'to' => ['adrian.olvera21@gmail.com','core.devmx@gmail.com'],
                    'subject' => 'Reporte de Inspección',
                    'attachment' => $pathStorage
                ];
                Mail::send(new ServiceMail($mail));
                // Crear log de sistema
                $this->logService->create('inspection_report', [
                    $this->nameService,
                    compact('uuid'),
                    $this->response,
                    trans('api.inspection_not_found'),
                    auth()->user()->id,
                ]);
                // Crear log de auditoria
                $this->proyectAudits(
                    $inspection->project->project_id,
                    $inspection->project->status->status_id,
                    $this->logService->log->application_log_id,
                    trans('api.document_generated')
                );
            } else {
                $this->statusCode = 404;
                $this->response['message'] = trans('api.inspection_not_found');
            }
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }

    private function isValidInspection($inspection): bool
    {
        $isValidInspection = true;
        if ($inspection->category->sections->isNotEmpty()) {
            foreach ($inspection->category->sections as $section) {
                // En caso de encontrar campos en la sección se valida que tengan resultados.
                foreach ($section->fields as $field) {
                    if (!$field->result) {
                        $this->response['data']['fields_without_results'][] = $field;
                        $isValidInspection = false;
                    }
                }
                // En caso de encontrar campos en la sub sección se valida que tengan resultados.
                if ($section->subSections->isNotEmpty()) {
                    foreach($section->subSections as $subSection) {
                        foreach ($subSection->fields as $field) {
                            if (!$field->result) {
                                $this->response['data']['fields_without_results'][] = $field;
                                $isValidInspection = false;
                            }
                        }
                    }
                }
            }
        }

        //return env('APP_DEBUG') ?? $isValidInspection;
        return true;
    }
}
