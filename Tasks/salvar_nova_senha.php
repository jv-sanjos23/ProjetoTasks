<?php

include "config.php";

$token = $_POST['token'] ?? null;

if(!$token){
    die("Token inválido ou não informado.");
}

$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

/* valida token */
$sql = "SELECT * FROM usuarios
        WHERE reset_token = ?
        AND token_expira > NOW()
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();

$resultado = $stmt->get_result();

if($resultado->num_rows == 0){
    die("Token inválido ou expirado.");
}

$usuario = $resultado->fetch_assoc();

/* atualiza senha */
$sql = "UPDATE usuarios
        SET senha = ?,
            reset_token = NULL,
            token_expira = NULL
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $senha, $usuario['id']);

if($stmt->execute()){

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senha Alterada</title>

    <link rel="stylesheet" href="css/style.css">

    <style>

        .sucesso-body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:linear-gradient(#ff7a00 5%, #f3b37d 100%);
            padding:20px;
        }

        .sucesso-box{
            width:100%;
            max-width:420px;
            background:#fff;
            border-radius:25px;
            padding:40px 25px;
            text-align:center;
            box-shadow:0 6px 15px rgba(0,0,0,0.25);
        }

        .check{
            width:100px;
            height:100px;
            margin:0 auto 25px;
            border-radius:50%;
            background:#fff3e8;
            border:6px solid #ff7a00;
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:50px;
            color:#ff7a00;
            font-weight:bold;
        }

        .sucesso-box h1{
            color:#ff7a00;
            font-size:32px;
            margin-bottom:15px;
        }

        .sucesso-box p{
            color:#444;
            font-size:16px;
            line-height:1.5;
            margin-bottom:30px;
        }

        .btn-ir-login{
            width:100%;
            padding:14px;
            border:none;
            border-radius:20px;
            background:#ff8a2a;
            color:black;
            font-weight:bold;
            font-size:16px;
            text-decoration:none;
            display:block;
            box-shadow:0 4px 0 #8a4b1f;
            transition:0.2s;
        }

        .btn-ir-login:hover{
            transform:translateY(-2px);
        }

    </style>

</head>

<body class="sucesso-body">

    <div class="sucesso-box">

        <div class="check">
            ✓
        </div>

        <h1>Senha alterada!</h1>

        <p>
            Sua senha foi redefinida com sucesso.<br>
            Agora você já pode fazer login novamente.
        </p>

        <a href="login.php" class="btn-ir-login">
            Ir para login
        </a>

    </div>

</body>
</html>

<?php

}else{
    echo "Erro ao alterar senha.";
}

?>