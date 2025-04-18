<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $team;

    /**
     * Create a new message instance.
     */
    public function __construct($team)
    {
        $this->team = \App\Models\Team::find($team);
        //dd($this->team);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Estado de Cuentas',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $result = \App\Models\Payment::where('team_id', $this->team->id)
            ->get()
            ->sortBy(['column' => 'date', 'direction' => 'desc']);

        return new Content(
            view: 'emails.account-status',
            with: [
                'team' => $this->team,
                'payments' => $result
            ]
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
