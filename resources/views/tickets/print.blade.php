<!DOCTYPE html>
<html>
<head>
    <title>Print Request Form - {{ $ticket->ticket_code }}</title>
    <style>
        body { font-family: sans-serif; font-size: 11pt; padding: 20px; }
        .document-container { border: 1px solid black; padding: 20px; }
        
        
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; border-bottom: 2px solid black; }
        .header-table td { border: none; vertical-align: top; padding-bottom: 5px; }
        .header-table .title { font-size: 18pt; font-weight: bold; text-decoration: underline; }
        .data-box { border: 1px solid black; padding: 8px; margin-bottom: 15px; }
        
        
        .auth-table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        .auth-table th, .auth-table td { border: 1px solid black; padding: 10px 5px; text-align: center; height: 70px; }
        .auth-table th { background-color: #f0f0f0; }
        .signature-name { font-weight: bold; margin-top: 5px; display: block; }
        .signature-date { font-size: 8pt; color: #555; }
        .approval-status { font-size: 8pt; color: green; font-weight: bold; }
        
        .description-box { border: 1px solid #333; padding: 10px; min-height: 80px; }
    </style>
</head>
<body>

    <div class="document-container">

        <table class="header-table">
            <tr>
                <td style="width: 25%; text-align: left;">
                    <img src="{{ public_path('images/logo-jtekt.png') }}" style="height: 40px; width: auto;">
                </td>
                <td style="width: 50%; text-align: center;">
                    <h2 style="margin: 0; text-transform: uppercase;">PT. JTEKT INDONESIA</h2>
                    <h3 class="title" style="margin-top: 5px;">IT REQUEST FORM</h3>
                </td>
                <td style="width: 25%; text-align: right;">
                    <p style="margin: 0; font-weight: bold;">Kode: {{ $ticket->ticket_code }}</p>
                    <p style="margin: 5px 0 0 0;">Date: {{ $ticket->created_at->format('d M Y') }}</p>
                </td>
            </tr>
        </table>
        
        <div style="margin-bottom: 15px;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%;">
                        <p style="font-weight: bold; margin: 0;">Requester Name:</p>
                        <p style="border-bottom: 1px solid black;">{{ $ticket->user->name }}</p>
                    </td>
                    <td style="width: 50%;">
                        <p style="font-weight: bold; margin: 0;">Department:</p>
                        <p style="border-bottom: 1px solid black;">{{ $ticket->department }}</p>
                    </td>
                </tr>
            </table>
            
            <p style="font-weight: bold; margin-top: 10px;">Request Type:</p>
            <p style="border: 1px solid black; padding: 5px; background: #f0f0f0;">
                {{ $ticket->category }}
            </p>
        </div>
        
        <p style="font-weight: bold; margin-top: 10px;">Description / Details:</p>
        <div class="description-box">
            {{ $ticket->description }}
        </div>
        
        <h3 style="font-size: 13pt; margin-top: 30px; margin-bottom: 10px;">AUTHORIZATION</h3>
        <table class="auth-table">
            <thead>
                <tr>
                    <th>Requester</th>
                    <th>Function Head</th>
                    <th>IT Dept Head</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <br><br>
                        <span class="signature-name">{{ $ticket->user->name }}</span>
                        <span class="approval-status">(Signed by System)</span>
                        <span class="signature-date">Tgl: {{ $ticket->created_at->format('d/m/Y') }}</span>
                    </td>

                    <td>
                        @if($ticket->approved_by_manager_id)
                            <br><br>
                            <span class="signature-name">{{ $ticket->managerApprover->name }}</span>
                            <span class="approval-status">(APPROVED)</span>
                            <span class="signature-date">Tgl: {{ \Carbon\Carbon::parse($ticket->manager_approved_at)->format('d/m/Y') }}</span>
                        @else
                            <br><br>
                            <span class="signature-date">--- Waiting Approval ---</span>
                        @endif
                    </td>

                    <td>
                         @if($ticket->approved_by_it_id)
                            <br><br>
                            <span class="signature-name">{{ $ticket->itApprover->name }}</span>
                            <span class="approval-status">(APPROVED)</span>
                            <span class="signature-date">Tgl: {{ \Carbon\Carbon::parse($ticket->it_approved_at)->format('d/m/Y') }}</span>
                        @else
                            <br><br>
                            <span class="signature-date">--- Waiting Approval ---</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <p style="font-size: 8pt; margin-top: 30px; text-align: right;">
            No. Dokumen: FR-IT-GNP-011-00 | Revisi: 00
        </p>

    </div>

</body>
</html>