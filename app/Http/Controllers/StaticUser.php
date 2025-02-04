<?php

namespace App\Http\Controllers;

use App\Models\Bateria01;
use Illuminate\Support\Facades\Auth;

class StaticUser extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        // Busca todos os registros da tabela Bateria03 com os usuários relacionados
        $staticUser = Bateria01::with('user')
            ->selectRaw('MIN(TMV) AS TVM')
            ->where('user_id', $userId)
            ->whereHas('user')
            ->orderByRaw("POS = 'NC', POS + 0") // Ordena colocando "NC" no final
            ->first();

        $corridas = Bateria01::query()
            ->select('corrida')  // Selecione apenas a coluna 'corrida'
            ->distinct()          // Retorna apenas valores únicos
            ->get();

   
        // Passa os dados para a view
        return view('dashboard', compact('staticUser', 'corridas'));
    }
}
