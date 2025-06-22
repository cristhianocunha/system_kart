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
        $data = $request->all();

        $validated = $request->validate(Bateria01::$rules);

        if (Bateria01::query()->where('corrida', $data['corrida'])->where('name', $data['name'])->first()) {
            return response()->json(['success' => false, "message" => "usuario já registrado nesse corrida " . $data['corrida']], 201);
        }

        if (!Bateria01::query()->where('name', $data['name'])->first()) {
            return response()->json(['success' => false, "message" => "Usuario não encontrado"], 201);
        }
        if (Bateria01::query()->where('POS', $data['POS'])->where('corrida', $data['corrida'])->first()) {
            return response()->json(['success' => false, "message" => "Posição já ocupada"], 201);
        }

        $userId = User::where('name', $data['name'])->value('id') ?? null;

        $validated['user_id'] = $userId;
        $bateria = Bateria01::create($validated);

        return response()->json(['success' => true, "data" => $bateria], 201);
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
    public function update(Request $request) {}


    public function updatePos($corrida, Request $request)
    {

        $data = $request->all();
        if (empty($data['POS']) || empty($data['name'])) {
            return response()->json(['success' => false, "message" => "Campos POS e Name são obrigatorios"], 400);
        }

        $positions = Bateria01::select(['id', 'POS'])->where('corrida', $corrida)->orderBy('POS', 'asc')->get();
        $piloto_id = Bateria01::query()->where('name', $data['name'])->where('corrida', $corrida)->value('id');
        $pilotos = $positions->toArray();
        $novaPos = $data['POS'];

        if ($piloto_id !== null && $novaPos !== null) {
            $pilotoMovido = null;
            foreach ($pilotos as $key => $piloto) {
                if ($piloto['id'] == $piloto_id) {
                    $pilotoMovido = $piloto;
                    $pilotoMovido['POS'] = $novaPos;
                    unset($pilotos[$key]);
                    break;
                }
            }

            if ($pilotoMovido) {
                 array_splice($pilotos, $novaPos - 1, 0, [$pilotoMovido]);
                
            }
            
        }
       
        $posicao = 1;
        foreach ($pilotos as &$piloto) {
            $piloto['POS'] = $posicao++;
        }
        
        $pilot = array_values($pilotos);
      
        foreach ($pilot as $pil) {
            
            Bateria01::where('corrida', $corrida)->where('id', $pil['id'])->update(['POS' => $pil['POS'], "update_ranking" => null]);
            var_dump($pil);
        }
        return response()->json(['success' => true], 201);
    }


    // +incrementing: true
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
