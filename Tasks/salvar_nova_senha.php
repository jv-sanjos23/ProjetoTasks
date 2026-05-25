<?php

include "config.php";

$token = $_GET['token'] ?? null;

if(!$token){
    die("Token inválido ou não informado.");
}

$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

/* valida token */
$sql = "SELECT * FROM usuarios WHERE reset_token = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    die("Token inválido ou expirado.");
}

$usuario = $resultado->fetch_assoc();

/* atualiza senha */
$sql = "UPDATE usuarios
        SET senha = ?,
            reset_token = NULL,
            token_expira = NULL
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $senha, $usuario['id']);

if ($stmt->execute()) {
    echo "Senha alterada com sucesso!";
} else {
    echo "Erro ao alterar senha.";
}

?>