<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Models\Note;
use App\Models\NoteShare;
use Illuminate\Support\Facades\Log;

class UpdateNoteChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, $noteId): array|bool
    {
        $user_id = $user->id;
        $note = Note::find($noteId);
        Log::info("note: ", ["note" => $note, "user_id"=> $user_id, "noteID"=> $noteId]);
        $pass = false;
        if($note && $note->user_id == $user_id) $pass = true;

        $noteShare = NoteShare::where('user_id', $user_id)->where('note_id', $noteId)->first();
        if($noteShare) $pass = true;

        return $pass;
    }
}
