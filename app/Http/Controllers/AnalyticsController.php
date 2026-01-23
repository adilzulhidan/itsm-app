<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; 

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

        
        $avgMinutes = (clone $query)->whereNotNull('resolved_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, created_at, resolved_at)) as avg_time')
            ->value('avg_time');
        
        $mttr = $avgMinutes ? round($avgMinutes / 60, 1) : 0;

        
        $trendData = (clone $query)
            ->selectRaw('DATE(created_at) as date, count(*) as total')
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

        return view('analytics.index', compact(
            'startDate', 'endDate', 
            'totalTickets', 'completionRate', 'mttr', 
            'trendData', 'agentPerformance', 'categoryData'
        ));
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
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, created_at, resolved_at)) as avg_time')
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

        
        $pdf = Pdf::loadView('analytics.pdf_report', compact(
            'startDate', 'endDate', 
            'totalTickets', 'completionRate', 'mttr', 
            'agentPerformance', 'categoryData'
        ));

        
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Laporan-ITSM-' . $startDate . '-sd-' . $endDate . '.pdf');
    }
}