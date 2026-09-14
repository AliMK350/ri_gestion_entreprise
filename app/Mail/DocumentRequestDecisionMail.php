<?php

namespace App\Mail;

use App\Models\DocumentRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DocumentRequestDecisionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public DocumentRequest $documentRequest,
        public string $status
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->status === 'approved'
                ? 'Votre demande de document a été acceptée'
                : 'Votre demande de document a été refusée'
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.document_request_decision',
            with: [
                'documentRequest' => $this->documentRequest,
                'status' => $this->status,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
