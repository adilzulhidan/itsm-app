<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // WAJIB ADA


class DashboardController extends Controller
{
    public function index()
    {
        // 1. Pagar Keamanan
        $user = Auth::user();
        if ($user->role !== 'admin' && $user->role !== 'it_head') {
            return redirect()->route('tickets.index')->with('error', 'Akses Ditolak! Anda tidak memiliki hak akses ke Dashboard.');
        }

        // --- DEFINISI VARIABEL ANGKA (Paling Atas) ---
        $totalTickets = Ticket::count();
        $openTickets = Ticket::where('status', 'open')->count();
        $progressTickets = Ticket::where('status', 'in_progress')->count();
        $closedTickets = Ticket::whereIn('status', ['resolved', 'closed'])->count();
        
        $totalUsers = User::count();
        $dailyTickets = Ticket::whereDate('created_at', Carbon::today())->count();
        $weeklyTickets = Ticket::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $monthlyTickets = Ticket::whereMonth('created_at', Carbon::now()->month)
                                ->whereYear('created_at', Carbon::now()->year)
                                ->count();
        // ----------------------------------------------


        // --- DATA UNTUK DONUT CHART (Distribusi Status) ---
        // Menggunakan DB::raw untuk query grouping
        $statusCounts = Ticket::select('status', DB::raw('count(*) as count'))
                              ->groupBy('status')
                              ->pluck('count', 'status')
                              ->toArray();

        $donutData = [
            'labels' => array_map('ucfirst', array_keys($statusCounts)), 
            'data' => array_values($statusCounts),
        ];

        // --- DATA UNTUK LINE CHART (Tren 7 Hari) ---
        
        // 1. Buat struktur 7 hari (Hari ini s/d 6 hari lalu)
        $sevenDays = collect(range(0, 6))->map(function ($i) {
            $date = Carbon::now()->subDays($i);
            return [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('D, d M'),
                'count' => 0,
            ];
        })->reverse()->values();

        // 2. Ambil data count dari DB
        $weeklyTrend = Ticket::where('created_at', '>=', Carbon::now()->subDays(7))
                             ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                             ->groupBy('date')
                             ->pluck('count', 'date')
                             ->toArray();
        
        // 3. Gabungkan data
        $lineData = $sevenDays->map(function ($day) use ($weeklyTrend) {
            $day['count'] = $weeklyTrend[$day['date']] ?? 0;
            return $day;
        });

        $lineChartData = [
            'labels' => $lineData->pluck('label'),
            'data' => $lineData->pluck('count'),
        ];
        
        // --- Akhir Data Chart ---

        return view('dashboard', compact(
            'totalTickets', 'openTickets', 'progressTickets', 'closedTickets', 
            'totalUsers', 'dailyTickets', 'weeklyTickets', 'monthlyTickets',
            'donutData', // Data Donut Chart
            'lineChartData' // Data Line Chart
        ));
    }
}