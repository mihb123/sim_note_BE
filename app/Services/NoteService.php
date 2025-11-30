<?php 

namespace App\Services;

use App\Repositories\Note\NoteRepositoryInterface;
use App\Repositories\NoteShare\NoteShareInterface;
use App\Repositories\UserRepository\UserRepository;
use Illuminate\Support\Facades\Log;
use App\Repositories\NoteVersion\NoteVersionInterface;
use App\Events\UpdateNoteEvent;

class NoteService
{
    public function __construct(protected NoteRepositoryInterface $noteRepository, protected NoteVersionInterface $noteVersionRepository, protected NoteShareInterface $noteShareRepository, protected UserRepository $userRepository)
    {
    }

    public function getNotesByUserId(int $userId, $size = 30, $is_save = 0, $search = '')
    {
        $size = (int) $size;
        return $this->noteRepository->getNotesByUserId($userId, $size, $is_save, $search);
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

    public function getNoteById(int $id)
    {
        return $this->noteRepository->getNoteById($id);
    }

    public function shareNote($noteId, $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $noteShare = $this->noteShareRepository->create([
            'note_id' => $noteId,
            'user_id' => $user->id,
        ]);

        if($noteShare){
            $note = $this->noteRepository->getNoteById($noteId);
            return ['status' => 'success', 'message' => 'Share note successfully', 'note' => $note];
        }

        return ['status' => 'error', 'message' => 'Share note failed', 'note' => null];        
    }

    public function unshareNote($shareId)
    {
        $deleted = $this->noteShareRepository->delete($shareId);

        if($deleted){
            return ['status' => 'success', 'message' => 'Unshare note successfully'];
        }

        return ['status' => 'error', 'message' => 'Unshare note failed'];        
    }

    public function getSharedNotes($userId)
    {
        return $this->noteShareRepository->getSharedNotes($userId);
    }

    public function changeDoc($noteId, $data){
        broadcast(new UpdateNoteEvent($noteId, $data['updates']))->toOthers();
        $res = $this->noteVersionRepository->create([
            'note_id'=> $noteId,
            'version' => $data['version'],
            'clientID' => $data['clientID'],
            'changes' => $data['updates'],
        ]);
        if($res) return ['status'=> 'success'];
        
        return ['status'=> 'error'];
    }

    public function getLatestVersion($id, $version){
        return $this->noteVersionRepository->getLatestVersion($id, $version);
    }
}