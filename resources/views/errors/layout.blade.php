<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Erreur') — CKF Motors</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Montserrat', -apple-system, sans-serif;
            background: #0a0a0a;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            overflow: hidden;
        }

        /* Fond subtil animé */
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(ellipse at center, rgba(196,163,90,0.03) 0%, transparent 70%);
            animation: pulse 8s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.1); }
        }

        .error-container {
            position: relative;
            z-index: 1;
            max-width: 600px;
            width: 100%;
        }

        .brand {
            font-size: 0.875rem;
            font-weight: 700;
            letter-spacing: 0.3em;
            color: #c4a35a;
            text-transform: uppercase;
            margin-bottom: 3rem;
        }

        .error-code {
            font-size: clamp(6rem, 15vw, 10rem);
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #c4a35a 0%, #e8d5a3 50%, #c4a35a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
        }

        .error-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 1rem;
        }

        .error-message {
            font-size: 1rem;
            font-weight: 300;
            color: #888888;
            line-height: 1.7;
            margin-bottom: 3rem;
        }

        .actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #c4a35a, #d4b96a);
            color: #0a0a0a;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #d4b96a, #e4c97a);
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(196,163,90,0.3);
        }

        .btn-secondary {
            background: transparent;
            color: #888888;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .btn-secondary:hover {
            color: #ffffff;
            border-color: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        .separator {
            width: 60px;
            height: 1px;
            background: linear-gradient(90deg, transparent, #c4a35a, transparent);
            margin: 0 auto 2rem;
        }

        .footer-text {
            position: fixed;
            bottom: 2rem;
            font-size: 0.75rem;
            color: #444;
            letter-spacing: 0.1em;
        }

        @media (max-width: 640px) {
            .actions { flex-direction: column; }
            .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="brand">CKF Motors</div>

        <div class="error-code">@yield('code')</div>

        <div class="separator"></div>

        <h1 class="error-title">@yield('title')</h1>

        <p class="error-message">@yield('description')</p>

        <div class="actions">
            @yield('actions')
        </div>
    </div>

    <div class="footer-text">
        CKF MOTORS — Location Premium — Abidjan
    </div>
</body>
</html>
