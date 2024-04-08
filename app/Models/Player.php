<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'fullname', 'phone', 'email', 'city','type','team_id'
    ];
    protected $hidden = ['password'];

    // Relationships, inverse. A player can be on just one team at a time.
    public function team()
    {
        return $this->belongsTo(\App\Models\Team::class);
    }

}
