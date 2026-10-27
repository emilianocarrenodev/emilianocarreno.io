<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Emails enviados</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/welcome.css')
    <style>
        .email-list-card {
            overflow: hidden;
            padding: 0;
        }

        .email-table-scroll {
            overflow-x: auto;
        }

        .email-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            white-space: nowrap;
        }

        .email-table th,
        .email-table td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--sf-border);
        }

        .email-table th {
            background: var(--sf-cloud-bg);
            color: var(--sf-blue-deep);
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.04rem;
            text-transform: uppercase;
        }

        .email-table td {
            color: var(--sf-text-muted);
            font-size: 0.95rem;
        }

        .email-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .email-table tbody tr:hover {
            background: #f8fbff;
        }

        .email-table .email-address {
            color: var(--sf-blue-primary);
            font-weight: 600;
        }

        .email-list-footer {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-top: 1.5rem;
            color: var(--sf-text-muted);
            font-size: 0.9rem;
        }

        .email-pagination {
            display: flex;
            gap: 0.5rem;
        }

        .email-pagination a {
            padding: 0.55rem 1rem;
            border: 1px solid var(--sf-border);
            border-radius: 4px;
            color: var(--sf-blue-primary);
            font-weight: 700;
            text-decoration: none;
        }

        .email-pagination a:hover {
            border-color: var(--sf-blue-primary);
            background: var(--sf-blue-primary);
            color: var(--sf-white);
        }

        @media (max-width: 640px) {
            .email-table th,
            .email-table td {
                padding: 0.85rem 1rem;
            }

            .email-list-footer {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="hero-wrapper">
        <section class="hero">
            <h1>Emails <span>enviados</span></h1>
            <p>Consulta los envíos y su actividad de apertura.</p>
        </section>
    </div>

    <main>
        <section aria-labelledby="email-list-heading">
            <div class="section-header">
                <h2 id="email-list-heading">Registro de emails</h2>
                <p>Listado de destinatarios, canales y fechas de apertura.</p>
            </div>

            <div class="project-card email-list-card">
                <div class="email-table-scroll">
                    <table class="email-table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Email</th>
                                <th scope="col">Creado</th>
                                <th scope="col">Actualizado</th>
                                <th scope="col">Canal</th>
                                <th scope="col">Abierto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sentEmails as $sentEmail)
                                <tr>
                                    <td>{{ $sentEmail->id }}</td>
                                    <td class="email-address">{{ $sentEmail->email }}</td>
                                    <td>{{ $sentEmail->created_at }}</td>
                                    <td>{{ $sentEmail->updated_at }}</td>
                                    <td>{{ $sentEmail->channel ?? '—' }}</td>
                                    <td>{{ $sentEmail->opened_at ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No hay emails enviados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="email-list-footer">
                    <span>
                        @if ($sentEmails->total() > 0)
                            Mostrando {{ $sentEmails->firstItem() }}–{{ $sentEmails->lastItem() }}
                            de {{ $sentEmails->total() }} emails
                        @else
                            No hay resultados para mostrar.
                        @endif
                    </span>
                    <nav class="email-pagination" aria-label="Paginación">
                        @if ($sentEmails->previousPageUrl())
                            <a href="{{ $sentEmails->previousPageUrl() }}" rel="prev">Anterior</a>
                        @endif
                        @if ($sentEmails->nextPageUrl())
                            <a href="{{ $sentEmails->nextPageUrl() }}" rel="next">Siguiente</a>
                        @endif
                    </nav>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
