<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NoteService;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UpdateNoteRequest;

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

    public function updateNote(UpdateNoteRequest $request)
    {
        $data = $request->validated();      
        $res = $this->noteService->updateNote($data);
        
        if($res['success']){
            return response()->json($res);
        }

        return response()->json($res, 400);
    }
}
