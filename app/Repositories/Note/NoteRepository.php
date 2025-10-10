<?php 

namespace App\Repositories\Note;

use App\Repositories\BaseRepository;
use App\Models\Note;
use App\Repositories\Note\NoteRepositoryInterface;

class NoteRepository extends BaseRepository implements NoteRepositoryInterface
{
    public function __construct(Note $model)
    {
        parent::__construct($model);
    }

    public function getNotesByUserId(int $userId)
    {
        return $this->model->where('user_id', $userId)->orderBy('updated_at', 'desc')->get();
    }

    public function updateNote(int $noteId, array $noteData)
    {
        $note = $this->model->where('id', $noteId)->first();
        if (!$note) {
            return null;
        }
        $note->update($noteData);

        return $note;    
    }
}