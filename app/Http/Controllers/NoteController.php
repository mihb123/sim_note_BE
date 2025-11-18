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
        $size = $request->query('per_page');
        $is_save = $request->query('is_save');
        $search = $request->query('search');

        $notes = $this->noteService->getNotesByUserId($user->id, $size, $is_save, $search);
        if(!$notes) {
            return response()->json(['message' => 'No notes found'], 404);
        }

        return response()->json($notes);
    }

    public function updateNote(UpdateNoteRequest $request)
    {
        $data = $request->validated();      
        $res = $this->noteService->updateNote($data);
        
        if($res){
            return response()->json($res);
        }

        return response()->json($res, 400);
    }

    public function createNote(Request $request)
    {
        $data = $request->only(['title', 'content']);
        $user_id = $request->user()->id;
        $data['user_id'] = $user_id;
        $res = $this->noteService->createNote($data);
        if($res){
            return response()->json($res);
        }

        return response()->json($res, 400);
    }

    public function deleteNote($noteId)
    {
        $res = $this->noteService->deleteNote($noteId);
        if($res){
            return response()->json(['success' => true]);
            }
            
        return response()->json(['success' => false], 400);
    }

    public function getNoteById($id)
    {
        $res = $this->noteService->getNoteById((int) $id);
        if($res){
            return response()->json($res);
        }

        return response()->json($res, 404);
    }

    public function shareNote($id, Request $request){
        $data = $request->validate(['email' => 'required|email|exists:users,email']);
        $res = $this->noteService->shareNote($id, $data['email']);
        if($res['status'] === 'success') {
            return response()->json($res);
        }

        return response()->json($res, 404);
    }

    public function unshareNote($shareId){
        $res = $this->noteService->unshareNote($shareId);
        if ($res['status'] === 'success') {
            return response()->json($res);
        }

        return response()->json($res, 404);
    }

    public function getSharedNotes(Request $request){
        $user = $request->user();
        $res = $this->noteService->getSharedNotes($user->id);
        if ($res) {
            return response()->json($res);
        }

        return response()->json($res, 404);
    }
}
