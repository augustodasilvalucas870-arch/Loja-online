<?php
session_start();
require "../app/config/database.php";

/* Proteção admin */
if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
    header("Location: ../public/login.php");
    exit;
}

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $preco = $_POST['preco'] ?? 0;

    /* Upload da imagem */
    if (!empty($_FILES['imagem']['name'])) {
        $pasta = "../public/assets/images/produtos/";
        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        $imagemNome = time() . "_" . basename($_FILES['imagem']['name']);
        $caminho = $pasta . $imagemNome;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
            $imagemDB = "public/assets/images/produtos/" . $imagemNome;
        } else {
            $erro = "Erro ao carregar imagem";
        }
    } else {
        $imagemDB = null;
    }

    if (!$erro) {
        $stmt = $pdo->prepare(
            "INSERT INTO produtos (nome, descricao, preco, imagem)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$nome, $descricao, $preco, $imagemDB]);

        $sucesso = "Produto adicionado com sucesso";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Novo Produto</title>
<link rel="stylesheet" href="../public/assets/css/style.css">
<link rel="stylesheet" href="../public/assets/css/admin.css">
</head>
<body>


<div class="container">
    <h1>Adicionar Produto</h1>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nome do Produto</label>
            <input type="text" name="nome" required>
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <textarea name="descricao" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label>Preço (Kz)</label>
            <input type="number" name="preco" required>
        </div>

        <div class="form-group">
            <label>Imagem</label>
            <input type="file" name="imagem">
        </div>

        <button class="btn btn-primary">Guardar Produto</button>
        <a href="produtos.php" class="btn btn-danger">Voltar</a>
    </form>
</div>

<br>


</body>
</html>
