<?php

namespace App\Models;

use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Get the players for the team.
    public function players()
    {
        return $this->hasMany(\App\Models\Player::class);
    }

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }

    public function sendWelcomeEmail()
    {
        // TODO: send the welcome email
        Mail::to($this->email)->send(new \App\Mail\Welcome($this->id));
    }

    public function sendDebtSummary()
    {
        Mail::to($this->email)->send(new \App\Mail\AccountStatus(
            $this->id,
        ));
    }
}
