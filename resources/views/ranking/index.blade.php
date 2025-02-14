<x-app-layout>

    <head>
        <title>Corrida $corredor->corrida</title>

        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                color: blanchedalmond;
            }

            th,
            td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
                color: aliceblue;
            }

            th {
                background-color: rgb(129, 129, 129);
                color: #ddd;
            }

            .nc {
                color: #999;
            }
        </style>
    </head>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Ranking Geral
        </h2>
        @auth
        @if(Auth::user()->name === 'Cristhiano Cunha')
        <form action="{{ route('ranking.update') }}" method="POST">
            @csrf
            <button class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" type="submit">Atualizar o ranking</button>
            @else

            @endif
            @endauth


        </form>
    </x-slot>
    <h1 style=" color:#ddd">Resultados da Campeonato </h1>
    <h3 style=" color:#ddd"></h3>

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
            @foreach($rankings as $ranking)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $ranking->pontos }}</td>
                <td>{{ $ranking->name }}</td>
                <td>{{ $ranking->TMV }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>