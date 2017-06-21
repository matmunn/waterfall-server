<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Console\Command;

class UpdateRecurringTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'waterfall:update-recurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the recurring tasks so that they appear within their next time period.';

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
        $tasks = Task::where('is_recurring', true)
            ->whereBetween('start_date', [(new Carbon())->startOfWeek(), new Carbon()])
            ->where('recurrence_complete', false)
            ->get();
        
        $tasks->each(function ($oldTask) {
            $newTask = new Task;
            $newTask->description = $oldTask->description;
            $newTask->user_id = $oldTask->user_id;
            $newTask->client_id = $oldTask->client_id;
            $newTask->created_by = $oldTask->created_by;
            $newTask->is_recurring = $oldTask->is_recurring;
            $newTask->recurrence_period = $oldTask->recurrence_period;
            $newTask->recurrence_type = $oldTask->recurrence_type;
            $newTask->start_date = new Carbon($oldTask->start_date . " + " . $oldTask->recurrence_period . " " . $oldTask->recurrence_type);
            $newTask->end_date = new Carbon($oldTask->end_date . " + " . $oldTask->recurrence_period . " " . $oldTask->recurrence_type);
            $newTask->created_at = $oldTask->created_at;
            $newTask->is_absence = $oldTask->is_absence;

            $newTask->save();

            $oldTask->recurrence_complete = true;
            $oldTask->save();
        });

        $this->info($tasks->count() . " new tasks have been set up.");
    }
}
