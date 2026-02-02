<?php
session_start();
require "../app/config/database.php";

if (!isset($_SESSION['user']) || empty($_SESSION['carrinho'])) {
    header("Location: index.php");
    exit;
}

if ($metodo === 'multicaixa') {
    $entidade = "12345";
    $referencia = rand(100000000, 999999999);
} else {
    $entidade = null;
    $referencia = null;
}

$stmt = $pdo->prepare(
    "INSERT INTO pedidos (user_id, metodo_pagamento, entidade, referencia, status)
     VALUES (?, ?, ?, ?, 'pendente')"
);
$stmt->execute([$user_id, $metodo, $entidade, $referencia]);

$user_id = $_SESSION['user']['id'];
$metodo = $_POST['pagamento'];
$total = 0;

/* Criar pedido */
$stmt = $pdo->prepare(
    "INSERT INTO pedidos (user_id, metodo_pagamento, status) VALUES (?, ?, 'pendente')"
);
$stmt->execute([$user_id, $metodo]);
$pedido_id = $pdo->lastInsertId();

/* Inserir itens */
foreach ($_SESSION['carrinho'] as $id => $qtd) {
    $p = $pdo->prepare("SELECT preco FROM produtos WHERE id=?");
    $p->execute([$id]);
    $produto = $p->fetch();

    if (!$produto) continue;

    $subtotal = $produto['preco'] * $qtd;
    $total += $subtotal;

    $stmt = $pdo->prepare(
        "INSERT INTO pedido_itens (pedido_id, produto_id, quantidade, preco)
         VALUES (?, ?, ?, ?)"
    );
    $stmt->execute([$pedido_id, $id, $qtd, $produto['preco']]);
}

/* Atualiza total */
$pdo->prepare(
    "UPDATE pedidos SET total=? WHERE id=?"
)->execute([$total, $pedido_id]);

/* Limpa carrinho */
unset($_SESSION['carrinho']);

header("Location: perfil.php");
exit;


