<?php

namespace App\Listeners;

use App\Events\TaskEdited;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskEditedListener
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
     * @param  TaskEdited  $event
     * @return void
     */
    public function handle(TaskEdited $event)
    {
        //
    }
}
