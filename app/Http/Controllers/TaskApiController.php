<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Client;
use App\Events\TaskAdded;
use App\Events\TaskEdited;
use App\Events\TaskDeleted;
use Illuminate\Http\Request;
use App\Events\TaskStatusChanged;
use Illuminate\Support\Facades\Auth;

class TaskApiController extends Controller
{
    private function getTasks($startDate = null, $endDate = null)
    {
        if (is_null($startDate)) {
            $startDate = (new Carbon())->startOfWeek();
        } else {
            $startDate = new Carbon($startDate);
        }

        if (is_null($endDate)) {
            $endDate = (new Carbon($endDate))->endOfWeek()->endOfDay();
        } else {
            $endDate = (new Carbon($endDate))->endOfDay();
        }

        $entries = Task::orderBy('start_date')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->get();

        $entries->each(function ($item, $key) {
            $item->blocks = $item->getBlocks();
        });

        return $entries;
    }

    private function updateTaskDetails(Task $task, Request $request)
    {
        $task->description = $request->description;

        $startDate = new Carbon($request->startTime);
        $endDate = new Carbon($request->endTime);

        if (!$endDate->gt($startDate)) {
            throw new \Exception("End date must be greater than start date");
        }
        
        $task->start_date = $startDate;
        $task->end_date = $endDate;
        $task->user_id = $request->user;
        $task->client_id = $request->client;
        $task->is_recurring = $request->recurring;
        $task->recurrence_period = $request->recurrencePeriod;
        $task->recurrence_type = $request->recurrenceType;
        $task->is_absence = $request->absence;

        $task->save();

        return $task;
    }

    public function getAllTasks()
    {
        $entries = $this->getTasks("1970-01-01", (new Carbon())->addYear());

        return response()->json($entries, 200, [], JSON_NUMERIC_CHECK);
    }

    public function getTasksByDate($startDate = null, $endDate = null)
    {
        $entries = $this->getTasks($startDate, $endDate);

        return response()->json($entries, 200, [], JSON_NUMERIC_CHECK);
    }

    public function createTask(Request $request)
    {
        $task = new Task;
        $task->created_by = Auth::id();

        $startDate = new Carbon($request->startTime);
        if ($startDate->gt((new Carbon)->startOfWeek()) && $startDate->lt((new Carbon)->endOfWeek())) {
            $task->task_added_during_week = true;
        }

        try {
            $task = $this->updateTaskDetails($task, $request);
        } catch (\Exception $e) {
            if ($e->getMessage() == "End date must be greater than start date") {
                return response('time-error', 422);
            }
        }

        event(new TaskAdded($task));

        return response($task, 201);
    }

    public function updateTask(Task $task, Request $request)
    {
        $task = $this->updateTaskDetails($task, $request);

        event(new TaskEdited($task));

        return response()->json($task, 200, [], JSON_NUMERIC_CHECK);
    }

    public function deleteTask(Task $task)
    {
        $taskId = $task->id;
        $task->delete();

        event(new TaskDeleted($taskId));

        return response()->json("OK", 200, [], JSON_NUMERIC_CHECK);
    }

    public function markTaskComplete(Task $task)
    {
        $task->markCompleted();

        event(new TaskEdited($task));

        return response()->json("OK", 200, [], JSON_NUMERIC_CHECK);
    }

    public function markTaskIncomplete(Task $task)
    {
        $task->markIncomplete();

        event(new TaskEdited($task));

        return response()->json("OK", 200, [], JSON_NUMERIC_CHECK);
    }
}
