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
        return $this->model->where('user_id', $userId)->get();
    }
}