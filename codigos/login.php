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
        $erro = "Login inválido";
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

    <!-- ILUSTRAÇÃO -->
    <div class="topo">
        <div class="circulo">
            <!-- você pode trocar por imagem -->
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="user">
        </div>
    </div>

    <!-- CARD LOGIN -->
    <div class="login-box">

        <?php if(isset($erro)) echo "<p class='erro'>$erro</p>"; ?>

        <form method="POST">

            <div class="input-group">
                <input type="email" name="email" placeholder="Usuário" required>
                <span>👤</span>
            </div>

            <div class="input-group">
                <input type="password" name="senha" placeholder="Senha" required>
                <span>👁</span>
            </div>

            <button class="btn-login">ENTRAR</button>

        </form>

        <p class="cadastro">
            Não tem uma conta? <a href="register.php">Cadastre-se agora!</a>
        </p>

        <p class="senha">Esqueci a senha.</p>

    </div>

</div>

</body>
</html>
