<?php

use Illuminate\Support\Facades\Broadcast;
use App\Broadcasting\UpdateNoteChannel;

Broadcast::channel('update.note.{noteId}', UpdateNoteChannel::class,['guards' => ['sanctum']]);