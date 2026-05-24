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
        $_SESSION['nome'] = $user['nome'];
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
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<div class="login-container">
    <div class="login-box">
        <!-- LOGO -->
        <div class="llogo">
            <div class="llogo-circulo">
                <!-- Troque pela sua imagem -->
                <img src="images/loginimg.png" alt="Logo">
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
                    id="senha"
                    name="senha"
                    placeholder="Senha"
                    required>
                <span id="toggleSenha">👁</span>
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
        <a href="redefinir_senha.php">
        <p class="senha">
            Esqueci a senha.
        </p>
        </a>
    </div>
</div>

<script>

const senha = document.getElementById("senha");
const toggle = document.getElementById("toggleSenha");

toggle.addEventListener("click", function(){

    if(senha.type === "password"){
        senha.type = "text";
        toggle.innerHTML = "🙈";
    } else {
        senha.type = "password";
        toggle.innerHTML = "👁";
    }

});
</script>

</body>
</html>
