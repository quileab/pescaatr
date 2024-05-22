<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'boatName',
        'plate',
        'hp',
    ];

    // Get the players for the team.
    public function players()
    {
        return $this->hasMany(\App\Models\Player::class);
    } 

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }

}
