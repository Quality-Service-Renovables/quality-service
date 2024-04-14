<?php

namespace App\Http\Modules\Api\V1\Inspections;

use App\Http\Modules\MainModule;
use App\Models\InspectionCategory;
use Exception;

class CategoryModule extends MainModule
{
    public function create()
    {
        //TODO Create Resource
    }

    public function update()
    {
        //TODO Update Resource
    }

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
            $this->response['message'] = 'List of Categories';
            $this->response['data'] = ['categories' => InspectionCategory::all()];
        } catch (Exception $exception) {
            $this->response['status'] = 'error';
            $this->response['message'] = 'Unable to get list of categories'.$exception->getMessage();
        }
        return $this->response;
    }

    public function delete()
    {
        //TODO Delete Resource
    }
}
