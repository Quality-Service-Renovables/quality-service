<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class AppsController extends Controller
{
    /**
     * Render the equipment component.
     */
    public function component(): Response
    {

        return Inertia::render('Apps');
    }
}
