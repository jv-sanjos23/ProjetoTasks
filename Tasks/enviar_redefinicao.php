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

/* gera token seguro */
$token = bin2hex(random_bytes(32));
$expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

/* salva no banco */
$stmt = $conn->prepare("
UPDATE usuarios 
SET reset_token = ?, token_expira = ?
WHERE id = ?
");

$stmt->bind_param("ssi", $token, $expira, $user['id']);
$stmt->execute();

/* garante URL correta */
$baseUrl = "http://localhost/Tasks/reset_senha.php";
$link = $baseUrl . "?token=" . $token;

/* saída mais segura */
echo "<h3>Link de recuperação gerado:</h3>";

echo "<p><a href='$link' target='_blank' style='color:blue; font-weight:bold; font-size:16px;'>
CLIQUE AQUI PARA REDEFINIR SUA SENHA
</a></p>";

echo "<p>Ou copie o link abaixo:</p>";

echo "<textarea style='width:100%; height:80px;'>$link</textarea>";

echo "<br><small>Token válido por 1 hora</small>";
?>