<?php
require_once "../app/config/database.php";

// Buscar produtos
$stmt = $pdo->query("SELECT id, nome, preco, imagem FROM produtos ORDER BY id DESC");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pesquisa = $_GET['q'] ?? '';

$sql = "SELECT * FROM produtos WHERE nome LIKE ?";
$stmt = $pdo->prepare($sql);
$stmt->execute(["%$pesquisa%"]);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pagina = $_GET['pagina'] ?? 1;
$limite = 6;
$inicio = ($pagina - 1) * $limite;

$total = $pdo->query("SELECT COUNT(*) FROM produtos")->fetchColumn();
$paginas = ceil($total / $limite);

$stmt = $pdo->prepare("SELECT * FROM produtos LIMIT $inicio, $limite");
$stmt->execute();
$produtos = $stmt->fetchAll();

$filtro = $_GET['preco'] ?? '';

$where = "";
if ($filtro === "baixo") $where = "WHERE preco <= 50000";
if ($filtro === "medio") $where = "WHERE preco BETWEEN 50000 AND 200000";
if ($filtro === "alto")  $where = "WHERE preco > 200000";

$stmt = $pdo->query("SELECT * FROM produtos $where");
$produtos = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Produtos</title>
    <link rel="stylesheet" href="/Loja_online/public/assets/css/produtos.css">

<div class="produtos-header">
    <h1>Produtos</h1>
    <a href="index.php">Início</a>
    <a href="login.php">Login</a>
</div>

<form method="GET" class="barra-pesquisa">
    <input type="text" name="q" placeholder="Pesquisar produto..." value="<?= htmlspecialchars($pesquisa) ?>">
    <button>Pesquisar</button>
</form>

<div class="paginacao">
<?php for ($i = 1; $i <= $paginas; $i++): ?>
    <a href="?pagina=<?= $i ?>"><?= $i ?></a>
<?php endfor; ?>
</div>

<form method="GET">
    <select name="preco">
        <option value="">Filtrar por preço</option>
        <option value="baixo">Até 50.000 Kz</option>
        <option value="medio">50.000 - 200.000 Kz</option>
        <option value="alto">+200.000 Kz</option>
    </select>
    <button>Filtrar</button>
</form>

<!-- Lista de produtos -->
<div class="produtos-container">
    <div class="produtos-grid">

        <?php foreach ($produtos as $p): ?>
            <div class="produto-card">
                <img src="/Loja_online/<?= htmlspecialchars($p['imagem']) ?>" alt="">
                
                <h3><?= htmlspecialchars($p['nome']) ?></h3>
                
                <div class="preco">
                    <?= number_format($p['preco'], 0, ',', '.') ?> Kz
                </div>

                <a href="produto_detalhe.php?id=<?= $p['id'] ?>">
                    Ver detalhes
                </a>
            </div>
        <?php endforeach; ?>

    </div>
</div>






</body>
</html>
