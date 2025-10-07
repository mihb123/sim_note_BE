<?php 

namespace App\Services;

use App\Repositories\Note\NoteRepositoryInterface;

class NoteService
{
    public function __construct(protected NoteRepositoryInterface $noteRepository)
    {
    }

    public function getNotesByUserId(int $userId)
    {
        return $this->noteRepository->getNotesByUserId($userId);
    }

}