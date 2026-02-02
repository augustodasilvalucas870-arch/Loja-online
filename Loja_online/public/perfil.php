<?php
session_start();
require "../app/config/database.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

$stmt = $pdo->prepare(
    "SELECT * FROM pedidos WHERE user_id=? ORDER BY created_at DESC"
);
$stmt->execute([$user['id']]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Perfil</title>
<link rel="stylesheet" href="/Loja_online/public/assets/css/style.css">
</head>
<body>

<div class="carrinho-container">
    <h2>Meu Perfil</h2>

    <p><strong>Nome:</strong> <?= htmlspecialchars($user['nome']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>

    <hr><br>

    <h3>Meus pedidos</h3>

    <?php if (!$pedidos): ?>
        <p>Ainda não realizou pedidos.</p>
    <?php else: ?>
        <?php foreach ($pedidos as $p): ?>
            <div class="carrinho-item">
                <div></div>
                <div>Pedido #<?= $p['id'] ?></div>
                <div><?= strtoupper($p['metodo_pagamento']) ?></div>
                <div><?= number_format($p['total'], 0, ',', '.') ?> Kz</div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
