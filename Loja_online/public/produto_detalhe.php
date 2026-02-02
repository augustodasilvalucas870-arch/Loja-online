<?php
require_once "../app/config/database.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: produtos.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    echo "Produto não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($produto['nome']) ?></title>
<link rel="stylesheet" href="assets/css/style.css">
<script src="assets/js/carrinho.js" defer></script>
</head>
<body>

<h1><?= htmlspecialchars($produto['nome']) ?></h1>

<img src="../uploads/<?= htmlspecialchars($produto['imagem']) ?>" class="img-detalhe">

<p><?= nl2br(htmlspecialchars($produto['descricao'])) ?></p>

<h2><?= number_format($produto['preco'], 0, ',', '.') ?> Kz</h2>

<button onclick="adicionarCarrinho(
<?= $produto['id'] ?>,
'<?= htmlspecialchars($produto['nome'], ENT_QUOTES) ?>',
<?= $produto['preco'] ?>
)">Adicionar ao carrinho</button>

<br><br>
<a href="produtos.php">← Voltar</a>

</body>
</html>
