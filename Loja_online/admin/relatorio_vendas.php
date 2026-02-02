<?php
session_start();
require "../app/config/database.php";

$totalVendas = $pdo->query(
    "SELECT COUNT(*) FROM pedidos"
)->fetchColumn();

$faturamento = $pdo->query(
    "SELECT SUM(total) FROM pedidos"
)->fetchColumn();

$pedidos = $pdo->query(
    "SELECT p.*, u.nome 
     FROM pedidos p
     JOIN users u ON u.id = p.user_id
     ORDER BY data_pedido DESC"
)->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Relatório de Vendas</h1>

<p>Total de pedidos: <strong><?= $totalVendas ?></strong></p>
<p>Faturamento total: <strong><?= number_format($faturamento, 0, ',', '.') ?> Kz</strong></p>

<table border="1" cellpadding="10">
<tr>
    <th>Cliente</th>
    <th>Total</th>
    <th>Data</th>
</tr>

<?php foreach ($pedidos as $p): ?>
<tr>
    <td><?= htmlspecialchars($p['nome']) ?></td>
    <td><?= number_format($p['total'], 0, ',', '.') ?> Kz</td>
    <td><?= $p['data_pedido'] ?></td>
</tr>
<?php endforeach; ?>
</table>
