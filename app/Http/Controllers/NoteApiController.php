<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Events\NoteAdded;
use App\Events\NoteEdited;
use App\Events\NoteDeleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteApiController extends Controller
{
    public function getAllNotes()
    {
        $notes = Note::orderBy('created_at', 'desc')->get();

        return response()->json($notes, 200, [], JSON_NUMERIC_CHECK);
    }

    public function createNote(Request $request)
    {
        $note = new Note;
        $note->message = $request->message;
        $note->entry_id = $request->entry;
        $note->created_by = Auth::id();
        $note->save();

        event(new NoteAdded($note));

        return response()->json($note, 201, [], JSON_NUMERIC_CHECK);
    }

    public function updateNote(Note $note, Request $request)
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
