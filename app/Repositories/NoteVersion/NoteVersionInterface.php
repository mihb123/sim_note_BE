<?php 

namespace App\Repositories\NoteVersion;

use App\Repositories\BaseRepositoryInterface;

interface NoteVersionInterface extends BaseRepositoryInterface
{
    public function getLatestVersion($noteId, $version);
}