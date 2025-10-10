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
        if ($noteId) {
            $data = [
                'title' => $noteData['title'] ?? null,
                'content' => $noteData['content'] ?? null,
                'user_id' => $noteData['user_id'] ?? null
            ];
            return $this->noteRepository->updateNote($noteId, $data);
        }
        return [];
    }

    public function createNote(array $noteData)
    {
        $data = [
            'title' => $noteData['title'] ?? "Untitled",
            'content' => $noteData['content'] ?? "",
            'user_id' => $noteData['user_id'] ?? null
        ];

        return $this->noteRepository->create($data);        
    }

    public function deleteNote(int $noteId)
    {
        return $this->noteRepository->delete($noteId);
    }
}