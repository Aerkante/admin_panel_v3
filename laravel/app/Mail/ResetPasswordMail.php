<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $subject = 'Nova Senha';
        return $this->from('no-reply@adminpanelv3.com.br')->to($this->data['to'])
            ->subject("Nova Senha | Tudo em Dobro")->view('mail.reset-pass', compact('data', 'subject'));
    }
}
