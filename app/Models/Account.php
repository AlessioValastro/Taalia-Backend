<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';

    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'status',           // Campo status
        'profile_picture',  // Campo profile_picture
        'tags'              // Campo tags (array di stringhe)
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'account_id');
    }
}
