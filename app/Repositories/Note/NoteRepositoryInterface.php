<?php 

namespace App\Repositories\Note;

use App\Repositories\BaseRepositoryInterface;

interface NoteRepositoryInterface extends BaseRepositoryInterface
{
    public function getNotesByUserId(int $userId);
    public function updateNote(int $noteId, array $noteData);
}