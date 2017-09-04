<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\Client;
use App\Events\TaskAdded;
use App\Events\TaskEdited;
use App\Events\TaskDeleted;
use Illuminate\Http\Request;
use App\Events\TaskCompleted;
use App\Events\TaskIncomplete;
use App\Events\TaskStatusChanged;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\TaskTimeException;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\CreateOrUpdateTask;
use App\Exceptions\ClientNotFoundException;

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
            throw new TaskTimeException("End date must be greater than start date");
        }

        if (!$client = Client::find($request->client)) {
            throw new ClientNotFoundException("The requested client couldn't be found.");
        }
        if (!$user = User::find($request->user)) {
            throw new UserNotFoundException("The requested user couldn't be found.");
        }
        
        $task->start_date = $startDate;
        $task->end_date = $endDate;
        $task->user_id = $user->id;
        $task->client_id = $client->id;
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

    public function createTask(CreateOrUpdateTask $request)
    {
        $task = new Task;
        $authUser = Auth::user();
        $task->created_by = $authUser->id;
        $task->group_id = $authUser->group_id;

        $startDate = new Carbon($request->startTime);
        if ($startDate->gt((new Carbon)->startOfWeek()) && $startDate->lt((new Carbon)->endOfWeek())) {
            $task->task_added_during_week = true;
        }

        try {
            $task = $this->updateTaskDetails($task, $request);
        } catch (TaskTimeException $e) {
            return response()->json('time-error', 422);
        } catch (ClientNotFoundException $e) {
            return response()->json('client-not-found-error', 422);
        } catch (UserNotFoundException $e) {
            return response()->json('user-not-found-error', 422);
        }

        event(new TaskAdded($task));

        return response($task, 201);
    }

    public function updateTask(Task $task, CreateOrUpdateTask $request)
    {
        try {
            $task = $this->updateTaskDetails($task, $request);
        } catch (TaskTimeException $e) {
            return response()->json('time-error', 422);
        } catch (ClientNotFoundException $e) {
            return response()->json('client-not-found-error', 422);
        } catch (UserNotFoundException $e) {
            return response()->json('user-not-found-error', 422);
        }

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
        event(new TaskCompleted($task));

        return response()->json("OK", 200, [], JSON_NUMERIC_CHECK);
    }

    public function markTaskIncomplete(Task $task)
    {
        $task->markIncomplete();

        event(new TaskEdited($task));
        event(new TaskIncomplete($task));

        return response()->json("OK", 200, [], JSON_NUMERIC_CHECK);
    }
}
