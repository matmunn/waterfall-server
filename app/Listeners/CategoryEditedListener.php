<?php

namespace App\Listeners;

use App\Events\CategoryEdited;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CategoryEditedListener
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
     * @param  CategoryEdited  $event
     * @return void
     */
    public function handle(CategoryEdited $event)
    {
        //
    }
}
