<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Ranking;
use App\Models\Bateria01;

class ProcessRanking implements ShouldQueue
{
    use Queueable;

    public function __construct(private ?int $teamId = null)
    {
        //
    }

    public function handle(): void
    {
        $baterias = Bateria01::query()
            ->whereNull('update_ranking')
            ->where('team_id', $this->teamId)
            ->get();

        if ($baterias->isEmpty()) {
            return;
        }

        foreach ($baterias as $bateria) {
            $pontos = match ($bateria->POS) {
                1  => 10,
                2  => 9,
                3  => 8,
                4  => 7,
                5  => 6,
                6  => 5,
                7  => 4,
                8  => 3,
                9  => 2,
                10 => 1,
                default => 0,
            };

            $corredor = Ranking::query()
                ->where('name', $bateria->name)
                ->where('team_id', $this->teamId)
                ->first();

            if ($corredor) {
                $corredor->update(['pontos' => $corredor->pontos + $pontos]);
            } else {
                Ranking::create([
                    'pontos'  => $pontos,
                    'name'    => $bateria->name,
                    'user_id' => $bateria->user_id ?? null,
                    'team_id' => $this->teamId,
                ]);
            }

            $bateria->update(['update_ranking' => now()]);
        }
    }

    public function updateTMV(): void
    {
        $updates = Bateria01::query()
            ->selectRaw('name, MIN(TMV) AS TVM')
            ->where('team_id', $this->teamId)
            ->groupBy('name')
            ->get();

        foreach ($updates as $update) {
            Ranking::query()
                ->where('name', $update->name)
                ->where('team_id', $this->teamId)
                ->update(['TMV' => $update->TVM]);
        }
    }
}
