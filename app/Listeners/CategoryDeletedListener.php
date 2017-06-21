<?php

namespace App\Listeners;

use App\Events\CategoryDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CategoryDeletedListener
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
     * @param  CategoryDeleted  $event
     * @return void
     */
    public function handle(CategoryDeleted $event)
    {
        //
    }
}
