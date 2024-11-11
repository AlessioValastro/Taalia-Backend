<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    protected $table = 'organizers';

    protected $fillable = [
        'name',
        'address',
        'email',
        'password',
        'profile_picture'
    ];

    public function events()
    {
        return $this->hasMany(Event::class, 'organizer_id'); // Relazione uno-a-molti
    }
}
