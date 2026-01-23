<!DOCTYPE html>
<html>
<head>
    <title>Laporan ITSM</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #1e3a8a; }
        .header p { margin: 5px 0; color: #666; font-size: 14px; }
        
        .kpi-container { display: table; width: 100%; margin-bottom: 30px; }
        .kpi-box { display: table-cell; text-align: center; padding: 10px; border: 1px solid #ddd; background: #f9fafb; width: 33%; }
        .kpi-number { font-size: 24px; font-weight: bold; color: #1e3a8a; }
        .kpi-label { font-size: 12px; text-transform: uppercase; color: #666; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 14px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #1e3a8a; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        
        .section-title { font-size: 16px; font-weight: bold; margin-bottom: 10px; color: #1e3a8a; border-left: 5px solid #1e3a8a; padding-left: 10px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #aaa; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Performa IT Support</h1>
        <p>PT JTEKT Indonesia</p>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
    </div>

    <div class="kpi-container">
        <div class="kpi-box">
            <div class="kpi-label">Total Tiket</div>
            <div class="kpi-number">{{ $totalTickets }}</div>
        </div>
        <div class="kpi-box">
            <div class="kpi-label">Completion Rate</div>
            <div class="kpi-number">{{ $completionRate }}%</div>
        </div>
        <div class="kpi-box">
            <div class="kpi-label">MTTR (Rata-rata)</div>
            <div class="kpi-number">{{ $mttr }} Jam</div>
        </div>
    </div>

    <div class="section-title">Performa Teknisi</div>
    <table>
        <thead>
            <tr>
                <th>Nama Teknisi</th>
                <th style="text-align: center; width: 30%;">Total Tiket Ditangani</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agentPerformance as $agent)
            <tr>
                <td>{{ $agent->assignee->name ?? 'Unassigned' }}</td>
                <td style="text-align: center;">{{ $agent->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Distribusi Masalah (Kategori)</div>
    <table>
        <thead>
            <tr>
                <th>Kategori Masalah</th>
                <th style="text-align: center; width: 30%;">Jumlah Tiket</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categoryData as $cat)
            <tr>
                <td>{{ $cat->category->name ?? $cat->category_id }}</td> 
                <td style="text-align: center;">{{ $cat->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak otomatis oleh Sistem ITSM pada {{ now()->format('d M Y H:i') }}
    </div>
</body>
</html>