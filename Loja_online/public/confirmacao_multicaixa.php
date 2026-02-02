<?php
session_start();
require "../app/config/database.php";

$id = $_GET['pedido'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM pedidos WHERE id=?");
$stmt->execute([$id]);
$pedido = $stmt->fetch();

if (!$pedido) {
    echo "Pedido não encontrado";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Pagamento Multicaixa</title>
<link rel="stylesheet" href="/Loja_online/public/assets/css/style.css">
</head>
<body>

<div class="carrinho-container">
    <h2>Pagamento Multicaixa Express</h2>

    <p><strong>Entidade:</strong> <?= $pedido['entidade'] ?></p>
    <p><strong>Referência:</strong> <?= $pedido['referencia'] ?></p>
    <p><strong>Valor:</strong> <?= number_format($pedido['total'],0,',','.') ?> Kz</p>

    <p style="margin-top:20px;">
        Dirija-se a um terminal Multicaixa ou app bancária para efetuar o pagamento.
    </p>
</div>

</body>
</html>
