<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get statistics for admin dashboard
        $totalApplications = Application::count();
        $todayApplications = Application::whereDate('created_at', Carbon::today())->count();
        $thisMonthApplications = Application::whereMonth('created_at', Carbon::now()->month)
                                          ->whereYear('created_at', Carbon::now()->year)
                                          ->count();
        
        // Get recent applications
        $recentApplications = Application::latest()->take(5)->get();
        
        // Get applications by job type
        $applicationsByJob = Application::selectRaw('apply_job, COUNT(*) as count')
                                       ->groupBy('apply_job')
                                       ->orderBy('count', 'desc')
                                       ->get();
        
        // Get monthly statistics for chart
        $monthlyStats = Application::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                                  ->whereYear('created_at', Carbon::now()->year)
                                  ->groupBy('month')
                                  ->orderBy('month')
                                  ->get();
        
        return view('home', compact(
            'totalApplications',
            'todayApplications', 
            'thisMonthApplications',
            'recentApplications',
            'applicationsByJob',
            'monthlyStats'
        ));
    }
}
