<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    function ProductPage(){
        return view('pages.dashboard.product-page');
    }
}
