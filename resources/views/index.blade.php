<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Amigos do Kart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: rgb(129, 129, 129); }
        .team-card { margin: 1rem 0; padding: 1rem; border: 1px solid #ddd; border-radius: 8px; }
        .team-card a { text-decoration: none; font-weight: bold; font-size: 1.1rem; }
    </style>
</head>
<body>
<main class="container">

@if(isset($team) && $team)
    {{-- Ranking de uma equipe específica --}}
    <h1>{{ $team->name }}</h1>
    <p><a href="/">← Todas as equipes</a></p>

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
            <tr><td colspan="4" style="color:#999">Nenhum resultado ainda.</td></tr>
            @endforelse
        </tbody>
    </table>

@elseif(isset($teams) && $teams->isNotEmpty())
    {{-- Lista de equipes --}}
    <h1>Amigos do Kart</h1>
    <h3>Selecione uma equipe para ver o ranking:</h3>

    @foreach($teams as $team)
    <div class="team-card">
        <a href="{{ route('ranking.public', $team->slug) }}">{{ $team->name }}</a>
    </div>
    @endforeach

@else
    <h1>Amigos do Kart</h1>
    <p>Nenhuma equipe cadastrada ainda.</p>
@endif

</main>
</body>
</html>
