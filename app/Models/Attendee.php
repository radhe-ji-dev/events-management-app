<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendee extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        //one attendee can have one user
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        //one attendee can have one event
        return $this->belongsTo(Event::class);
    }
}
