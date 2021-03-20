<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Forget extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;
    public $link;

    /**
     * Create a new message instance.
     *
     * @param  User  $user
     * @param  string  $link
     */
    public function __construct(User $user, string $link)
    {
        $this->user = $user;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.forget')->subject('重置密码');
    }
}
