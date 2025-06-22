<?php

namespace App\Http\Controllers;

use App\Models\Bateria01;
use Illuminate\Support\Facades\Auth;

class StaticUser extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
       
        $staticUser = Bateria01::with('user')
            ->selectRaw('MIN(TMV) AS TVM')
            ->where('user_id', $userId)
            ->whereHas('user')
            ->first();

        $corridas = Bateria01::query()
            ->select('corrida')  
            ->orderby('corrida', 'asc')
            ->distinct()
            ->get();

    
        return view('dashboard', compact('staticUser', 'corridas'));
    }
}
