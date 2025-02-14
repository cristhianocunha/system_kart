<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Ranking;
use App\Models\Bateria01;

class ProcessRanking implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $baterias = Bateria01::query()
            ->whereNull("update_ranking")
            ->get();

        if (!$baterias) {
            die;
        }
        foreach ($baterias as $bateria) {

            $pontos = match ($bateria->POS) {
                "1" => 10,
                "2" => 9,
                "3" => 8,
                "4" => 7,
                "5" => 6,
                "6" => 5,
                "7" => 4,
                "8" => 3,
                "9" => 2,
                "10" => 1,
                default => 0,
            };

            $Corredor = Ranking::query()
                ->where('name', $bateria->name)->first();

            if ($Corredor) {
                $pontos = $Corredor->pontos + $pontos;
                $update = Ranking::query()->where('name', $bateria->name)->update([
                    "pontos" => $pontos,

                ]);
                if ($update) {
                    Bateria01::query()->where("id", $bateria->id)
                        ->update([
                            "update_ranking" => date('Y-m-d H:i:s'),
                        ]);
                }
            }

            if (!$Corredor) {
                $create = Ranking::insert([
                    'pontos' => $pontos,
                    'name' => $bateria->name,
                    'user_id' => $bateria->user_id ?? null,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                if ($create) {
                    Bateria01::query()->where("id", $bateria->id)
                        ->update([
                            "update_ranking" => date('Y-m-d H:i:s'),
                        ]);
                }
            }
        }
    }
    public function updateTMV()
    {
        $updates = Bateria01::query()
            ->selectRaw("name, MIN(TMV) AS TVM")
            ->groupBy('name')
            ->get()->toArray();
        foreach ($updates as $update) {
            Ranking::query()->where('name', $update['name'])
                ->update(["TMV" => $update['TVM']]);
        }
    }
}
