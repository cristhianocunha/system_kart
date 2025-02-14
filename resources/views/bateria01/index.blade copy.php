@extends('layouts.app')

@section('title', 'Minha Página')
<head>
    <title>Resultados da Bateria 01</title>
    
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color:rgb(129, 129, 129);
        }
        .nc {
            color: #999;
        }
    </style>
</head>


    <h1>Resultados da Bateria 03</h1>
    <h3>Data: 11/01/2025 19:33:40</h3>

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
                <td>{{ \Carbon\Carbon::parse($corredor->TMV)->format('H:i:s.v') }}</td>
                <td>{{ \Carbon\Carbon::parse($corredor->IT)->format('H:i:s.v') }}</td>
                <td>{{ \Carbon\Carbon::parse($corredor->DL)->format('H:i:s.v') }}</td>
                <td>{{ \Carbon\Carbon::parse($corredor->DA)->format('H:i:s.v') }}</td>
                <td>{{ \Carbon\Carbon::parse($corredor->TUV)->format('H:i:s.v') }}</td>
                <td>{{ $corredor->TV }}</td>
                <td>{{ number_format($corredor->VM, 5, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

