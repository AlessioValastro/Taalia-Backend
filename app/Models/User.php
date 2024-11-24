<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'status',           
        'profile_picture',  
        'tags'             
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }
}
