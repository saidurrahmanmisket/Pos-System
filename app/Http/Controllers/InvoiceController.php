<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    function InvoicePage()
    {
        return view('pages.dashboard.invoice-page');
    }
    function SalePage()
    {
        return view('pages.dashboard.sale-page');
    }
}
