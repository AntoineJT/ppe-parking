<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetLink extends Mailable
{
    use Queueable, SerializesModels;

    private $resetLink;

    /**
     * Create a new message instance.
     *
     * @param string $reset_link
     */
    public function __construct(string $reset_link)
    {
        $this->resetLink = $reset_link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.resetlink')
            ->with(['reset_link' => $this->resetLink])
            ->subject('Réinitialisation du mot de passe');
    }
}
