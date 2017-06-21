<?php

namespace App\Listeners;

use App\Events\NoteEdited;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NoteEditedListener
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
     * @param  NoteEdited  $event
     * @return void
     */
    public function handle(NoteEdited $event)
    {
        //
    }
}
