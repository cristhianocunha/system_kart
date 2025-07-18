<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use App\Models\Bateria01;
use App\Jobs\ProcessRanking;
use Illuminate\Http\Request;

class RankingController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rankings = Ranking::query()->orderBy('pontos', 'desc')
            ->get();
        $cont = Ranking::query()->count();
        return view('ranking.index', compact('rankings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $rankings = Ranking::query()->orderBy('pontos', 'desc')
            ->get();
        $cont = Ranking::query()->count();
        return view('index', compact('rankings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ranking $ranking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        $update = new ProcessRanking;
        $update->handle();
        $update->updateTMV();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ranking $ranking)
    {
        try {
            $ranking::truncate();
            Bateria01::query()->update(["update_ranking" => null]);

            return redirect()->back()->with('status', [
                'type' => 'success',
                'message' => 'Tabela limpa com sucesso!'
            ]);
        } catch (\Exception $e) {
            return back()->with('status', [
                'type' => 'danger',
                'message' => 'Erro ao limpar tabela: ' . $e->getMessage()
            ]);
        }
    }
}
