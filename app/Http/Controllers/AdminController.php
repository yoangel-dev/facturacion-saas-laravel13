<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Más adelante: listar todos los usuarios del sistema
        return view('admin.users.index');
    }
}
