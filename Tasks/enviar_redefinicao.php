<?php
include "config.php";

$email = $_POST['email'] ?? null;

if(!$email){
    die("Email não enviado.");
}

/* busca usuário */
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0){
    die("Email não encontrado.");
}

$user = $result->fetch_assoc();

/* gera token */
$token = bin2hex(random_bytes(32));
$expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

/* salva token */
$stmt = $conn->prepare("
UPDATE usuarios
SET reset_token = ?, token_expira = ?
WHERE id = ?
");

$stmt->bind_param("ssi", $token, $expira, $user['id']);
$stmt->execute();

/* link */
$baseUrl = "http://localhost/Tasks/reset_senha.php";
$link = $baseUrl . "?token=" . $token;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Gerado</title>

    <link rel="stylesheet" href="css/style.css">

    <style>

        .link-body{
            min-height:100vh;
            background:linear-gradient(#ff7a00 5%, #f3b37d 100%);
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
        }

        .link-box{
            width:100%;
            max-width:450px;
            background:white;
            border-radius:25px;
            padding:35px 25px;
            box-shadow:0 6px 15px rgba(0,0,0,0.25);
            text-align:center;
        }

        .link-box h1{
            color:#ff7a00;
            margin-bottom:15px;
            font-size:30px;
        }

        .link-box p{
            color:#555;
            font-size:15px;
            margin-bottom:20px;
            line-height:1.5;
        }

       .link-area{
    width:100%;
    min-height:120px;
    border:none;
    resize:none;
    border-radius:15px;
    padding:15px;
    background:#e6d8c3;
    border:2px solid #c46a2e;
    margin-bottom:20px;
    font-size:13px;

   
    overflow-wrap: break-word;
    word-break: break-all;
    white-space: pre-wrap;
    line-height:1.5;
    color:#5a2d0c;
}

        .btn-link{
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
            text-decoration:none;
            display:block;
            transition:0.2s;
        }

        .btn-link:hover{
            transform:translateY(-2px);
        }

        .tempo{
            margin-top:15px;
            font-size:13px;
            color:#777;
        }

    </style>

</head>

<body class="link-body">

    <div class="link-box">

        <h1>Link gerado!</h1>

        <p>
            Clique no botão abaixo ou copie o link para redefinir sua senha.
        </p>

        <textarea class="link-area" readonly><?= htmlspecialchars($link) ?></textarea>

        <a href="<?= $link ?>" target="_blank" class="btn-link">
            Redefinir senha
        </a>

        <div class="tempo">
            Token válido por 1 hora
        </div>

    </div>

</body>

</html>