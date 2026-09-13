<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessRanking;
use App\Models\Bateria01;
use App\Models\Ranking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Bateria01Controller extends Controller
{
    public function destroy($corrida)
    {
        $user = Auth::user();
        $teamId = $user->isSuperAdmin() ? null : $user->team_id;

        Bateria01::where('corrida', $corrida)->where('team_id', $teamId)->delete();

        Ranking::where('team_id', $teamId)->delete();
        Bateria01::where('team_id', $teamId)->update(['update_ranking' => null]);

        $job = new ProcessRanking($teamId);
        $job->handle();
        $job->updateTMV();

        return redirect()->route('ranking.index')
            ->with('status', "Corrida {$corrida} removida e ranking recalculado.");
    }

    public function index($corrida)
    {
        $user = Auth::user();
        $teamId = $user->isSuperAdmin() ? null : $user->team_id;

        $corredores = Bateria01::with('user')
            ->where('corrida', $corrida)
            ->where('team_id', $teamId)
            ->orderByRaw("POS IS NULL, POS + 0")
            ->get();

        $data_corrida = Bateria01::query()
            ->select('date_corrida')
            ->where('corrida', $corrida)
            ->where('team_id', $teamId)
            ->distinct()
            ->value('date_corrida');

        $data_corrida = Carbon::parse($data_corrida)->format('d/m/Y');

        return view('bateria01.index', compact('corredores', 'corrida', 'data_corrida'));
    }
}
