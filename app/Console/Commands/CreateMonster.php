<?php

namespace App\Console\Commands;

use App\Http\Controllers\GameController;
use Illuminate\Console\Command;

class CreateMonster extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:createMonster';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        (new GameController())->createMonster();

        return 0;
    }
}
