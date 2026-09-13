<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bateria01;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $users = $user->isSuperAdmin()
            ? User::with('team')->orderBy('name')->get()
            : User::where('team_id', $user->team_id)->orderBy('name')->get();

        return view('admin.members.index', compact('users'));
    }

    public function create()
    {
        $teams = Auth::user()->isSuperAdmin() ? Team::orderBy('name')->get() : collect();
        return view('admin.members.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $isSuperAdmin = Auth::user()->isSuperAdmin();

        $request->validate([
            'name'       => 'required|string|max:50',
            'pilot_name' => 'nullable|string|max:50',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8|confirmed',
            'is_admin'   => 'boolean',
            'team_id'    => $isSuperAdmin ? 'nullable|exists:teams,id' : '',
        ]);

        $pilotName = $request->filled('pilot_name') ? $request->pilot_name : null;
        $teamId = $isSuperAdmin ? ($request->team_id ?: null) : Auth::user()->team_id;

        $user = User::create([
            'name'                 => $request->name,
            'pilot_name'           => $pilotName,
            'email'                => $request->email,
            'password'             => Hash::make($request->password),
            'is_admin'             => $request->boolean('is_admin'),
            'must_change_password' => true,
            'team_id'              => $teamId,
        ]);

        if ($pilotName) {
            Bateria01::where('name', $pilotName)->whereNull('user_id')->update(['user_id' => $user->id]);
        }

        return redirect()->route('admin.members.index')
            ->with('status', "Membro \"{$request->name}\" criado com sucesso.");
    }

    public function edit(User $user)
    {
        $teams = Auth::user()->isSuperAdmin() ? Team::orderBy('name')->get() : collect();
        return view('admin.members.edit', compact('user', 'teams'));
    }

    public function update(Request $request, User $user)
    {
        $isSuperAdmin = Auth::user()->isSuperAdmin();

        $request->validate([
            'name'       => 'required|string|max:50',
            'pilot_name' => 'nullable|string|max:50',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'is_admin'   => 'boolean',
            'password'   => 'nullable|string|min:8|confirmed',
            'team_id'    => $isSuperAdmin ? 'nullable|exists:teams,id' : '',
        ]);

        $data = [
            'name'       => $request->name,
            'pilot_name' => $request->filled('pilot_name') ? $request->pilot_name : null,
            'email'      => $request->email,
            'is_admin'   => $request->boolean('is_admin'),
        ];

        if ($isSuperAdmin) {
            $data['team_id'] = $request->team_id ?: null;
        }

        if ($request->filled('password')) {
            $data['password']             = Hash::make($request->password);
            $data['must_change_password'] = true;
        }

        $user->update($data);

        if ($request->filled('pilot_name')) {
            Bateria01::where('name', $request->pilot_name)->whereNull('user_id')->update(['user_id' => $user->id]);
        }

        return redirect()->route('admin.members.index')
            ->with('status', "Membro \"{$user->name}\" atualizado com sucesso.");
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors(['error' => 'Você não pode excluir sua própria conta.']);
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.members.index')
            ->with('status', "Membro \"{$name}\" excluído com sucesso.");
    }
}
