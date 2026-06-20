<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly ContactMessage $contactMessage,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Нова порака од financebuddy.mk — ' . $this->contactMessage->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.new-contact-message',
        );
    }
}
