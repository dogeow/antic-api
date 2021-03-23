<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerify extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;
    public string $link;

    /**
     * Create a new message instance.
     *
     * @param  User  $user
     * @param  string  $link  重置链接
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
    public function build(): EmailVerify
    {
        return $this->view('emails.emailVerify')->subject('验证邮箱');
    }
}
