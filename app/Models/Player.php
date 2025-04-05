<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['password'];

    // Relationships, inverse. A player can be on just one team at a time.
    public function team()
    {
        return $this->belongsTo(\App\Models\Team::class);
    }

    // create an accessor typeAttr to translate player type wheel or player as Timonel or Participante
    protected function typeAttr(): Attribute
    {
        return Attribute::make(get: fn($value) => $this->type == 'wheel' ? 'Timonel' : 'Participante');
    }
}
