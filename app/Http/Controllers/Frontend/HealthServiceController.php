<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class HealthServiceController extends Controller
{
    public function index()
    {
        return view('frontend.health-services.index');
    }
}
