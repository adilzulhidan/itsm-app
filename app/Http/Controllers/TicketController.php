<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage; // Ditambahkan untuk hapus file
use Barryvdh\DomPDF\Facade\Pdf; 
use Illuminate\Support\Str; 
use App\Mail\ManagerApprovalNotification; 
use App\Mail\ITHeadApprovalNotification;
use App\Mail\TicketApprovedNotification; 
use App\Mail\TicketRejectedNotification; 

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $userRole = strtolower($user->role);
        $query = Ticket::query();

        if (in_array($userRole, ['admin', 'it_head'])) {
            // Admin dan IT Head melihat semua tiket
        } 
        elseif ($userRole == 'manager') {
            $query->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhereRaw('LOWER(department) = ?', [strtolower($user->department)]);
            });
        }
        else {
            // User biasa hanya melihat tiket sendiri
            $query->where('user_id', $user->id);
        }

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

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest()->paginate(10)->withQueryString();
        return view('tickets.index', compact('tickets'));
    }
    
    public function create()
    {
        $userRole = strtolower(Auth::user()->role);

        if (in_array($userRole, ['admin', 'it_head'])) {
            $users = User::orderBy('name', 'asc')->get();
            return view('tickets.create_admin', compact('users')); 
        }

        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject'     => 'required|string|max:255',
            'category'    => 'required', 
            'description' => 'required',
            'attachment'  => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048', 
        ]);
    
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }
    
        $ticketCode = 'IT-' . date('Ymd') . '-' . strtoupper(Str::random(5));
        
        $userId = Auth::id();
        $userRole = strtolower(Auth::user()->role);
        $dept   = $request->filled('department') ? $request->department : Auth::user()->department;
        $source = $request->filled('source') ? $request->source : 'Web System';
        $priority = 'medium';

        if (in_array($userRole, ['admin', 'it_head'])) {
            if ($request->filled('created_for_user')) {
                $targetUser = User::find($request->created_for_user);
                if ($targetUser) {
                    $userId = $targetUser->id;
                    $dept   = $targetUser->department; 
                }
            }
            if ($request->filled('priority')) {
                $priority = $request->priority;
            }
        }

        $initialStatus = 'Menunggu Persetujuan Manager';
        $mgrId = null; 
        $mgrAt = null;
        $itId  = null;
        $itAt  = null;
    
        if ($userRole == 'manager') {
            $initialStatus = 'Menunggu Persetujuan IT Head';
            $mgrId = Auth::id();
            $mgrAt = now();
        }
       elseif (in_array($userRole, ['admin', 'it_head'])) {
            $initialStatus = 'In Progress'; 
            $mgrId = Auth::id(); 
            $mgrAt = now();
            $itId = Auth::id();
            $itAt = now();
        }
    
        $ticket = Ticket::create([ 
            'user_id'              => $userId,
            'ticket_code'          => $ticketCode,
            'subject'              => $request->subject, 
            'department'           => $dept,
            'source'               => $source,
            'category'             => $request->category,
            'priority'             => $priority,
            'status'               => $initialStatus, 
            'description'          => $request->description,
            'attachment'           => $attachmentPath,
            'approved_by_manager_id' => $mgrId,
            'manager_approved_at'    => $mgrAt,
            'approved_by_it_id'      => $itId,
            'it_approved_at'         => $itAt,
        ]);
        
        try {
            if ($initialStatus == 'Menunggu Persetujuan Manager') {
                $manager = User::whereRaw('LOWER(role) = ?', ['manager'])->where('department', $dept)->first();
                if ($manager) Mail::to($manager->email)->send(new ManagerApprovalNotification($ticket));
            } 
            elseif ($initialStatus == 'Menunggu Persetujuan IT Head' && $userRole != 'admin') {
                $itHead = User::whereRaw('LOWER(role) = ?', ['it_head'])->first();
                if ($itHead) Mail::to($itHead->email)->send(new ITHeadApprovalNotification($ticket));
            }
        } catch (\Exception $e) {
            \Log::error("Email Error: " . $e->getMessage());
        }
    
        return redirect()->route('tickets.index')->with('success', 'Tiket berhasil dibuat! Kode: ' . $ticketCode);
    }
    
    public function show(Ticket $ticket)
    {
        $user = Auth::user();
        $userRole = strtolower($user->role);
        $isAuthorized = false;

        if (in_array($userRole, ['admin', 'it_head'])) $isAuthorized = true;
        elseif ($userRole == 'manager' && ($ticket->user_id == $user->id || $ticket->department == $user->department)) $isAuthorized = true;
        elseif ($ticket->user_id == $user->id) $isAuthorized = true;

        if (!$isAuthorized) abort(403, 'Unauthorized access');

        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $user = Auth::user();
        $userRole = strtolower($user->role);

        if (in_array($userRole, ['admin', 'it_head'])) {
            return view('tickets.edit', compact('ticket'));
        }

        if ($user->id === $ticket->user_id) {
            return view('tickets.edit', compact('ticket'));
        }

        if ($userRole == 'manager' && $user->department == $ticket->department) {
             return view('tickets.edit', compact('ticket'));
        }

        return redirect()->route('tickets.show', $ticket->id)->with('error', 'Akses ditolak.');
    }

    public function update(Request $request, Ticket $ticket)
    {
        $userRole = strtolower(Auth::user()->role);
        
        $request->validate([
            'category'    => 'required',
            'description' => 'required',
            'status'      => 'nullable|string',
            'priority'    => 'nullable|string', 
        ]);
    
        $dataUpdate = [
            'department'  => ($userRole == 'admin') ? $request->department : $ticket->department,
            'category'    => $request->category,
            'description' => $request->description,
        ];
    
        if (in_array($userRole, ['admin', 'it_head', 'technician'])) { 
            if ($request->filled('status')) {
                if ($request->status == 'In Progress' && is_null($ticket->approved_by_it_id)) {
                    return redirect()->back()->with('error', 'Gagal! Status tidak dapat diubah ke In Progress karena tiket belum disetujui oleh IT Head.');
                }
                $dataUpdate['status'] = $request->status;
            }
            if ($request->filled('priority')) {
                $dataUpdate['priority'] = $request->priority;
            }
        }
    
        $ticket->update($dataUpdate);
    
        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Tiket diperbarui!');
    }

    // FUNGSI HAPUS TIKET SUDAH DITINGKATKAN (DEEP DELETE)
    public function destroy(Ticket $ticket)
    {
        $userRole = strtolower(Auth::user()->role);
        
        if ($userRole !== 'admin') {
            return back()->with('error', 'Hanya Admin yang bisa menghapus tiket.');
        }

        // 1. Hapus file lampiran fisik dari storage server jika ada
        if ($ticket->attachment && Storage::disk('public')->exists($ticket->attachment)) {
            Storage::disk('public')->delete($ticket->attachment);
        }

        // 2. Hapus komentar terkait untuk mencegah Foreign Key Error di PostgreSQL
        $ticket->comments()->delete();

        // 3. Hapus paksa tiket dari database
        if (method_exists($ticket, 'forceDelete')) {
            $ticket->forceDelete(); // Jika pakai SoftDeletes
        } else {
            $ticket->delete(); // Jika tidak pakai SoftDeletes
        }

        return redirect()->route('tickets.index')->with('success', 'Tiket dan seluruh data terkait berhasil dihapus secara permanen.');
    }

    public function approveManager(Request $request, Ticket $ticket) 
    {
        if (strtolower(Auth::user()->role) != 'manager') return back()->with('error', 'Akses Ditolak');
        if (Auth::user()->department != $ticket->department) return back()->with('error', 'Bukan departemen Anda.');

        $ticket->update([
            'approved_by_manager_id' => Auth::id(),
            'manager_approved_at' => now(),
            'status' => 'Menunggu Persetujuan IT Head', 
        ]);
        
        try {
            $itHead = User::whereRaw('LOWER(role) = ?', ['it_head'])->first(); 
            if ($itHead) Mail::to($itHead->email)->send(new ITHeadApprovalNotification($ticket));
        } catch (\Exception $e) {}

        return back()->with('success', 'Disetujui Manager.');
    }

    public function approveIt(Ticket $ticket)
    {
        $userRole = strtolower(Auth::user()->role);
        
        if (!in_array($userRole, ['it_head', 'admin'])) {
            return back()->with('error', 'Akses Ditolak. Hanya IT Head atau Admin yang berwenang.');
        }

        $ticket->update([
            'approved_by_it_id' => Auth::id(),
            'it_approved_at' => now(),
            'status' => 'In Progress', 
        ]);
        
        try {
            Mail::to($ticket->user->email)->send(new TicketApprovedNotification($ticket));
        } catch (\Exception $e) {}

        return back()->with('success', 'Disetujui IT Head. Tiket mulai diproses.');
    }
    
    public function rejectTicket(Request $request, Ticket $ticket)
    {
        $request->validate(['rejection_reason' => 'required|string|max:500']);
        
        $user = Auth::user();
        $userRole = strtolower($user->role);
        
        $rejectedBy = 'System';
        if ($userRole === 'manager') $rejectedBy = 'Manager';
        elseif (in_array($userRole, ['it_head', 'admin'])) $rejectedBy = 'IT Head';

        $ticket->update([
            'status' => 'Rejected',
            'rejection_reason' => $request->rejection_reason, 
            'rejected_by_id' => $user->id,
            'rejected_at' => now(),
        ]);

        try {
            Mail::to($ticket->user->email)->send(new TicketRejectedNotification($ticket, $request->rejection_reason, $rejectedBy));
        } catch (\Exception $e) {}

        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Tiket berhasil ditolak.');
    }

    public function printTicket(Ticket $ticket)
    {
        $pdf = Pdf::loadView('tickets.print', compact('ticket'));
        return $pdf->stream('ticket-' . $ticket->ticket_code . '.pdf');
    }

    public function exportPdf()
    {
        $user = Auth::user();
        $userRole = strtolower($user->role);
        $query = Ticket::query();

        if ($userRole == 'manager') {
            $query->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('department', $user->department);
            });
        } 
        elseif (!in_array($userRole, ['admin', 'it_head'])) {
            $query->where('user_id', $user->id);
        }
        
        $tickets = $query->latest()->get();

        $pdf = Pdf::loadView('tickets.pdf', compact('tickets'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan-Tiket-ITSM.pdf');
    }
}