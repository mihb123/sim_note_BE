<?php 

namespace App\Services;

use App\Repositories\Note\NoteRepositoryInterface;
use Illuminate\Support\Facades\Log;

class NoteService
{
    public function __construct(protected NoteRepositoryInterface $noteRepository)
    {
    }

    public function getNotesByUserId(int $userId, $size = 30)
    {
        $size = (int) $size;
        return $this->noteRepository->getNotesByUserId($userId, $size);
    }

    public function updateNote(array $noteData)
    {
        $noteId = $noteData['id'] ?? null;
        if ($noteId) {
            $data = [
                'title' => $noteData['title'] ?? null,
                'content' => $noteData['content'] ?? '',
                'user_id' => $noteData['user_id'] ?? null,
                'is_save' => $noteData['is_save'] ?? false,
                'updated_at' => $noteData['updated_at'] ?? null
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