<?php

namespace App\Http\Controllers\Api\V1;

use Inertia\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        if($user->image_profile){
            $user->image_profile = url($user->image_profile);
        }else{
            $user->image_profile = url('/img/user_default.png');
        }
        return response()->json(Auth::user());
    }
}
