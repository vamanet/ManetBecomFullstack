<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard', [
            'user' => $request->user(),
        ]);
    }
    public function dashboardOne()
    {
        return view('dashboardOne/dashboard');
    }
}
