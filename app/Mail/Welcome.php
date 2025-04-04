<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    public $team;
    /**
     * Create a new message instance.
     */
    public function __construct(string $plate)
    {
        $this->team = \App\Models\Team::where('plate', $plate)->first();
        //dd($this->team);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'contacto@pescavariadaatr.com.ar',
            to: [$this->team->email],
            subject: 'Bienvenido a Pesca Variada ATR',
            bcc: [],
            cc: ['contacto@pescavariadaatr.com.ar'],
            replyTo: ['contacto@pescavariadaatr.com.ar'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome',
            with: [
                'team' => $this->team,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath(public_path('Reglamento y Condiciones.pdf')),
        ];
    }
}
