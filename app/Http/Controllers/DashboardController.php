<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LatestNews;
use App\Models\Service;
use App\Models\Team;
use App\Models\Works;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalTeamMember = Team::count();
        $latestNews = LatestNews::count();
        $totalService = Service::count();
        $totalDepartment = Works::count();
        return view('dashboard', compact('totalTeamMember', 'latestNews', 'totalService', 'totalDepartment'));
    }
}
