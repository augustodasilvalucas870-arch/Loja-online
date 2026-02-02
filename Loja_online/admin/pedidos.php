<?php
session_start();
require "../app/config/database.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
    header("Location: ../public/login.php");
    exit;
}

$pedidos = $pdo->query("
    SELECT p.id, u.nome, p.total, p.status, p.criado_em
    FROM pedidos p
    JOIN users u ON u.id = p.user_id
    ORDER BY p.criado_em DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Pedidos</title>
<link rel="stylesheet" href="../public/assets/css/style.css">
<link rel="stylesheet" href="css/admin.css">
</head>
<body>

<h1>Pedidos</h1>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Cliente</th>
    <th>Total</th>
    <th>Estado</th>
    <th>Data</th>
</tr>

<?php foreach ($pedidos as $p): ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= htmlspecialchars($p['nome']) ?></td>
    <td><?= number_format($p['total'], 0, ',', '.') ?> Kz</td>
    <td><?= $p['status'] ?></td>
    <td><?= $p['criado_em'] ?></td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>


