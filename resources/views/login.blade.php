<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BORALAJEAR! | Login</title>
    <!-- Favicons -->
    <link href="{{ asset('img/elemento.ico') }}" rel="icon">
    <link href="{{ asset('img/elemento.ico') }}" rel="apple-touch-icon">
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2bab3c;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .input-group {
            margin-bottom: 10px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            padding: 10px;
            background-color: #048f2a;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 30px;
        }

        button:hover {
            background-color: #2bab3c;
        }

        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 3px;
            width: 100%;
            /* Garante que o alerta ocupe toda a largura do container */
            text-align: center;
            /* Centraliza o texto dentro do alerta */
        }
    </style>
</head>

<body>

    <div class="login-container">
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
        <form action="{{ url('/admin/autenticar') }}" method="post">
            @csrf
            <h2>Login</h2>
            <div class="input-group">
                <label for="username">Usuário</label>
                <input type="text" id="username" name="usuario" placeholder="Seu usuário" required
                    value="{{ old('usuario') }}">
            </div>
            <div class="input-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="senha" placeholder="Sua senha" required>
            </div>
            <button class="mb-4" type="submit">Entrar</button>
            <a href="{{ url('/') }}" class="btn btn-link">
                <i class="bi bi-arrow-left"></i> Voltar para página
            </a>
        </form>
    </div>
</body>

</html>