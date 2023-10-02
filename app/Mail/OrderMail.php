<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;
    private $orderStatus;
    private $updateCase;

    /**
     * Create a new message instance.
     * @param Order $order
     * @param int $status -> 0 pending, 1 confirmed, -1 cancelled
     */
    public function __construct(public Order $order, int $status = 0, bool $updateCase = false)
    {
        $this->orderStatus = $status == 0 ? 'Pending' : ($status == 1 ? 'Confirmed' : 'Cancelled');
        $this->updateCase = $updateCase;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: $this->updateCase ? 'emails.orders.updated' : 'emails.orders.show',
            with: ['orderStatus' => $this->orderStatus]
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
