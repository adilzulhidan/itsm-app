<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; 
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $query = Ticket::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        $totalTickets = (clone $query)->count();
        $resolvedTickets = (clone $query)->where('status', 'resolved')->count();
        $completionRate = $totalTickets > 0 ? round(($resolvedTickets / $totalTickets) * 100, 1) : 0;
        $avgMinutes = (clone $query)->whereNotNull('resolved_at')->selectRaw('AVG(EXTRACT(EPOCH FROM (resolved_at - created_at)) / 60) as avg_time')->value('avg_time');     
        $mttr = $avgMinutes ? round($avgMinutes / 60, 1) : 0;
        $trendData = (clone $query)
            ->selectRaw('created_at::date as date, count(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $agentPerformance = (clone $query)
            ->select('assigned_to', DB::raw('count(*) as total'))
            ->whereNotNull('assigned_to')
            ->with('assignee:id,name')
            ->groupBy('assigned_to')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $categoryData = (clone $query)
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();

        // Tambahkan data bandwidth jaringan
        $networkStats = $this->getNetworkBandwidth();
        $bandwidthUsage = $this->calculateBandwidthUsage();
        $networkInterfaces = $this->getNetworkInterfaces();

        return view('analytics.index', compact(
            'startDate', 'endDate', 
            'totalTickets', 'completionRate', 'mttr', 
            'trendData', 'agentPerformance', 'categoryData',
            'networkStats', 'bandwidthUsage', 'networkInterfaces'
        ));
    }   

    /**
     * Get real-time network bandwidth statistics
     */
    private function getNetworkBandwidth()
    {
        try {
            // Method 1: Using /proc/net/dev (Linux)
            if (file_exists('/proc/net/dev')) {
                return $this->getNetworkFromProc();
            }
            
            // Method 2: Using ifconfig or ip command
            return $this->getNetworkFromCommand();
            
        } catch (\Exception $e) {
            Log::error('Failed to get network bandwidth: ' . $e->getMessage());
            return $this->getMockNetworkData();
        }
    }

    /**
     * Read network stats from /proc/net/dev
     */
    private function getNetworkFromProc()
    {
        $interfaces = [];
        $content = @file_get_contents('/proc/net/dev');
        
        if (!$content) {
            return $this->getMockNetworkData();
        }
        
        $lines = explode("\n", $content);
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            // Skip headers and empty lines
            if (strpos($line, 'Inter-') === 0 || strpos($line, 'face') === 0 || empty($line)) {
                continue;
            }
            
            $parts = preg_split('/\s+/', $line);
            $interface = rtrim($parts[0], ':');
            
            // Skip loopback interface
            if ($interface === 'lo') {
                continue;
            }
            
            $rxBytes = isset($parts[1]) ? (int)$parts[1] : 0;
            $rxPackets = isset($parts[2]) ? (int)$parts[2] : 0;
            $txBytes = isset($parts[9]) ? (int)$parts[9] : 0;
            $txPackets = isset($parts[10]) ? (int)$parts[10] : 0;
            
            // Calculate speed if we have previous data
            $speed = $this->calculateInterfaceSpeed($interface, $rxBytes, $txBytes);
            
            $interfaces[] = [
                'interface' => $interface,
                'rx_bytes' => $rxBytes,
                'rx_packets' => $rxPackets,
                'tx_bytes' => $txBytes,
                'tx_packets' => $txPackets,
                'rx_speed' => $speed['rx_speed'] ?? 0,
                'tx_speed' => $speed['tx_speed'] ?? 0,
                'rx_speed_human' => $this->formatBytes($speed['rx_speed'] ?? 0) . '/s',
                'tx_speed_human' => $this->formatBytes($speed['tx_speed'] ?? 0) . '/s',
                'total_bytes' => $rxBytes + $txBytes,
                'status' => $this->getInterfaceStatus($interface),
            ];
        }
        
        // Sort by total traffic
        usort($interfaces, function($a, $b) {
            return $b['total_bytes'] <=> $a['total_bytes'];
        });
        
        return [
            'interfaces' => $interfaces,
            'total_rx_bytes' => array_sum(array_column($interfaces, 'rx_bytes')),
            'total_tx_bytes' => array_sum(array_column($interfaces, 'tx_bytes')),
            'timestamp' => now()->toDateTimeString(),
        ];
    }

    /**
     * Get network stats using system commands
     */
    private function getNetworkFromCommand()
    {
        $interfaces = [];
        
        // Try ip command first (modern Linux)
        if ($this->commandExists('ip')) {
            $output = shell_exec('ip -s link show');
            return $this->parseIpCommand($output);
        }
        
        // Fallback to ifconfig
        if ($this->commandExists('ifconfig')) {
            $output = shell_exec('ifconfig');
            return $this->parseIfconfig($output);
        }
        
        // Fallback to netstat
        if ($this->commandExists('netstat')) {
            $output = shell_exec('netstat -i');
            return $this->parseNetstat($output);
        }
        
        return $this->getMockNetworkData();
    }

    /**
     * Calculate bandwidth usage over time
     */
    private function calculateBandwidthUsage()
    {
        $cacheKey = 'bandwidth_history_' . date('Y-m-d');
        $history = Cache::get($cacheKey, []);
        
        $currentData = $this->getNetworkBandwidth();
        $currentTime = now()->timestamp;
        
        // Add current data to history
        $history[] = [
            'timestamp' => $currentTime,
            'total_rx' => $currentData['total_rx_bytes'] ?? 0,
            'total_tx' => $currentData['total_tx_bytes'] ?? 0,
        ];
        
        // Keep only last 60 data points (5 minutes if collected every 5 seconds)
        if (count($history) > 60) {
            $history = array_slice($history, -60);
        }
        
        Cache::put($cacheKey, $history, 3600); // Store for 1 hour
        
        // Calculate statistics
        if (count($history) >= 2) {
            $first = $history[0];
            $last = $history[count($history) - 1];
            $timeDiff = $last['timestamp'] - $first['timestamp'];
            
            if ($timeDiff > 0) {
                $rxDiff = $last['total_rx'] - $first['total_rx'];
                $txDiff = $last['total_tx'] - $first['total_rx'];
                
                return [
                    'avg_rx_speed' => $rxDiff / $timeDiff,
                    'avg_tx_speed' => $txDiff / $timeDiff,
                    'peak_rx_speed' => $this->calculatePeakSpeed($history, 'total_rx'),
                    'peak_tx_speed' => $this->calculatePeakSpeed($history, 'total_tx'),
                    'total_traffic' => ($rxDiff + $txDiff),
                    'total_traffic_human' => $this->formatBytes($rxDiff + $txDiff),
                    'time_period' => $timeDiff,
                    'data_points' => count($history),
                ];
            }
        }
        
        return [
            'avg_rx_speed' => 0,
            'avg_tx_speed' => 0,
            'peak_rx_speed' => 0,
            'peak_tx_speed' => 0,
            'total_traffic' => 0,
            'total_traffic_human' => '0 B',
            'time_period' => 0,
            'data_points' => count($history),
        ];
    }

    /**
     * Calculate speed for a specific interface
     */
    private function calculateInterfaceSpeed($interface, $currentRx, $currentTx)
    {
        $cacheKey = 'interface_speed_' . $interface;
        $previous = Cache::get($cacheKey);
        
        $speed = ['rx_speed' => 0, 'tx_speed' => 0];
        
        if ($previous) {
            $timeDiff = microtime(true) - $previous['timestamp'];
            
            if ($timeDiff > 0) {
                $rxDiff = $currentRx - $previous['rx_bytes'];
                $txDiff = $currentTx - $previous['tx_bytes'];
                
                $speed['rx_speed'] = $rxDiff / $timeDiff; // Bytes per second
                $speed['tx_speed'] = $txDiff / $timeDiff;
            }
        }
        
        // Store current data
        Cache::put($cacheKey, [
            'rx_bytes' => $currentRx,
            'tx_bytes' => $currentTx,
            'timestamp' => microtime(true),
        ], 10); // Store for 10 seconds
        
        return $speed;
    }

    /**
     * Get list of network interfaces
     */
    private function getNetworkInterfaces()
    {
        try {
            if ($this->commandExists('ip')) {
                $output = shell_exec('ip link show');
                return $this->parseInterfacesFromIp($output);
            }
            
            if ($this->commandExists('ifconfig')) {
                $output = shell_exec('ifconfig -a');
                return $this->parseInterfacesFromIfconfig($output);
            }
            
            return [];
        } catch (\Exception $e) {
            Log::error('Failed to get network interfaces: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get interface status (up/down)
     */
    private function getInterfaceStatus($interface)
    {
        try {
            if ($this->commandExists('ip')) {
                $output = shell_exec("ip link show {$interface} 2>/dev/null");
                return strpos($output, 'state UP') !== false ? 'up' : 'down';
            }
            
            return 'unknown';
        } catch (\Exception $e) {
            return 'unknown';
        }
    }

    /**
     * Calculate peak speed from history
     */
    private function calculatePeakSpeed($history, $type)
    {
        $peak = 0;
        
        for ($i = 1; $i < count($history); $i++) {
            $timeDiff = $history[$i]['timestamp'] - $history[$i-1]['timestamp'];
            $dataDiff = $history[$i][$type] - $history[$i-1][$type];
            
            if ($timeDiff > 0) {
                $speed = $dataDiff / $timeDiff;
                $peak = max($peak, $speed);
            }
        }
        
        return $peak;
    }

    /**
     * Check if a command exists
     */
    private function commandExists($command)
    {
        return !empty(shell_exec("which {$command} 2>/dev/null"));
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Mock data for development or when system commands fail
     */
    private function getMockNetworkData()
    {
        return [
            'interfaces' => [
                [
                    'interface' => 'eth0',
                    'rx_bytes' => rand(1000000, 100000000),
                    'tx_bytes' => rand(1000000, 50000000),
                    'rx_speed' => rand(100000, 1000000),
                    'tx_speed' => rand(50000, 500000),
                    'rx_speed_human' => $this->formatBytes(rand(100000, 1000000)) . '/s',
                    'tx_speed_human' => $this->formatBytes(rand(50000, 500000)) . '/s',
                    'status' => 'up',
                ],
            ],
            'total_rx_bytes' => rand(1000000000, 5000000000),
            'total_tx_bytes' => rand(500000000, 2000000000),
            'timestamp' => now()->toDateTimeString(),
            'is_mock' => true,
        ];
    }

    /**
     * API endpoint for real-time bandwidth data (for AJAX)
     */
    public function getBandwidthData(Request $request)
    {
        $networkStats = $this->getNetworkBandwidth();
        $bandwidthUsage = $this->calculateBandwidthUsage();
        
        return response()->json([
            'success' => true,
            'data' => [
                'network' => $networkStats,
                'usage' => $bandwidthUsage,
                'timestamp' => now()->toIso8601String(),
            ],
        ]);
    }

    /**
     * API endpoint for bandwidth history
     */
    public function getBandwidthHistory(Request $request)
    {
        $minutes = $request->input('minutes', 30);
        $cacheKey = 'bandwidth_history_' . date('Y-m-d');
        $history = Cache::get($cacheKey, []);
        
        // Filter by time if needed
        $cutoff = now()->subMinutes($minutes)->timestamp;
        $filteredHistory = array_filter($history, function($point) use ($cutoff) {
            return $point['timestamp'] >= $cutoff;
        });
        
        return response()->json([
            'success' => true,
            'data' => array_values($filteredHistory),
            'count' => count($filteredHistory),
        ]);
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $query = Ticket::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        $totalTickets = (clone $query)->count();
        $resolvedTickets = (clone $query)->where('status', 'resolved')->count();
        $completionRate = $totalTickets > 0 ? round(($resolvedTickets / $totalTickets) * 100, 1) : 0;
        $avgMinutes = (clone $query)->whereNotNull('resolved_at')
            ->selectRaw('AVG(EXTRACT(EPOCH FROM (resolved_at - created_at)) / 60) as avg_time')
            ->value('avg_time');
            
        $mttr = $avgMinutes ? round($avgMinutes / 60, 1) : 0;

        $agentPerformance = (clone $query)
            ->select('assigned_to', DB::raw('count(*) as total'))
            ->whereNotNull('assigned_to')
            ->with('assignee:id,name')
            ->groupBy('assigned_to')
            ->orderByDesc('total')
            ->get(); 

        $categoryData = (clone $query)
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();

        // Tambahkan data bandwidth ke PDF
        $networkStats = $this->getNetworkBandwidth();

        $pdf = Pdf::loadView('analytics.pdf_report', compact(
            'startDate', 'endDate', 
            'totalTickets', 'completionRate', 'mttr', 
            'agentPerformance', 'categoryData',
            'networkStats'
        ));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Laporan-ITSM-' . $startDate . '-sd-' . $endDate . '.pdf');
    }
}