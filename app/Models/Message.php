<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = ['chat_id', 'role', 'content'];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
