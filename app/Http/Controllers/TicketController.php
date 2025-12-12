<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf; 

// Import Notification Mailables
use App\Mail\ManagerApprovalNotification; 
use App\Mail\ITHeadApprovalNotification;
use App\Mail\TicketApprovedNotification; 
use App\Mail\TicketRejectedNotification; 

class TicketController extends Controller
{
    // --- [1] DAFTAR TIKET (INDEX) ---
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Ticket::query();

        // LOGIKA HAK AKSES
        if ($user->role == 'admin' || $user->role == 'it_head') {
            // Admin & IT Head: Lihat SEMUA
        } 
        elseif ($user->role == 'manager') {
            // Manager: Lihat tiket SENDIRI + tiket DEPARTEMENNYA
            $query->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('department', $user->department);
            });
        } 
        else {
            // User Biasa: Hanya lihat tiket SENDIRI
            $query->where('user_id', $user->id);
        }

        // LOGIKA PENCARIAN
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_code', 'LIKE', "%$search%")
                  ->orWhere('subject', 'LIKE', "%$search%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'LIKE', "%$search%");
                  });
            });
        }

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest()->paginate(10)->withQueryString();
        return view('tickets.index', compact('tickets'));
    }
    
    // --- [2] HALAMAN BUAT TIKET (YANG TADI ERROR) ---
    public function create()
    {
        return view('tickets.create');
    }

    // --- [3] PROSES SIMPAN TIKET (LOGIKA PINTAR) ---
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required', 
            'description' => 'required',
            // Department optional di validasi request karena bisa ambil dari Auth User
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        $ticketCode = 'IT-' . date('Ymd') . '-' . strtoupper(uniqid());

        // Tentukan Status Awal
        $initialStatus = 'Menunggu Persetujuan Manager';
        $mgrId = null; 
        $mgrAt = null;

        // Jika Manager yang buat -> Lolos Manager -> Masuk IT Head
        if (Auth::user()->role == 'manager') {
            $initialStatus = 'Menunggu Persetujuan IT Head';
            $mgrId = Auth::id();
            $mgrAt = now();
        }
        // Jika IT Head/Admin yang buat -> Langsung In Progress
        if (Auth::user()->role == 'it_head' || Auth::user()->role == 'admin') {
            $initialStatus = 'In Progress';
            $mgrId = Auth::id();
            $mgrAt = now();
        }

        // Pastikan Departemen Terisi
        $dept = Auth::user()->department ?? $request->department;

        $ticket = Ticket::create([ 
            'user_id'     => Auth::id(),
            'ticket_code' => $ticketCode,
            'subject'     => 'Request: ' . $request->category,
            'department'  => $dept,
            'category'    => $request->category,
            'priority'    => 'medium',
            'status'      => $initialStatus, 
            'description' => $request->description,
            'attachment'  => $attachmentPath,
            'approved_by_manager_id' => $mgrId,
            'manager_approved_at' => $mgrAt,
        ]);
        
        // Logika Email Notifikasi
        try {
            if ($initialStatus == 'Menunggu Persetujuan Manager') {
                // Kirim ke Manager departemen terkait
                $manager = User::where('role', 'manager')->where('department', $dept)->first();
                if ($manager) Mail::to($manager->email)->send(new ManagerApprovalNotification($ticket));
            } 
            elseif ($initialStatus == 'Menunggu Persetujuan IT Head') {
                // Kirim ke IT Head
                $itHead = User::where('role', 'it_head')->first();
                if ($itHead) Mail::to($itHead->email)->send(new ITHeadApprovalNotification($ticket));
            }
        } catch (\Exception $e) {
            \Log::error("Email Error: " . $e->getMessage());
        }

        return redirect()->route('tickets.index')
                         ->with('success', 'Tiket berhasil dibuat! Kode: ' . $ticketCode);
    }
    
    // --- [4] DETAIL TIKET ---
    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    // --- [5] HALAMAN EDIT TIKET ---
    public function edit(Ticket $ticket)
    {
        // Cek Akses: Hanya pemilik atau Admin/IT yang boleh edit
        if (Auth::id() !== $ticket->user_id && Auth::user()->role !== 'admin' && Auth::user()->role !== 'it_head') {
             return redirect()->route('tickets.show', $ticket->id)->with('error', 'Akses ditolak.');
        }
        return view('tickets.edit', compact('ticket'));
    }

    // --- [6] UPDATE TIKET ---
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'category'   => 'required',
            'description'=> 'required',
        ]);

        $ticket->update([
            'department' => $request->department ?? $ticket->department, // Jaga-jaga kalau user edit dept
            'category'   => $request->category,
            'description'=> $request->description,
        ]);

        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Tiket diperbarui!');
    }

    // --- [7] HAPUS TIKET ---
    public function destroy(Ticket $ticket)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Hanya Admin yang bisa menghapus tiket.');
        }
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Tiket dihapus.');
    }

    // --- [8] APPROVAL MANAGER ---
    public function approveManager(Request $request, Ticket $ticket) 
    {
        if (Auth::user()->role != 'manager') return back()->with('error', 'Akses Ditolak');
        
        $ticket->update([
            'approved_by_manager_id' => Auth::id(),
            'manager_approved_at' => now(),
            'status' => 'Menunggu Persetujuan IT Head', 
        ]);
        
        try {
            $itHead = User::where('role', 'it_head')->first(); 
            if ($itHead) Mail::to($itHead->email)->send(new ITHeadApprovalNotification($ticket));
        } catch (\Exception $e) {}

        return back()->with('success', 'Disetujui Manager.');
    }

    // --- [9] APPROVAL IT HEAD ---
    public function approveIt(Ticket $ticket)
    {
        if (Auth::user()->role != 'it_head' && Auth::user()->role != 'admin') return back()->with('error', 'Akses Ditolak');

        $ticket->update([
            'approved_by_it_id' => Auth::id(),
            'it_approved_at' => now(),
            'status' => 'In Progress', 
        ]);
        
        try {
            Mail::to($ticket->user->email)->send(new TicketApprovedNotification($ticket));
        } catch (\Exception $e) {}

        return back()->with('success', 'Disetujui IT Head. Tiket diproses.');
    }
    
    // --- [10] REJECT TICKET ---
    public function rejectTicket(Request $request, Ticket $ticket)
    {
        $request->validate(['rejection_reason' => 'required|string|max:500']);
        
        $user = Auth::user();
        $rejectedBy = ($user->role === 'manager') ? 'Manager' : 'IT Head';

        $ticket->update([
            'status' => 'Rejected',
            'rejection_reason' => $request->rejection_reason, 
            'rejected_by_id' => $user->id,
            'rejected_at' => now(),
        ]);

        try {
            Mail::to($ticket->user->email)->send(new TicketRejectedNotification($ticket, $request->rejection_reason, $rejectedBy));
        } catch (\Exception $e) {}

        return redirect()->route('tickets.show', $ticket->id)->with('error', 'Tiket ditolak.');
    }

    // --- [11] PRINT PDF ---
    public function printTicket(Ticket $ticket)
    {
        $pdf = Pdf::loadView('tickets.print', compact('ticket'));
        return $pdf->stream('ticket-' . $ticket->ticket_code . '.pdf');
    }

    public function exportPdf()
    {
        // 1. Ambil User yang sedang login
        $user = Auth::user();
        $query = Ticket::query();

        // 2. Terapkan Logika Hak Akses (Sama seperti di Index)
        if ($user->role == 'manager') {
            // Manager: Tiket sendiri + Departemennya
            $query->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('department', $user->department);
            });
        } 
        elseif ($user->role != 'admin' && $user->role != 'it_head') {
            // User Biasa: Hanya tiket sendiri
            $query->where('user_id', $user->id);
        }
        // Admin & IT Head otomatis melihat semua (tidak perlu where)

        // 3. Ambil data (Gunakan get() bukan paginate() agar terambil semua)
        $tickets = $query->latest()->get();

        // 4. Load View PDF
        // Pastikan nama file view sesuai dengan yang ada di folder Anda: resources/views/tickets/pdf.blade.php
        $pdf = Pdf::loadView('tickets.pdf', compact('tickets'));

        // 5. Atur Ukuran Kertas (Landscape agar tabel lebar muat)
        $pdf->setPaper('a4', 'landscape');

        // 6. Tampilkan / Download
        return $pdf->stream('Laporan-Tiket-ITSM.pdf');
    }
}