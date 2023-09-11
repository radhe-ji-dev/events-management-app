<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\User;

class Event extends Model
{
    use HasFactory;
    //define the fillable fields which can be mass assigned for this model
    protected $fillable = ['name', 'description', 'start_time', 'end_time', 'user_id'];

    public function attendees(): BelongsToMany
    {
        //one event can have many attendees
        return $this->belongsToMany(User::class, 'attendees');
    }

    public function user(): BelongsTo
    {
        //one event can have one user
        return $this->belongsTo(User::class);
    }
}
