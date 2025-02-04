<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bateria01 extends Model
{
    protected $table = 'bateria01';

    // Relação: Um registro da Bateria03 pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}