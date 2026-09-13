<x-app-layout>
    <head>
        <style>
            table { width: 100%; border-collapse: collapse; color: blanchedalmond; }
            th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; color: aliceblue; }
            th { background-color: rgb(129, 129, 129); color: #ddd; }
        </style>
    </head>

    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Ranking — {{ $team?->name ?? 'Selecione uma equipe' }}
            </h2>
            @auth
            @if(Auth::user()->isAdmin())
            <div class="flex gap-2">
                <form action="{{ route('ranking.update') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="px-3 py-1 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-md shadow transition">
                        Atualizar Ranking
                    </button>
                </form>
                <form action="{{ route('ranking.destroy') }}" method="POST"
                      onsubmit="return confirm('Limpar o ranking desta equipe?')">
                    @csrf
                    <button type="submit"
                            class="px-3 py-1 text-sm bg-red-600 hover:bg-red-700 text-white rounded-md shadow transition">
                        Limpar Ranking
                    </button>
                </form>
            </div>
            @endif
            @endauth
        </div>
    </x-slot>

    @if(Auth::user()->isSuperAdmin())
    <div style="padding: 1rem; color:#ddd;">
        <strong>Super Admin:</strong>
        Visualizando equipe:
        @if($team)
            <strong>{{ $team->name }}</strong>
            — <a href="{{ route('admin.teams.index') }}" style="color:#93c5fd">ver todas as equipes</a>
        @else
            <em>nenhuma selecionada</em>
            — <a href="{{ route('admin.teams.index') }}" style="color:#93c5fd">gerenciar equipes</a>
        @endif
    </div>
    @endif

    <h1 style="color:#ddd">Campeonato {{ $team?->name }}</h1>

    <table>
        <thead>
            <tr>
                <th>POS</th>
                <th>Pontos</th>
                <th>Nome</th>
                <th>TMV</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rankings as $ranking)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $ranking->pontos }}</td>
                <td>{{ $ranking->name }}</td>
                <td>{{ $ranking->TMV }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="color:#999">Nenhum resultado para esta equipe.</td></tr>
            @endforelse
        </tbody>
    </table>
</x-app-layout>
