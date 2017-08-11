<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Task;
use App\Events\NoteAdded;
use App\Events\NoteEdited;
use App\Events\NoteDeleted;
use Illuminate\Http\Request;
use App\Http\Requests\CreateNote;
use App\Http\Requests\UpdateNote;
use Illuminate\Support\Facades\Auth;

class NoteApiController extends Controller
{
    public function getAllNotes()
    {
        $notes = Note::orderBy('created_at', 'desc')->get();

        return response()->json($notes, 200, [], JSON_NUMERIC_CHECK);
    }

    public function createNote(CreateNote $request)
    {
        $authUser = Auth::user();

        try {
            $task = Task::findOrFail($request->entry);
        } catch (\Exception $e) {
            return response()->json('task-not-found-error', 422);
        }

        $note = new Note;
        $note->message = $request->message;
        $note->entry_id = $task->id;
        $note->created_by = $authUser->id;
        $note->group_id = $authUser->group_id;
        $note->save();

        event(new NoteAdded($note));

        return response()->json($note, 201, [], JSON_NUMERIC_CHECK);
    }

    public function updateNote(Note $note, UpdateNote $request)
    {
        $note->message = $request->message;
        $note->save();

        event(new NoteEdited($note));

        return response()->json($note, 200, [], JSON_NUMERIC_CHECK);
    }

    public function deleteNote(Note $note)
    {
        $noteId = $note->id;
        $note->delete();

        event(new NoteDeleted($noteId));

        return response()->json("OK", 200, [], JSON_NUMERIC_CHECK);
    }
}
