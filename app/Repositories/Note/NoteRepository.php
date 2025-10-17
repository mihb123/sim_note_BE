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

    public function getNotesByUserId(int $userId, int $size, $is_save, $search)
    {
        $query = $this->model
            ->where('user_id', $userId)
            ->when($is_save, fn($q) => $q->where('is_save', $is_save))
            ->when($search, fn($q) => $q->where(function ($sub) use ($search){
                $sub->where('title', 'like', "%$search%")
                    ->orWhere('content', 'like', "%$search%");
            }))
            ->orderBy('updated_at', 'desc');

        return $size ? $query->paginate($size) : $query->get();
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