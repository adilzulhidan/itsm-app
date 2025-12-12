Yth. Bapak/Ibu {{ $ticket->user->name }},

Kami informasikan bahwa tiket ITSM Anda telah DITOLAK dalam proses persetujuan oleh **{{ $rejectedByRole }}**.

Detail Tiket Ditolak:
- ID Tiket: {{ $ticket->ticket_code }}
- Judul: {{ $ticket->subject }}
- Ditolak Oleh: {{ $rejectedByRole }}

Alasan Penolakan:
> {{ $rejectionReason }}

Mohon perbaiki/lengkapi informasi sesuai alasan di atas dan ajukan tiket baru jika diperlukan.

Hormat kami,
Sistem ITSM PT JTEKT