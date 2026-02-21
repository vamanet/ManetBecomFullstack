<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        return view('app');
    }

    public function dashboardOne(Request $request): View
    {
        return view('app');
    }
    public function profile(Request $request): View
    {
        return view('app');
    }
}
