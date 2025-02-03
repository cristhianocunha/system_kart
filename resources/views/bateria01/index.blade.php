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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Minha Página
        </h2>
    </x-slot>
    <h1 style=" color:#ddd">Resultados da Corrida {{ $corrida }} </h1>
    <h3 style=" color:#ddd">Data: {{ $data_corrida }} 19:33:40</h3>

    <table>
        <thead>
            <tr>    
                <th>POS</th>
                <th>Kart</th>
                <th>Nome</th>
                <th>MV</th>
                <th>TMV</th>
                <th>IT</th>
                <th>DL</th>
                <th>DA</th>
                <th>TUV</th>
                <th>TV</th>
                <th>VM (Km/h)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($corredores as $corredor)
            <tr class="{{ $corredor->POS === 'NC' ? 'nc' : '' }}">
                <td>{{ $corredor->POS }}</td>
                <td>{{ $corredor->Kart }}</td>
                <td>{{ $corredor->name }}</td>
                <td>{{ $corredor->MV }}</td>
                <td>{{ $corredor->TMV }}</td>
                <td>{{ $corredor->IT }}</td>
                <td>{{ $corredor->DL }}</td>
                <td>{{ $corredor->DA }}</td>
                <td>{{ $corredor->TUV }}</td>
                <td>{{ $corredor->TV }}</td>
                <td>{{ number_format($corredor->VM, 5, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>