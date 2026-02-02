<?php
session_start();
require "../app/config/database.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
    header("Location: ../public/login.php");
    exit;
}

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
    die("Acesso negado.");
    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (nome, email, senha, tipo) VALUES (?, ?, ?, 'admin')");
    $stmt->execute([$nome, $email, $senha]);

    echo "Admin criado com sucesso!";
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Admin</title>
    <link rel="stylesheet" href="../public/assets/css/admin.css">
</head>
<body>

<div class="container">
    <h1>Criar novo administrador</h1>
<form method="POST">
    <input type="text" name="nome" placeholder="Nome" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="senha" placeholder="Senha" required><br>
    <button type="submit">Criar Admin</button>
   
</form>


</body>
</html>