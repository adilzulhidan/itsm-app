<p>Halo Manager,</p>
<p>Ada tiket baru yang membutuhkan persetujuan Anda:</p>
<ul>
    <li><strong>Kode:</strong> {{ $ticket->ticket_code }}</li>
    <li><strong>User:</strong> {{ $ticket->user->name }}</li>
    <li><strong>Kategori:</strong> {{ $ticket->category }}</li>
    <li><strong>Deskripsi:</strong> {{ $ticket->description }}</li>
</ul>
<p>Silakan login ke sistem untuk menyetujui atau menolak.</p>