<!DOCTYPE html>
<html>
<head>
    <title>Correo de prueba</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            line-height: 1.6;
            color: #333;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .message {
            border-radius: 5px;
            padding: 20px;
            background-color: #f7f7f7;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .message-header {
            font-size: 20px;
            color: #555;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .message-body {
            font-size: 16px;
            color: #666;
        }
        .message-footer {
            font-size: 14px;
            color: #888;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="message">
        <div class="message-logo">
            <img src="https://laravel.com/img/logomark.min.svg" alt="Logo"/>
        </div>
        <div class="message-header">
            <h2>¡Hola!</h2>
            <p>Este es un correo de prueba</p>
        </div>
        <div class="message-body">
            <p>Gracias por usar nuestra aplicación.</p>
        </div>
        <div class="message-footer">
            <p>Este es un correo electrónico automatizado, por favor no respondas a este mensaje.</p>
        </div>
    </div>
</div>
</body>
</html>
