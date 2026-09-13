<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use App\Models\Bateria01;
use App\Models\Team;
use App\Jobs\ProcessRanking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RankingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $teamId = $user->isSuperAdmin() ? request('team') : $user->team_id;
        $team = $teamId ? Team::find($teamId) : null;

        $rankings = Ranking::query()
            ->where('team_id', $teamId)
            ->orderBy('pontos', 'desc')
            ->get();

        return view('ranking.index', compact('rankings', 'team'));
    }

    public function showTeam(string $slug)
    {
        $team = Team::where('slug', $slug)->firstOrFail();

        $rankings = Ranking::where('team_id', $team->id)
            ->orderBy('pontos', 'desc')
            ->get();

        return view('index', compact('rankings', 'team'));
    }

    public function show()
    {
        $teams = Team::orderBy('name')->get();
        $rankings = collect();

        return view('index', compact('rankings', 'teams'));
    }

    public function update()
    {
        $user = Auth::user();
        $teamId = $user->isSuperAdmin() ? request('team') : $user->team_id;

        $update = new ProcessRanking($teamId);
        $update->handle();
        $update->updateTMV();

        return redirect()->back();
    }

    public function destroy(Ranking $ranking)
    {
        $user = Auth::user();
        $teamId = $user->isSuperAdmin() ? request('team') : $user->team_id;

        try {
            Ranking::where('team_id', $teamId)->delete();
            Bateria01::where('team_id', $teamId)->update(['update_ranking' => null]);

            return redirect()->back()->with('status', [
                'type'    => 'success',
                'message' => 'Ranking limpo com sucesso!',
            ]);
        } catch (\Exception $e) {
            return back()->with('status', [
                'type'    => 'danger',
                'message' => 'Erro ao limpar ranking: ' . $e->getMessage(),
            ]);
        }
    }
}
