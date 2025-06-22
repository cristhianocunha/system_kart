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

        $validated = $request->validate(Bateria01::$rules);

        if (Bateria01::query()->where('corrida', $data['corrida'])->where('name', $data['name'])->first()) {
            return response()->json(['success' => false, "message" => "usuario já registrado nesse corrida " . $data['corrida']], 201);
        }
        if (!Bateria01::query()->where('name', $data['name'])->first()) {
            return response()->json(['success' => false, "message" => "Usuario não encontrado"], 201);
        }
        $userId = User::where('name', $data['name'])->value('id') ?? null;

        $data['user_id'] = $userId;
        $bateria = Bateria01::create($validated);

        return response()->json(['success' => true, "data" => $bateria], 201);
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
