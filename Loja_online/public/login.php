<?php
session_start();
require "../app/config/database.php";
$_SESSION['user_id'] = $usuario['id'];

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['password'])) {
    
        $_SESSION['user'] = [
    'id'    => $user['id'],
    'nome'  => $user['nome'],
    'email' => $user['email'],
    'tipo'  => $user['tipo']
    ];
         if ($user['tipo'] === 'admin') {
    header("Location: ../admin/dashboard.php");
} else {
    header("Location: index.php");
}
exit;

        if ($user['tipo'] === 'admin') {
    header("Location: ../admin/dashboard.php");
} else {
    header("Location: index.php");
}
exit;

    } else {
        $erro = "Email ou palavra-passe inválidos";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="/Loja_online/public/assets/css/style.css">
</head>
<body class="auth-body">

<div class="auth-container">
    <h2>Entrar</h2>

    <?php if ($erro): ?>
        <p class="auth-error"><?= $erro ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Palavra-passe" required>
        <button class="btn-primary full">Entrar</button>
    </form>

    <p>Não tem conta? <a href="registo.php">Criar conta</a></p>
</div>

</body>
</html>
