<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $fillable = [
        'title',
        'organizer',
        'date',
        'address',
        'price',
        'description',
        'tags',
        'img'
    ];

    // Definisci la relazione con l'organizzatore
    public function organizer()
    {
        return $this->belongsTo(Organizer::class, 'organizer');
    }
}
