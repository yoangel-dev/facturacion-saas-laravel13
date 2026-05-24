<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mas adelante aqui cargaremos datos (nº de facturas, etc.)
        return view('dashboard');
    }
    
}
