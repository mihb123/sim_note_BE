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

    public function updateNote(array $noteData)
    {
        $noteId = $noteData['id'] ?? null;
        $userId = $noteData['user_id'] ?? null;
        if (!$noteId || !$userId) {
            return null;
        }
        $data = [
            'title' => $noteData['title'] ?? null,
            'content' => $noteData['content'] ?? null,
            'user_id' => $userId
        ];
        $note = $this->noteRepository->updateNote($userId, $noteId, $data);
        if($note){
            return ['success' => true, 'note' => $note];
        } else {
            return ['success' => false, 'note' => []];
        }
    }
}