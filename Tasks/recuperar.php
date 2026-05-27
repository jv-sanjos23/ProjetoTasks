<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>

    <link rel="stylesheet" href="css/style.css">

    <style>

        .recuperar-body{
            min-height:100vh;
            background:linear-gradient(#ff7a00 5%, #f3b37d 100%);
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
        }

        .recuperar-box{
            width:100%;
            max-width:420px;
            background:#ffffff;
            border-radius:25px;
            padding:35px 25px;
            box-shadow:0 6px 15px rgba(0,0,0,0.25);
        }

        .recuperar-box h1{
            color:#ff7a00;
            font-size:32px;
            text-align:center;
            margin-bottom:10px;
        }

        .recuperar-box p{
            text-align:center;
            color:#666;
            font-size:15px;
            margin-bottom:25px;
            line-height:1.5;
        }

        .input-group{
            position:relative;
            margin-bottom:20px;
        }

        .input-group input{
            width:100%;
            padding:14px 15px;
            border-radius:18px;
            border:2px solid #c46a2e;
            background:#e6d8c3;
            font-size:14px;
            outline:none;
        }

        .input-group input::placeholder{
            color:#a35a22;
        }

        .btn-recuperar{
            width:100%;
            padding:14px;
            border:none;
            border-radius:20px;
            background:#ff8a2a;
            color:black;
            font-weight:bold;
            font-size:16px;
            cursor:pointer;
            box-shadow:0 4px 0 #8a4b1f;
            transition:0.2s;
        }

        .btn-recuperar:hover{
            transform:translateY(-2px);
        }

        .voltar-login{
            text-align:center;
            margin-top:18px;
            font-size:14px;
        }

        .voltar-login a{
            color:black;
            text-decoration:none;
            font-weight:bold;
        }

    </style>

</head>

<body class="recuperar-body">

    <div class="recuperar-box">

        <h1>Recuperar senha</h1>

        <p>
            Digite seu email para receber o link de redefinição de senha.
        </p>

        <form action="enviar_redefinicao.php" method="POST">

            <div class="input-group">
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Digite seu email"
                    required
                >
            </div>

            <button type="submit" class="btn-recuperar">
                Enviar link
            </button>

        </form>

        <div class="voltar-login">
            <a href="login.php">
                Voltar para login
            </a>
        </div>

    </div>

</body>
</html>