<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bateria01 extends Model
{
    protected $table = 'bateria01';
    protected $primaryKey = 'id';
    protected $attributes = [
        'TV' => 0,          
        'corrida' => 1,     
        'Kart' => 999,      
        'user_id' => null,  
        'POS' => '---',     
        'MV' => 0,         
        'update_ranking' => null 
    ];
    protected $fillable = [
        'POS', 'Kart', 'name', 'user_id', 'MV', 'TMV', 'TT', 'DL', 
        'DA', 'TUV', 'TV', 'VM', 'corrida', 'date_corrida', 'update_ranking'
    ];

    // Relação: Um registro da Bateria03 pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}