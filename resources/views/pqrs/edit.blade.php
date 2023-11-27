<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/pqredit.css') }}">
</head>
<body>
    <div class="users-form">
        <form action="{{ route('pqrs.update', $pqr['id']) }}" method="post">
            @csrf
            @method('PUT') 
            <h3>Editar datos</h3>

            <label for="tipo">Tipo de PQRS:</label>
            <select id="tipo" name="tipo">
                <option value="peticion" {{ optional($pqr)['tipo'] == 'peticion' ? 'selected' : '' }}>Petición</option>
                <option value="queja" {{ optional($pqr)['tipo'] == 'queja' ? 'selected' : '' }}>Queja</option>
                <option value="reclamo" {{ optional($pqr)['tipo'] == 'reclamo' ? 'selected' : '' }}>Reclamo</option>
                <option value="sugerencia" {{ optional($pqr)['tipo'] == 'sugerencia' ? 'selected' : '' }}>Sugerencia</option>
            </select>

            <label for="mensaje">Mensaje:</label><br>
            <textarea id="mensaje" name="motivo" rows="4" cols="50" required>{{ optional($pqr)['motivo'] }}</textarea><br><br>

            <label for="usuario">Usuario:</label>
            <select name="user_id" id="user_id">
                @foreach ($users as $user)
                <option value="{{ $user['id'] }}" {{ $user_id == $user['id'] ? 'selected' : '' }}>
                    {{ $user['nombres'] }}
                </option>
                @endforeach
            </select>

            <input type="submit" value="Actualizar PQRS">
        </form>
    </div>
</body>
</html>
