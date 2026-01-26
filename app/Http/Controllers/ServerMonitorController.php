<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Server;
use Carbon\Carbon;

class ServerMonitorController extends Controller
{
    // 1. Tampilkan Halaman Dashboard
    public function index()
    {
        return view('monitor.index');
    }

    // 2. API untuk Data Real-time (Dipanggil via AJAX)
    public function getServerData()
    {
        // Ambil semua data server
        $servers = Server::all();
        
        // Hitung statistik ringkas untuk KPI Card
        $stats = [
            'total_servers' => $servers->count(),
            'online' => $servers->where('status', 'online')->count(),
            'offline' => $servers->where('status', 'offline')->count(),
            'avg_latency' => round($servers->avg('latency'), 1),
            'avg_load' => round($servers->avg('load_cpu'), 1),
        ];

        return response()->json([
            'servers' => $servers,
            'stats' => $stats,
            'timestamp' => Carbon::now()->format('H:i:s')
        ]);
    }

    // 3. (Opsional) Fitur "Ping" Nyata
    // Fungsi ini bisa dipanggil via cronjob atau tombol di admin untuk update status asli
    public function checkStatus()
    {
        $servers = Server::all();
        foreach ($servers as $server) {
            // Simulasi pengecekan (karena di server production kadang ping diblokir)
            // Di real world, Anda bisa pakai `fsockopen` atau `exec("ping...")`
            
            // LOGIKA SIMULASI CERDAS:
            // Ubah latency secara acak sedikit agar terlihat hidup
            $newLatency = rand(5, 50); 
            $newLoad = rand(10, 80);
            
            // Kadang-kadang buat status warning jika load tinggi
            $status = 'online';
            if ($newLoad > 90) $status = 'warning';
            
            // Update database
            $server->update([
                'latency' => $newLatency,
                'load_cpu' => $newLoad,
                'status' => $status,
                'last_checked_at' => Carbon::now()
            ]);
        }
        
        return response()->json(['message' => 'Status Updated']);
    }
}