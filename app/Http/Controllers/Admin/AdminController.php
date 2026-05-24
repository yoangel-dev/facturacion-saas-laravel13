<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tenant;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'total_users' => User::count(),
            'total_tenants' => Tenant::count(),
        ]);
    }
}
