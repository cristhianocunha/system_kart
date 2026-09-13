<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::withCount('users')->orderBy('name')->get();

        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('admin.teams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:teams,name',
        ]);

        Team::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.teams.index')
            ->with('status', "Equipe \"{$request->name}\" criada com sucesso.");
    }

    public function edit(Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:teams,name,' . $team->id,
        ]);

        $team->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.teams.index')
            ->with('status', "Equipe \"{$team->name}\" atualizada com sucesso.");
    }

    public function destroy(Team $team)
    {
        if ($team->users()->exists()) {
            return back()->withErrors(['error' => "A equipe \"{$team->name}\" possui membros ativos e não pode ser excluída."]);
        }

        $name = $team->name;
        $team->delete();

        return redirect()->route('admin.teams.index')
            ->with('status', "Equipe \"{$name}\" excluída com sucesso.");
    }
}
