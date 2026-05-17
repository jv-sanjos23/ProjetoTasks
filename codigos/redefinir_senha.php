<?php

include("conexao.php");

$token = $_GET['token'];

$sql = "SELECT * FROM usuarios 
        WHERE reset_token = ?
        AND token_expira > NOW()";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();

$resultado = $stmt->get_result();

if($resultado->num_rows == 0){
    die("Token inválido ou expirado.");
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nova Senha</title>
</head>
<body>

<h2>Digite sua nova senha</h2>

<form action="salvar_nova_senha.php" method="POST">

    <input type="hidden" name="token" value="<?php echo $token; ?>">

    <input type="password" 
           name="nova_senha" 
           placeholder="Nova senha"
           required>

    <button type="submit">
        Salvar senha
    </button>

</form>

</body>
</html>
