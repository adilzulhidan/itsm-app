<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tiket - {{ $ticket->ticket_code }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
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
        
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }
    </style>
</head>
<body class="bg-gray-100">


    <div class="bg-white shadow-sm py-4 px-6 mb-6">
        <div class="container mx-auto max-w-5xl">
            <a href="{{ route('tickets.index') }}" class="text-blue-600 hover:underline flex items-center gap-2">
                back
            </a>
        </div>
    </div>


    <div class="container mx-auto px-4 max-w-5xl pb-10">
        

        <div class="bg-white rounded-t-lg shadow-sm border-b p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $ticket->subject }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Kode Tiket: <span class="font-mono font-bold bg-gray-100 px-2 py-0.5 rounded">{{ $ticket->ticket_code }}</span>
                </p>
            </div>
            <div>
                @php
                    $status = strtolower($ticket->status);
                    $badgeClass = 'bg-gray-100 text-gray-700 border-gray-200';
                    
                    switch($status) {
                        case 'open':
                        case 'menunggu persetujuan manager':
                            $badgeClass = 'bg-blue-100 text-blue-700 border-blue-200';
                            break;
                        case 'menunggu persetujuan it head':
                            $badgeClass = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                            break;
                        case 'in progress':
                            $badgeClass = 'bg-indigo-100 text-indigo-700 border-indigo-200';
                            break;
                        case 'resolved':
                        case 'closed':
                            $badgeClass = 'bg-green-100 text-green-700 border-green-200';
                            break;
                        case 'rejected':
                            $badgeClass = 'bg-red-100 text-red-700 border-red-200';
                            break;
                        default:
                            $badgeClass = 'bg-gray-100 text-gray-700 border-gray-200';
                    }
                @endphp
                <span class="{{ $badgeClass }} px-4 py-2 rounded-full font-bold text-sm border inline-block">
                    {{ strtoupper($ticket->status) }}
                </span>
            </div>
        </div>
        
    
        @php
            $user = Auth::user();
        @endphp

        @if ($ticket->status == 'Menunggu Persetujuan Manager')
            @if ($user->role == 'manager')
                <div class="bg-yellow-50 p-4 border border-yellow-200 rounded-b-lg shadow-sm mb-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <p class="font-semibold text-yellow-800">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Tindakan Diperlukan: Anda dapat menyetujui atau menolak tiket ini.
                        </p>
                        <div class="flex gap-2 flex-wrap">
                        
                            <form action="{{ route('tickets.manager.approve', $ticket->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin menyetujui tiket ini?');">
                                @csrf
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-bold text-sm shadow-md transition flex items-center gap-2">
                                    <i class="fas fa-check"></i> Setujui
                                </button>
                            </form>

                    
                            <button type="button" onclick="openRejectModal()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 font-bold text-sm shadow-md transition flex items-center gap-2">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @elseif ($ticket->status == 'Menunggu Persetujuan IT Head')
            @if ($user->role == 'it_head' || $user->role == 'admin')
                <div class="bg-yellow-50 p-4 border border-yellow-200 rounded-b-lg shadow-sm mb-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <p class="font-semibold text-yellow-800">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Tindakan Diperlukan: Persetujuan Akhir dari IT Head.
                        </p>
                        <div class="flex gap-2 flex-wrap">
                            <form action="{{ route('tickets.ithead.approve', $ticket->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin menyetujui akhir tiket ini? Status akan menjadi In Progress.');">
                                @csrf
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-bold text-sm shadow-md transition flex items-center gap-2">
                                    <i class="fas fa-check"></i> Setujui Akhir
                                </button>
                            </form>

                
                            <button type="button" onclick="openRejectModal()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 font-bold text-sm shadow-md transition flex items-center gap-2">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @endif

      
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
           
            <div class="lg:col-span-2 space-y-6">
                
                
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
                        <i class="fas fa-align-left text-blue-600"></i>
                        Deskripsi Masalah
                    </h3>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-wrap bg-gray-50 p-4 rounded">{{ $ticket->description }}</div>

                    @if($ticket->attachment)
                        <div class="mt-6 bg-gray-50 p-4 rounded border">
                            <h4 class="text-sm font-bold text-gray-600 mb-2 flex items-center gap-2">
                                <i class="fas fa-paperclip"></i>
                                Lampiran Bukti:
                            </h4>
                            <div class="flex flex-col sm:flex-row items-start gap-4">
                                <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="group">
                                    <img src="{{ asset('storage/' . $ticket->attachment) }}" alt="Attachment" class="h-32 rounded shadow group-hover:opacity-75 transition cursor-zoom-in">
                                </a>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 mb-2">Klik gambar untuk memperbesar</p>
                                    <a href="{{ asset('storage/' . $ticket->attachment) }}" download class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                                        <i class="fas fa-download"></i>
                                        Download Lampiran
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
                        <i class="fas fa-user-check text-blue-600"></i>
                        Authorization / Approval
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-center border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100 font-bold">
                                    <th class="border p-2">Requester</th>
                                    <th class="border p-2">Function Head (Manager)</th>
                                    <th class="border p-2">IT Dept Head</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border p-4 align-middle">
                                        <div class="flex flex-col items-center">
                                            <span class="font-bold text-black">{{ $ticket->user->name }}</span>
                                            <span class="text-xs text-gray-500 mt-1">{{ $ticket->created_at->format('d M Y, H:i') }}</span>
                                            <span class="text-xs text-green-600 font-bold mt-1">
                                                <i class="fas fa-check-circle"></i> Signed System
                                            </span>
                                        </div>
                                    </td>

                                    <td class="border p-4 align-middle">
                                        @if($ticket->approved_by_manager_id)
                                            <div class="flex flex-col items-center">
                                                <span class="font-bold text-black">{{ $ticket->managerApprover->name ?? '-' }}</span>
                                                <span class="text-xs text-gray-500 mt-1">
                                                    {{ \Carbon\Carbon::parse($ticket->manager_approved_at)->format('d M Y, H:i') }}
                                                </span>
                                                <span class="text-xs text-green-600 font-bold mt-1">
                                                    <i class="fas fa-check-circle"></i> Approved
                                                </span>
                                            </div>
                                        @elseif($ticket->status == 'Rejected' && isset($ticket->rejected_by_id))
                                            <div class="flex flex-col items-center">
                                                <span class="font-bold text-red-600">Ditolak</span>
                                                <span class="text-xs text-gray-500">Oleh Manager</span>
                                            </div>
                                        @else
                                            <div class="flex flex-col items-center">
                                                <span class="text-gray-400 italic">Waiting Approval...</span>
                                                <i class="fas fa-clock text-gray-300 mt-2 text-lg"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td class="border p-4 align-middle">
                                        @if($ticket->approved_by_it_id)
                                            <div class="flex flex-col items-center">
                                                <span class="font-bold text-black">{{ $ticket->itApprover->name ?? '-' }}</span>
                                                <span class="text-xs text-gray-500 mt-1">
                                                    {{ \Carbon\Carbon::parse($ticket->it_approved_at)->format('d M Y, H:i') }}
                                                </span>
                                                <span class="text-xs text-green-600 font-bold mt-1">
                                                    <i class="fas fa-check-circle"></i> Approved
                                                </span>
                                            </div>
                                        @elseif($ticket->status == 'Rejected' && isset($ticket->rejected_by_id))
                                            <div class="flex flex-col items-center">
                                                <span class="font-bold text-red-600">Ditolak</span>
                                                <span class="text-xs text-gray-500">Oleh IT Head</span>
                                            </div>
                                        @else
                                            <div class="flex flex-col items-center">
                                                <span class="text-gray-400 italic">Waiting Approval...</span>
                                                <i class="fas fa-clock text-gray-300 mt-2 text-lg"></i>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-comments text-blue-600"></i>
                            Diskusi / Tindak Lanjut
                        </h3>
                        <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded-full">
                            {{ $ticket->comments->count() }} komentar
                        </span>
                    </div>
                    
                    <div class="p-6 bg-white max-h-96 overflow-y-auto custom-scrollbar space-y-4" id="comment-section">
                        @forelse($ticket->comments->sortByDesc('created_at') as $comment)
                            <div class="flex {{ $comment->user_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[85%] {{ $comment->user_id == Auth::id() ? 'bg-blue-50 border-blue-100' : 'bg-gray-50 border-gray-200' }} border rounded-lg p-3">
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-xs {{ $comment->user_id == Auth::id() ? 'text-blue-700' : 'text-gray-700' }}">
                                                {{ $comment->user->name }}
                                            </span>
                                            @if($comment->user->role)
                                                <span class="text-[10px] bg-gray-200 px-1.5 py-0.5 rounded">{{ $comment->user->role }}</span>
                                            @endif
                                        </div>
                                        <span class="text-[10px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700 mt-2">{{ $comment->message }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-400 italic text-sm">
                                <i class="fas fa-comment-slash text-2xl mb-2"></i><br>
                                Belum ada diskusi.
                            </div>
                        @endforelse
                    </div>

                    
                    <div class="p-4 bg-gray-50 border-t">
                        <form action="{{ route('comments.store', $ticket->id) }}" method="POST" class="flex gap-2" id="comment-form">
                            @csrf
                            <input type="text" name="message" class="flex-1 border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" placeholder="Tulis balasan..." required autocomplete="off">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 text-sm font-bold flex items-center gap-2 transition">
                                <i class="fas fa-paper-plane"></i>
                                <span class="hidden sm:inline">Kirim</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            
            <div class="lg:col-span-1 space-y-6">
                
                
                <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 border-blue-800">
                    <h3 class="font-bold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-600"></i>
                        Informasi Request
                    </h3>
                    <div class="space-y-4 text-sm">
                        <div>
                            <label class="block text-xs text-gray-500 uppercase font-semibold mb-1">
                                <i class="fas fa-user mr-1"></i>Pelapor
                            </label>
                            <span class="font-medium text-gray-900">{{ $ticket->user->name }}</span>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 uppercase font-semibold mb-1">
                                <i class="fas fa-building mr-1"></i>Departemen
                            </label>
                            <span class="font-medium text-gray-900 bg-gray-100 px-2 py-1 rounded block">{{ $ticket->department ?? '-' }}</span>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 uppercase font-semibold mb-1">
                                <i class="fas fa-tag mr-1"></i>Tipe Request
                            </label>
                            <span class="font-medium text-blue-700 font-bold">{{ $ticket->category }}</span>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 uppercase font-semibold mb-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>Prioritas
                            </label>
                            @php
                                $priorityColors = [
                                    'low' => 'bg-green-100 text-green-800',
                                    'medium' => 'bg-yellow-100 text-yellow-800',
                                    'high' => 'bg-red-100 text-red-800'
                                ];
                                $priorityColor = $priorityColors[strtolower($ticket->priority)] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="font-medium px-2 py-1 rounded {{ $priorityColor }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 uppercase font-semibold mb-1">
                                <i class="fas fa-calendar mr-1"></i>Tanggal Lapor
                            </label>
                            <span class="font-medium text-gray-900">{{ $ticket->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        @if($ticket->updated_at != $ticket->created_at)
                        <div>
                            <label class="block text-xs text-gray-500 uppercase font-semibold mb-1">
                                <i class="fas fa-sync-alt mr-1"></i>Terakhir Diupdate
                            </label>
                            <span class="font-medium text-gray-900">{{ $ticket->updated_at->format('d M Y, H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
                        <i class="fas fa-cog text-blue-600"></i>
                        Tindakan
                    </h3>
                    
                    <div class="space-y-3">
                        @if($ticket->approved_by_it_id)
                            <a href="{{ route('tickets.printTicket', $ticket->id) }}" target="_blank" class="block w-full text-center bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-bold text-sm transition shadow-sm flex items-center justify-center gap-2">
                                <i class="fas fa-print"></i>
                                Print Approved Ticket
                            </a>
                        @else
                            <button disabled class="block w-full text-center bg-gray-300 text-gray-600 py-3 rounded-lg text-sm cursor-not-allowed flex items-center justify-center gap-2">
                                <i class="fas fa-clock"></i>
                                Menunggu Approval
                            </button>
                        @endif
                        
                        <a href="{{ route('tickets.edit', $ticket->id) }}" class="block w-full text-center bg-yellow-500 text-white py-3 rounded-lg hover:bg-yellow-600 font-bold text-sm transition shadow-sm flex items-center justify-center gap-2">
                            <i class="fas fa-edit"></i>
                            Edit / Update Status
                        </a>

                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tiket ini permanen? Tindakan ini tidak dapat dibatalkan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="block w-full text-center bg-red-100 text-red-600 py-3 rounded-lg hover:bg-red-200 font-bold text-sm transition border border-red-200 flex items-center justify-center gap-2">
                                <i class="fas fa-trash-alt"></i>
                                Hapus Tiket
                            </button>
                        </form>
                        
                        
                        @if(in_array($user->role, ['admin', 'it_head']) && $ticket->status == 'In Progress')
                            <button onclick="assignTechnician()" class="block w-full text-center bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 font-bold text-sm transition shadow-sm flex items-center justify-center gap-2">
                                <i class="fas fa-user-cog"></i>
                                Assign Technician
                            </button>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
    

    <div id="rejectModal" class="modal-overlay">
        <div class="modal-content">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Alasan Penolakan</h3>
            <form action="{{ route('tickets.reject', $ticket->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Berikan alasan penolakan:
                    </label>
                    <textarea 
                        name="rejection_reason" 
                        id="rejection_reason" 
                        rows="4" 
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                        placeholder="Masukkan alasan penolakan..." 
                        required></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-bold">
                        Submit Penolakan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        
        function openRejectModal() {
            document.getElementById('rejectModal').style.display = 'block';
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
        }

    
        window.onclick = function(event) {
            const modal = document.getElementById('rejectModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

    
        document.addEventListener('DOMContentLoaded', function() {
            const commentSection = document.getElementById('comment-section');
            if (commentSection) {
                commentSection.scrollTop = commentSection.scrollHeight;
            }
        });

        
        document.getElementById('comment-form')?.addEventListener('submit', function(e) {
            const input = this.querySelector('input[name="message"]');
            if (input.value.trim() === '') {
                e.preventDefault();
                input.focus();
            }
        });

        
        function assignTechnician() {
            alert('Fitur assign technician akan datang!');
        }
    </script>
    
</body>
</html>