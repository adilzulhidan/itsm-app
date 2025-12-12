<?php

namespace App\Mail;

use App\Models\Ticket; // Import Model Ticket
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ManagerApprovalNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket; // Variable publik agar bisa dibaca di View

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ITSM: Butuh Persetujuan Manager - ' . $this->ticket->ticket_code,
        );
    }

    public function content(): Content
    {
        // Pastikan view ini dibuat (lihat langkah 3)
        return new Content(
            view: 'emails.manager_approval', 
        );
    }
}