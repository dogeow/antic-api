<?php

declare(strict_types=1);

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
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private $cmd)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $output = shell_exec($this->cmd);
        Notification::send(new User(), new BuildNotification($output));
    }
}
