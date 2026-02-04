<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Server;
use Carbon\Carbon;

class ServerMonitorController extends Controller
{

    public function index()
    {
        return view('monitor.index');
    }

    public function getServerData()
    {
        $servers = Server::all();
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

    
    public function checkStatus()
    {
        $servers = Server::all();
        foreach ($servers as $server) {
           
            $newLatency = rand(5, 50); 
            $newLoad = rand(10, 80);
            $status = 'online';
            if ($newLoad > 90) $status = 'warning';

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