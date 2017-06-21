<?php

namespace App\Listeners;

use App\Events\UserEdited;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserEditedListener
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
     * @param  UserEdited  $event
     * @return void
     */
    public function handle(UserEdited $event)
    {
        //
    }
}
