<?php 

namespace App\Repositories\NoteShare;

use App\Repositories\BaseRepositoryInterface;

interface NoteShareInterface extends BaseRepositoryInterface
{
    public function deleteByNoteAndUser($noteId, $userId);
    public function getSharedNotes($user_id);
}