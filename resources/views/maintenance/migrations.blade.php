<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Migraciones de base de datos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/welcome.css')
    <style>
        .migration-card {
            max-width: 800px;
            margin: 0 auto;
        }

        .migration-card h3 {
            margin-bottom: 0.75rem;
            color: var(--sf-blue-deep);
            font-size: 1.3rem;
            font-weight: 700;
        }

        .migration-card p {
            margin-bottom: 1.5rem;
            color: var(--sf-text-muted);
        }

        .migration-status {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem 1.25rem;
            border: 1px solid;
            border-radius: 8px;
            font-weight: 600;
        }

        .migration-status.success {
            border-color: #a7d8b2;
            background: #f0faf2;
            color: #176b2c;
        }

        .migration-status.failure {
            border-color: #f1b8b8;
            background: #fff5f5;
            color: #a12626;
        }

        .migration-output {
            overflow-x: auto;
            margin-top: 1.25rem;
            padding: 1.25rem;
            border-radius: 8px;
            background: var(--sf-blue-deep);
            color: var(--sf-white);
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.9rem;
            line-height: 1.6;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        .migration-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        @media (max-width: 640px) {
            .migration-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="hero-wrapper">
        <section class="hero">
            <h1>Migraciones de <span>base de datos</span></h1>
            <p>Administra las migraciones pendientes del entorno de producción.</p>
        </section>
    </div>

    <main>
        <section aria-labelledby="migration-heading">
            <div class="section-header">
                <h2 id="migration-heading">
                    @isset($exitCode)
                        Resultado de la ejecución
                    @else
                        Ejecutar migraciones
                    @endisset
                </h2>
                <p>Las migraciones modifican el esquema de la base de datos.</p>
            </div>

            <div class="project-card migration-card">
                @isset($exitCode)
                    @if ($exitCode === 0)
                        <div class="migration-status success" role="status">
                            <span aria-hidden="true">✓</span>
                            <span>El comando de migraciones terminó correctamente.</span>
                        </div>
                    @else
                        <div class="migration-status failure" role="alert">
                            <span aria-hidden="true">!</span>
                            <span>El comando de migraciones terminó con errores. Revisa la salida antes de volver a intentarlo.</span>
                        </div>
                    @endif

                    <pre class="migration-output">{{ $output !== '' ? $output : 'El comando no produjo salida.' }}</pre>
                @else
                    <h3>Confirma antes de continuar</h3>
                    <p>Esta acción ejecutará todas las migraciones pendientes en la base de datos de producción.</p>

                    <div class="migration-actions">
                        <form method="post" action="{{ route('maintenance.migrations.run', ['code' => $code]) }}">
                            @csrf
                            <button type="submit" class="btn-sf primary">Ejecutar migraciones pendientes</button>
                        </form>
                    </div>
                @endisset
            </div>
        </section>
    </main>
</body>
</html>
