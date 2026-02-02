<?php
session_start();
require "../app/config/database.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
    header("Location: ../public/login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: produtos.php");
    exit;
}

/* Buscar produto */
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    header("Location: produtos.php");
    exit;
}

$erro = "";

/* Atualizar produto */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = $_POST['nome'];
    $preco = $_POST['preco'];

    if ($nome && $preco) {
        $stmt = $pdo->prepare(
            "UPDATE produtos SET nome = ?, preco = ? WHERE id = ?"
        );
        $stmt->execute([$nome, $preco, $id]);

        header("Location: produtos.php");
        exit;
    } else {
        $erro = "Preencha todos os campos";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Editar Produto</title>
<link rel="stylesheet" href="../public/assets/css/style.css">
<link rel="stylesheet" href="../public/assets/css/admin.css">

</head>
<body>

<h1>Editar Produto</h1>

<?php if ($erro): ?>
<p style="color:red"><?= $erro ?></p>
<?php endif; ?>

<form method="POST">
    <label>Nome</label><br>
    <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required><br><br>

    <label>Preço (Kz)</label><br>
    <input type="number" name="preco" value="<?= $produto['preco'] ?>" required><br><br>

    <button type="submit">Guardar alterações</button>
</form>

<br>
<a href="produtos.php">Cancelar</a>

</body>
</html>
