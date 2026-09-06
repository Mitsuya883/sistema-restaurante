<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido al Equipo</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" style="padding: 40px 10px;">

                <table role="presentation" width="100%" style="max-width: 500px; background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e5e7eb;">

                    <tr>
                        <td align="center" style="background-color: #fff7ed; padding: 40px 30px; border-bottom: 2px solid #fed7aa;">
                            <img src="{{ $message->embed(public_path('images/logo.png')) }}" alt="Logo" style="height: 90px; width: auto; display: block; margin-bottom: 20px;">

                            <h1 style="color: #c2410c; margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">
                                ¡Bienvenido al Equipo!
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 30px;">
                            <p style="color: #4b5563; font-size: 16px; line-height: 1.6; margin-top: 0;">
                                Hola <strong style="color: #111827;">{{ $user->name }}</strong>,
                            </p>
                            <p style="color: #4b5563; font-size: 16px; line-height: 1.6;">
                                Nos alegra informarte que tu cuenta para acceder al <strong>Sistema del Restaurante</strong> ha sido creada exitosamente.
                            </p>

                            <table width="100%" style="background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <table width="100%">
                                            <tr>
                                                <td style="padding-bottom: 10px; border-bottom: 1px dashed #e5e7eb;">
                                                    <span style="font-size: 12px; font-weight: bold; text-transform: uppercase; color: #9ca3af;">Usuario / Correo</span><br>
                                                    <strong style="font-size: 16px; color: #374151;">{{ $user->email }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0; border-bottom: 1px dashed #e5e7eb;">
                                                    <span style="font-size: 12px; font-weight: bold; text-transform: uppercase; color: #9ca3af;">Contraseña Temporal</span><br>
                                                    <span style="display: inline-block; background-color: #ffffff; padding: 6px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-family: monospace; font-size: 18px; color: #ea580c; font-weight: bold; margin-top: 4px;">
                                                        {{ $password }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <div style="text-align: center;">
                                <a href="{{ route('login') }}" style="display: inline-block; background-color: #ea580c; color: #ffffff; padding: 14px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px; box-shadow: 0 4px 6px rgba(234, 88, 12, 0.25);">
                                    Acceder al Sistema
                                </a>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding: 20px; background-color: #f9fafb; border-top: 1px solid #e5e7eb; color: #9ca3af; font-size: 12px;">
                            <p style="margin: 0;">© {{ date('Y') }} El Soly. Todos los derechos reservados.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
