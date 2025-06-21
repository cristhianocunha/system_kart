<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bateria01;
use App\Models\User;

class UpdateRun extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $bateria = Bateria01::show();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->all();

        $isint = $this->isInt([
            "corrida" => $data['corrida'],
            "Kart" => $data['Kart'],
            "MV" => $data['MV'] ?? null,
            "TV" => $data['TV'] ?? null
        ]);

        if (!$isint['status']) {
            return response()->json(['success' => false, 'message' => "Essas variveis deve ser int", "variable" => $isint['retorno']], 201);
        }

        if (Bateria01::query()->where('corrida', $data['corrida'])->where('name', $data['name'])->first()) {
            return response()->json(['success' => false, "message" => "usuario já registrado nesse corrida " . $data['corrida']], 201);
        }
        if (!Bateria01::query()->where('name', $data['name'])->first()) {
            return response()->json(['success' => false, "message" => "Usuario não encontrado"], 201);
        }
        $userId = User::where('name', $data['name'])->value('id') ?? null;

        $create = Bateria01::create([
            "POS" => $data['POS'],
            "Kart" => $data['Kart'],
            "name" => $data['name'],
            "user_id" => $userId??null,
            "MV" => $data['MV'] ?? null,
            "TMV" => $data['TMV'] ?? null,
            "TT" => $data['TT'] ?? null,
            "DL" => $data['DL'] ?? null,
            "DA" => $data['DA'] ?? null,
            "TUV" => $data['TUV'] ?? null,
            "TV" => $data['TV'] ?? null,
            "VM" => $data['VM'] ?? null,
            "corrida" => "44",
            "date_corrida" => $data['date_corrida'],
        ]);

        return response()->json(['success' => true], 200);
    }
    // +incrementing: true
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function isInt(array $ints)
    {
        $retorno = [];
        foreach ($ints as $int => $key) {
            if (empty($key)) {
                continue;
            }
            if (!is_int($key)) {
                $retorno[] = $int;
            }
        }
        if (!empty($retorno)) {
            return ["status" => false, "retorno" => $retorno];
        }
        return ["status" => true];
    }
}
