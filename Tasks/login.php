<?php

include "config.php";

if ($_POST) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user && password_verify($senha, $user['senha'])) {

        $_SESSION['user_id'] = $user['id'];

        header("Location: index.php");
        exit;

    } else {

        $erro = "Email ou senha inválidos";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="login-container">

    <div class="login-box">

        <!-- LOGO -->

        <div class="logo">

            <div class="logo-circulo">

                <img 
                    src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" 
                    alt="Logo"
                >

            </div>

        </div>

        <!-- ERRO -->

        <?php if(isset($erro)) : ?>

            <p class="erro"><?= $erro ?></p>

        <?php endif; ?>

        <!-- FORM -->

        <form method="POST">

            <div class="input-group">

                <input 
                    type="email" 
                    name="email" 
                    placeholder="Usuário"
                    required
                >

                <span>👤</span>

            </div>

            <div class="input-group">

                <input 
                    type="password" 
                    name="senha" 
                    placeholder="Senha"
                    required
                >

                <span>👁</span>

            </div>

            <button class="btn-login">

                ENTRAR

            </button>

        </form>

        <!-- LINKS -->

        <p class="cadastro">

            Não tem uma conta?

            <a href="register.php">

                Cadastre-se agora!

            </a>

        </p>

        <p class="senha">

            <a href="recuperar.php" class="link-senha">

                Esqueci minha senha

            </a>

        </p>

    </div>

</div>

</body>
</html>