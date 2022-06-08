<?php

namespace App\Http\controllers\Admin\Dashboard;

use App\Http\controllers\Controller;
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
