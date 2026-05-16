<?php
include "config.php";

if ($_POST) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sss", $nome, $email, $senha);
        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $erro = "Erro ao cadastrar (email já pode existir)";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
</head>
<body>

<h2>Cadastro</h2>

<?php if(isset($erro)) echo "<p style='color:red'>$erro</p>"; ?>

<form method="POST">
    <input name="nome" placeholder="Nome" required><br><br>
    <input name="email" placeholder="Email" required><br><br>
    <input name="senha" type="password" placeholder="Senha" required><br><br>
    <button type="submit">Cadastrar</button>
</form>

<p>
    Já tem conta?
    <a href="login.php">Fazer login</a>
</p>

</body>
</html>
