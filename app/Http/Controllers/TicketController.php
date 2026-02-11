<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Mail;
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
        $query = Ticket::query();

    
        if ($user->role == 'admin' || $user->role == 'it_head') {
            
        } 
        elseif ($user->role == 'manager') {
            
            $query->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('department', $user->department);
            });
        } 
        else {
            
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
        $user = Auth::user();

        
        if (in_array($user->role, ['admin', 'it_head'])) {
            return view('tickets.create_admin'); 
        }

        
        return view('tickets.create');
    }


   public function store(Request $request)
{

    $request->validate([
        'category'    => 'required', 
        'description' => 'required',
        'attachment'  => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048', 
    ]);

    
    $attachmentPath = null;
    if ($request->hasFile('attachment')) {
        $attachmentPath = $request->file('attachment')->store('attachments', 'public');
    }

    
    $ticketCode = 'IT-' . date('Ymd') . '-' . strtoupper(Str::random(5));

    
    $userRole = Auth::user()->role;
    $mgrId = null; 
    $mgrAt = null;
    $itId  = null;
    $itAt  = null;

    
    $initialStatus = 'Menunggu Persetujuan Manager';

    
    if ($userRole == 'manager') {
        $initialStatus = 'Menunggu Persetujuan IT Head';
        $mgrId = Auth::id();
        $mgrAt = now();
    }
    
    
    elseif ($userRole == 'admin') {
        $initialStatus = 'Menunggu Persetujuan IT Head'; 
        $mgrId = Auth::id(); 
        $mgrAt = now();
    }

    
    elseif ($userRole == 'it_head') {
        $initialStatus = 'In Progress';
        $mgrId = Auth::id(); 
        $mgrAt = now();
        $itId  = Auth::id();
        $itAt  = now();
    }

    
    $dept = $request->filled('department') ? $request->department : Auth::user()->department;
    $source = $request->filled('source') ? $request->source : 'Web System';

    
    $ticket = Ticket::create([ 
        'user_id'              => Auth::id(),
        'ticket_code'          => $ticketCode,
        'subject'              => 'Request: ' . $request->category,
        'department'           => $dept,
        'source'               => $source,
        'category'             => $request->category,
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

        if (in_array($user->role, ['admin', 'it_head'])) {
            return view('tickets.edit', compact('ticket'));
        }

    
        if ($user->id === $ticket->user_id) {
            return view('tickets.edit', compact('ticket'));
        }


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
        'status'      => 'nullable|string',
        'priority'    => 'nullable|string', 
    ]);

    
    $dataUpdate = [
        'department'  => (Auth::user()->role == 'admin') ? $request->department : $ticket->department,
        'category'    => $request->category,
        'description' => $request->description,
    ];

    if (in_array(Auth::user()->role, ['admin', 'it_head', 'technician'])) { 
        if ($request->filled('status')) {
            $dataUpdate['status'] = $request->status;
        }
        if ($request->filled('priority')) {
            $dataUpdate['priority'] = $request->priority;
        }
    }

    $ticket->update($dataUpdate);

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



    public function approveManager(Request $request, Ticket $ticket) 
    {
        if (Auth::user()->role != 'manager') return back()->with('error', 'Akses Ditolak');
        
        
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