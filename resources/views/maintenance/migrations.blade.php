<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Migraciones de base de datos</title>
</head>
<body>
    <main>
        <h1>Migraciones de base de datos</h1>

        @isset($exitCode)
            @if ($exitCode === 0)
                <p>El comando de migraciones terminó correctamente.</p>
            @else
                <p>El comando de migraciones terminó con errores. Revisa la salida antes de volver a intentarlo.</p>
            @endif

            <pre>{{ $output !== '' ? $output : 'El comando no produjo salida.' }}</pre>
        @else
            <p>Esta acción ejecutará todas las migraciones pendientes en la base de datos de producción.</p>
            <form method="post" action="{{ route('maintenance.migrations.run', ['code' => $code]) }}">
                <button type="submit">Ejecutar migraciones pendientes</button>
            </form>
        @endisset
    </main>
</body>
</html>
