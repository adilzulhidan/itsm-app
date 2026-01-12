<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        
        $user = Auth::user();
        
        if ($user->role !== 'admin' && $user->role !== 'it_head') {
            return redirect()->route('tickets.index')->with('error', 'Akses Ditolak!');
        }

    
        $totalTickets = Ticket::count();
        $openTickets = Ticket::where('status', 'open')->count();
    
        $progressTickets = Ticket::where('status', 'In Progress')->count(); 
        $resolved = Ticket::where('status', 'resolved')->count();
        $closedTickets = Ticket::where('status', 'closed')->count();
        $rejected = Ticket::where('status', 'rejected')->count();
        
        $totalUsers = User::count();
        
        
        $dailyTickets = Ticket::whereDate('created_at', Carbon::today())->count();
        $weeklyTickets = Ticket::where('created_at', '>=', Carbon::today()->subDays(7))->count();
        $monthlyTickets = Ticket::whereMonth('created_at', Carbon::now()->month)
                                ->whereYear('created_at', Carbon::now()->year)
                                ->count();


        
        $statusCounts = Ticket::select('status', DB::raw('count(*) as count'))
                              ->groupBy('status')
                              ->pluck('count', 'status')
                              ->toArray();

        
        $donutData = [
            'labels' => array_map(function($status) {
                return ucfirst(str_replace('_', ' ', $status));
            }, array_keys($statusCounts)), 
            'data' => array_values($statusCounts),
        ];
        
        $sevenDays = collect(range(0, 6))->map(function ($i) {
            $date = Carbon::today()->subDays($i); 
            return [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('D, d M'), 
                'count' => 0,
            ];
        })->reverse()->values();

        
        $startDate = Carbon::today()->subDays(6)->startOfDay(); 
        
        $weeklyTrend = Ticket::where('created_at', '>=', $startDate)
                             ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                             ->groupBy('date') 
                             ->pluck('count', 'date')
                             ->toArray();
        
        
        $lineData = $sevenDays->map(function ($day) use ($weeklyTrend) {
            $day['count'] = $weeklyTrend[$day['date']] ?? 0; 
            return $day;
        });

        $lineChartData = [
            'labels' => $lineData->pluck('label'),
            'data' => $lineData->pluck('count'),
        ];
        
        return view('dashboard', compact(
            'totalTickets', 'openTickets', 'progressTickets', 'resolved', 'closedTickets', 'rejected', 
            'totalUsers', 'dailyTickets', 'weeklyTickets', 'monthlyTickets',
            'donutData', 'lineChartData'
        ));
    }
}