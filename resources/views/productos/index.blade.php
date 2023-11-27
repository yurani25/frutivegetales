<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/imagenproduc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/crud1.css') }}">
    <title>Document</title>
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
                <th>user_id</th>
                <th>nombre</th>
                <th>Tiempo de Reclamo</th>
                <th>Imagen</th> {{-- Descomentar esta línea --}}
                <th>Precio</th>
                <th>descripcion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $producto)
            <tr>
                <td>{{$producto['id'] }}</td>
                <td>{{$producto ['user_id']}}</td>
                <td>{{$producto['nombres']}}</td>
                <td>{{$producto['tiempo_reclamo']}}</td>
                <td>
                    @if ($producto['imagen'])
                        <img class="product-image" src="{{ $producto['imagen'] }}" alt="Imagen del producto">
                    @else
                        No hay imagen
                    @endif
                </td>
                <td>{{$producto['precio']}}</td>
                <td>{{$producto['descripcion']}}</td>
                <td>
                    <a class="delete-button" href="{{ route('productos.destroy', $producto['id']) }}">Eliminar </a>                                  
                    <a href="{{ route('productos.edit', $producto['id']) }}" class="edit-button">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a class="add-button" href="{{ route('productos.create') }}">Agregar</a>
    <a class="add-button" href="{{ route('index') }}">Inicio</a>
</div>

</body>
</html>
