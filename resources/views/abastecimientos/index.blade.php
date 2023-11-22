<!DOCTYPE html>
<html lang="en">
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
                <th>ID</th>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Horario de Atención</th>
                <th>Acciones</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach ($data as $abastecimiento)
            <tr>
                <td>{{$abastecimiento['id']}}</td>
                <td>{{$abastecimiento['nombre']}}</td>
                <td>{{$abastecimiento['ubicacion']}}</td>
                <td>{{$abastecimiento['horario_atencion']}}</td>
                <td>

                    <a class="delete-button" href="{{ route('abastecimientos.destroy', $abastecimiento['id']) }}">eliminar </a>
                    <a href="{{ route('abastecimientos.edit', $abastecimiento['id']) }}" class="edit-button">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a class="add-button" href="{{route('abastecimientos.create')}}">Agregar</a>
    <a class="add-button" href="{{route('index')}}">inicio</a>
</body>
</html>

