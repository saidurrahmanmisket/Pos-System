<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    function ReportPage()
    {
        return view('pages.dashboard.report-page');
    }
}
