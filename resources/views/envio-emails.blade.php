<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Envío de emails</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/welcome.css')
    <style>
        .email-send-card {
            max-width: 720px;
            margin: 0 auto;
        }

        .email-send-card h3 {
            margin-bottom: 0.75rem;
            color: var(--sf-blue-deep);
            font-size: 1.3rem;
            font-weight: 700;
        }

        .email-send-card > p {
            margin-bottom: 1.5rem;
            color: var(--sf-text-muted);
        }

        .email-send-form {
            display: grid;
            gap: 0.75rem;
        }

        .email-send-form label {
            color: var(--sf-text-dark);
            font-weight: 600;
        }

        .email-send-form input,
        .email-send-form select {
            width: 100%;
            min-height: 3rem;
            padding: 0.65rem 0.8rem;
            border: 1px solid var(--sf-border);
            border-radius: 4px;
            color: var(--sf-text-dark);
            font: inherit;
        }

        .email-send-form input:focus,
        .email-send-form select:focus {
            border-color: var(--sf-blue-primary);
            outline: 2px solid rgba(1, 118, 211, 0.2);
        }

        .email-send-form input[aria-invalid="true"],
        .email-send-form select[aria-invalid="true"] {
            border-color: #a12626;
        }

        .email-send-error {
            color: #a12626;
        }

        .email-send-status {
            margin-bottom: 1.25rem;
            padding: 0.9rem 1rem;
            border: 1px solid;
            border-radius: 4px;
            font-weight: 600;
        }

        .email-send-status.success {
            border-color: #a7d8b2;
            background: #f0faf2;
            color: #176b2c;
        }

        .email-send-status.error {
            border-color: #f1b8b8;
            background: #fff5f5;
            color: #a12626;
        }

        .email-send-form .btn-sf {
            justify-self: start;
            border: 0;
        }

        @media (max-width: 640px) {
            .email-send-card {
                padding: 1.5rem;
            }

            .email-send-form .btn-sf {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="hero-wrapper">
        <section class="hero">
            <h1>Envío de <span>emails</span></h1>
            <p>Selecciona el tipo de email y la dirección a la que quieres enviarlo.</p>
        </section>
    </div>

    <main>
        <section aria-labelledby="email-send-heading">
            <div class="section-header">
                <h2 id="email-send-heading">Enviar email</h2>
                <p>Selecciona el tipo de email e introduce el correo del destinatario.</p>
            </div>

            <div class="project-card email-send-card">
                @if (session('status'))
                    <div class="email-send-status success" role="status">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="email-send-status error" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Datos del envío</h3>
                <p>Solo se puede enviar un email a cada dirección, independientemente del tipo.</p>

                <form
                    class="email-send-form"
                    method="post"
                    action="{{ route('envio-emails.send', ['code' => $code]) }}"
                >
                    @csrf
                    <label for="email_type">Tipo de email</label>
                    <select
                        id="email_type"
                        name="email_type"
                        required
                        aria-invalid="{{ $errors->has('email_type') ? 'true' : 'false' }}"
                        @error('email_type') aria-describedby="email-type-error" @enderror
                    >
                        <option value="">Selecciona un tipo de email</option>
                        @foreach ($emailTypes as $value => $label)
                            <option value="{{ $value }}" @selected(old('email_type') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('email_type')
                        <p id="email-type-error" class="email-send-error" role="alert">{{ $message }}</p>
                    @enderror

                    <label for="email">Correo electrónico</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        maxlength="255"
                        autocomplete="email"
                        required
                        aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                        @error('email') aria-describedby="email-error" @enderror
                    >
                    @error('email')
                        <p id="email-error" class="email-send-error" role="alert">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="btn-sf primary">Enviar email</button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
