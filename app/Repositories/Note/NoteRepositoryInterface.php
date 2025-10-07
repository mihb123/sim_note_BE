<?php 

namespace App\Repositories\Note;

use App\Repositories\BaseRepositoryInterface;

interface NoteRepositoryInterface extends BaseRepositoryInterface
{
    public function getNotesByUserId(int $userId);
}