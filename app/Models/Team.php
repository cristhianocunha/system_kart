<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'slug', 'trial_ends_at'];

    protected $casts = [
        'trial_ends_at' => 'datetime',
    ];

    public function onTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function baterias()
    {
        return $this->hasMany(Bateria01::class);
    }

    public function rankings()
    {
        return $this->hasMany(Ranking::class);
    }
}
