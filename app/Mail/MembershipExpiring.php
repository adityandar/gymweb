<?php

namespace App\Mail;

use App\Models\Membership;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MembershipExpiring extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Membership $membership
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Gym Membership is Expiring Soon');
    }

    public function content(): Content
    {
        return new Content(markdown: 'mail.membership-expiring');
    }
}
