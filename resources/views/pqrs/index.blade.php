<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de PQRS</title>
    <link rel="stylesheet" href="{{ asset('css/crud1.css') }}">
</head>
<body>
  
    <table class="crud-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Tipo</th>
                <th>Motivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if (!is_null($data) && (is_array($data) || is_object($data)))
                @foreach ($data as $pqr)
                    <tr>
                        <td>{{$pqr['id']}}</td>
                        <td>{{$pqr['user_id']}}</td>
                        <td>{{$pqr['tipo']}}</td>
                        <td>{{$pqr['motivo']}}</td>

                        <td>
                            <a class="delete-button" href="{{ route('pqrs.destroy', $pqr['id']) }}">Eliminar </a>                                  
                            <a href="{{ route('pqrs.edit', $pqr['id']) }}" class="edit-button">Editar</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5">No hay datos disponibles</td>
                </tr>
            @endif
        </tbody>
    </table>

    <a class="add-button" href="{{route('pqrs.create')}}">Agregar</a>
    <a class="add-button" href="{{route('index')}}">Inicio</a>
</body>
</html>
