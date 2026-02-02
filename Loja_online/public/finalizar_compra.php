<?php
require_once "../config/database.php";
require_once "../auth.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Verificar carrinho
if (empty($_SESSION['carrinho'])) {
    header("Location: carrinho.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$total = 0;

// Calcular total
foreach ($_SESSION['carrinho'] as $item) {
    $total += $item['preco'] * $item['quantidade'];
}

try {
    $pdo->beginTransaction();

    // Criar pedido
    $stmt = $pdo->prepare("
        INSERT INTO pedidos (user_id, total, status)
        VALUES (?, ?, 'pendente')
    ");
    $stmt->execute([$user_id, $total]);

    $pedido_id = $pdo->lastInsertId();

    // Inserir itens
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

    // Limpar carrinho
    unset($_SESSION['carrinho']);

    header("Location: sucesso.php");
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Erro ao finalizar compra: " . $e->getMessage();
}
