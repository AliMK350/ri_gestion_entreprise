<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveDecisionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $leave;
    public $status;

    public function __construct($leave, $status)
    {
        $this->leave = $leave;
        $this->status = $status;
    }

    public function envelope(): Envelope
    {
        $subject = match ($this->status) {
            'approved' => 'Votre congé a été approuvé',
            'rejected' => 'Votre congé a été refusé',
            'cancelled' => 'Votre congé a été annulé',
            default => 'Mise à jour de votre congé',
        };

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.leave_decision',
            with: [
                'leave' => $this->leave,
                'status' => $this->status,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
