<?php
session_start();
require "../app/config/database.php";


if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
    header("Location: ../public/login.php");
    exit;
}

/* Apagar produto */
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM produtos WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: produtos.php");
    exit;
}

/* Listar produtos */
$produtos = $pdo->query("SELECT * FROM produtos")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Produtos</title>
<link rel="stylesheet" href="../public/assets/css/style.css">
<link rel="stylesheet" href="css/admin.css">

</head>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Admin - Produtos</title>
<link rel="stylesheet" href="../public/assets/css/admin.css">
</head>
<body>

<div class="admin-container">

    <aside class="sidebar">
        <h2>Painel Admin</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="produtos.php" class="active">Produtos</a>
        <a href="pedidos.php">Pedidos</a>
        <a href="../public/index.php">Voltar à Loja</a>
    </aside>

    <main class="content">
        <div class="content-header">
            <h1>Gestão de Produtos</h1>
            <a href="produto_novo.php" class="btn-primary">+ Novo Produto</a>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['nome']) ?></td>
                    <td><?= number_format($p['preco'], 0, ',', '.') ?> Kz</td>
                    <td class="actions">
                        <a href="produto_editar.php?id=<?= $p['id'] ?>" class="btn-edit">✏️</a>
                        <a href="produto_apagar.php?id=<?= $p['id'] ?>" class="btn-delete"
                           onclick="return confirm('Deseja apagar este produto?')">🗑️</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

</div>
<a href="produto_apagar.php?id=<?= $p['id'] ?>"
   class="btn btn-danger"
   onclick="return confirm('Deseja realmente eliminar este produto?')">
   
</a>

</body>
</html>
