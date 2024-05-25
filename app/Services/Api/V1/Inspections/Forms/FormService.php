<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections\Forms;

use App\Models\Inspections\Categories\Form;
use App\Models\Inspections\Categories\Section;
use App\Models\Inspections\Category;
use App\Services\Service;
use Illuminate\Http\Request;
use Throwable;

class FormService extends Service
{
    public string $nameService = 'ct_inspection';

    public function createSection(Request $request): array
    {
        try {
            $section = Section::create();
            // Response
            $this->response['message'] = trans('api.created');
            $this->response['data'] = $section;
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }

    public function getForm(string $uuid): array
    {
        try {
            $form = [];
            $inspectionCategory = Category::where([
                'ct_inspection_uuid' => $uuid,
            ])->first();

            if ($inspectionCategory) {
                $sections = Section::where([
                    'ct_inspection_id' => $inspectionCategory->ct_inspection_id,
                ])->get();

                if (count($sections)) {
                    $fields = Form::whereIn(
                        'ct_inspection_section_id', $sections->pluck('ct_inspection_section_id'))
                        ->get();
                    if ($fields) {
                        $form = $this->buildForm($sections, $fields);
                    }
                }
            }
            // Response
            $this->response['message'] = trans('api.readed');
            $this->response['data'] = $form;
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }

    private function buildForm($sections, $fields): array
    {
        $form['sections'] = [];
        // Set sections
        foreach ($sections as $section) {
            // Set subsections
            if ($section->section_relation_id) {
                $currentSection = $section->where('ct_inspection_section_id', '=', $section->section_relation_id)->first();
                $sectionCode = $currentSection->ct_inspection_section_code;
                // Set fields
                $form['sections'][$sectionCode]['fields'] = $fields->where('ct_inspection_section_id', $section->section_relation_id);
                //$section['fields'] = $fields->where('ct_inspection_section_id', $section->ct_inspection_section_id);
                $section['fields'] = $fields->collect($section['fields'])->mapWithKeys(function ($item) {
                    return [$item['ct_inspection_form_code'] => $item];
                })->where('ct_inspection_section_id', $section->ct_inspection_section_id)->all();
                // Set sub section
                $form['sections'][$sectionCode]['sub_sections'][] = $section;
            }
        }

        return $form;
    }
}
