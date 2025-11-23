<?php

namespace App\Repositories\NoteVersion;

use App\Repositories\BaseRepository;
use App\Models\NoteVersion;
use App\Repositories\NoteVersion\NoteVersionInterface;

class NoteVersionRepository extends BaseRepository implements NoteVersionInterface
{
    public function __construct(NoteVersion $model)
    {
      parent::__construct($model);
    }

    public function getLatestVersion($noteId, $version)
    {
      return $this->model->where("note_id","=", $noteId)->where("version",">=", $version)->get();
    }
}