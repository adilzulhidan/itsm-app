<!DOCTYPE html>
<html>
<head>
    <title>Laporan Tiket ITSM</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        
        /* Tabel Header (Kop Surat) */
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; border-bottom: 3px double black; }
        .header-table td { border: none; vertical-align: middle; padding-bottom: 10px; }
        
        /* Tabel Data Utama */
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 6px; text-align: left; }
        .data-table th { background-color: #f0f0f0; text-align: center; font-weight: bold; }
        
        /* Status Color */
        .status-open { color: green; font-weight: bold; }
        .status-closed { color: red; font-weight: bold; }
        .status-progress { color: #d97706; font-weight: bold; } /* Orange */
        
        /* Zebra Striping */
        .data-table tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td style="width: 20%; text-align: left;">
                <img src="{{ public_path('images/logo-jtekt.png') }}" style="height: 60px; width: auto;">
            </td>
            
            <td style="width: 80%; text-align: center;">
                <h2 style="margin: 0; text-transform: uppercase;">PT. JTEKT INDONESIA</h2>
                <h3 style="margin: 5px 0; font-weight: normal; text-decoration: underline;">REKAPITULASI IT REQUEST FORM</h3>
                <p style="margin: 0; font-size: 10px;">Dicetak pada Tanggal: {{ date('d F Y') }}</p>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Kode Tiket</th>
                <th style="width: 15%">Pelapor</th>
                <th style="width: 12%">Departemen</th>
                <th style="width: 12%">Kategori</th>
                <th style="width: 20%">Subjek Masalah</th>
                <th style="width: 10%">Status</th>
                <th style="width: 11%">Tgl Lapor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $index => $ticket)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="text-align: center; font-family: monospace;">{{ $ticket->ticket_code }}</td>
                <td>{{ $ticket->user->name }}</td>
                <td style="text-align: center;">{{ $ticket->department ?? '-' }}</td>
                <td style="text-align: center;">{{ $ticket->category }}</td>
                <td>{{ $ticket->subject }}</td>
                
                <td style="text-align: center;">
                    @if($ticket->status == 'open')
                        <span class="status-open">OPEN</span>
                    @elseif($ticket->status == 'closed')
                        <span class="status-closed">CLOSED</span>
                    @elseif($ticket->status == 'in_progress')
                        <span class="status-progress">PROGRESS</span>
                    @else
                        {{ strtoupper($ticket->status) }}
                    @endif
                </td>
                
                <td style="text-align: center;">{{ $ticket->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 40px; width: 100%;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="border: none; width: 70%;"></td>
                <td style="border: none; width: 30%; text-align: center;">
                    <p>Karawang, {{ date('d F Y') }}</p>
                    <p>Mengetahui,</p>
                    <br><br><br>
                    <p><strong>IT Dept Head</strong></p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>