<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteVersion extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'note_id',
        'version',
        'clientID',
        'changes',
    ];

    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
