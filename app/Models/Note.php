<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'is_save',        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function noteShares()
    {
        return $this->hasMany(NoteShare::class, 'note_id');
    }
}
