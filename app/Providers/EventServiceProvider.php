<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UpdateAvailable' => [
            'App\Listeners\UpdateAvailableListener',
        ],
        'App\Events\TaskAdded' => [
            'App\Listeners\TaskAddedListener',
        ],
        'App\Events\TaskDeleted' => [
            'App\Listeners\TaskDeletedListener',
        ],
        'App\Events\TaskEdited' => [
            'App\Listeners\TaskEditedListener',
        ],
        'App\Events\NoteAdded' => [
            'App\Listeners\NoteAddedListener',
        ],
        'App\Events\NoteDeleted' => [
            'App\Listeners\NoteDeletedListener',
        ],
        'App\Events\NoteEdited' => [
            'App\Listeners\NoteEditedListener',
        ],
        'App\Events\UserAdded' => [
            'App\Listeners\UserAddedListener',
        ],
        'App\Events\UserDeleted' => [
            'App\Listeners\UserDeletedListener',
        ],
        'App\Events\UserEdited' => [
            'App\Listeners\UserEditedListener',
        ],
        'App\Events\ClientAdded' => [
            'App\Listeners\ClientAddedListener',
        ],
        'App\Events\ClientDeleted' => [
            'App\Listeners\ClientDeletedListener',
        ],
        'App\Events\ClientEdited' => [
            'App\Listeners\ClientEditedListener',
        ],
        'App\Events\CategoryAdded' => [
            'App\Listeners\CategoryAddedListener',
        ],
        'App\Events\CategoryDeleted' => [
            'App\Listeners\CategoryDeletedListener',
        ],
        'App\Events\CategoryEdited' => [
            'App\Listeners\CategoryEditedListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
