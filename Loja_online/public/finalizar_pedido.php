<?php
session_start();
require "../app/config/database.php";
require "../app/helpers/auth.php";

$carrinho = $_SESSION['carrinho'];
$total = 0;

foreach ($carrinho as $item) {
    $total += $item['preco'] * $item['qtd'];
}

$stmt = $pdo->prepare("INSERT INTO pedidos (user_id, total) VALUES (?, ?)");
$stmt->execute([$_SESSION['user']['id'], $total]);

$pedido_id = $pdo->lastInsertId();

$stmtItem = $pdo->prepare(
    "INSERT INTO pedido_itens (pedido_id, produto_nome, preco, quantidade)
     VALUES (?, ?, ?, ?)"
);

foreach ($carrinho as $item) {
    $stmtItem->execute([
        $pedido_id,
        $item['nome'],
        $item['preco'],
        $item['qtd']
    ]);
}

unset($_SESSION['carrinho']);

echo "Compra finalizada com sucesso!";
