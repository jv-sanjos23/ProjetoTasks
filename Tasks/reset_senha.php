<?php
include "config.php";

$token = $_GET['token'] ?? null;

if(!$token){
    die("Token inválido ou não informado.");
}

$sql = "SELECT * FROM usuarios 
        WHERE reset_token = ? 
        AND token_expira > NOW()
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0){
    die("Token inválido ou expirado.");
}

$user = $result->fetch_assoc();
?>

<h2>Redefinir Senha</h2>

<form method="POST" action="salvar_nova_senha.php">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
    <input type="password" name="senha" required>
    <button>Salvar</button>
</form>