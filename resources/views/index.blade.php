<!DOCTYPE html>


@section('title', 'Amigos do Kart')
<head>
    <title>Resultados da Bateria 01</title>
    <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css"
>
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


    <h1>Ranking Geral</h1>
    <h3></h3>

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
</body>
</html>


