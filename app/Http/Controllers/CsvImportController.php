<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessRanking;
use App\Models\Bateria01;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CsvImportController extends Controller
{
    public function create()
    {
        $teamId = Auth::user()->team_id;
        $nextCorrida = (Bateria01::where('team_id', $teamId)->max('corrida') ?? 0) + 1;

        return view('corrida.import', compact('nextCorrida'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'csv'          => 'required|file|mimes:csv,txt',
            'date_corrida' => 'required|date',
        ]);

        $teamId = Auth::user()->team_id;
        $corrida = (Bateria01::where('team_id', $teamId)->max('corrida') ?? 0) + 1;
        $dataCorrida = $request->input('date_corrida');

        $file = $request->file('csv');
        $handle = fopen($file->getRealPath(), 'r');

        $header = fgetcsv($handle);
        $header = array_map('trim', $header);

        $rows = [];
        while (($line = fgetcsv($handle)) !== false) {
            $line = array_map('trim', $line);
            if (count($line) < count($header)) {
                continue;
            }
            $rows[] = array_combine($header, $line);
        }
        fclose($handle);

        if (empty($rows)) {
            return back()->withErrors(['csv' => 'O arquivo CSV está vazio ou inválido.']);
        }

        $userCache = [];

        foreach ($rows as $row) {
            $posRaw = strtoupper(trim($row['POS'] ?? ''));
            $pos = ($posRaw === 'NC' || $posRaw === '') ? null : (int) $posRaw;

            $name = trim($row['name'] ?? '');

            if (!isset($userCache[$name])) {
                $userCache[$name] = User::where('pilot_name', $name)
                    ->where('team_id', $teamId)
                    ->value('id');
            }

            Bateria01::create([
                'POS'          => $pos,
                'Kart'         => (int) ($row['Kart'] ?? 999),
                'name'         => $name,
                'user_id'      => $userCache[$name] ?? null,
                'team_id'      => $teamId,
                'MV'           => (int) ($row['NV'] ?? 0),
                'TMV'          => $row['TMV'] ?? null,
                'TT'           => $row['TT'] ?? null,
                'DL'           => $row['DL'] ?? null,
                'DA'           => $row['DA'] ?? null,
                'TUV'          => $row['TUV'] ?? null,
                'VM'           => $row['TV'] ?? null,
                'corrida'      => $corrida,
                'date_corrida' => $dataCorrida,
            ]);
        }

        $job = new ProcessRanking($teamId);
        $job->handle();
        $job->updateTMV();

        return redirect()->route('bateria01.index', ['corrida' => $corrida])
            ->with('status', "Corrida {$corrida} importada com sucesso! Pontos calculados.");
    }
}
