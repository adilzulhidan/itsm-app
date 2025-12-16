<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf; 
use Illuminate\Support\Str; // Tambahan untuk helper string

// Import Notification Mailables
use App\Mail\ManagerApprovalNotification; 
use App\Mail\ITHeadApprovalNotification;
use App\Mail\TicketApprovedNotification; 
use App\Mail\TicketRejectedNotification; 

class TicketController extends Controller
{
    /**
     * Menampilkan daftar tiket berdasarkan Role.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Ticket::query();

        // 1. Filter hak akses melihat tiket
        if ($user->role == 'admin' || $user->role == 'it_head') {
            // Admin & IT Head melihat semua tiket
        } 
        elseif ($user->role == 'manager') {
            // Manager melihat tiket buatannya SENDIRI atau tiket dari DEPARTMENT-nya
            $query->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('department', $user->department);
            });
        } 
        else {
            // User biasa hanya melihat tiket buatannya sendiri
            $query->where('user_id', $user->id);
        }

        // 2. Filter Pencarian (Search)
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

        // 3. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest()->paginate(10)->withQueryString();
        return view('tickets.index', compact('tickets'));
    }
    
    /**
     * Menampilkan Form Pembuatan Tiket.
     * Membedakan tampilan antara Admin/IT Head dengan User Biasa.
     */
    public function create()
    {
        $user = Auth::user();

        // Jika Admin atau IT Head, tampilkan Form "Kertas Resmi" (create_admin.blade.php)
        if (in_array($user->role, ['admin', 'it_head'])) {
            return view('tickets.create_admin'); 
        }

        // Jika User biasa atau Manager, tampilkan Form Simpel Web (create_user.blade.php)
        return view('tickets.create');
    }

    /**
     * Menyimpan Tiket ke Database.
     * Menangani logika input yang berbeda antara Admin dan User.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Dasar
        $request->validate([
            'category'    => 'required', 
            'description' => 'required',
            // Tambahkan dukungan PDF
            'attachment'  => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048', 
        ]);

        // 2. Upload Attachment (Jika ada)
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        // 3. Generate Kode Tiket Unik
        $ticketCode = 'IT-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // 4. Tentukan Status Awal & Auto Approval berdasarkan Siapa yang input
        $initialStatus = 'Menunggu Persetujuan Manager';
        $mgrId = null; 
        $mgrAt = null;

        // Jika Manager yang buat, otomatis approve level 1
        if (Auth::user()->role == 'manager') {
            $initialStatus = 'Menunggu Persetujuan IT Head';
            $mgrId = Auth::id();
            $mgrAt = now();
        }
        
        // Jika Admin/IT Head yang buat, langsung In Progress (Bypass approval)
        if (in_array(Auth::user()->role, ['admin', 'it_head'])) {
            $initialStatus = 'In Progress';
            $mgrId = Auth::id(); 
            $mgrAt = now();
        }

        // 5. LOGIKA DEPARTMENT & SOURCE (Penting!)
        
        // Department: Jika input tersedia (dari form Admin), pakai itu. Jika tidak (User), ambil dari Auth.
        $dept = $request->filled('department') ? $request->department : Auth::user()->department;

        // Source: Jika input tersedia (dari form Admin), pakai itu. Jika tidak, default 'Web System'.
        $source = $request->filled('source') ? $request->source : 'Web System';

        // 6. Simpan Data
        $ticket = Ticket::create([ 
            'user_id'              => Auth::id(),
            'ticket_code'          => $ticketCode,
            'subject'              => 'Request: ' . $request->category,
            'department'           => $dept,      // Hasil logika poin 5
            'source'               => $source,    // Hasil logika poin 5
            'category'             => $request->category,
            'priority'             => 'medium',
            'status'               => $initialStatus, 
            'description'          => $request->description,
            'attachment'           => $attachmentPath,
            'approved_by_manager_id' => $mgrId,
            'manager_approved_at'    => $mgrAt,
        ]);
        
        // 7. Kirim Notifikasi Email
        try {
            if ($initialStatus == 'Menunggu Persetujuan Manager') {
                // Cari manager di department TIKET tersebut (bukan department user login, jaga-jaga admin input buat dept lain)
                $manager = User::where('role', 'manager')->where('department', $dept)->first();
                if ($manager) Mail::to($manager->email)->send(new ManagerApprovalNotification($ticket));
            } 
            elseif ($initialStatus == 'Menunggu Persetujuan IT Head') {
                $itHead = User::where('role', 'it_head')->first();
                if ($itHead) Mail::to($itHead->email)->send(new ITHeadApprovalNotification($ticket));
            }
        } catch (\Exception $e) {
            \Log::error("Email Error: " . $e->getMessage());
        }

        return redirect()->route('tickets.index')
                         ->with('success', 'Tiket berhasil dibuat! Kode: ' . $ticketCode);
    }
    
    
    public function show(Ticket $ticket)
    {
        // Pastikan user hanya bisa melihat tiket yang diizinkan (mirip logika index)
        $user = Auth::user();
        $isAuthorized = false;

        if (in_array($user->role, ['admin', 'it_head'])) $isAuthorized = true;
        elseif ($user->role == 'manager' && ($ticket->user_id == $user->id || $ticket->department == $user->department)) $isAuthorized = true;
        elseif ($ticket->user_id == $user->id) $isAuthorized = true;

        if (!$isAuthorized) abort(403, 'Unauthorized access');

        return view('tickets.show', compact('ticket'));
    }

    
    public function edit(Ticket $ticket)
    {
        $user = Auth::user();

        // Admin & IT Head boleh edit semua
        if (in_array($user->role, ['admin', 'it_head'])) {
            return view('tickets.edit', compact('ticket'));
        }

        // Pemilik tiket boleh edit
        if ($user->id === $ticket->user_id) {
            return view('tickets.edit', compact('ticket'));
        }

        // Manager boleh edit tiket departmentnya (Opsional, jika diinginkan)
        if ($user->role == 'manager' && $user->department == $ticket->department) {
             return view('tickets.edit', compact('ticket'));
        }

        return redirect()->route('tickets.show', $ticket->id)->with('error', 'Akses ditolak.');
    }

    
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'category'    => 'required',
            'description' => 'required',
        ]);

        $ticket->update([
            // Admin bisa ubah department, user biasa tidak
            'department' => (Auth::user()->role == 'admin') ? $request->department : $ticket->department,
            'category'   => $request->category,
            'description'=> $request->description,
        ]);

        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Tiket diperbarui!');
    }

    
    public function destroy(Ticket $ticket)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Hanya Admin yang bisa menghapus tiket.');
        }
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Tiket dihapus.');
    }

    // --- LOGIKA APPROVAL ---

    public function approveManager(Request $request, Ticket $ticket) 
    {
        if (Auth::user()->role != 'manager') return back()->with('error', 'Akses Ditolak');
        
        // Pastikan manager hanya approve departemennya sendiri
        if (Auth::user()->department != $ticket->department) return back()->with('error', 'Bukan departemen Anda.');

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

    
    public function approveIt(Ticket $ticket)
    {
        if (!in_array(Auth::user()->role, ['it_head', 'admin'])) return back()->with('error', 'Akses Ditolak');

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

    // --- PDF & PRINT ---

    public function printTicket(Ticket $ticket)
    {
        $pdf = Pdf::loadView('tickets.print', compact('ticket'));
        return $pdf->stream('ticket-' . $ticket->ticket_code . '.pdf');
    }

    public function exportPdf()
    {
        $user = Auth::user();
        $query = Ticket::query();

        if ($user->role == 'manager') {
            $query->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('department', $user->department);
            });
        } 
        elseif ($user->role != 'admin' && $user->role != 'it_head') {
            $query->where('user_id', $user->id);
        }
        
        $tickets = $query->latest()->get();

        $pdf = Pdf::loadView('tickets.pdf', compact('tickets'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan-Tiket-ITSM.pdf');
    }
}