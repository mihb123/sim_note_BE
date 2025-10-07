<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NoteService;

class NoteController extends Controller
{
    public function __construct(protected NoteService $noteService)
    {    
    }

    public function getNotes(Request $request)
    {
        $user = $request->user();
        $notes = $this->noteService->getNotesByUserId($user->id);
        if(!$notes) {
            return response()->json(['message' => 'No notes found'], 404);
        }
        return response()->json($notes);
    }
}
