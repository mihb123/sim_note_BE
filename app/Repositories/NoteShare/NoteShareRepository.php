<?php

namespace App\Repositories\NoteShare;

use App\Repositories\BaseRepository;
use App\Models\NoteShare;
use App\Repositories\NoteShare\NoteShareInterface;

class NoteShareRepository extends BaseRepository implements NoteShareInterface
{
    public function __construct(NoteShare $model)
    {
      parent::__construct($model);
    }

    public function deleteByNoteAndUser($noteId, $userId)
    {
      return $this->model->where('note_id', $noteId)->where('user_id', $userId)->delete();
    }

	public function getSharedNotes($user_id)
	{
		return $this->model
			->where('user_id', $user_id)
      ->with('note.user', fn($q) => $q->select('id', 'name'))
      ->orderBy('updated_at', 'desc')
			->get();
	}
}