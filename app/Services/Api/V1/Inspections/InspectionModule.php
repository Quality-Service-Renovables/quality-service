<?php

namespace App\Services\Api\V1\Inspections;

class InspectionModule
{
    public array $response;
    public int $status_code;

    public function __construct()
    {
        $this->response = [
            'status' => 'ok',
            'message' => null,
            'data' => [],
        ];
        $this->status_code = 200;
    }

    public function create()
    {
        //TODO Create Resource
    }

    public function update()
    {
        //TODO Update Resource
    }

    public function read()
    {
        //TODO Read Resource
    }

    public function delete()
    {
        //TODO Delete Resource
    }
}
