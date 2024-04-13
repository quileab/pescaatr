<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    // create an accessor to translate player type
    protected function type(): Attribute{
        return Attribute::make(get: fn(string $value)
         => match($value){
            'wheel' => 'Timonel',
            'player' => 'Participante',
            default => 'Participante'
            });
    }

}
