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
        
        // 1. Normalisasi Role agar kebal terhadap huruf besar/kecil (Case-Insensitive)
        $userRole = strtolower($user->role);
        
        if (!in_array($userRole, ['admin', 'it_head'])) {
            return redirect()->route('tickets.index');
        }

        // 2. Hitung Total Keseluruhan Tiket
        $totalTickets = Ticket::count();
        
        // 3. Hitung Kartu OPEN (Tiket yang baru masuk atau sedang menunggu approval)
        $openTickets = Ticket::whereIn('status', [
            'Menunggu Persetujuan Manager', 
            'Menunggu Persetujuan IT Head',
            'open',
            'Open'
        ])->count();
    
        // 4. Hitung Kartu Status Lainnya (Menggunakan LOWER agar aman di PostgreSQL)
        $progressTickets = Ticket::whereRaw('LOWER(status) = ?', ['in progress'])
                                 ->orWhereRaw('LOWER(status) = ?', ['in_progress'])
                                 ->count(); 
                                 
        $resolved = Ticket::whereRaw('LOWER(status) = ?', ['resolved'])->count();
        $closedTickets = Ticket::whereRaw('LOWER(status) = ?', ['closed'])->count();
        $rejected = Ticket::whereRaw('LOWER(status) = ?', ['rejected'])->count();
        
        $totalUsers = User::count();
        
        // 5. Statistik Rentang Waktu (Today, This Week, This Month)
        $dailyTickets = Ticket::whereDate('created_at', Carbon::today())->count();
        $weeklyTickets = Ticket::where('created_at', '>=', Carbon::today()->subDays(7))->count();
        $monthlyTickets = Ticket::whereMonth('created_at', Carbon::now()->month)
                                ->whereYear('created_at', Carbon::now()->year)
                                ->count();

        // 6. Data untuk Donut Chart (Status Distribution)
        $statusCountsRaw = Ticket::select('status', DB::raw('count(*) as count'))
                              ->groupBy('status')
                              ->pluck('count', 'status')
                              ->toArray();

        $donutLabels = [];
        $donutDataValues = [];
        
        foreach ($statusCountsRaw as $status => $count) {
            // Menyederhanakan nama status yang panjang agar Donut Chart tidak berantakan
            $label = $status;
            if (str_contains(strtolower($status), 'manager')) {
                $label = 'Wait Manager';
            } elseif (str_contains(strtolower($status), 'it head')) {
                $label = 'Wait IT Head';
            }
            
            $donutLabels[] = ucfirst($label);
            $donutDataValues[] = $count;
        }

        $donutData = [
            'labels' => $donutLabels, 
            'data' => $donutDataValues,
        ];
        
        // 7. Data untuk Line Chart (Tren 7 Hari Terakhir)
        $sevenDays = collect(range(0, 6))->map(function ($i) {
            $date = Carbon::today()->subDays($i); 
            return [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('D, d M'), 
                'count' => 0,
            ];
        })->reverse()->values();

        $startDate = Carbon::today()->subDays(6)->startOfDay(); 
        
        // Menggunakan DATE() yang dieksekusi mentah di PostgreSQL
        $weeklyTrend = Ticket::where('created_at', '>=', $startDate)
                             ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                             ->groupBy(DB::raw('DATE(created_at)')) 
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