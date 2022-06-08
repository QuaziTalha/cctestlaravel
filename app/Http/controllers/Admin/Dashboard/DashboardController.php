<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // --- === Dashboard View Function === --- \\
    public function Dashboard()
    {
        return view('Admin.Dashboard.Dashboard');
    }
    // --- === Dashboard View Function === --- \\
}
