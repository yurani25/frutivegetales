<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Abastecimiento</title>
    <link rel="stylesheet" href="{{ asset('css/formularios1.css') }}">
</head>

<body>
    <div class="users-form">
        <form action="{{ route('abastecimientos.update', $abastecimiento->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')

            <h1>Editar Abastecimiento</h1>
            <input type="hidden" name="id" value="{{ $abastecimiento->id }}">

            <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="{{ $abastecimiento->nombre }}" autofocus>

            <input type="text" name="ubicacion" id="ubicacion" placeholder="Ubicación" value="{{ $abastecimiento->ubicacion }}" autofocus>

            <input type="text" name="horario_atencion" id="horario_atencion" placeholder="Horario de Atención"
                value="{{ $abastecimiento->horario_atencion }}" autofocus>

            {{-- Otros campos que puedas tener --}}
            <input type="submit" value="Actualizar formulario">
        </form>
    </div>
</body>

</html>
