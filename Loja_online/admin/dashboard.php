<?php
session_start();
require "../app/config/database.php";


if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
    $_SESSION['redirect_after_login'] = '../admin/dashboard.php';
    header("Location: ../public/login.php");
    exit;
}

/* Estatísticas */
$totalProdutos = $pdo->query("SELECT COUNT(*) FROM produtos")->fetchColumn();
$totalPedidos  = $pdo->query("SELECT COUNT(*) FROM pedidos")->fetchColumn();
$totalClientes = $pdo->query("SELECT COUNT(*) FROM users WHERE tipo='cliente'")->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>



<body class="admin-body">

<div class="admin-container">
    <h1>Painel Administrativo</h1>

    <div class="admin-cards">
        <div class="admin-card">
            <span>Produtos</span>
            <strong><?= $totalProdutos ?></strong>
        </div>

        <div class="admin-card">
            <span>Pedidos</span>
            <strong><?= $totalPedidos ?></strong>
        </div>

        <div class="admin-card">
            <span>Clientes</span>
            <strong><?= $totalClientes ?></strong>
        </div>
    </div>
      <a href="criar_admin.php">Criar novo admin</a>
    <nav>
        <a class="admin-btn btn-edit" href="produtos.php">Gerir Produtos</a>
        <a class="admin-btn btn-edit" href="pedidos.php">Ver Pedidos</a>
        <a class="admin-btn btn-back" href="../public/index.php">Voltar à loja</a>
    </nav>
    <a href="relatorio_vendas.php">📊 Relatório de Vendas</a>

</div>

</body>
</html>
