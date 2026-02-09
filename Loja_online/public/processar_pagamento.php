<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['carrinho'])) {
    header("Location: carrinho.php");
    exit;
}

$metodo = $_POST['metodo'] ?? null;
$user_id = $_SESSION['user_id'];

if (!$metodo) {
    die("Método inválido");
}

// Simulação de pagamento aprovado
$status_pagamento = "pago";

// Calcular total
$total = 0;
foreach ($_SESSION['carrinho'] as $item) {
    $total += $item['preco'] * $item['quantidade'];
}

try {
    $pdo->beginTransaction();

    // Criar pedido
    $stmt = $pdo->prepare("
        INSERT INTO pedidos (user_id, total, status, metodo_pagamento)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$user_id, $total, $status_pagamento, $metodo]);

    $pedido_id = $pdo->lastInsertId();

    // Itens do pedido
    $stmtItem = $pdo->prepare("
        INSERT INTO pedido_itens (pedido_id, produto_id, quantidade, preco)
        VALUES (?, ?, ?, ?)
    ");

    foreach ($_SESSION['carrinho'] as $id => $item) {
        $stmtItem->execute([
            $pedido_id,
            $id,
            $item['quantidade'],
            $item['preco']
        ]);
    }

    $pdo->commit();

    unset($_SESSION['carrinho']);

    header("Location: sucesso.php");
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    die("Erro no pagamento: " . $e->getMessage());
}
