<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\BuildNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ProcessGithubWebHook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $cmd;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cmd)
    {
        $this->cmd = $cmd;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $output = shell_exec($this->cmd);
        Notification::send(new User, new BuildNotification($output));
    }
}
