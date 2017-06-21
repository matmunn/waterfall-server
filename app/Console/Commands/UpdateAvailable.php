<?php

namespace App\Console\Commands;

use App\Events\UpdateAvailable as UpdateAvailableEvent;
use Illuminate\Console\Command;

class UpdateAvailable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'waterfall:update-available';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push a notification that an update is available';

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
     *
     * @return mixed
     */
    public function handle()
    {
        event(new UpdateAvailableEvent());
    }
}
