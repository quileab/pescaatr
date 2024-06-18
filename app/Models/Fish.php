<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'species_id',
        'size',
        'weight'
    ];

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

}
