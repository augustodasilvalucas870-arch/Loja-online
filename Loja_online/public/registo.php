<?php
session_start();
require "../app/config/database.php";

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare(
            "INSERT INTO users (nome, email, password) VALUES (?, ?, ?)"
        );
        $stmt->execute([$nome, $email, $senha]);

        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        $erro = "Email já registado";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Registo</title>
<link rel="stylesheet" href="/Loja_online/public/assets/css/style.css">
</head>
<body class="auth-body">

<div class="auth-container">
    <h2>Criar conta</h2>

    <?php if ($erro): ?>
        <p class="auth-error"><?= $erro ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="nome" placeholder="Nome completo" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Palavra-passe" required>
        <button class="btn-primary full">Registar</button>
    </form>

    <p>Já tem conta? <a href="login.php">Entrar</a></p>
</div>

</body>
</html>
