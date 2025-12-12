<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketRejectedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $rejectionReason;
    public $rejectedByRole; // Untuk menampilkan siapa yang menolak

    public function __construct(Ticket $ticket, string $rejectionReason, string $rejectedByRole)
    {
        $this->ticket = $ticket;
        $this->rejectionReason = $rejectionReason;
        $this->rejectedByRole = $rejectedByRole;
    }

    public function build()
    {
        return $this->subject('❌ Pembaruan Status: Tiket ITSM Anda Ditolak - ' . $this->ticket->ticket_code)
                    ->view('emails.ticket-rejected'); // Nama blade view untuk email
    }
}