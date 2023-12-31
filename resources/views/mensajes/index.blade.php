<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/crud1.css') }}">
</head>
<body>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <table class="crud-table"> 
        <thead>
            <tr>
                <th>id</th>
                <th>user_id</th>
                <th>nombre_chat</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($data) && is_array($data))
                @foreach ($data as $mensaje)
                    <tr>
                        <td>{{ $mensaje['id'] }}</td>
                        <td>{{ $mensaje['user_id'] }}</td>
                        <td>{{ $mensaje['nombre_chat'] }}</td>
                        <td>
                            <a class="delete-button" href="{{ route('mensajes.destroy', $mensaje['id']) }}">eliminar</a>
                            <a href="{{ route('mensajes.edit', $mensaje['id']) }}" class="edit-button">Editar</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">No hay datos disponibles</td>
                </tr>
            @endif
        </tbody>
    </table>

    <a class="add-button" href="{{ route('mensajes.create') }}">Agregar</a>
    <a class="add-button" href="{{ route('index') }}">Inicio</a>
</body>
</html>
