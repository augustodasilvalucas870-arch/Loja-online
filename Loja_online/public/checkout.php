<?php
session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['redirect_after_login'] = 'checkout.php';
    header("Location: login.php");
    exit;
    require_once "../app/helpers/auth.php";

}

if (empty($_SESSION['carrinho'])) {
    die("Carrinho vazio");
}

$total = $_POST['total'];
$metodo = $_POST['metodo'];

$pdo->beginTransaction();

$stmt = $pdo->prepare("
    INSERT INTO pedidos (user_id, total, metodo_pagamento)
    VALUES (?, ?, ?)
");
$stmt->execute([$_SESSION['user_id'], $total, $metodo]);

$pedido_id = $pdo->lastInsertId();


foreach ($_SESSION['carrinho'] as $produto_id => $qtd) {

    $p = $pdo->prepare("SELECT preco FROM produtos WHERE id = ?");
    $p->execute([$produto_id]);
    $produto = $p->fetch();

    $stmt = $pdo->prepare("
        INSERT INTO pedido_itens (pedido_id, produto_id, quantidade, preco)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$pedido_id, $produto_id, $qtd, $produto['preco']]);
}

$pdo->commit();

$_SESSION['pedido_id'] = $pedido_id;

if ($metodo === 'paypal') {
    header("Location: paypal.php");
} else {
    header("Location: multicaixa.php");
}
exit;



