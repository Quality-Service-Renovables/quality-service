<?php

namespace App\Http\Modules;

use App\Http\Modules\Applications\LogModule;

class MainModule
{
    public array $response;

    public int $statusCode;

    public LogModule $logModule;

    public function __construct()
    {
        $this->response = [
            'status' => 'ok',
            'message' => null,
            'data' => [],
        ];
        $this->statusCode = 200;
        $this->logModule = new LogModule();
    }
}
