<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include "config.php";

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // BUSCA USUÁRIO
    $sql = "SELECT * FROM usuarios WHERE email = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro SQL: " . $conn->error);
    }

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    // VERIFICA SE EXISTE
    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        // VERIFICA SENHA
        if (password_verify($senha, $user['senha'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nome'] = $user['nome'];

            header("Location: index.php");
            exit;

        } else {

            $erro = "Senha incorreta!";
        }

    } else {

        $erro = "Usuário não encontrado!";
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
        <?php if($erro != "") : ?>

            <p class="erro">

                <?php echo $erro; ?>

            </p>

        <?php endif; ?>

        <!-- FORM -->
        <form method="POST">

            <!-- EMAIL -->
            <div class="input-group">

                <input 
                    type="email"
                    name="email"
                    placeholder="Usuário"
                    required
                >

                <span>👤</span>

            </div>

            <!-- SENHA -->
            <div class="input-group">

                <input 
                    type="password"
                    name="senha"
                    placeholder="Senha"
                    required
                >

                <span>👁</span>

            </div>

            <!-- BOTÃO -->
            <button type="submit" class="btn-login">

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