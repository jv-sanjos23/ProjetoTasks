<?php
include "config.php";

if ($_POST) {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar = $_POST['confirmar'];

    if ($senha != $confirmar) {
        $erro = "As senhas não coincidem";

    } else {

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {

            $stmt->bind_param("sss", $nome, $email, $senhaHash);

            if ($stmt->execute()) {

    $usuario_id = $stmt->insert_id;

    $conn->query("
    INSERT INTO configuracoes (usuario_id)
    VALUES ($usuario_id)
    ");

    header("Location: login.php");
    exit;
} else {

                $erro = "Email já cadastrado";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastro</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="cadastro-body">
<div class="cadastro-box">
    <!-- LOGO -->
    <div class="logo">
        <div class="logo-circulo">
            <!-- troque pela sua imagem -->
            <img src="images/cadastroimg.png">
        </div>
    </div>
    <?php if(isset($erro)) : ?>
        <p class="erro"><?= $erro ?></p>
    <?php endif; ?>
    <form method="POST">
        <div class="input-group">
            <input type="email" name="email" placeholder="E-mail" required>
            <span>✉</span>
        </div>
        <div class="input-group">
            <input type="text" name="nome" placeholder="Usuário" required>
            <span>👤</span>
        </div>
        <div class="input-group">
            <input type="password" name="senha" placeholder="Senha" required>
            <span>👁</span>
        </div>
        <div class="input-group">
            <input type="password" name="confirmar" placeholder="Confirmar senha" required>
            <span>👁</span>
        </div>
        <button class="btn-cadastro">
            CADASTRAR
        </button>
    </form>
    <p class="login-link">
        Já tem uma conta?
        <a href="login.php">Faça o login.</a>
    </p>
</div>
</body>
</html>
