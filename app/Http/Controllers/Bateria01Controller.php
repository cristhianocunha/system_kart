<?php

namespace App\Http\Controllers;

use App\Models\Bateria01;
use Carbon\Carbon;

class Bateria01Controller extends Controller
{
    public function index($corrida)
    {

        // Busca todos os registros da tabela Bateria03 com os usuários relacionados
        $corredores = Bateria01::with('user')
            // ->whereHas('user')
            ->where('corrida', $corrida)
            ->orderByRaw("POS = 'NC', POS + 0") // Ordena colocando "NC" no final
            ->get();

        $data_corrida = Bateria01::query()
        ->select('date_corrida')
        ->where('corrida', $corrida)
        ->distinct()
        ->value('date_corrida');
  
        $data_corrida = Carbon::parse($data_corrida)->format('d/m/Y');
        // Passa os dados para a view
        return view('bateria01.index', compact('corredores', 'corrida', 'data_corrida'));
    }
}
