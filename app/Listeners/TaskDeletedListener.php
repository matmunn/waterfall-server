<?php

namespace App\Listeners;

use App\Events\TaskDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskDeletedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TaskDeleted  $event
     * @return void
     */
    public function handle(TaskDeleted $event)
    {
        //
    }
}
