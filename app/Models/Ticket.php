<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';

    protected $fillable = [
        'account_id', // Cambiato da user_id a account_id
        'event_id'
    ];

    // Relazione con Account
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    // Relazione con Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
