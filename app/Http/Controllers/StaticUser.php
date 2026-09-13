<?php

namespace App\Http\Controllers;

use App\Models\Bateria01;
use Illuminate\Support\Facades\Auth;

class StaticUser extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $staticUser = Bateria01::selectRaw('MIN(TMV) AS TVM')
            ->where('team_id', $user->team_id)
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id);
                if ($user->pilot_name) {
                    $q->orWhere('name', $user->pilot_name);
                }
            })
            ->first();

        $corridas = Bateria01::query()
            ->select('corrida')
            ->where('team_id', $user->team_id)
            ->orderBy('corrida', 'asc')
            ->distinct()
            ->get();

        return view('dashboard', compact('staticUser', 'corridas'));
    }
}
