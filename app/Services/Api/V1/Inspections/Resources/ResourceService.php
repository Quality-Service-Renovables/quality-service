<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections\Resources;

use App\Models\Inspections\Categories\InspectionExternals;
use App\Models\Inspections\Categories\InspectionInternals;
use App\Models\Inspections\Categories\InspectionSections;
use App\Models\Inspections\Category;
use App\Services\Service;
use Throwable;

class ResourceService extends Service
{
    public string $nameService = 'ct_inspection';

    /**
     * Retrieve the list of categories.
     *
     * @return array The response containing the list of categories.
     *
     * @throws \Exception If there is an error retrieving the list of categories.
     */
    public function getInspectionDetail(string $uuid): array
    {
        try {
            $inspectionCategory = Category::where('ct_inspection_uuid', $uuid)
                ->first();
            $inspection = [];
            if ($inspectionCategory) {
                // Sections
/*                $inspection['sections'] = InspectionSections::
                    where(['ct_inspection_id' => $inspectionCategory->ct_inspection_id,])
                    ->get();*/
                // Internals
                $inspection['internals'] = InspectionInternals::with(['section'])
                    ->where(['ct_inspection_id' => $inspectionCategory->ct_inspection_id,])
                    ->get()->groupBy('section.ct_inspection_section_code');;
                // Externals
                $inspection['externals'] = InspectionExternals::with(['section'])
                    ->where(['ct_inspection_id' => $inspectionCategory->ct_inspection_id,])
                    ->get()->groupBy('section.ct_inspection_section_code');

            }
            // Response
            $this->response['message'] = trans('api.readed');
            $this->response['data'] = $inspection;
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }
}
