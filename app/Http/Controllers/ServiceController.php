<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display the services page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // No specific data needed for this static services page,
        // but you could fetch services from a database here if they were dynamic.
        return view('frontend.services.index');
    }
}
