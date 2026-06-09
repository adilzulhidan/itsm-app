<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tiket - {{ $ticket->ticket_code }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            max-width: 500px;
            margin: 2rem auto;
        }
        
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #888; border-radius: 3px; }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <div class="bg-white shadow-sm py-4 px-6 mb-6">
        <div class="container mx-auto max-w-5xl">
            <a href="{{ route('tickets.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-2 transition">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Tiket
            </a>
        </div>
    </div>

    <div class="container mx-auto px-4 max-w-5xl pb-10">
        
        <div class="bg-white rounded-t-lg shadow-sm border-b border-gray-200 p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-t-4 border-blue-800">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $ticket->subject }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Kode Tiket: <span class="font-mono font-bold bg-gray-100 px-2 py-0.5 rounded border">{{ $ticket->ticket_code }}</span>
                </p>
            </div>
            <div>
                @php
                    $status = strtolower($ticket->status);
                    $badgeClass = 'bg-gray-100 text-gray-700 border-gray-200';
                    
                    if(str_contains($status, 'open') || str_contains($status, 'manager')) {
                        $badgeClass = 'bg-blue-100 text-blue-800 border-blue-200';
                    } elseif(str_contains($status, 'it head')) {
                        $badgeClass = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                    } elseif(str_contains($status, 'in progress')) {
                        $badgeClass = 'bg-purple-100 text-purple-800 border-purple-200';
                    } elseif(str_contains($status, 'resolved') || str_contains($status, 'closed')) {
                        $badgeClass = 'bg-green-100 text-green-800 border-green-200';
                    } elseif(str_contains($status, 'rejected')) {
                        $badgeClass = 'bg-red-100 text-red-800 border-red-200';
                    }
                @endphp
                <span class="{{ $badgeClass }} px-4 py-2 rounded-lg font-bold text-sm border inline-block tracking-wide">
                    {{ strtoupper($ticket->status) }}
                </span>
            </div>
        </div>
    
        @php $user = Auth::user(); @endphp

        @if ($ticket->status == 'Menunggu Persetujuan Manager' && $user->role == 'manager')
            <div class="bg-yellow-50 p-4 border-x border-b border-yellow-200 rounded-b-lg shadow-sm mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <p class="font-semibold text-yellow-800 text-sm">
                        <i class="fas fa-exclamation-circle mr-2"></i> Tindakan Diperlukan: Anda dapat menyetujui atau menolak tiket ini.
                    </p>
                    <div class="flex gap-2 flex-wrap">
                        <form action="{{ route('tickets.manager.approve', $ticket->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin menyetujui tiket ini?');">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-bold text-sm shadow-sm transition flex items-center gap-2">
                                <i class="fas fa-check"></i> Setujui
                            </button>
                        </form>
                        <button type="button" onclick="openRejectModal()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 font-bold text-sm shadow-sm transition flex items-center gap-2">
                            <i class="fas fa-times"></i> Tolak
                        </button>
                    </div>
                </div>
            </div>
        @elseif ($ticket->status == 'Menunggu Persetujuan IT Head' && in_array($user->role, ['it_head', 'admin']))
            <div class="bg-yellow-50 p-4 border-x border-b border-yellow-200 rounded-b-lg shadow-sm mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <p class="font-semibold text-yellow-800 text-sm">
                        <i class="fas fa-exclamation-circle mr-2"></i> Tindakan Diperlukan: Persetujuan Akhir dari IT Head.
                    </p>
                    <div class="flex gap-2 flex-wrap">
                        <form action="{{ route('tickets.ithead.approve', $ticket->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin menyetujui akhir tiket ini? Status akan menjadi In Progress.');">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-bold text-sm shadow-sm transition flex items-center gap-2">
                                <i class="fas fa-check-double"></i> Setujui Akhir
                            </button>
                        </form>
                        <button type="button" onclick="openRejectModal()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 font-bold text-sm shadow-sm transition flex items-center gap-2">
                            <i class="fas fa-times"></i> Tolak
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="mb-6"></div> @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
                        <i class="fas fa-align-left text-blue-600"></i> Deskripsi Masalah
                    </h3>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-wrap bg-gray-50 p-4 rounded-lg border border-gray-200">{{ $ticket->description }}</div>

                    @if($ticket->attachment)
                        <div class="mt-6 bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <h4 class="text-sm font-bold text-blue-800 mb-3 flex items-center gap-2">
                                <i class="fas fa-paperclip"></i> Lampiran Bukti:
                            </h4>
                            <div class="flex flex-col sm:flex-row items-start gap-4">
                                <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="group block bg-white p-1 border rounded shadow-sm">
                                    <img src="{{ asset('storage/' . $ticket->attachment) }}" alt="Attachment" class="h-32 object-cover rounded group-hover:opacity-80 transition cursor-zoom-in">
                                </a>
                                <div class="flex-1 mt-2 sm:mt-0">
                                    <p class="text-xs text-gray-500 mb-2">Klik gambar untuk melihat resolusi penuh</p>
                                    <a href="{{ asset('storage/' . $ticket->attachment) }}" download class="inline-flex bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-3 rounded transition items-center gap-2">
                                        <i class="fas fa-download"></i> Download File
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2 text-lg">
                        <i class="fas fa-file-signature text-blue-600"></i> Authorization / Approval
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-center border-collapse">
                            <thead>
                                <tr class="bg-gray-50 font-bold text-gray-600 text-sm border-y border-gray-200">
                                    <th class="p-3 border-x border-gray-200 w-1/3">Requester</th>
                                    <th class="p-3 border-x border-gray-200 w-1/3">Manager Dept.</th>
                                    <th class="p-3 border-x border-gray-200 w-1/3">IT Dept. Head</th>
                                </tr>
                            </thead>
                            <tbody class="border-b border-gray-200">
                                <tr>
                                    <td class="p-4 align-middle border-x border-gray-200 bg-white">
                                        <div class="flex flex-col items-center">
                                            <span class="font-bold text-gray-800">{{ $ticket->user->name }}</span>
                                            <span class="text-xs text-gray-500 mt-1">{{ $ticket->created_at->format('d M Y, H:i') }}</span>
                                            <span class="text-xs text-green-600 font-bold mt-2 bg-green-50 px-2 py-1 rounded">
                                                <i class="fas fa-check-circle mr-1"></i> Signed System
                                            </span>
                                        </div>
                                    </td>

                                    <td class="p-4 align-middle border-x border-gray-200 bg-white">
                                        @if($ticket->approved_by_manager_id)
                                            <div class="flex flex-col items-center">
                                                <span class="font-bold text-gray-800">{{ $ticket->managerApprover->name ?? '-' }}</span>
                                                <span class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($ticket->manager_approved_at)->format('d M Y, H:i') }}</span>
                                                <span class="text-xs text-green-600 font-bold mt-2 bg-green-50 px-2 py-1 rounded">
                                                    <i class="fas fa-check-circle mr-1"></i> Approved
                                                </span>
                                            </div>
                                        @elseif($ticket->status == 'Rejected' && isset($ticket->rejected_by_id) && $ticket->rejected_by_id == $ticket->managerApprover->id)
                                            <div class="flex flex-col items-center">
                                                <span class="font-bold text-red-600"><i class="fas fa-times-circle mr-1"></i> Ditolak</span>
                                                <span class="text-xs text-gray-500 mt-1">Oleh Manager</span>
                                            </div>
                                        @else
                                            <div class="flex flex-col items-center text-gray-400">
                                                <i class="fas fa-clock text-xl mb-1 opacity-50"></i>
                                                <span class="italic text-xs font-medium">Waiting Approval...</span>
                                            </div>
                                        @endif
                                    </td>

                                    <td class="p-4 align-middle border-x border-gray-200 bg-white">
                                        @if($ticket->approved_by_it_id)
                                            <div class="flex flex-col items-center">
                                                <span class="font-bold text-gray-800">{{ $ticket->itApprover->name ?? '-' }}</span>
                                                <span class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($ticket->it_approved_at)->format('d M Y, H:i') }}</span>
                                                <span class="text-xs text-green-600 font-bold mt-2 bg-green-50 px-2 py-1 rounded">
                                                    <i class="fas fa-check-circle mr-1"></i> Approved
                                                </span>
                                            </div>
                                        @elseif($ticket->status == 'Rejected' && isset($ticket->rejected_by_id))
                                            <div class="flex flex-col items-center">
                                                <span class="font-bold text-red-600"><i class="fas fa-times-circle mr-1"></i> Ditolak</span>
                                                <span class="text-xs text-gray-500 mt-1">Oleh IT Head</span>
                                            </div>
                                        @else
                                            <div class="flex flex-col items-center text-gray-400">
                                                <i class="fas fa-clock text-xl mb-1 opacity-50"></i>
                                                <span class="italic text-xs font-medium">Waiting Approval...</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2 text-lg">
                            <i class="fas fa-comments text-blue-600"></i> Diskusi / Log
                        </h3>
                        <span class="text-xs font-bold text-gray-500 bg-white border border-gray-200 px-3 py-1 rounded-full">
                            {{ $ticket->comments->count() }} Pesan
                        </span>
                    </div>
                    
                    <div class="p-6 bg-white max-h-96 overflow-y-auto custom-scrollbar space-y-4" id="comment-section">
                        @forelse($ticket->comments->sortByDesc('created_at') as $comment)
                            <div class="flex {{ $comment->user_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[85%] {{ $comment->user_id == Auth::id() ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200' }} border rounded-xl p-3 shadow-sm">
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-xs {{ $comment->user_id == Auth::id() ? 'text-blue-800' : 'text-gray-700' }}">
                                                {{ $comment->user->name }}
                                            </span>
                                            @if($comment->user->role)
                                                <span class="text-[10px] bg-white border border-gray-200 text-gray-600 px-1.5 py-0.5 rounded shadow-sm uppercase">{{ $comment->user->role }}</span>
                                            @endif
                                        </div>
                                        <span class="text-[10px] text-gray-400 font-mono">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700 mt-2">{{ $comment->message }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-gray-400">
                                <i class="fas fa-comment-dots text-4xl mb-3 opacity-30"></i>
                                <p class="text-sm font-medium">Belum ada diskusi atau catatan teknisi.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="p-4 bg-gray-50 border-t border-gray-200">
                        <form action="{{ route('comments.store', $ticket->id) }}" method="POST" class="flex gap-2" id="comment-form">
                            @csrf
                            <input type="text" name="message" class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm" placeholder="Tulis balasan atau catatan..." required autocomplete="off">
                            <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 text-sm font-bold flex items-center gap-2 transition shadow-sm">
                                <i class="fas fa-paper-plane"></i>
                                <span class="hidden sm:inline">Kirim</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-1 space-y-6">
                
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 border-t-4 border-blue-800">
                    <h3 class="font-bold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-600"></i> Informasi Request
                    </h3>
                    <div class="space-y-4 text-sm">
                        <div>
                            <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Pelapor</label>
                            <span class="font-medium text-gray-900"><i class="fas fa-user text-gray-400 mr-1 w-4"></i> {{ $ticket->user->name }}</span>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Department</label>
                            <span class="font-bold text-gray-800 bg-gray-100 px-2 py-1 rounded inline-block"><i class="fas fa-building text-gray-400 mr-1"></i> {{ $ticket->department ?? '-' }}</span>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Kategori</label>
                            <span class="font-bold text-blue-700"><i class="fas fa-tag text-blue-400 mr-1 w-4"></i> {{ $ticket->category }}</span>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 uppercase font-bold mb-1">Prioritas</label>
                            @php
                                $priorityColors = [
                                    'low' => 'bg-green-100 text-green-800 border-green-200',
                                    'medium' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'high' => 'bg-orange-100 text-orange-800 border-orange-200',
                                    'critical' => 'bg-red-100 text-red-800 border-red-200'
                                ];
                                $priorityColor = $priorityColors[strtolower($ticket->priority)] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                            @endphp
                            <span class="font-bold px-2 py-1 rounded text-xs uppercase border {{ $priorityColor }}">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $ticket->priority }}
                            </span>
                        </div>
                        <div class="pt-2 border-t border-gray-100">
                            <label class="block text-xs text-gray-400 uppercase font-bold mb-1">Waktu Dibuat</label>
                            <span class="font-mono text-gray-600 text-xs"><i class="fas fa-calendar-alt w-4"></i> {{ $ticket->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        @if($ticket->updated_at != $ticket->created_at)
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold mb-1">Terakhir Diupdate</label>
                            <span class="font-mono text-gray-600 text-xs"><i class="fas fa-history w-4"></i> {{ $ticket->updated_at->format('d M Y, H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
                        <i class="fas fa-cogs text-blue-600"></i> Tindakan
                    </h3>
                    
                    <div class="space-y-3">
                        
                        @if($ticket->status == 'Rejected')
                            <button disabled class="w-full flex items-center justify-center bg-red-50 text-red-500 font-bold py-2.5 px-4 rounded-lg cursor-not-allowed border border-red-100 text-sm">
                                <i class="fas fa-ban mr-2"></i> Tiket Ditolak
                            </button>

                        @elseif(is_null($ticket->approved_by_it_id))
                            <button disabled class="w-full flex items-center justify-center bg-gray-100 text-gray-400 font-bold py-2.5 px-4 rounded-lg cursor-not-allowed border border-gray-200 text-sm">
                                <i class="fas fa-clock mr-2"></i> Menunggu Approval
                            </button>

                        @else
                            <a href="{{ route('tickets.printTicket', $ticket->id) }}" target="_blank" class="w-full flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg transition-all duration-200 shadow-sm text-sm">
                                <i class="fas fa-print mr-2"></i> Print Dokumen
                            </a>

                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="w-full flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2.5 px-4 rounded-lg transition-all duration-200 shadow-sm text-sm">
                                <i class="fas fa-edit mr-2"></i> Edit Status
                            </a>

                            @if(in_array(Auth::user()->role, ['admin', 'it_head']) && strtolower($ticket->status) == 'in progress')
                                <button onclick="assignTechnician()" class="w-full flex items-center justify-center bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-4 rounded-lg transition-all duration-200 shadow-sm text-sm">
                                    <i class="fas fa-user-cog mr-2"></i> Assign Technician
                                </button>
                            @endif
                        @endif

                        @if(Auth::user()->role == 'admin')
                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="mt-4 pt-4 border-t border-gray-100" onsubmit="return confirm('Yakin ingin menghapus tiket ini permanen? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-600 font-bold py-2.5 px-4 rounded-lg transition-all duration-200 text-sm border border-red-100">
                                    <i class="fas fa-trash-alt mr-2"></i> Hapus Tiket
                                </button>
                            </form>
                        @endif
                        
                    </div>
                </div>

            </div>

        </div>
    </div>
    
    <div id="rejectModal" class="modal-overlay">
        <div class="modal-content border-t-4 border-red-600 shadow-xl relative mt-32">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-red-600"></i> Alasan Penolakan
            </h3>
            <form action="{{ route('tickets.reject', $ticket->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="rejection_reason" class="block text-sm font-bold text-gray-700 mb-2">
                        Berikan alasan mengapa tiket ini ditolak:
                    </label>
                    <textarea 
                        name="rejection_reason" 
                        id="rejection_reason" 
                        rows="4" 
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" 
                        placeholder="Misal: Anggaran tidak disetujui, atau masalah bisa diselesaikan oleh user..." 
                        required></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeRejectModal()" class="px-5 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-50 font-bold text-gray-600 text-sm transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-bold text-sm shadow-sm transition">
                        Submit Penolakan
                    </button>
                </div>
            </form>
            <button onclick="closeRejectModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
    </div>

    <script>
        function openRejectModal() { document.getElementById('rejectModal').style.display = 'block'; }
        function closeRejectModal() { document.getElementById('rejectModal').style.display = 'none'; }
    
        window.onclick = function(event) {
            const modal = document.getElementById('rejectModal');
            if (event.target == modal) { modal.style.display = 'none'; }
        }
    
        document.addEventListener('DOMContentLoaded', function() {
            const commentSection = document.getElementById('comment-section');
            if (commentSection) { commentSection.scrollTop = commentSection.scrollHeight; }
        });
        
        document.getElementById('comment-form')?.addEventListener('submit', function(e) {
            const input = this.querySelector('input[name="message"]');
            if (input.value.trim() === '') {
                e.preventDefault();
                input.focus();
            }
        });
        
        function assignTechnician() { alert('Modal form penugasan teknisi akan muncul di sini.'); }
    </script>
    
</body>
</html>