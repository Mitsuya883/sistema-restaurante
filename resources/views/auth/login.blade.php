<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torremolino's | Iniciar Sesión</title>
    <style>
        :root {
            --orange: #f7931e;
            --orange-dark: #e8720c;
            --panel-bg: rgba(27, 36, 54, 0.85);
            --input-bg: rgba(41, 52, 74, 0.8);
            --input-border: rgba(255, 255, 255, 0.1);
            --text-light: #f4f4f4;
            --text-muted: #9aa4b8;
            --text-faint: #6b7690;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #090d16;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1700px;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* SECCIÓN IZQUIERDA */
        .left {
            flex: 1.15;
            position: relative;
            background: linear-gradient(110deg, rgba(0,0,0,0.65) 20%, rgba(0,0,0,0.2) 80%), 
                        url('/images/Fondo-login.png') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 80px;
            color: #fff;
            clip-path: polygon(0 0, 96% 0, 100% 100%, 0% 100%);
            border-right: 2px solid var(--orange);
        }

        .content-box {
            width: 100%;
            max-width: 440px;
        }

        .logo-wrap {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .my-logo {
            max-width: 180px;
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 8px 20px rgba(0, 0, 0, 0.6));
            transition: transform 0.3s ease;
        }

        .my-logo:hover {
            transform: scale(1.03);
        }

        .welcome-title {
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 18px;
            border-left: 5px solid var(--orange);
            padding-left: 22px;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }

        .welcome-title .accent { 
            color: var(--orange); 
            display: block; 
            font-style: italic;
        }

        .subtitle { 
            font-size: 1.15rem; 
            color: #e8e8e8; 
            padding-left: 27px; 
            font-weight: 400; 
            letter-spacing: 0.3px;
        }

        /* SECCIÓN DERECHA */
        .right {
            flex: 1;
            background: #090d16;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
        }

        .form-card {
            width: 100%;
            max-width: 580px;
            background: var(--panel-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 24px;
            padding: 50px 56px 36px;
            border: 1px solid rgba(247, 147, 30, 0.25);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6), 
                        0 0 30px rgba(247, 147, 30, 0.08);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-card:hover {
            border-color: rgba(247, 147, 30, 0.4);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7), 
                        0 0 40px rgba(247, 147, 30, 0.15);
        }

        .field-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        .input-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 26px;
            transition: all 0.25s ease;
        }

        .input-wrap:focus-within {
            border-color: var(--orange);
            background: rgba(41, 52, 74, 1);
            box-shadow: 0 0 0 4px rgba(247, 147, 30, 0.18);
        }

        .input-wrap svg { 
            flex-shrink: 0; 
            width: 22px; 
            height: 22px; 
            color: var(--text-faint); 
            transition: color 0.25s ease;
        }

        .input-wrap:focus-within svg {
            color: var(--orange);
        }
        
        .input-wrap input {
            background: transparent;
            border: none;
            outline: none;
            color: var(--text-light);
            font-size: 1rem;
            width: 100%;
        }

        .input-wrap input::placeholder { color: var(--text-faint); }

        .btn-login {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: linear-gradient(90deg, var(--orange), var(--orange-dark));
            border: none;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 700;
            padding: 18px;
            border-radius: 14px;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0 8px 25px rgba(247, 147, 30, 0.35);
            transition: all 0.25s ease;
        }

        .btn-login:hover { 
            filter: brightness(1.12); 
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(247, 147, 30, 0.5);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login svg { width: 22px; height: 22px; }

        .divider { 
            border: none; 
            border-top: 1px solid rgba(255, 255, 255, 0.08); 
            margin: 32px 0 22px; 
        }

        .footer { 
            text-align: center; 
            color: var(--text-faint); 
            font-size: 0.85rem; 
        }

        @media (max-width: 900px) {
            .container { flex-direction: column; }
            .left { clip-path: none; border-right: none; border-bottom: 3px solid var(--orange); padding: 50px 30px; min-height: 40vh; }
            .welcome-title { font-size: 2.2rem; }
            .form-card { padding: 36px 24px; border-radius: 0; border: none; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="left">
        <div class="content-box">
            <div class="logo-wrap">
                <img src="/images/mi-logo.png" alt="Logo Restaurante" class="my-logo">
            </div>

            <div class="welcome-title">
                ¡Bienvenido de <span class="accent">nuevo!</span>
            </div>
            <p class="subtitle">Ingresa tus credenciales para acceder</p>
        </div>
    </div>

    <div class="right">
        <!-- SE AGREGÓ METHOD Y ACTION SIN CAMBIAR ESTILOS -->
        <form method="POST" action="{{ route('login') }}" class="form-card">
            @csrf

            <label class="field-label">CORREO ELECTRÓNICO</label>
            <div class="input-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 6 10-6"/></svg>
                <!-- SE AGREGÓ NAME="EMAIL" -->
                <input type="email" name="email" value="{{ old('email') }}" placeholder="tucorreo@ejemplo.com" required autofocus>
            </div>

            <label class="field-label">CONTRASEÑA</label>
            <div class="input-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 018 0v3"/></svg>
                <!-- SE AGREGÓ NAME="PASSWORD" -->
                <input type="password" name="password" placeholder="Tu contraseña" required>
            </div>

            <!-- SE CAMBIÓ A TYPE="SUBMIT" -->
            <button type="submit" class="btn-login">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M15 3H9a2 2 0 00-2 2v14a2 2 0 002 2h6"/><path d="M10 12h11m0 0l-4-4m4 4l-4 4"/></svg>
                Iniciar Sesión
            </button>

            <hr class="divider">

            <div class="footer">
                <div>© 2026 Sistema de Restaurante</div>
            </div>
        </form>
    </div>
</div>

</body>
</html>