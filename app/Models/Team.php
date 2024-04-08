<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'boatName',
        'plate',
        'hp',
    ];

    // Get the players for the team.
    public function players()
    {
        return $this->hasMany(\App\Models\Player::class);
    } // member.php

}
