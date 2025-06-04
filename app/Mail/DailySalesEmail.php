<?php

namespace App\Mail;

use App\Models\Seller;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailySalesEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Seller $seller,
        public array $salesData
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Suas vendas de hoje - ' . Carbon::parse($this->salesData['date'])->format('d/m/Y'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.daily-sales',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
